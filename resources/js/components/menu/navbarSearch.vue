<template>

    <v-app-bar flat color="white" class="py-2 h-auto">
        <v-spacer/>

        <v-btn class="mr-3" @click="goBack" icon><v-icon>mdi-chevron-double-left</v-icon></v-btn>

        <v-text-field ref="search" rounded filled hide-details dense placeholder="Cari galang dana" prepend-inner-icon="search" v-model="query"/>

        <v-spacer/>
    </v-app-bar>

</template>

<script>
    export default {
        data () {
            return {
                query: null,
            };
        },
        watch: {
            query(after, before){
                this.searchSubmission();
            }
        },
        methods: {
            goBack: function () {
                this.$router.go(-1);
            },
            searchSubmission() {
                axios.get('/search', { params : { query: this.query } })
                .then(response => this.result = response.data)
                .catch(error => {});
            }
        },
        mounted(){
            this.$refs.search.focus();
        }
    }
</script>

<style>
    .back-lg {
        display: block;
    }

    .back-md {
        display: none;
    }

    @media only screen and (max-width: 959px) {
        .back-lg {
            display: none;
        }

        .back-md {
            display: block;
        }
    }

    .v-btn:focus {
        outline: 0;
    }

    a.v-btn:hover, .v-chip:hover {
        text-decoration: none;
    }
</style>
