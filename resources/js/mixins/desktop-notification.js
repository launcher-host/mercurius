module.exports = {
    methods: {
        /**
         * Displays a desktop notification.
         *
         * @param  {string}  from     Sender name
         * @param  {string}  avatar   Sender avatar
         * @param  {string}  message  Message body
         * @param  {string} redirect  (optional) Redirect to url
         *
         * @return {void}
         */
        desktopNotification(from, avatar, message, redirect = false) {
            Notification.requestPermission(permission => {
                let notification = new Notification(from+':', {
                    body: message,
                    icon: avatar
                });

                // link to page when clicking the notification
                notification.onclick = () => {
                    window.open(redirect || window.location.href);
                };
            });
        }
    }
};
