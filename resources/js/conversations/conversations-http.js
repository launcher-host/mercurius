module.exports = {
    data() {
        return {
            is_loading: false,
        }
    },


    methods: {
        /**
         * Load all conversations.
         *
         * @param  {string} recipient
         * @param  {string} message
         */
        loadConversations() {
            this.is_loading = true

            setTimeout(() => {
                axios.get('/conversations')
                    .then(res => {
                        Bus.$emit('mercuriusConversationsLoaded', res.data);
                    })
                    .catch(err => {
                        swal(
                            __('err_hd'),
                            __('err_conversations_load')
                            +'\n'+error.response.data.message,
                            'error'
                        )

                    })
                    .finally(() => {
                        this.is_loading = false
                    })
            }, 500);
        },


        /**
         * Deletes a conversation.
         *
         * @param  {string} recipient
         */
        deleteConversation(recipient) {
            swal({
                title: __('conversation_delete_hd'),
                text: __('conversation_delete_alt'),
                icon: "warning",
                dangerMode: true,
                buttons: {
                    cancel: {
                        text: __('btn_cancel'),
                        visible: true,
                        closeModal: true
                    },
                    confirm: {
                        text: __('conversation_delete_btn'),
                        closeModal: false
                    },
                },
            })
            .then((val) => {
                if (!val) return false;

                axios
                    .delete('/conversations/'+recipient)
                    .then(res => {
                        if (res.status != 200) {
                            swal(__('err_hd'), __('err_conversation_delete'), res.message)
                            return
                        }

                        Bus.$emit('mercuriusConversationDeleted', recipient);
                    })
                    .catch(error => {
                        swal(
                            __('err_hd'),
                            __('err_conversation_delete')
                            +'\n'+error.response.data.message,
                            'error'
                        )
                    })
                    .then(() => swal.close())
            });
        }
    },
};
