@extends('General.layoutCompany') @section('pageTitle', 'Ajouter une produit') @section('content')

<style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }

</style>
<div class="content-wrapper">

    <section class="content-header">

        {{ Breadcrumbs::render('addCustomProduct',$company) }}
    </section>

    <section class="content" style="margin-top:20px;" id="app">
        <div class="row">
            <div class="container">
                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title"> Modifier un produit</h3>
                    </div>

                 

                    <form role="form" method="post"
                        action="{{route('handleUpdateCustomProduct',['price'=>$price->id,'company_id'=>$company->id])}}">
                        {{csrf_field()}}
                        <div class="box-body">

                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nom Societé</label>
                                        <input type="text" class="form-control" value="{{$company->name}}" disabled>
                                    </div>
                                </div>
                                @if($price->stores->count() > 0)
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Magasins concernés par la remise </label>
                                        <div class="form-check" style="margin: 10px 15px 20px;">
                                            <input type="checkbox" class="form-check-input selectAll">
                                            Tout séléctionner
                                        </div>
                                        <div class="scrollable">
                                            @forelse($price->stores as $key => $store)
                                            <div class="col-md-12" style="padding: 2px 0px;">
                                                <div class="form-check" style="margin-bottom:5px;">
                                                    <input type="checkbox" class="form-check-input willCheck"
                                                        name="store_id[]" id="exampleCheck1" value="{{$store->id}}"
                                                        checked>
                                                    <span>{{$store->designation}}</span>
                                                </div>
                                            </div>
                                            @empty
                                            <p>Aucun magasin trouvé!</p>
                                            @endforelse

                                        </div>



                                    </div>
                                </div>
                                @else
                                <div class="box-body">
                                    <p>Aucun magasin trouvé !</p>
                                </div>

                                @endif


                    

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Autres magasins </label>
                                        @if(count($freeStores) >0)
                                        <div class="form-check" style="margin: 10px 15px 20px;">

                                            <input type="checkbox" class="form-check-input selectBalance">
                                            Tout séléctionner
                                        </div>
                                        @endif
                                        <div class="scrollable">
                                            @forelse($freeStores as $key => $freeStore)

                                            <div class="col-md-12" style="padding: 2px 0px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input willCheckBalance"
                                                        name="new_store_id[]" id="exampleCheck1"
                                                        value="{{$freeStore->id}}">
                                                    <span>{{$freeStore->designation}}</span>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="box-body">
                                                <p>Aucun magasin trouvé !</p>
                                            </div>


                                            @endforelse

                                        </div>
                                    </div>
                                </div>


                            </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Nom Produit</label>
                                <select class="form-control selected_product" name="product_id" required>
                                    @forelse($products as $product)
                                    <option value="{{$product->id}}"
                                        {{ $product->id == $price->product->id ? 'selected' : ''}}>
                                        {{$product->nom}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code produit</label>
                                        <input class="form-control" value="{{$price->product->code}}" type="text"
                                            placeholder="Code produit" id="productCode" disabled>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code à barre</label>
                                        <input class="form-control" value="{{$price->product->barcode}}" type="text"
                                            placeholder="Code à barre" id="barCode" disabled>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Prix unitaire de base (euro)</label>
                                        <input class="form-control" type="text"
                                            value="{{$price->product->public_price}}"
                                            placeholder="Prix unitaire de base (euro)" id="productPrice" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Prix unitaire remisé</label>
                                <input class="form-control" id="disabledInput" name="price" value="{{$price->price}}"
                                    type="number" step="0.01" placeholder="Prix unitaire pour societé (euro)" min="0"
                                    required>
                            </div>


                            <div class="row">
                                <div class="container text-center">

                                    <a href="{{route('showCustomProducts',$company->id)}}"
                                        class="btn btn-danger pl-1">Annuler</a>
                                    <button type="submit" class="btn btn-success pl-1">Confirmer</button>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>


            </div>

    </section>

</div>


@endsection
