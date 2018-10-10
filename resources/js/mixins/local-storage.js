/**
 * Handles browser LocalStorage for load and save user settings.
 *
 * This is only used for setting the dark_mode style.
 * Use this to extend with other settings.
 */
module.exports = {
    methods: {
        /**
         * The default object used with the LocalStorage.
         */
        getDefaultLocalStorage() {
            return {
                dark_mode: true,
            }
        },


        /**
         * Read the LocalStorage.
         */
        readLocalStorage() {
            let _LS = localStorage.getItem('mercurius')

            if (!_LS) {
                let _s = this.getDefaultLocalStorage()
                this.saveLocalStorage(_s)
                return _s
            }

            return JSON.parse(_LS)
        },


        /**
         * Save data on LocalStorage.
         */
        saveLocalStorage(data) {
            let _LS = localStorage.getItem('mercurius')
            if (!_LS) _LS = '{}'

            _LS = JSON.parse(_LS)

            _.merge(_LS, data);

            localStorage.setItem('mercurius', JSON.stringify(_LS));
        },
    }
};
