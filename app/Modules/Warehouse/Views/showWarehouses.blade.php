@extends('General.layout')
@section('pageTitle', 'Liste des entrepôts')
@section('content')

<div class="content-wrapper">

    <section class="content-header">


        {{ Breadcrumbs::render('warhouses') }}
    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Liste des entrepôts</h3>
                        @if(Auth::user()->primaryAdmin())
                        <a href="{{route('showAddWarehouse')}}" class="btn btn-primary pull-right">Ajouter un
                            entrepôt</a>
                        @endif


                        <!-- <h3 class="box-title pull-right"><a href=""> /a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body scrollable-table">
                        <table class="table table-bordered table-hover example2">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th class="is-wrapped">Code</th>
                                    <th class="is-wrapped">Désignation</th>
                                    <th class="is-wrapped">Ville</th>
                                    <th class="is-wrapped">Code postal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($warehouses as $warehouse)
                                <tr class="table-t">
                                    @if($warehouse->photo)
                                    <td  data-url="{{route('showWarehouse',$warehouse->id)}}" style="width: 150px"> <img
                                            src="{{asset('/img/'.$warehouse->photo)}}" height="80" class="user-image"
                                            alt="User Image"> </td>
                                    @else
                                    <td data-url="{{route('showWarehouse',$warehouse->id)}}" style="width: 150px"> <img
                                            src="{{asset('/img')}}/no-logo.png" height="80" class="user-image"
                                            alt="User Image"> </td>
                                    @endif
                                    <td data-url="{{route('showWarehouse',$warehouse->id)}}">{{$warehouse->code}}</td>
                                    <td data-url="{{route('showWarehouse',$warehouse->id)}}">{{$warehouse->designation}}
                                    </td>
                                    <td data-url="{{route('showWarehouse',$warehouse->id)}}">
                                        {{ucfirst($warehouse->city->name)}}</td>
                                    <td data-url="{{route('showWarehouse',$warehouse->id)}}">
                                        {{$warehouse->zipcode->code}}</td>
                                    <td class="not-this text-center">

                                        <button type="button" class="btn btn-block btn-primary style-button-dropdown"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="style-dropdown">Plus</span></button>

                                        <ul class="dropdown-menu edit" role="menu">

                                            <li><a href="{{ route('showWarehouse',$warehouse->id) }}">       <span class="dropdown-font">Voir les
                                                    détails</span></a> </li>
                                            @if(Auth::user()->primaryAdmin())
                                            <li><a href="{{ route('showUpdateWarehouse',$warehouse->id) }}">       <span class="dropdown-font">Modifier</span></a>
                                            </li>
                                            <li><a data-toggle="modal"
                                                    data-target="#modal-default{{$warehouse->id}}">       <span class="dropdown-font">Supprimer</span></a></li>
                                            @endif
                                        </ul>

                                        <div class="modal fade" id="modal-default{{$warehouse->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title">Voulez vous vraiment supprimer cet
                                                            entrepôt ?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="modal-title"> <b>Attention </b> : La suppression de
                                                            cette entité est irreversible, procéder à la suppression?

                                                        </h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="text-center">
                                                            <form
                                                                action="{{ route('handleDeleteWarehouse',$warehouse->id) }}"
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
                 
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <h4>Aucun entrepôt existant !</h4>
                        </td>
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



@endsection
