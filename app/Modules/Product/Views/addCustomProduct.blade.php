@extends('General.layoutCompany') @section('pageTitle', 'Ajouter un produit au tarif') @section('content')

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
                        <h3 class="box-title"> Ajouter un produit au tarif</h3>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <form role="form" method="post" action="{{route('handleStoreCustomPrice',$company->id)}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nom Societé</label>
                                        <input type="text" class="form-control" value="{{$company->name}}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Magasins concernés par la remise </label>
                                        <div class="form-check" style="margin: 10px 15px 20px;">
                                            <input type="checkbox" class="form-check-input selectAll">
                                            Tout séléctionner
                                        </div>
                                        <div class="scrollable">
                                            @forelse($company->stores as $store)
                                            <div class="col-md-12" style="padding: 2px 0px;">
                                                <div class="form-check" style="margin-bottom:5px;">
                                                    <input type="checkbox" class="form-check-input willCheck"
                                                        name="store_id[]" id="exampleCheck1" value="{{$store->id}}">
                                                    <span>{{$store->designation}}</span>
                                                </div>
                                            </div>
                                            @empty
                                            <p>Aucun magasin trouvé!</p>
                                            @endforelse

                                        </div>



                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nom Produit</label>
                                <select class="form-control selected_product" name="product_id" required>
                                    <option value="">Séléctionner un produit</option>
                                    @forelse($products as $product)
                                    <option value="{{$product->id}}"
                                        {{ old('product_id') == $product->id ? 'Selected' :  '' }}> {{$product->nom}}
                                    </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code produit</label>
                                        <input class="form-control" name="productCode" type="text"
                                            placeholder="Code produit" id="productCode" value="{{old('productCode')}}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code à barre</label>
                                        <input class="form-control" type="text" name="productBarCode"
                                            placeholder="Code à barre" id="barCode" value="{{old('productBarCode')}}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Prix unitaire de base (euro)</label>
                                        <input class="form-control" type="text" name="productPrice"
                                            placeholder="Prix unitaire de base (euro)" id="productPrice"
                                            value="{{old('productPrice')}}" readonly>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Prix unitaire remisé</label>
                                <input class="form-control" id="disabledInput" name="price" type="number"
                                    placeholder="Prix unitaire remisé" min="0" step="0.01" value="{{old('price')}}"
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
