<?php

namespace App\Modules\Order\Controllers\api;

use App\Http\Controllers\Controller;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderHistory;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductPrepare;
use App\Modules\Warehouse\Models\Warehouse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function handleSaveOrder(Request $request)
    {
        $checkOrder = Order::where('code', $request->code)->first();
        if (!$checkOrder) {
            $order = Order::create([
                'code' => $request->code,
                'status' => $request->status,
                'total' => $request->total_order,
                'store_id' => $request->store_id,
                'comment' => $request->comment,
            ]);

            if ($request->input('ordered_products')) {
                foreach ($request->input('ordered_products') as $ordered) {
                    $order->products()->attach($ordered['product_id'], [
                        'package' => $ordered['packing'],
                        'unit' => $ordered['unit'],
                    ]);

                }
            }
            OrderHistory::create([
                'action' => 'Création',
                'order_id' => $order->id,
                'user_id' => $request->user_id,
            ]);
            return response()->json(['status' => 200]);

        }

        return response()->json(['status' => 400]);

    }
    public function showOrder($id)
    {
        $order = Order::find($id);

        if ($order) {
            $ordered_products = $order->products()->withPivot('package', 'unit')->get();

            $order_history = OrderHistory::with('user')->where('order_id', $order->id)->get();

            $check = Product::with('warehouses')->get();
            // $check = Product::withAndWhereHas('warehouses',function($query){
            //     $query->where('id',10);
            // })->get();;
            // $custom_prepared = $prepared_products->map(function ($prepared) use ($prepared_products) {
            //     return [
            //         'id' => $prepared->id,
            //         'name' => $prepared->productwarehouse->product->nom,
            //         'quantity' => $prepared->productwarehouse->quantity,
            //         'packing' => $prepared->productwarehouse->packing,
            //         'creation_date' => $prepared->productwarehouse->creation_date,
            //         'expiration_date' => $prepared->productwarehouse->expiration_date,
            //         'prepared_quantity' => $prepared->quantity,
            //         'product_id' => $prepared->productwarehouse->product->id,
            //         'warehouse_id' => $prepared->productwarehouse->warehouse->id,
            //         'prepared'=>$prepared_products

            //     ];
            // });

            return response()->json(['status' => 200, 'order' => $order, 'ordered_products' => $ordered_products, 'order_history' => $order_history, 'prepared_products' => $check]);

        }

        return response()->json(['status' => 404]);

    }

    public function handleDeleteProduct(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->products()->detach($request->product_id);
            return response()->json(['status' => 200]);

        }
        return response()->json(['status' => 404]);

    }
    public function handleUpdateProduct(Request $request, $id)
    {

        $order = Order::find($id);
        if ($order) {

            $order->update([
                'store_id' => $request->store_id,
                'total' => $request->total_order,
                'comment' => $request->comment,
                'status' => $request->status,
            ]);
            foreach ($request->custom_ordered as $custom) {
                $checkProduct = $order->products()->where('product_id', $custom['product_id'])->first();
                // dd($request->all());
                if ($checkProduct) {
                    $order->products()->updateExistingPivot($custom['product_id'], ['package' => $custom['package'], 'unit' => $custom['unit']]);

                } else {
                    $order->products()->attach($custom['product_id'], ['package' => $custom['package'], 'unit' => $custom['unit']]);
                }

            }
            OrderHistory::create([
                'action' => $request->status == 0 ? 'Modification' : 'Etat vers : A préparer',
                'user_id' => $request->user_id,
                'order_id' => $order->id,
            ]);
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function handleUpdateOrderToPrepare(Request $request, $id)
    {

        $order = Order::find($id);
        if ($order) {

            if ($request->input('new_status') &&
                $request->input('new_status_text') &&
                $request->input('user_id')
            ) {
                $order->update([
                    'status' => $request->input('new_status'),
                    'preparator_id' => $request->input('preparator_id'),
                    'comment' => $request->comment,
                ]);
                OrderHistory::create([
                    'order_id' => $order->id,
                    'user_id' => $request->user_id,
                    'action' => $request->input('new_status_text'),
                ]);

                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 400]);

            }

        }
        return response()->json(['status' => 404]);

    }

    public function handleOrderPreparedProducts($id, Request $request)
    {
        $order = Order::find($id);

        if ($order) {
            if ($order->prepared->count() == 0) {
                foreach ($request->final_prepared as $final) {
                    foreach ($final['prepared_products'] as $prepared) {

                        if (isset($prepared['prepared_quantity'])) {
                            ProductPrepare::create([
                                'quantity' => $prepared['prepared_quantity'],
                                'order_id' => $id,
                                'product_warehouse_id' => $prepared['id'],
                            ]);
                            $getWarehouse = Warehouse::where('designation', $prepared['warehouse_name'])->first();
                            $getStock = $getWarehouse->products()->where('product_warehouse.id', $prepared['id'])->first();
                            $getStock->pivot->quantity -= $prepared['prepared_quantity'];
                            $getStock->pivot->save();
                        }

                    }

                }

            } else {

                foreach ($request->final_prepared as $final) {

                    foreach ($final['prepared_products'] as $prepared) {

                        $checkPrepare = ProductPrepare::find($prepared['id']);
                        if ($checkPrepare) {
                            if ($prepared['prepared_quantity'] > $checkPrepare->quantity) {
                                $difference = $prepared['prepared_quantity'] - $checkPrepare->quantity;

                                $getWarehouse = Warehouse::find($prepared['warehouse_id']);
                                $getStock = $getWarehouse->products()->where('product_warehouse.id', $checkPrepare->product_warehouse_id)->first();
                                $getStock->pivot->quantity -= $difference;
                                $getStock->pivot->save();

                            } else if ($prepared['prepared_quantity'] < $checkPrepare->quantity) {
                                $difference = $checkPrepare->quantity - $prepared['prepared_quantity'];
                                $getWarehouse = Warehouse::find($prepared['warehouse_id']);
                                $getStock = $getWarehouse->products()->where('product_warehouse.id', $checkPrepare->product_warehouse_id)->first();
                                $getStock->pivot->quantity += $difference;
                                $getStock->pivot->save();

                            }
                        }

                    }

                }
            }

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function handleDeleteOrderPrepare($id, Request $request)
    {
        foreach ($request->final_prepared['prepared_products'] as $prepared) {
            $checkPrepare = ProductPrepare::where('product_warehouse_id', $prepared['id'])->first();
            if ($checkPrepare) {
                $checkPrepare->delete();
            }

        }
        return response()->json(['status' => 200]);

    }

}
