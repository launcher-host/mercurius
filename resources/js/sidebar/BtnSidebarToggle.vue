<template>
    <a
        href="#"
        class="btn_sidebar_toggle btn btn-link"
        v-model="closed"
        @click="toggleSidebar()"
    ><svg class="ic _ic-arrow-left"><use xlink:href="#icon-arrow-left"></use></svg>
        <h4 class="title" v-text="recipient"></h4>
    </a>
</template>


<script>
export default {
    data() {
        return {
            closed: false,
            recipient: '',
        }
    },


    created() {
        Bus.$on('mercuriusComposeNewMessage', () => this.updateStatus(__('return')));
        Bus.$on('mercuriusOpenConversation', (conv) => this.updateStatus(conv.user));
    },


    methods: {
        updateStatus(recipient) {
            this.recipient = recipient
            this.toggleSidebar(true);
        },
        onConversationOpen(conv) {
            this.recipient = conv.user
            this.toggleSidebar(true);
        },
        toggleSidebar(val = false) {
            this.closed = val || !this.closed;

            Bus.$emit('mercuriusSidebarToggle', this.closed)
        },
    }
}
</script>
