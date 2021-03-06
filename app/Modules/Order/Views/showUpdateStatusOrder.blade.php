@extends('General.vue_layout') @section('pageTitle', 'Modifier état de la commande') @section('content')
<style>
    .swal-btns > .swal2-actions > .swal2-styled.swal2-cancel,
    .swal-btns > .swal2-actions > .swal2-styled.swal2-confirm {

        width: 310px !important;
    }
    .v-spinner {
        position:absolute;
        top:50%;
        left:50%;
    }

</style>
<div class="content-wrapper">

    <section class="content-header">

        {{ Breadcrumbs::render('showUpdateStatusOrder',$order) }}
    </section>

    <section class="content" id="app">
        <div class="row">
            <div class="container-fluid">

                <order-status-update 
                :order_full="{{$order}}"
                :order_id="{{$order->id}}"
                code="{{$order->code}}"
               :status="{{$order->status}}"
               :user_id="{{Auth::user()->id}}" 
               :history="{{$history ? $history  :   'null' }}"
                :is_preparator="{{Auth::user()->preparator() ? Auth::user()->preparator()  : 0}}"
               > 
                </order-status-update>


            </div>

        </div>

    </section>

</div>


@endsection
<script>
function myFunction(id)
{
    let clientsArr =  JSON.parse(localStorage.getItem('balance')) || [];
   clientsArr.push(id);
   localStorage.setItem('balance', JSON.stringify(clientsArr));;
}
</script>