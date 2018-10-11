@extends('mercurius::master')

@section('content')
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">
            <a
                class="navbar-brand"
                href="{{ route('mercurius.home') }}">
                <img src="{{ asset('vendor/mercurius/img/logo-mercurius-bold-alt-sm.png') }}"
                    height="30px">
            </a>


            <!-- Right Side Navbar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="notification-bell nav-link mr-2"
                        href="{{ route('mercurius.home') }}">
                        <svg class="ic ic-bell"><use xlink:href="#icon-bell-outline"></use></svg>
                        <div class="notification-bell__total"
                             v-if="totalNotifications > 0"
                             v-text="totalNotifications"
                        ></div>
                    </a>
                </li>
                <li class="nav-item">
                    <b-dd
                        class="nav-link"
                        toggle-class="p-0"
                        menu-class="mt-2"
                        variant="link"
                        right
                    >
                        <template slot="button-content">
                            <mercurius-avatar
                                :name="user.name"
                                size="30"
                                :image="user.avatar"
                                :is_online="user.is_online"
                            ></mercurius-avatar>
                        </template>
                        <b-dd-item href="{{ route('mercurius.home') }}">Messenger</b-dd-item>
                        <b-dd-item v-b-modal.profile-settings>Settings</b-dd-item>
                        <b-dd-divider></b-dd-divider>
                        <b-dd-item href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </b-dd-item>
                    </b-dd>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container text-white-50">
        <div class="d-block my-5">
            <h2>Page Example</h2>
            <p>Shows the usage of the notification icon and the avatars.</p>
        </div>



        {{-- Avatar examples --}}
        <div class="row text-center mb-5">
            <div class="col col-xs-4">
                <mercurius-avatar
                    name="Lua"
                    size="150"
                    image="/vendor/mercurius/img/avatar/avatar_lua.png"
                    is_online
                ></mercurius-avatar>
            </div>
            <div class="col col-xs-4">
                <mercurius-avatar
                    name="Noa"
                    size="150"
                    image="/vendor/mercurius/img/avatar/avatar_noa.png"
                ></mercurius-avatar>
            </div>
            <div class="col col-xs-4">
                <mercurius-avatar
                    name="Ian"
                    size="150"
                    image="/vendor/mercurius/img/avatar/avatar_ian.png"
                    is_online
                ></mercurius-avatar>
            </div>
        </div>
    </div>


    @include('mercurius::inc.modal-profile-settings')
@endsection
