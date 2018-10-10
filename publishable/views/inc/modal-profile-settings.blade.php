<profile-settings :user="user" inline-template>
    <b-modal
        id="profile-settings"
        modal-class="profile-modal"
        body-class="profile-modal__body"
        size="sm"
        centered
        hide-footer
        >
        <div class="text-center mb-3">
            <mercurius-avatar
                size="100"
                border="3"
                :name="user.name"
                :image="user.avatar"
                :is_online="user.is_online"
            ></mercurius-avatar>
            <h4 v-text="user.name" class="profile-name my-2"></h4>
            <h3>{{ __('mercurius.settings') }}</h3>
        </div>
        <button
            class="profile-option-btn btn btn-link"
            :class="{active: is_online}"
            @click="toggleOnlineStatus"
        >
            <svg class="ic ic-on-off"><use xlink:href="#icon-on-off"></use></svg>
            <span class="title">{{ __('mercurius.status') }}</span>
            <span class="alt" v-if="is_online">{{ __('mercurius.available') }}</span>
            <span class="alt" v-else>{{ __('mercurius.invisible') }}</span>
        </button>
        <button
            class="profile-option-btn btn btn-link"
            :class="{active: be_notified}"
            @click="toggleNotifications"
        >
            <svg class="ic ic-bell-outline"><use xlink:href="#icon-bell-outline"></use></svg>
            <span class="title">{{ __('mercurius.notifications') }}</span>
            <span class="alt" v-if="be_notified">{{ __('mercurius.notify_yes') }}</span>
            <span class="alt" v-else>{{ __('mercurius.notify_no') }}</span>
        </button>
        <button
            class="profile-option-btn btn btn-link"
            :class="{active: dark_mode}"
            @click="toggleDarkMode()"
        >
            <svg class="ic ic-dark-mode"><use xlink:href="#icon-dark-mode"></use></svg>
            <span class="title">{{ __('mercurius.dark_mode') }}</span>
            <span class="alt" v-if="dark_mode">{{ __('mercurius.enabled') }}</span>
            <span class="alt" v-else>{{ __('mercurius.disabled') }}</span>
        </button>
    </b-modal>
</profile-settings>
