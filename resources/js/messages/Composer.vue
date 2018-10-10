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
        Bus.$on('mercuriusConversationDeleted', usrId => this.onConversationDeleted(usrId));
        Bus.$on('mercuriusMessageSent', () => this.reset())
    },


    methods: {
        reset() {
            this.message = ''
        },
        onConversationDeleted(usrId) {
            if (this.conversation.id === usrId) this.reset()
        },
        onSend() {
            if (_.isEmpty(this.message)) return
            this.sendMessage(this.conversation.id, this.message);
        },
    },


    computed: {
        enabled() {
            return !_.isEmpty(this.conversation);
        },
    },
}
</script>
