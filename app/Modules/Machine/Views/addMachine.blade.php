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
                                    <input type="text" name="code" class="form-control code" id="exampleInputEmail1" placeholder="Code" value="{{old('code')}}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Etat</label>
                                        <select class="form-control" name="status" required>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : ''}}>Fonctionnelle</option>
                                            <option value="2" {{ old('status') == '2' ? 'selected' : ''}}>Non utilisé</option>

                                            <option value="0" {{ old('status') == '0' ? 'selected' : ''}} >En panne</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                                <div class="form-group">
                                        <label for="exampleInputEmail1">Code à barres</label>
                                        <input class="form-control" name="barcode" id="disabledInput" type="text" placeholder="Code à barres" value="{{old('barcode')}}" required>

                                    </div>



                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Désignation</label>
                                        <input class="form-control designation" name="designation" id="disabledInput" type="text" placeholder="Désignation" pattern=".{6,}" title="6 caractères minimum" value="{{old('designation')}}"  required>

                                    </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type</label>
                                        <select class="form-control" name="type">
                                            <option value="jus" {{ old('type') == 'jus' ? 'selected' : ''}}>Jus </option>
                                            <option value="granite" {{ old('type') == 'granite' ? 'selected' : ''}}>Granité</option>
                                            <option value="jus-granite" {{ old('type') == 'jus-granite"' ? 'selected' : ''}}> Jus et Granité</option>
                                        </select>


                                    </div>
                                </div>

                                      <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre de bacs</label>
                                        <select name="number_bacs" class="form-control">
                                            <option value="1" {{ old('number_bacs') == '1' ? 'selected' : ''}}>1</option>
                                            <option value="2" {{ old('number_bacs') == '2' ? 'selected' : ''}}>2</option>
                                            <option value="3" {{ old('number_bacs') == '3' ? 'selected' : ''}}>3</option>
                                            <option value="4" {{ old('number_bacs') == '4' ? 'selected' : ''}}>4</option>
                                            <option value="5" {{ old('number_bacs') == '5' ? 'selected' : ''}}>5</option>
                                        </select>


                                    </div>
                                </div>


                            </div>
                                 <div class="form-group">
                                        <label for="exampleInputEmail1">Affichage tablette</label>
                                        <select class="form-control" name="display_tablet">
                                                 <option value="true"  {{ old('display_tablet') == 'true' ? 'selected' : ''}}>Oui</option>
                                                 <option value="false" {{ old('display_tablet') == 'false' ? 'selected' : ''}}>Non</option>
                                         </select>


                                    </div>

                                         <div class="form-group">
                                        <label for="exampleInputEmail1">Prix de location mensuelle ( en euros )</label>
                                         <input class="form-control" id="disabledInput" name="price_month" type="number" step="0.01" placeholder="Prix de location mensuelle ( en euros )" value="{{old('price_month')}}"  required>

                                    </div>


                                        <div class="form-group">
                                        <label>Commentaires (optionnel)</label>
                                        <textarea class="form-control" rows="3" name="comment" placeholder="Commentaires">{{old('comment')}}</textarea>
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
