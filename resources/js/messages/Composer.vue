<template>
    <div class="composer" v-show="enabled">
        <input
            type="text"
            name="msg"
            class="composer__input"
            :class="{disabled: is_sending}"
            ref="inpmessage"
            v-model.trim="message"
            @input="onTyping"
            @keyup.enter="onSend"
            :placeholder="'type_message' | __"
            :disabled="is_sending"
            autocomplete="off"
        >
        <button
            type="button"
            class="composer__btn"
            :class="{active: is_sending}"
            :disabled="is_sending"
            @click="onSend"
        >
            <i v-if="is_sending" class="fa fa-btn fa-spinner fa-spin"></i>
            <span v-else>{{ 'btn_send' | __ }}</span>
        </button>
    </div>
</template>

<script>
import MessageSending from './message-sending';

export default {
    props: ['conversation'],


    mixins: [MessageSending],


    data() {
        return {
            message: '',
            typing: false
        }
    },


    created() {
        Bus.$on('mercuriusConversationLoaded', conv => this.onConversationLoaded(conv))
        Bus.$on('mercuriusConversationDeleted', user => this.onConversationDeleted(user));
        Bus.$on('mercuriusMessageSent', () => this.reset())
    },


    methods: {
        reset() {
            this.message = ''
        },
        onConversationLoaded(conv) {
            this.reset();
            setTimeout(() => { this.$refs.inpmessage.focus() }, 125);
        },
        onConversationDeleted(user) {
            if (this.conversation.slug === user) this.reset()
        },
        onSend() {
            if (_.isEmpty(this.message)) return
            this.sendMessage(this.conversation.slug, this.message);
        },
        onTyping() {
            let channel = Echo.private('mercurius.conversation.'+this.conversation.slug);
            setTimeout(function() {
                channel.whisper('typing', Mercurius.user.slug);
            }, 500);
        },
    },


    computed: {
        enabled() {
            return !_.isEmpty(this.conversation);
        },
    },
};
</script>
