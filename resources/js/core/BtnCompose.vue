<template>
    <button
        type="button"
        class="btn_compose btn btn-secondary"
        @click="compose()"
    ><svg class="ic ic-plus"><use xlink:href="#icon-plus"></use></svg>
    </button>
</template>


<script>
export default {
    methods: {
        compose() {
            Bus.$emit('mercuriusComposeNewMessage');
        },
    }
};
</script>
