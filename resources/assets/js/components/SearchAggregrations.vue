<template>
    <div>
        Resultaten: {{ $store.getters.foundResults }} | Totaal aantal: {{ $store.getters.totalResults }}

        <div class="card mt-3" v-for="(facet, field) in aggregrations">
            <div class="card-header">
                {{ field | facetTitle}}
            </div>
            <div class="card-body">
                <div class="checkbox" v-for="item in aggregrations[field]">
                    <label style="width: 100%;">
                        <span style="float: right; color: darkgrey;">{{ item.value }}</span>
                        <input type="checkbox" v-model="$root.searchCriteria[field]" :value="item.label"> {{ item.label }}
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {

            aggregrations() {
                return this.$store.getters.aggregrations
            }
        },
    }
</script>
