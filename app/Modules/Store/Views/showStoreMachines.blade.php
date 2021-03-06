@extends('General.layoutStore')
@section('pageTitle', 'Liste des locations machines')
@section('content')

<div class="content-wrapper">

    <section class="content-header">
    {{ Breadcrumbs::render('detailStoreMachines',$store->company,$store->designation) }}

    </section>


    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Liste des machines en location </h3>
                        @if(Auth::user()->primaryAdmin())
                        <a href="{{route('showStartRentalMachines')}}" class="btn btn-primary pull-right">Commencer location</a>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="scrollable-table">
                                <table class="table table-bordered table-hover example2">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th class="is-wrapped" >Code</th>
                                                <th class="is-wrapped" >Désignation</th>
                                                <th class="is-wrapped" >Affichage Tablette</th>
                                                <th class="is-wrapped" >Nombre de bacs</th>
                                                <th class="is-wrapped" >Etat</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rentals as $rental)
                                            <tr>
                                            @if($rental->machine->photo_url)
                                                <td> <img src="{{asset('/img/'.$rental->machine->photo_url)}}" width="100" class="user-image"
                                                        alt="User Image"> </td>
                                                @else
                                                <td> <img src="{{asset('/img')}}/no-logo.png" width="100" class="user-image"
                                                        alt="User Image"> </td>
                                                        @endif
                                                <td>{{$rental->machine->code}}</td>
                                                <td>{{$rental->machine->designation}}</td>
                                                <td>{{$rental->machine->display_tablet == 1 ? 'Oui' : 'Non'}}</td>
                                                <td>{{$rental->machine->bacs->count()}}</td>
                                                <td>{{$rental->machine->status}}</td>
                                                <td class="not-this text-center">
                                                    <div class="btn-group">
                                                        <a href="#" class="dots" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"></a>
                                                            <ul class="dropdown-menu edit" role="menu"
                                                            style="margin-left:-175px !important;">
                                                            <li><a href="{{route('showRental', $rental->id)}}">Voir détails location</a></li>
                                                            @if($rental->machine->rented==false)
                                                            <li><a href="{{route('startRental', $rental->id).'?machine=true'}}">Commencer
                                                                    location</a></li>
            
                                                            <li><a href="{{route('showListRental', $rental->id).'?machine=true'}}">Voir
                                                                    historique des locations</a></li>
                                                            <li><a href="{{route('showHistoryMachine',$rental->machine->id)}}">Voir détails machine</a></li>
                                                            @else
                                                            @if(Auth::user()->primaryAdmin())  
                                                            <li><a
                                                                    href="{{route('showEndRental', $rental->id)}}">Arrêter
                                                                    location</a></li>
                                                                    @endif
                                                            <li><a href="{{route('showListRental', $rental->machine->id).'?machine=true'}}">Voir
                                                                    historique des locations</a></li>
                                                            <li><a href="{{route('showHistoryMachine',$rental->machine->id)}}">Voir détails machine</a></li>
                                                            @endif
                                                            @if(Auth::user()->primaryAdmin())  
                                                            <li><a href="{{route('machineStatusEdit', $rental->machine->id)}}">Mettre à jour
                                                                    état</a></li>
                                                            <li><a href="{{route('editMachine', $rental->machine->id)}}">Modifier</a></li>
                                                            <li><a href="" data-toggle="modal"
                                                                    data-target="#modal-default{{$rental->machine->id}}">Supprimer</a></li>
                                                                    @endif
                                                        </ul>
            
                                                        <div class="modal fade" id="modal-default{{$rental->machine->id}}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title">Voulez vous vraiment supprimer cette
                                                                        machine ?</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                            <h5 class="modal-title"> <b>Attention </b> : La suppression de cette entité est irreversible, procéder à la suppression?
                                                                
                                                            </h5>
                                                        </div>
                                                                    <div class="modal-footer">
                                                                        <div class="text-center">
                                                                            <form
                                                                                action="{{route('deleteMachine', $rental->machine->id)}}"
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
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                <h4>Aucune location trouvée !</h4>
            
                                                </td>
                                            </tr>
            
                                            @endforelse
            
                                        </tbody>
            
                                    </table>
                        </div>
               
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
