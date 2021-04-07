<template>
<v-app>
    <navbar/>

    <main class="h-100">
        <div class="fluid">
            <section class="top-space bg-section-1">
                <v-container class="pb-12">
                    <h1 class="display-1 font-weight-bold text-left">Galang Dana</h1>
                    <p>Dukung mereka untuk sembuh kembali. Mulai dari sepuluh ribu rupiah.</p>
                    
                    <v-row>
                        
                        <v-col v-for="submisi in submisis" :key="submisi.submisi_id" cols="12" sm="6" md="4" xl="4" class="px-2">
                        <v-hover v-slot:default="{ hover }">
                            
                            <v-card @click="reroutes('/campaign/'+submisi.submisi_id)" :elevation="hover ? 24 : 6" class="my-4 card-transform">
                                <v-img :src="'/storage/submission/'+submisi.submisi_foto" height="200px"></v-img>

                                <v-card-title v-text="submisi.submisi_judul"></v-card-title>

                                <v-card-subtitle v-text="submisi.user_name"></v-card-subtitle>

                                <v-card-text>
                                    <v-progress-linear rounded height="8" v-model="submisi.kekurangan_donasi" color="deep-orange"></v-progress-linear>
                                </v-card-text>

                                <v-card-text class="d-flex justify-space-between">
                                    <span><strong class="deep-orange--text title">{{submisi.total_donasi}}</strong> Terkumpul <br/> {{'dari ' + submisi.target_donasi}}</span>
                                    <span><strong class="deep-orange--text title">{{submisi.day_left}}</strong> hari lagi</span>
                                </v-card-text>

                                <v-divider class="my-0 mx-4"></v-divider>

                                <v-card-text>
                                    <v-chip class="mr-2">
                                        <v-icon left>mdi-charity</v-icon>Galang
                                    </v-chip>
                                    <v-chip class="mr-2">
                                        <v-icon left>mdi-cash-usd</v-icon>Dana
                                    </v-chip>
                                </v-card-text>
                            </v-card>
                        </v-hover>
                        </v-col>
                    </v-row>
                    <v-row justify="center" >
                        <v-pagination color="deep-orange" v-model="page" :length="length" :page="page" :total-visible="7" @input="getDataPage(page)"></v-pagination>
                    </v-row>
                </v-container>
            </section>
        </div>
    </main>

    <footbar/>
</v-app>
</template>

<script>
    export default {
        data: () => ({
            chips: [],
            submisis: [],
            filter: ['Galang', 'Dana'],
            length: 0,
            nextIcon: 'navigate_next',
            prevIcon: 'navigate_before',
            page: 1,
            
        }),
        created() {
            this.loadData();
        },
        methods: {
            loadData() {
                axios.get("/api/campaign/all").then(response => {
                    this.submisis = response.data.data;
                    this.length = response.data.last_page;
                    this.list = response.data;
                });
            },
            getDataPage(id) {
                axios.get("/api/campaign/all?page="+id).then(response => {
                    this.list = response.data;
                    this.submisis = response.data.data;
                    this.length = response.data.last_page;
                });
            },
            reroutes: function (url) {
                this.$router.push({ path: url });
            },
            remove (item) {
                this.chips.splice(this.chips.indexOf(item), 1)
                this.chips = [...this.chips]
            },
        },
    }
</script>

<style>
    section .v-card {
        transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1) all;
    }

    section .card-transform:hover {
        transform: translatey(-10px);
    }

    .top-space {
        padding-top: 96px!important;
    }

    .v-btn:focus {
        outline: 0;
    }

    .v-pagination__item:focus, .v-pagination__navigation:focus {
        outline: 0;
    }
    
    a.v-btn:hover, .v-chip:hover {
        text-decoration: none;
    }
    /*@import './assets/styles/yourstyles.css';*/
</style>