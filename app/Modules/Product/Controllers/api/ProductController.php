<?php

namespace App\Modules\Product\Controllers\api;

use App\Http\Controllers\Controller;
use App\Modules\Order\Models\Order;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductHistory;
use App\Modules\Store\Models\Store;
use App\Modules\Store\Models\StoreProduct;
use App\Modules\Store\Models\StoreProductHistory;
use App\Modules\Store\Models\StoreProductHistoryDetails;
use App\Modules\User\Models\User;
use App\Repositories\Image;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function store(Request $request)
    {

        $request->validate([
            'code' => 'required|regex:/^[A-Z0-9]+$/|alpha_dash',
            'state' => 'required',
            'name' => 'required|min:1|max:150',
            'type' => 'required',
            'barcode' => 'required|min:1|max:150',
            'designation' => 'required|min:1|max:150',
            'composition' => 'required|min:1|max:150',
            'version' => 'required|min:1|max:150',
            'color' => 'required',
            'weight' => 'required|digits_between:1,6|numeric',
            'height' => 'required|digits_between:1,6|numeric',
            'width' => 'required|digits_between:1,6|numeric',
            'depth' => 'required|digits_between:1,6|numeric',
            'publicPrice' => 'required|min:1|max:999999|numeric',
            'validityClosed' => 'required|digits_between:1,6|numeric',
            'validityOpened' => 'required|digits_between:1,6|numeric',
            'unityPerDisplay' => 'required|digits_between:1,6|numeric',
            'unityPerPack' => 'required|digits_between:1,6|numeric',
            'packing' => 'required|digits_between:1,6|numeric',
            'tva' => 'required|min:0|max:999999|numeric',

        ], [
            'code.required' => ' Code est obligatoire',
            'code.regex' => ' Code n\'est pas valide',
            'code.alpha_dash' => ' Code doit être alphanumérique',
            'code.digits_between' => ' Code n\'est pas valide',
            'state.required' => ' Etat est requis',
            'name.required' => ' Nom du produit est requis',
            'name.min' => ' Nom du produit n\'est pas valide',
            'name.max' => ' Nom du produit n\'est pas valide',
            'type.required' => ' Type du produit  est requis',
            'color.required' => ' Couleur  est requis',
            'barcode.required' => ' Code à barres est requis',
            'barcode.min' => ' Code à barres n\'est pas valide',
            'barcode.max' => ' Code à barres n\'est pas valide',
            'designation.required' => ' Désignation est requise',
            'designation.min' => ' Désignation n\'est pas valide',
            'designation.max' => ' Désignation n\'est pas valide',
            'composition.required' => ' Composition est requise',
            'composition.min' => ' Composition n\'est pas valide',
            'composition.max' => ' Composition n\'est pas valide',
            'version.required' => ' Version est requise',
            'version.min' => ' Version n\'est pas valide',
            'version.max' => ' Version n\'est pas valide',
            'weight.required' => ' Poids est requis',
            'weight.digits_between' => ' Poids n\'est pas valide',
            'weight.numeric' => ' Poids n\'est pas valide',
            'height.required' => ' Hauteur est requis',
            'height.digits_between' => ' Hauteur n\'est pas valide',
            'height.numeric' => ' Hauteur n\'est pas valide',
            'width.required' => ' Largeur est requis',
            'width.digits_between' => ' Largeur n\'est pas valide',
            'width.numeric' => ' Largeur n\'est pas valide',
            'depth.required' => ' Profondeur est requis',
            'depth.digits_between' => ' Profondeur n\'est pas valide',
            'depth.numeric' => ' Profondeur n\'est pas valide',
            'publicPrice.required' => ' Prix unitaire de vente est requis',
            'publicPrice.between' => ' Prix unitaire de vente n\'est pas valide',
            'publicPrice.numeric' => ' Prix unitaire de vente n\'est pas valide',
            'validityClosed.required' => ' Durée de validité de produit fermé ( en jours) est requis',
            'validityClosed.digits_between' => ' Durée de validité de produit fermé ( en jours)  n\'est pas valide',
            'validityClosed.numeric' => ' Durée de validité de produit fermé ( en jours)  n\'est pas valide',
            'validityOpened.required' => ' Durée de validité aprés ouverture ( en heures) est requis',
            'validityOpened.digits_between' => ' Durée de validité aprés ouverture ( en heures) n\'est pas valide',
            'validityOpened.numeric' => ' Durée de validité aprés ouverture ( en heures) n\'est pas valide',
            'unityPerDisplay.required' => ' Nombre d\'unités par display est requis',
            'unityPerDisplay.digits_between' => ' Nombre d\'unités par display n\'est pas valide',
            'unityPerDisplay.numeric' => ' Nombre d\'unités par display n\'est pas valide',
            'unityPerPack.required' => ' Nombre de display par colis est requis',
            'unityPerPack.digits_between' => ' Nombre de display par colis n\'est pas valide',
            'unityPerPack.numeric' => ' Nombre de display par colis n\'est pas valide',
            'packing.required' => ' Colisage est requis',
            'packing.digits_between' => ' Colisage n\'est pas valide',
            'packing.numeric' => ' Colisage n\'est pas valide',
            'tva.required' => ' TVA (%) est requis',
            'tva.digits_between' => ' TVA (%) n\'est pas valide',
            'tva.numeric' => ' TVA (%) n\'est pas valide',
            'tva.min' => ' TVA (%) n\'est pas valide',
            'tva.max' => ' TVA (%) n\'est pas valide',

        ]);

        $checkCode = Product::where('code', $request->code)->first();
        if ($checkCode) {
            return response()->json(['status' => 400]);
        }

        $checkBarcode = Product::where('barcode', $request->barcode)->first();
        if ($checkBarcode) {
            return response()->json(['status' => 401]);
        }
        if ($request->photo) {
            $name = $this->image->handleUploadImage($request->photo);

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
    public function showProductsCategorized()
    {
        $disposableProducts = Product::where('type', 'Jettable')
            ->where('status', 'disponible')
            ->get();
        $alimentaryProducts = Product::where('type', 'alimentaire')
            ->where('status', 'disponible')
            ->get();
        return response()->json([
            'status' => 200,
            'disposableProducts' => $disposableProducts,
            'alimentaryProducts' => $alimentaryProducts,
        ]);
    }

    // public function handleGetProductById($id, $store_id)
    // {

    //     $checkProduct = Product::find($id);

    //     if ($checkProduct) {

    //         $stockProducts = DB::table('store_products')
    //             ->where('store_id', $store_id)
    //             ->where('product_id', $id)
    //             ->get();

    //         return response()->json(['status' => '200',
    //             'product' => $checkProduct,
    //             'stockProduct' => $stockProducts,

    //         ]);

    //     } else {
    //         return response()->json(['status' => '404', 'product' => 'Product not found']);
    //     }

    // }

    public function handleFilterProductByNameOrBarcode($value, Request $request)
    {

        $checkProducts = Product::where('nom', 'like', "%{$value}%")
            ->orWhere('barcode', $value)
            ->get();
        if ($checkProducts) {
            return response()->json(['status' => '200', 'products' => $checkProducts]);

        }
        return response()->json(['status' => '404', 'product' => ' Product not found']);

    }

    public function handleFilterProductByBarcode($barcode)
    {

        $checkProduct = Product::where('barcode', 'like', "%{$barcode}%")->first();
        if ($checkProduct) {
            return response()->json(['status' => '200', 'product' => $checkProduct]);

        }
        return response()->json(['status' => '404', 'product' => ' Product not found']);

    }

    public function handleGetAllProduct()
    {
        $products = Product::where('status', 'disponible')->get();
        return response()->json(['status' => '200', 'products' => $products]);

    }

    public function handleUpdateProduct(Request $request, $id)
    {

        $request->validate([
            'code' => 'required|regex:/^[A-Z0-9]+$/|alpha_dash',
            'state' => 'required',
            'name' => 'required|min:1|max:150',
            'type' => 'required',
            'barcode' => 'required|min:1|max:150',
            'designation' => 'required|min:1|max:150',
            'composition' => 'required|min:1|max:150',
            'version' => 'required|min:1|max:150',
            'color' => 'required',
            'weight' => 'required|digits_between:1,6|numeric',
            'height' => 'required|digits_between:1,6|numeric',
            'width' => 'required|digits_between:1,6|numeric',
            'depth' => 'required|digits_between:1,6|numeric',
            'publicPrice' => 'required|min:1|max:999999|numeric',
            'validityClosed' => 'required|digits_between:1,6|numeric',
            'validityOpened' => 'required|digits_between:1,6|numeric',
            'unityPerDisplay' => 'required|digits_between:1,6|numeric',
            'unityPerPack' => 'required|digits_between:1,6|numeric',
            'packing' => 'required|digits_between:1,6|numeric',
            'tva' => 'required|min:0|max:999999|numeric',

        ], [
            'code.required' => ' Code est obligatoire',
            'code.regex' => ' Code n\'est pas valide',
            'code.alpha_dash' => ' Code doit être alphanumérique',
            'code.digits_between' => ' Code n\'est pas valide',
            'state.required' => ' Etat est requis',
            'name.required' => ' Nom du produit est requis',
            'name.min' => ' Nom du produit n\'est pas valide',
            'name.max' => ' Nom du produit n\'est pas valide',
            'type.required' => ' Type du produit  est requis',
            'color.required' => ' Couleur  est requis',
            'barcode.required' => ' Code à barres est requis',
            'barcode.min' => ' Code à barres n\'est pas valide',
            'barcode.max' => ' Code à barres n\'est pas valide',
            'designation.required' => ' Désignation est requise',
            'designation.min' => ' Désignation n\'est pas valide',
            'designation.max' => ' Désignation n\'est pas valide',
            'composition.required' => ' Composition est requise',
            'composition.min' => ' Composition n\'est pas valide',
            'composition.max' => ' Composition n\'est pas valide',
            'version.required' => ' Version est requise',
            'version.min' => ' Version n\'est pas valide',
            'version.max' => ' Version n\'est pas valide',
            'weight.required' => ' Poids est requis',
            'weight.digits_between' => ' Poids n\'est pas valide',
            'weight.numeric' => ' Poids n\'est pas valide',
            'height.required' => ' Hauteur est requis',
            'height.digits_between' => ' Hauteur n\'est pas valide',
            'height.numeric' => ' Hauteur n\'est pas valide',
            'width.required' => ' Largeur est requis',
            'width.digits_between' => ' Largeur n\'est pas valide',
            'width.numeric' => ' Largeur n\'est pas valide',
            'depth.required' => ' Profondeur est requis',
            'depth.digits_between' => ' Profondeur n\'est pas valide',
            'depth.numeric' => ' Profondeur n\'est pas valide',
            'publicPrice.required' => ' Prix unitaire de vente est requis',
            'publicPrice.between' => ' Prix unitaire de vente n\'est pas valide',
            'publicPrice.numeric' => ' Prix unitaire de vente n\'est pas valide',
            'validityClosed.required' => ' Durée de validité de produit fermé ( en jours) est requis',
            'validityClosed.digits_between' => ' Durée de validité de produit fermé ( en jours)  n\'est pas valide',
            'validityClosed.numeric' => ' Durée de validité de produit fermé ( en jours)  n\'est pas valide',
            'validityOpened.required' => ' Durée de validité aprés ouverture ( en heures) est requis',
            'validityOpened.digits_between' => ' Durée de validité aprés ouverture ( en heures) n\'est pas valide',
            'validityOpened.numeric' => ' Durée de validité aprés ouverture ( en heures) n\'est pas valide',
            'unityPerDisplay.required' => ' Nombre d\'unités par display est requis',
            'unityPerDisplay.digits_between' => ' Nombre d\'unités par display n\'est pas valide',
            'unityPerDisplay.numeric' => ' Nombre d\'unités par display n\'est pas valide',
            'unityPerPack.required' => ' Nombre de display par colis est requis',
            'unityPerPack.digits_between' => ' Nombre de display par colis n\'est pas valide',
            'unityPerPack.numeric' => ' Nombre de display par colis n\'est pas valide',
            'packing.required' => ' Colisage est requis',
            'packing.digits_between' => ' Colisage n\'est pas valide',
            'packing.numeric' => ' Colisage n\'est pas valide',
            'tva.required' => ' TVA (%) est requis',
            'tva.digits_between' => ' TVA (%) n\'est pas valide',
            'tva.numeric' => ' TVA (%) n\'est pas valide',
            'tva.min' => ' TVA (%) n\'est pas valide',
            'tva.max' => ' TVA (%) n\'est pas valide',

        ]);
        $product = Product::find($id);
        $checkCode = Product::where('code', $request->code)
            ->where('id', '!=', $product->id)
            ->first();
        if ($checkCode) {
            return response()->json(['status' => 400]);
        }

        $checkbBarcode = Product::where('barcode', $request->barcode)
            ->where('id', '!=', $product->id)
            ->first();
        if ($checkbBarcode) {
            return response()->json(['status' => 401]);
        }

        $currentPhoto = $product->photo_url;
        if ($product) {

            if ($request->photo != $currentPhoto) {
                $name = $this->image->handleUploadImage($request->photo);

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

    public function handleCheckProductBeforeUpdate($id)
    {
        // Vérifier si un produit existe déja dans une commande en cours de saisie
        $checkProductPrepared = Order::whereHas('products', function ($q) use ($id) {
            $q->where('product_id', $id);

        })->where('status', 0)
            ->get();

        if ($checkProductPrepared) {
            return response()->json(['status' => 200, 'countOrders' => count($checkProductPrepared)]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleGetProductsByStore($id)
    {

        $checkStore = Store::find($id);
        if ($checkStore) {
            $stockProducts = DB::table('store_products')
                ->join('stores', 'stores.id', '=', 'store_products.store_id')
                ->join('products', 'products.id', '=', 'store_products.product_id')
                ->where('store_id', $checkStore->id)
                ->select(DB::raw('products.id,products.nom as name,products.photo_url,sum(quantity) as unitQuantities'))
                ->groupBy('product_id')
                ->get();

            return response()->json(['status' => 200, 'stockProducts' => $stockProducts]);

        }
        return response()->json(['status' => 404]);
    }

    public function handleGetProductInStores($id, $store_id)
    {
        $checkProduct = Product::find($id);
        if (!$checkProduct) {
            return response()->json(['status' => 404, 'Product' => 'Product not found']);

        }

        $checkStore = Store::find($store_id);
        if (!$checkStore) {
            return response()->json(['status' => 404, 'Store' => 'Store not found']);
        }

        $stockProduct = DB::table('store_products')
            ->where('product_id', $id)
            ->where('store_id', $store_id)
            ->get();
        $stockProductHistory = StoreProductHistory::whereIn('store_products_id', $stockProduct->pluck('id'))
            ->with(['user', 'histories'])
            ->get();

        return response()->json(['status' => 200,
            'product' => $checkProduct,
            'stockProducts' => $stockProduct,
            'history' => $stockProductHistory,
        ]);

    }

    public function handleStoreProductInStock($id, $store_id, Request $request)
    {

        if (!$request->filled('newStock') ||
            empty($request->input('newStock')) ||
            !$request->input('userId')) {
            return response()->json(['status' => 400]);

        }

        //Disallow wrong keys
        $filteredNewStockKeys = array_keys($request->input('newStock'));
        $allowedKeys = [
            'packing',
            'quantity',
            'creation_date',
            'expiration_date',
            'stock_display',
            'packing_display',
            'comment',
            'product_id',
            'store_id',
        ];
        foreach ($filteredNewStockKeys as $key) {
            if (!in_array($key, $allowedKeys)) {
                return response()->json(['status' => 404, 'newStock' => "Wrong keys"]);
            }
        }

        $checkProduct = Product::find($id);
        if (!$checkProduct) {
            return response()->json(['status' => 404, 'Product' => 'Product not found']);

        }

        $checkStore = Store::find($store_id);
        if (!$checkStore) {
            return response()->json(['status' => 404, 'Store' => 'Store not found']);
        }
        if ($store_id != $request->input('newStock')['store_id']) {
            return response()->json(['status' => 404, 'Store' => 'Store not found']);

        }

        $newStoreProduct = StoreProduct::create($request->input('newStock'));

        StoreProductHistory::create([
            'action' => 'Ajout : ' . $checkProduct->nom,
            'user_id' => $request->input('userId'),
            'comment' => $request->filled('comment') ? $request->input('comment') : null,
            'store_products_id' => $newStoreProduct->id,
        ]);
        return response()->json(['status' => 200]);
    }

    public function handleUpdateStoreProductStock($id, Request $request)
    {

        if (!$request->filled('newStock') ||
            empty($request->input('newStock')) ||
            !$request->filled('userId')) {
            return response()->json(['status' => 400]);

        }

        //Disallow wrong keys
        $filteredNewStockKeys = array_keys($request->input('newStock'));
        $allowedKeys = [
            'packing',
            'quantity',
            'creation_date',
            'expiration_date',
            'stock_display',
            'packing_display',
            'comment',
        ];
        foreach ($filteredNewStockKeys as $key) {
            if (!in_array($key, $allowedKeys)) {
                return response()->json(['status' => 404, 'newStock' => "Wrong keys"]);
            }
        }

        $filteredNewStock = array_filter($request->input('newStock'), 'strlen');
        if (empty($filteredNewStock)) {
            return response()->json(['status' => 404, 'newStock' => "Wrong values"]);
        }

        $checkUser = User::find($request->input('userId'));
        if (!$checkUser) {
            return response()->json(['status' => 404, 'User' => "User not found"]);

        }

        $checkStock = StoreProduct::find($id);
        if ($checkStock) {
            $historyDetails = [];

            $checkStockHistroy = StoreProductHistory::create([
                'action' => 'Modfication',
                'user_id' => $request->input('userId'),
                'comment' => $request->filled('comment') ? $request->input('comment') : null,
                'store_products_id' => $checkStock->id,
            ]);

            (array_key_exists('packing', $filteredNewStock) && $filteredNewStock['packing'] != $checkStock->packing) ? array_push($historyDetails, [
                'field' => 'Colisage',
                'changes' => $checkStock->packing . ' => ' . $filteredNewStock['packing'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('quantity', $filteredNewStock) && $filteredNewStock['quantity'] != $checkStock->quantity) ? array_push($historyDetails, [
                'field' => 'Quantité',
                'changes' => $checkStock->quantity . ' => ' . $filteredNewStock['quantity'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('creation_date', $filteredNewStock) && $filteredNewStock['creation_date'] != $checkStock->creation_date) ? array_push($historyDetails, [
                'field' => 'Date de création',
                'changes' => $checkStock->creation_date . ' => ' . $filteredNewStock['creation_date'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('expiration_date', $filteredNewStock) && $filteredNewStock['expiration_date'] != $checkStock->expiration_date) ? array_push($historyDetails, [
                'field' => 'Date d\'expiration',
                'changes' => $checkStock->expiration_date . ' => ' . $filteredNewStock['expiration_date'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('stock_display', $filteredNewStock) && $filteredNewStock['stock_display'] != $checkStock->stock_display) ? array_push($historyDetails, [
                'field' => 'Nombre d\'unités par display',
                'changes' => $checkStock->stock_display . ' => ' . $filteredNewStock['stock_display'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('packing_display', $filteredNewStock) && $filteredNewStock['packing_display'] != $checkStock->packing_display) ? array_push($historyDetails, [
                'field' => 'Nombre de display par colis',
                'changes' => $checkStock->packing_display . ' => ' . $filteredNewStock['packing_display'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            (array_key_exists('comment', $filteredNewStock) && $filteredNewStock['comment'] != $checkStock->comment) ? array_push($historyDetails, [
                'field' => 'Commentaire',
                'changes' => $checkStock->comment . ' => ' . $filteredNewStock['comment'],
                'store_products_history_id' => $checkStockHistroy->id,
            ]) : '';

            // remove null // empty  values
            if (!empty($historyDetails)) {
                foreach ($historyDetails as $historyDetail) {
                    array_filter($historyDetail, 'strlen');

                }

                if (!empty($historyDetails)) {
                    StoreProductHistoryDetails::insert($historyDetails);
                    $checkStock->update($filteredNewStock);
                    return response()->json(['status' => 200]);
                }

            }

            return response()->json(['status' => 200]);

        }

        return response()->json(['status' => 404, 'Stock' => 'Stock not found']);

    }

    public function handleEmptyStoreProductStock($id, Request $request)
    {
        if (!$request->filled('userId')) {
            return response()->json(['status' => 200]);

        }
        $checkStock = StoreProduct::find($id);

        if ($checkStock) {
            $checkStock->update(['quantity' => 0]);
            $checkStockHistroy = StoreProductHistory::create([
                'action' => 'Suppréssion',
                'user_id' => $request->input('userId'),
                'comment' => $request->filled('comment') ? $request->input('comment') : null,
                'store_products_id' => $checkStock->id,
            ]);
            return response()->json(['status' => 200]);

        }
        return response()->json(['status' => 404]);

    }

}
