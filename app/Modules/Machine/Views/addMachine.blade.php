@extends('General.layout') @section('pageTitle', 'Ajouter une machine') @section('content')


<div class="content-wrapper">

    <section class="content-header">

        {{ Breadcrumbs::render('addMachine') }}
    </section>

    <section class="content">
        <div class="row">
            <div class="container">

                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title"> Ajouter une machine</h3>

                    </div>

                    <form role="form" method="post" enctype="multipart/form-data" action="{{route('storeMachine')}}">
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

                            

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Code</label>
                                        <input type="text" name="code" class="form-control code" id="exampleInputEmail1" placeholder="Code" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Etat</label>
                                        <select class="form-control" name="status" required>
                                            <option value="Fonctionnelle">Fonctionnelle</option>
                                            <option value="Non utilisé">Non utilisé</option>

                                            <option value="En panne">En panne</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                                <div class="form-group">
                                        <label for="exampleInputEmail1">Code à barres</label>
                                        <input class="form-control" name="barcode" id="disabledInput" type="text" placeholder="Code à barres" required>

                                    </div>



                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Désignation</label>
                                        <input class="form-control designation" name="designation" id="disabledInput" type="text" placeholder="Désignation" pattern=".{6,}" title="6 caractères minimum" required>

                                    </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label>
                                        <select class="form-control" name="type">
                                            <option value="jus">Jus </option>
                                            <option value="granite">Granité</option>
                                            <option value="jus-granite">Jus et Granité</option>
                                        </select>


                                    </div>
                                </div>

                                      <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre de bacs</label>
                                        <select name="number_bacs" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>


                                    </div>
                                </div>


                            </div>
                                 <div class="form-group">
                                        <label for="exampleInputEmail1">Affichage tablette</label>
                                        <select class="form-control" name="display_tablet">
                                                 <option value="true">Oui</option>
                                                 <option value="false">Non</option>
                                         </select>


                                    </div>

                                         <div class="form-group">
                                        <label for="exampleInputEmail1">Prix de location mensuelle ( en euros )</label>
                                        <input class="form-control" id="disabledInput" name="price_month" type="number" step="0.01" placeholder="Prix de location mensuelle ( en euros )"  required>

                                    </div>


                                        <div class="form-group">
                                        <label>Commentaires (optionnel)</label>
                                        <textarea class="form-control" rows="3" name="comment" placeholder="Commentaires"></textarea>
                                        </div>

                                    <div class="form-group">
                                    <label for="exampleInputFile">Photo du machine (Optionnel)</label>
                                    <input type="file" name="photo" id="exampleInputFile">


                                     </div>

                                    <div class="row">
                                    <div class="container text-center">

                                    <a href="{{route('showMachines')}}" class="btn btn-danger pl-1" style="margin: 1em">Annuler</a>
                                    <button type="submit" class="btn btn-success pl-1" style="margin: 1em">Confirmer</button>

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
@section('dynamicProduct.script')
<script>
$('document').ready(function(){

  var newProduct=$('.box-color').html();
  var newButton=$('.clicked').html();
$('.clicked').click(function(){
// var html="";
// html+= '<div class="box-tools pull-right">';
// html+='<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>';
// html+=' <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>';
// html+='</div>';
// $(newProduct).prepend(html);

$('.box-color').append(newProduct);
$('.products').each(function(i, obj) {
   if (i!=0) {
    $(this).children(":first").css("display","block");


      }
});

});

   $(document).on('click', '.removed', function(){
    $(this).parent().parent().slideUp();
});

});
</script>
@endsection
