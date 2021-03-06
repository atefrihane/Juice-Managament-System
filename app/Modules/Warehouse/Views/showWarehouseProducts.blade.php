@extends('General.layout')
@section('pageTitle', 'Liste des produits en stock')
@section('content')

<div class="content-wrapper">

    <section class="content-header">

        {{ Breadcrumbs::render('productWarehouse') }}
    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Liste des produits en stock</h3>
                        @if(Auth::user()->preparatorAdmin())
                        <a href="{{route('showAddProductQuantity')}}" class="btn btn-primary pull-right">Ajouter une
                            entrée</a>
                            @endif


                        <!-- <h3 class="box-title pull-right"><a href=""> /a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body scrollable-table">
                        <table class="table table-bordered table-hover example2 ">
                            <thead>
                                <tr>

                                    <th class="is-wrapped" >Nom Produit</th>
                                    <th class="is-wrapped" >Quantité(nbr des unités)</th>
                                    <th class="is-wrapped" >Unités par diplay</th>
                                    <th class="is-wrapped" >Displays par colis</th>
                                    <th class="is-wrapped" >Colisage</th>
                                    <th class="is-wrapped" >Entrepôt</th>
                                    <th class="is-wrapped" >Date de fabrication</th>
                                    <th class="is-wrapped" >Date de péremption</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouseProducts as $warehouseProduct)
                                <tr>
                                    <td>{{$warehouseProduct->product->nom}}</td>
                                    <td>{{$warehouseProduct->quantity}}</td>
                                    <td>{{ $warehouseProduct->stock_display }}</td>
                                    <td>{{ $warehouseProduct->packing_display }}</td>
                                    <td>{{$warehouseProduct->packing}}</td>
                                    <td>{{$warehouseProduct->warehouse->designation}}</td>
                                    <td> {{ Carbon\Carbon::parse($warehouseProduct->creation_date)->format('d-m-Y') }}</td>
                                    <td> {{ Carbon\Carbon::parse($warehouseProduct->expiration_date)->format('d-m-Y') }}</td>
                                    <td class="not-this text-center">
                                   
                                            <button type="button"
                                            class="btn btn-block btn-primary style-button-dropdown"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="style-dropdown">Plus</span></button>
                                                @if(Auth::user()->primaryAdmin())
                                            <ul class="dropdown-menu edit" role="menu">
                                                <li><a href="{{route('showEditProductQuantity',$warehouseProduct->id)}}"><span
                                                    class="dropdown-font">Modifier</span></a></li>
                                                <li><a href="#" data-toggle="modal"
                                                        data-target="#modal-default{{$warehouseProduct->id}}"><span
                                                        class="dropdown-font">Supprimer</span></a>
                                                </li>

                                            </ul>
                                            @endif
                                      
                                    </td>


                                    <div class="modal fade" id="modal-default{{$warehouseProduct->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Voulez vous vraiment supprimer ce
                                                        produit ?</h4>
                                                </div>
                                                <div class="modal-body">
                                                <h5 class="modal-title"> <b>Attention </b> : La suppression de cette entité est irreversible, procéder à la suppression?
                                                    
                                                </h5>
                                            </div>
                                                <div class="modal-footer">
                                                    <div class="text-center">
                                                        <form
                                                            action="{{ route('handleDeleteWarehouseQuantity',$warehouseProduct->id) }}"
                                                            method="post">
                                                            {{csrf_field()}}
                                                            <a href="#" class="btn btn-danger"
                                                                data-dismiss="modal">Annuler</a>

                                                            <button type="submit"
                                                                class="btn btn-success">Confirmer</button>
                                                        

                                                        </form>

                                                    </div>


                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">  <h4>Aucun produit en stock !</h4></td>
                                </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>


            </div>

        </div>

    </section>

</div>

<script>
    $('document').ready(function () {

        $('.treeview-menu').css('display', 'block');

    });

</script>


@endsection
