<template>
    <div
        class="recipient_search"
        :class="{active: enabled}"
        v-show="enabled"
    >
        <div class="recipient_search__wrap">
            <input
                type="text"
                name="recipient"
                id="inputRecipient"
                class="recipient__input"
                ref="inprecipient"
                value=""
                v-model.trim="query"
                @blur="onBlur"
                @focus="onFocus"
                @keyup.esc="onReset"
                @keyup="onType"
                placeholder="Type contact name..."
                autocomplete="off"
            >
            <svg
                v-show="loading"
                class="ic"
            ><use xlink:href="#icon-ani-puff"></use></svg>
        </div>

        <nav
            v-show="is_open"
            class="recipient__results"
        >
            <a
                class="recipient__results__item"
                v-for="(recipient, key) in recipients"
                href="#"
                :key="key"
                @click.prevent="onSelect(recipient)"
            >
                <img class="recipient__results__avatar"
                    :alt="recipient.name"
                    :src="recipient.avatar || placeholder"
                />
                <span v-text="recipient.name"/>
            </a>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            placeholder: '/vendor/mercurius/img/avatar/avatar_placeholder.png',
            query:      '',
            total:      0,
            recipients: [],
            is_open:    false,
            enabled:    false,
            loading:    false,
            _timeout:   null
        }
    },


    created() {
        Bus.$on('mercuriusComposeNewMessage', () => this.onStart())
        Bus.$on('mercuriusOpenConversation', () => this.enabled = false);
    },


    methods: {
        onStart() {
            this.enabled = true
            this.onReset();
            setTimeout(() => { this.$refs.inprecipient.focus() }, 125);
        },
        onType() {
            clearTimeout(this._timeout)
            this._timeout = setTimeout(() => { this._search() }, 500);
        },
        onBlur() {
            this._toggleResults(false)
        },
        onFocus() {
            if (this.total === 0) return
            this._toggleResults(true)
        },
        onSelect(recipient) {
            this.enabled = false
            this.onReset()
            Bus.$emit('mercuriusRecipientSelected', recipient)
        },
        onReset() {
            this.query = ''
            this.recipients = []
            this.total = 0
        },
        _toggleResults(state) {
            setTimeout(() => { this.is_open = state }, 150);
        },
        _search() {
            if (this.query === '') return

            this.recipients = []
            this.is_open = false
            this.loading = true

            axios
                .post('/receivers', { q: this.query })
                .then((res) => {
                    this.recipients = res.data.hits
                    this.total      = res.data.total
                    this.is_open    = true
                })
                .catch(() => swal(__('err_hd'), __('err_recipients'), 'error'))
                .finally(() => this.loading = false);
        },
    }
}
</script>
