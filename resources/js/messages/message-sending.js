export default {
    data() {
        return {
            is_sending: false,
        }
    },


    methods: {
        /**
         * Sends a chat message.
         *
         * @param  {string} recipient
         * @param  {string} message
         *
         * @return {promise}
         */
        sendMessage(recipient, message) {
            this.is_sending = true

            axios.post('/messages', {
                message:   message,
                recipient: recipient
            })
            .then(response => {
                Bus.$emit('mercuriusMessageSent', response.data);
            })
            .catch(errors => {
                swal(__('err_hd'), __('err_message_send'), "error")
            })
            .finally(() => {
                this.is_sending = false
            });
        }
    }
};
