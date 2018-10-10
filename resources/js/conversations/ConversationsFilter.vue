<template>
    <div
        class="conversations_filter"
        role="filter"
        aria-label="filter conversations"
        >
        <svg class="ic ic-search"><use xlink:href="#icon-search"></use></svg>
        <input
            class="conversations_filter__input"
            type="text"
            v-model.trim="value"
            :placeholder="'search_messages' | __ "
            @keyup.esc="onReset"
            @keyup="onTyping"
        >
    </div>
</div>
</template>


<script>
export default {
    data() {
        return {
            value: '',
        }
    },


    methods: {
        onReset() {
            this.value = ''
            this.onTyping()
        },
        onTyping() {
            Bus.$emit('mercuriusFilterConversations', this.value);
        },
    }
}
</script>
