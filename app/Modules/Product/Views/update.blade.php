@extends('General.layout') @section('pageTitle', 'Modifier un produit') @section('content')


    <div class="content-wrapper">

        <section class="content-header">

            {{ Breadcrumbs::render('editProduct',$product) }}
        </section>

        <section class="content" id="prod">
            <div class="row">
                <div class="container">

                    <div class="box box-primary"  >

                        <div class="box-header" >
                            <h3 class="box-title"> Modifier un produit</h3>
                        </div>
                        <form role="form" method="post" enctype="multipart/form-data" action="{{route('updateProduct', $product->id)}}">
                            {{csrf_field()}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ID</label>
                                            <input class="form-control" id="disabledInput" type="text" value="{{$product->id}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Code </label>
                                            <input type="text" name="code" value="{{$product->code}}"  class="form-control" id="exampleInputEmail1" placeholder="Code..">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Etat</label>
                                            <select class="form-control" name="status" value="{{$product->status}}">
                                                <option value="disponible">disponible</option>
                                                <option value="non disponible">non disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nom Produit</label>
                                    <input class="form-control"  id="disabledInput" type="text" name="nom" value="{{$product->nom}}" placeholder="Nom Produit">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Type de Produit</label>
                                    <select class="form-control" name="type">
                                        <option
                                        {{$product->type == 'alimentaire' ? 'selected' : ''}}>alimentaire</option>
                                        <option
                                        {{$product->type == 'autre' ? 'selected' : ''}}>autre</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Version de Produit</label>
                                    <input class="form-control" name="version" value="{{$product->version}}" id="disabledInput" type="text" placeholder="version">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Code à barre</label>
                                    <input class="form-control" name="barcode" value="{{$product->barcode}}"  id="disabledInput" type="text" placeholder="Code à barre">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Désignation</label>
                                    <input class="form-control"   id="disabledInput" type="text" value="{{$product->designation}}" placeholder="Désignation">

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Composition</label>
                                    <input class="form-control" id="disabledInput" type="text" name="composition" value="{{$product->composition}}" placeholder="Composition">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Couleur du produit</label>
                                            <input class="form-control"  id="col" type="text" name="color" value="{{$product->color}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label ></label>
                                            <input type="color" onchange="document.getElementById('col').value = this.value" class="form-control" id="exampleInputEmail1" value="{{$product->color}}" placeholder="Code..">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Poids (en kg)</label>
                                    <input class="form-control" name="weight" value="{{$product->weight}}" id="disabledInput" type="number" placeholder="Poids">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Hauteur(cm)</label>
                                            <input class="form-control"  name="height" value="{{$product->height}}" type="number" placeholder="hauteur">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Largeur(cm)</label>
                                            <input class="form-control" name="width" value="{{$product->width}}" type="number" placeholder="Largeur">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Profondeur(cm)</label>
                                            <input class="form-control" name="depth" value="{{$product->depth}}" type="number" placeholder="Profondeur">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Prix public</label>
                                    <input class="form-control" name="public_price" value="{{$product->public_price}}" id="disabledInput" type="number" placeholder="prix">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Durée de validité de produit fermé ( en jours)</label>
                                    <input class="form-control" name="period_of_validity" value="{{$product->period_of_validity}}" type="number" placeholder="durée de validité de produit fermé">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Durée de validité aprés ouverture ( en heures)</label>
                                    <input class="form-control"  value="{{$product->validity_after_opening}}" name="validity_after_opening" type="number" placeholder="duree de validité apres ouverture">
                                </div>

                                <div class="form-group">
                                    <label>Commentaires (optionnel)</label>
                                    <textarea class="form-control" rows="3" placeholder="Commentaires" name="comment">{{$product->comment}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Photo du produit (optionnel)</label>
                                    <input type="file" name="photo_url" id="exampleInputFile">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre d'unitée par display</label>
                                    <input class="form-control" name="unit_by_display" value="{{$product->unit_by_display}}" id="disabledInput" type="number" placeholder="prix">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre de display par colis</label>
                                    <input class="form-control" name="unit_per_package" value="{{$product->unit_per_package}}" type="number" placeholder="durée de validité de produit fermé">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">colisage</label>
                                    <input class="form-control" name="packing" value="{{$product->packing}}" id="disabledInput" type="number" placeholder="duree de validité apres ouverture">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Possibilités de mélange</label>
                                </div>
                                @forelse($product->mixtures as $key=>$mixture)
                                <div class="box" style="border:1px solid rgb(228, 228, 228);background:rgb(228, 228, 228);">
                                    <div class="box-body">
                                        <input type="hidden" name="mixtures[{{$key}}][]"  required value="{{$mixture->id}}">
                                            <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nom du mélange</label>
                                                    <input class="form-control" id="disabledInput" type="text" placeholder="Nom du mélange"
                                                    value="{{$mixture->name}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Quantité de produit fini(en litre)</label>
                                                    <input class="form-control" id="disabledInput" type="number" step="0.01"
                                                        placeholder="Quantité de produit fini.."  value="{{$mixture->final_amount}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Poids necessaire du produit (en kg)</label>
                                                    <input class="form-control" id="disabledInput" type="number" placeholder="Poids.."
                                                        step="0.01"  value="{{$mixture->needed_weight}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Quantité d'eau (en litre)</label>
                                                    <input class="form-control" id="disabledInput" type="number" step="0.01"
                                                        placeholder="Quantité eau..."  value="{{$mixture->water_amount}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Quantité de sucre (en kg)</label>
                                                    <input class="form-control" id="disabledInput" type="number" step="0.01"
                                                        placeholder="Quantité sucre..."  value="{{$mixture->sugar_amount}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Volume de verre (en cl)</label>
                                                    <input class="form-control" id="disabledInput" type="number" step="0.01"
                                                        placeholder="Volume de verre..."  value="{{$mixture->glass_size}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nombre de verre obtenu </label>
                                                    <input class="form-control" id="disabledInput" type="number"
                                                        placeholder="Nombre de verre.."  value="{{$mixture->number_of_glasses}}" name="mixtures[{{$key}}][]"  required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- box-footer -->
                                </div>
                                    @empty
                                    @endforelse


                                <div class="row">
                                    <div class="container text-center">
                                        <a href="{{route('showProducts')}}" class="btn btn-danger pl-1">Annuler</a>
                                        <button  class="btn btn-success pl-1" type="submit">Confirmer</button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>
    </div>


@endsection
