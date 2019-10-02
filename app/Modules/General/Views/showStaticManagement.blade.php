@extends('General.layout')
@section('pageTitle', 'Gestion des constantes')
@section('content')


<div class="content-wrapper">

    <section class="content-header">

        {{ Breadcrumbs::render('static') }}
    </section>


    <section class="content">


        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Gestion des pays,villes et codes postaux </h3>
                        <a href="{{route('showAddCountry')}}" class="btn btn-primary pull-right">Ajouter un pays</a>


                        <!-- <h3 class="box-title pull-right"><a href=""> /a></h3> -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">


                        <table class="table table-bordered table-hover example2">
                            <thead>
                                <tr>
                                    <th>Pays</th>
                                    <th>Code téléphonique</th>
                                    <th>Nombre des villes</th>
                                    <th>Nombre des codes postaux</th>
                                    <th></th>
                             </tr>
                            </thead>
                            <tbody>
                            @forelse($countries as $country)
                            <tr class="table-tr">
                                
                                    <td>{{$country->name}}</td>
                                    <td>{{$country->code}}</td>
                                    <td>{{$country->cities->count()}}</td>
                                    <td>{{$country->zipcodes->count()}}</td>
                                  
                                    <td class="not-this text-center" data-url="javascript:void(0)">
                                        <div class="btn-group">
                                            <a class="dots" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"></a>
                                            <ul class="dropdown-menu edit" role="menu">
                                                <li><a href="{{route('showUpdateCountry',$country->id)}}">Modifier</a></li>
                                                <li>
                                                    <a data-toggle="modal"
                                                        data-target="#modal-default{{$country->id}}">Supprimer</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                <div class="modal fade" id="modal-default{{$country->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">Vous voulez vraiment supprimer ce pays ?
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p> Ce processus ne peut pas être annulé.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="text-center">
                                                    <form action="{{ route('handleDeleteCountry',$country->id) }}"
                                                        method="post">
                                                        {{csrf_field()}}
                                                        <a href="#" class="btn btn-danger"
                                                            data-dismiss="modal">Annuler</a>

                                                        <button type="submit" class="btn btn-success">Confirmer</button>
                                                      

                                                    </form>

                                                </div>


                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>

                                    <!-- /.modal-dialog -->
                                </div>

                            @empty
                            @endforelse




                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>


            </div>
            <!-- /.col -->
        </div>

    </section>

</div>


@endsection
