@extends('mercurius::master')

@section('content')
    @include('mercurius::inc.profile-dropdown')

    <div class="conversations_empty" v-show="showEmptyWrap" v-cloak>
        <h4 class="title">@{{ __('conversations_empty') }}</h4>
    </div>

    <mercurius-sidebar>
        <conversations-filter></conversations-filter>
        <conversations :conversations="conversations"></conversations>
        <btn-compose></btn-compose>
    </mercurius-sidebar>


    <btn-sidebar-toggle></btn-sidebar-toggle>


    <div class="mercurius__container">
        <recipient></recipient>
        <messages :conversation="conversation"></messages>
        <composer :conversation="conversation"></composer>
    </div>



    @include('mercurius::inc.modal-profile-settings')
@endsection
