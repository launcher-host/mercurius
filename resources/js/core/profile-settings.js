module.exports = {
    props: ['user'],


    data() {
        return {
            busy: false,
        }
    },


    methods: {
        toggleOnlineStatus() {
            this._saveUserSetting('is_online')
        },
        toggleNotifications() {
            this._saveUserSetting('be_notified')
        },
        toggleDarkMode() {
            Bus.$emit('mercuriusThemeChange', {'dark_mode': !this.dark_mode });
        },

        _saveUserSetting(key) {
            if (this.busy) return

            let val = !this.user[key]

            this.user[key] = val;

            let params = {
                setting_key: key,
                setting_val: val,
            }

            axios.post('/profile', params)
                .then(response => {
                    Bus.$emit('mercuriusProfileUpdated', key, val);
                })
                .catch(err => swal(__('err_hd'), __('err_profile_updating'), 'error'))
                .finally(() => {this.busy = false});
        },
    },


    computed: {
        is_online() {
            return this.user.is_online;
        },
        be_notified() {
            return this.user.be_notified;
        },
        dark_mode() {
            return this.user.dark_mode;
        },
    },
};
