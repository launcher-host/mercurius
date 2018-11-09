export default {
    data() {
        return {
            is_loading:     false,
            conversationId: false,
            offset:         0,    // takes value of -1 when reaches the end
            pagesize:       20,   // pagination size
            messages:       [],
        }
    },


    methods: {
        /**
         * Reset messages loader.
         */
        loadMessagesReset(id = false) {
            this.conversationId = id
            this.messages       = []
            this.offset         = 0
        },


        /**
         * Start loading messages for a given conversation id.
         *
         * @param  {mixed} conversationId
         * @return {Promise}
         */
        async loadMessagesStart(conversationId) {
            this.loadMessagesReset(conversationId);

            return this.loadMessages();
        },


        /**
         * Load messages with pagination.
         *
         * @return {Promise}
         */
        async loadMessages() {
            if (this.is_loading || this.offset < 0) return;

            let params = {
                offset:   this.offset,
                pagesize: this.pagesize,
            }

            this.is_loading = true
            this.offset += this.pagesize

            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    axios.post('/conversations/'+this.conversationId, params)
                        .then(res => {
                            this.messages.push.apply(this.messages, res.data)

                            if (res.data.length < this.pagesize) this.offset = -1

                            resolve(res);
                        })
                        .catch(err => {
                            swal(
                                __('err_hd'),
                                __('err_messages_load')
                                +'\n'+error.response.data.message,
                                'error'
                            )
                            reject(errors);
                        })
                        .finally(() => {
                            this.is_loading = false
                        });
                }, 500);
            });
        },


        /**
         * Deletes a message.
         *
         * @param  {object} message
         */
        deleteMessage(msg) {
            swal({
                title: __('message_delete_hd'),
                text: __('message_delete_alt'),
                icon: "warning",
                dangerMode: true,
                buttons: {
                    cancel: {
                        text: __('btn_cancel'),
                        visible: true,
                        closeModal: true
                    },
                    confirm: {
                        text: __('message_delete_btn'),
                        closeModal: false
                    },
                },
            })
            .then((answer) => {
                if (!answer) return false;

                axios
                    .delete('/messages/'+msg.id)
                    .then(res => {
                        let idx = _.findIndex(this.messages, ['id', msg.id]);

                        Vue.delete(this.messages, idx)

                        let msgLatest = false;

                        // When removing the last message, we ensure
                        // that the conversations list is update with
                        // the latest message, so we attach that object.
                        //
                        if (idx === 0 && this.messages.length > 0) {
                            msgLatest = this.messages[0];
                        }

                        Bus.$emit('mercuriusMessageDeleted', msg, msgLatest);
                    })
                    .catch(err => {
                        swal(
                            __('err_hd'),
                            __('err_message_delete')
                            +'\n'+error.response.data.message,
                            'error'
                        )
                    })
                    .finally(() => swal.close())
            });
        },
    },
};
