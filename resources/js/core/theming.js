module.exports = {
    mixins: [
        require('./../mixins/local-storage'),
    ],


    mounted() {
        this.getUserTheme();
    },


    created() {
        Bus.$on('mercuriusThemeChange', (theme) => {
            this.onThemeChange(theme)
        });
    },


    computed: {
        darkMode() {
            return this.user.dark_mode;
        },
    },


    methods: {
        /**
         * Set application style DarkMode On/Off.
         *
         * @param {boolean} val
         */
        onThemeChange(val) {
            let _LS = this.saveLocalStorage(val)
            this.getUserTheme()
        },

        /**
         * Get user settings from LocalStorage.
         */
        getUserTheme() {
            let _LS = this.readLocalStorage()
            this.user.dark_mode = _LS.dark_mode;
        },
    }
};
