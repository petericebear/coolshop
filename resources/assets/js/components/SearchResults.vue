<template>
    <div>
        <div class="card-deck">
            <div class="card panel-default mb-3" v-for="item in results" style="max-width: 33%">
                <img class="card-img-top p-3" :src="item.image" :alt="item.title" />
                <div class="card-body">
                    <h4 class="card-title" v-text="item.title" />
                    <ul>
                        <li v-for="option in item.productOptions">{{ option }}</li>
                    </ul>
                    <p>&euro; {{ item.price }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            results() {
                return this.$store.getters.results
            }
        },
    }
</script>
