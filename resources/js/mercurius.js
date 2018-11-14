module.exports = {
    el: '#mercurius',


    mixins: [
        require('./core/notifications'),
        require('./core/theming'),
        require('./mixins/desktop-notification'),
    ],


    data() {
        return {
            user: {},
            conversations: [],
            conversation: false,
            is_loaded: false,
            finding_recipient: false,
        }
    },


    created() {
        this.user = Mercurius.user;

        Bus.$on('mercuriusConversationsLoaded', res => this.onConversationsLoaded(res));
        Bus.$on('mercuriusConversationDeleted', usrId => this.onConversationDeleted(usrId));
        Bus.$on('mercuriusOpenConversation', conv => this.onOpenConversation(conv));
        Bus.$on('mercuriusComposeNewMessage', () => this.onComposeNewMessage());
    },


    mounted() {
        this.listen();
    },


    computed: {
        showEmptyWrap() {
            return this.is_loaded
                && !this.finding_recipient
                && this.conversations.length === 0;
        },
    },


    methods: {
        /**
         * Setup event listener using Laravel Echo and Pusher.
         */
        listen() {
            Echo.private('mercurius.'+this.user.slug)
                .listen('.mercurius.message.sent', this.onMessageReceived)
                .listen('.mercurius.user.status.changed', this.onUserStatusChanged);
        },


        /**
         * Message was received.
         *
         * @param {object} msg Message object
         */
        onMessageReceived(msg) {
            Bus.$emit('mercuriusMessageReceived', msg.user, msg.sender, msg.message);

            if (this.user.be_notified) {
                this.desktopNotification(
                    msg.sender.name,
                    msg.sender.avatar,
                    msg.message.message
                );
            }
        },


        /**
         * When opening a conversation.
         */
        onOpenConversation(conv) {
            this.conversation = conv
            this.finding_recipient = false
        },


        /**
         * When composing a new message.
         */
        onComposeNewMessage() {
            this.conversation = false
            this.finding_recipient = true
        },


        /**
         * Conversation was loaded.
         */
        onConversationsLoaded(data) {
            this.conversations = data;
            this.is_loaded = true
        },


        /**
         * Conversation was deleted.
         */
        onConversationDeleted(recipient) {
            let _c = this.conversations
            let _i = _.findIndex(_c, ['slug', recipient])
            Vue.delete(_c, _i)

            if (this.conversation.slug === recipient) {
                this.conversation = {}
            }
        },


        /**
         * When the User changes his status Active/Inactive/Idle.
         *
         * @param {object} user
         */
        onUserStatusChanged(ev) {
            let _c = _.find(this.conversations, ['slug', ev.user])
            if (!_c) return

            _c.is_online = (ev.status === 'active')
        },
    },
};
