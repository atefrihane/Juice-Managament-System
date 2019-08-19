<?php

namespace App\Modules\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Models\Company;
use App\Modules\Product\Models\Product;
use App\Modules\CompanyPrice\Models\CompanyPrice;
class ProductController extends Controller
{

    public function showProducts()
    {
        $products = Product::all();

        return view('Product::showProducts', compact('products'));

    }

    public function showAddProduct()
    {

        return view('Product::addProduct');
    }

    public function showCustomProducts($id)
    {


        $company = Company::find($id);
        $company_prices = CompanyPrice::where('company_id',$company->id)->get();

        if ($company) {
            return view('Product::showCustomProducts', compact('company','company_prices'));
        }
        return view('General::notFound');

    }

    public function showAddCustomProduct($id)
    {
        $company = Company::find($id);
        $products = Product::all();
        if ($company) {

            return view('Product::addCustomProduct', compact('company','products'));

        }
        return view('General::notFound');

    }

}
