<template>
    <div class="mercurius__sidebar" :class="{'closed': is_closed}">
        <slot></slot>
    </div>
</template>

<script>
export default {
    data() {
        return {
            is_closed: false,
        }
    },


    created() {
        Bus.$on('mercuriusSidebarToggle', val => this.toggleSidebar(val));
    },


    methods: {
        toggleSidebar(val = false) {
            this.is_closed = val
        },
    },
};
</script>
