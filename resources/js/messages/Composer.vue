<template>
    <div class="composer" v-show="enabled">
        <input
            type="text"
            name="msg"
            class="composer__input"
            :class="{disabled: is_sending}"
            ref="inpmessage"
            v-model.trim="message"
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
        }
    },


    created() {
        Bus.$on('mercuriusComposeNewMessage', () => this.reset())
        Bus.$on('mercuriusConversationDeleted', user => this.onConversationDeleted(user));
        Bus.$on('mercuriusMessageSent', () => this.reset())
    },


    methods: {
        reset() {
            this.message = ''
        },
        onConversationDeleted(user) {
            if (this.conversation.slug === user) this.reset()
        },
        onSend() {
            if (_.isEmpty(this.message)) return
            this.sendMessage(this.conversation.slug, this.message);
        },
    },


    computed: {
        enabled() {
            return !_.isEmpty(this.conversation);
        },
    },
}
</script>
