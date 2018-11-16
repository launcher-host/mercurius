<template>
    <a
        href="#"
        class="btn_sidebar_toggle btn btn-link"
        v-model="closed"
        @click="toggleSidebar()"
    ><svg class="ic _ic-arrow-left"><use xlink:href="#icon-arrow-left"></use></svg>
        <h4 class="title" v-text="title"></h4>
    </a>
</template>


<script>
export default {
    data() {
        return {
            closed: false,
            title: '',
        }
    },


    created() {
        Bus.$on('mercuriusComposeNewMessage', () => this.updateTitle(__('return')));
        Bus.$on('mercuriusConversationOpen', (conv) => this.updateTitle(conv.user));
    },


    methods: {
        updateTitle(name) {
            this.title = name
            this.toggleSidebar(true);
        },
        onConversationOpen(conv) {
            this.title = conv.user
            this.toggleSidebar(true);
        },
        toggleSidebar(val = false) {
            this.closed = val || !this.closed;

            Bus.$emit('mercuriusSidebarToggle', this.closed)
        },
    }
};
</script>
