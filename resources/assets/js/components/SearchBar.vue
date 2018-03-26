<template>
    <div>
        <input class="form-control mb-2" v-model="phrase" @keyup.enter="setSearchPhrase" placeholder="Zoek naar product.." />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                phrase: null,
            }
        },

        methods: {
            setSearchPhrase() {
                this.$root.searchCriteria.search_text = this.phrase;
            }
        }
    }
</script>