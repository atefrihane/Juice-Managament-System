@extends('General.layoutCompany')
@section('pageTitle', $company->name)
@section('content')
<style>
    .dots:after {
        content: '\f141';
        font-family: FontAwesome;
        font-size: 20px;
        color: black;


    }

    .edit {
        margin: 6px -20px 0 !important;
        min-width: 100px;
    }

</style>
<div class="content-wrapper">
    <section class="content-header">
        {{ Breadcrumbs::render('detail', $company) }}

    </section>

    <div class="container" style="margin-top:50px;">
        <section class="content-header">
            <h1>
                Informations de la societé
                <small> {{$company->name}}</small>
            </h1>
            <div class="btn-group breadcrumb1">
                <a href="#" class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                <ul class="dropdown-menu edit" role="menu">
                    <li><a href="{{route('editCompany', $company->id)}}">Modifier</a></li>

                    <li><a href="{{route('deleteCompany', $company->id)}}">Supprimer</a></li>

                </ul>
            </div>

        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset( $company->logo) }}" style="width:100%;padding:40px;">
                </div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Code</label>
                                            <input type="text" class="form-control" value="{{$company->code}}" readonly
                                                aria-describedby="emailHelp" placeholder="Code..">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Statut</label>
                                            <input type="text" class="form-control"
                                                value="{{$company->status == 0 ? 'Fermé' :  $company->status == 1 ?'En sommeil': 'Active'   }}"
                                                readonly placeholder="Nom du groupe">

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nom du groupe</label>
                                    <input type="text" class="form-control" value="{{$company->name}}" readonly
                                        placeholder="Nom du groupe">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Désignation</label>
                                    <input type="text" class="form-control" value="{{$company->designation}}" readonly
                                        placeholder="Désignation">
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ville</label>
                                            <input type="text" class="form-control" value="{{$company->city->name}}"
                                                readonly aria-describedby="emailHelp" placeholder="Ville">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Code Postal</label>
                                            <input type="text" class="form-control" value="{{$company->zipcode->code}}"
                                                readonly placeholder="Code Postal">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Adresse de siége</label>
                                    <input type="text" class="form-control" value="{{$company->address}}" readonly
                                        placeholder="Adresse de siége">
                                </div>



                                <div class="form-group">
                                    <label for="exampleInputPassword1">Complément addresse (optionnel )</label>
                                    <input type="text" class="form-control" value="{{$company->complement}}" readonly
                                        placeholder="Complément addresse">
                                </div>

                                <div class="form-group">
                                    <label>Commentaires (optionnel)</label>
                                    <textarea class="form-control" rows="3" readonly
                                        placeholder="Commentaires">{{$company->comment}}</textarea>
                                </div>





                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="box box-primary">
                <div class="box-body">
                    <h4>
                        Historique de la societé
                        <small> {{$company->name}}</small>
                    </h4>
                    <table class="table table-bordered table-hover example2">
                        <thead>
                            <tr>
                                <th>Modifications</th>
                                <th>Effectuée par</th>
                                <th> Date et heure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company->histories as $history)
                            <tr>
                                <td>{{$history->changes}}</td>
                                <td>{{ucfirst($history->user->nom)}} {{ucfirst($history->user->prenom)}}</td>
                                <td>{{ $history->created_at->format('d-m-Y')}}
                                    {{ $history->created_at->timezone('Europe/Paris')->format('H:i:s')}}</td>
                            </tr>
                            @empty

                            @endforelse




                        </tbody>

                    </table>
                </div>

            </div>
        </section>


    </div>
</div>
@endsection
