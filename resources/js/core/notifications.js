module.exports = {
    data() {
        return {
            notifications: 0,
        }
    },


    mounted() {
        this.getNotifications();
    },


    computed: {
        totalNotifications() {
            return this.notifications;
        },
    },


    methods: {
        /**
         * Get notifications with the total unread conversations.
         */
        getNotifications() {
            axios.get('/profile/notifications')
                .then(res => {
                    if (res.status != 200) {
                        swal(__('err_hd'), __('err_profile_notifications'), 'error')
                        return
                    }
                    this.notifications = res.data.total;
                })
                .catch(err => swal(
                    __('err_hd'),
                    __('err_profile_notifications'),
                    'error')
                );
        },
    }
};
