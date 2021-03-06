@extends('General.layoutCompany') @section('pageTitle', 'Modifer un contact') @section('content')


<div class="content-wrapper" id="app">

    <section class="content-header" >

        {{ Breadcrumbs::render('editContact',$company,$user) }}
    </section>
   

   @if($user->getType() == 'Directeur')
    <contact-update :company="{{$company}}" :user="{{$user}}" :related_data="{{$relatedData}}" user_type="{{$type}}" :is_director="true" user_id="{{Auth::user()->id}}"> </contact-update>
    @elseif($user->getType() == 'Autre')
    <contact-update :company="{{$company}}" :user="{{$user}}" :related_data="{{$relatedData}}" user_type="{{$type}}" :free_stores="{{$freeStores}}" :is_director="false" user_id="{{Auth::user()->id}}"> </contact-update>
    @endif

</div>


@endsection
