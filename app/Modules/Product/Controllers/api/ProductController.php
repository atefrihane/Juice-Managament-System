<?php

namespace App\Modules\Product\Controllers\api;

use App\Http\Controllers\Controller;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductHistory;
use App\Modules\Store\Models\Store;
use App\Repositories\Image;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function store(Request $request, Image $image)
    {

        $checkCode = Product::where('code', $request->code)->first();
        if ($checkCode) {
            return response()->json(['status' => 400]);
        }
        if ($request->photo) {
            $name = $image->handleUploadImage($request->photo);

        }

        $product = Product::create([
            'code' => $request->code,
            'status' => lcfirst($request->state),
            'type' => $request->type,
            'nom' => $request->name,
            'designation' => $request->designation,
            'barcode' => $request->barcode,
            'version' => $request->version,
            'composition' => $request->composition,
            'color' => $request->color,
            'weight' => $request->weight,
            'height' => $request->height,
            'width' => $request->width,
            'depth' => $request->depth,
            'public_price' => $request->publicPrice,
            'period_of_validity' => $request->validityClosed,
            'validity_after_opening' => $request->validityOpened,
            'comment' => $request->comment,
            'unit_by_display' => $request->unityPerDisplay,
            'unit_per_package' => $request->unityPerPack,
            'packing' => $request->packing,
            'tva' => $request->tva,
            'photo_url' => isset($name) ? $name : null,
        ]);

        ProductHistory::create([
            'action' => 'Création',
            'product_id' => $product->id,
            'user_id' => $request->userId,
        ]);
        return response()->json(['status' => 200]);

    }

    public function index()
    {
        return Product::where('status', 'disponible')->get();
    }

    public function handleGetProductById($id)
    {

        $checkProduct = Product::find($id);

        if ($checkProduct) {

            return response()->json(['status' => 'status', 'product' => $checkProduct->mixtures]);

        } else {
            return response()->json(['status' => '404', 'product' => 'Product not found']);
        }

    }

    public function handleGetProductByName($name)
    {
        $checkProduct = Product::where('nom', $name)->first();
        if ($checkProduct) {
            return response()->json(['status' => '200', 'product' => $checkProduct]);

        } else {
            return response()->json(['status' => '404', 'product' => ' Product not found']);
        }

    }

    public function handleGetProductByBarcode($barcode)
    {

        $checkProduct = Product::where('barcode', $barcode)->first();
        if ($checkProduct) {
            return response()->json(['status' => '200', 'product' => $checkProduct]);

        } else {
            return response()->json(['status' => '404', 'product' => ' Product not found']);
        }

    }

    public function handleGetAllProduct()
    {
        $products = Product::where('status', 'disponible')->get();
        return response()->json(['status' => '200', 'products' => $products]);

    }

    public function handleUpdateProduct(Request $request, $id, Image $image)
    {

        $product = Product::find($id);
        $checkCode = Product::where('code', $request->code)
            ->where('id', '!=', $product->id)
            ->first();
        if ($checkCode) {
            return response()->json(['status' => 400]);
        }
        $currentPhoto = $product->photo_url;
        if ($product) {

            if ($request->photo != $currentPhoto) {
                $name = $image->handleUploadImage($request->photo);

                // $image->upload($request);
                $userPhoto = public_path('img/') . $currentPhoto;
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }

            }

            $product->update([
                'code' => $request->code,
                'status' => $request->state,
                'type' => $request->type,
                'nom' => $request->name,
                'designation' => $request->designation,
                'barcode' => $request->barcode,
                'version' => $request->version,
                'composition' => $request->composition,
                'color' => $request->color,
                'weight' => $request->weight,
                'height' => $request->height,
                'width' => $request->width,
                'depth' => $request->depth,
                'public_price' => $request->publicPrice,
                'period_of_validity' => $request->validityClosed,
                'validity_after_opening' => $request->validityOpened,
                'comment' => $request->comment,
                'unit_by_display' => $request->unityPerDisplay,
                'unit_per_package' => $request->unityPerPack,
                'packing' => $request->packing,
                'tva' => $request->tva,
                'photo_url' => isset($name) ? $name : $currentPhoto,
            ]);

            ProductHistory::create([
                'action' => 'Modification',
                'user_id' => $request->userId,
                'product_id' => $product->id,
            ]);

            return response()->json(['status' => 200]);

        }
    }
    public function handleGetProductDetails($id)
    {

        $product = Product::find($id);

        if ($product) {
            return response()->json(['status' => '200', 'product' => $product]);

        }
        return response()->json(['status' => '404']);

    }
    public function handleGetProductPrices($id, Request $request)
    {

        $product = Product::find($id);
        $checkCustomPrice = Store::find($request->store_id)->prices->where('product_id', $product->id)->first();

        if ($product) {
            return response()->json(['status' => '200', 'product' => $product, 'custom_price' => $checkCustomPrice]);

        }
        return response()->json(['status' => '404']);

    }

    public function handleGetProductInWarehouses(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {

            $productInWarehouses = $product->warehouses()
                ->where('quantity', '>', 0)
                ->orderBy('pivot_expiration_date', 'ASC')
                ->withPivot('id', 'packing', 'quantity', 'comment', 'creation_date', 'expiration_date')
                ->get();

            return response()->json(['status' => 200, 'warehouse_products' => $productInWarehouses, 'productName' => $product->nom]);

        }
        return response()->json(['status' => 404]);

    }
    public function handleGetValidityAfterOpening($id, Request $request)
    {

        $product = Product::find($id);
        if ($product) {

            $date = Carbon::parse($request->date);
            $finalDate = $date->addDays($product->period_of_validity);

            return response()->json(['status' => 200, 'finalDate' => $date->format('Y-m-d')]);

        }
        return response()->json(['status' => 404]);

    }

    public function handleCheckQuantityInWarehouses($id, Request $request)
    {
        $checkProductInWarehouse = DB::table('product_warehouse')->find($id);
        if ($checkProductInWarehouse) {
            if ($checkProductInWarehouse->quantity >= $request->preparedQuantity) {
                return response()->json(['status' => 200, 'warehouseQuantity' => $checkProductInWarehouse->quantity]);

            }
            return response()->json(['status' => 400, 'warehouseQuantity' => $checkProductInWarehouse->quantity]);
        }
        return response()->json(['status' => 404]);

    }

}
