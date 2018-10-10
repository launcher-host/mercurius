<b-dd
    class="profile-dropdown"
    toggle-class="p-0"
    menu-class="mt-2"
    variant="link"
    right
    >
    <template slot="button-content">
        <mercurius-avatar
            size="45"
            :name="user.name"
            :image="user.avatar"
            :is_online="user.is_online"
        ></mercurius-avatar>
    </template>
    <b-dd-item v-b-modal.profile-settings>Settings</b-dd-item>
    <b-dd-item href="{{ route('mercurius.example') }}">Page sample</b-dd-item>
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
