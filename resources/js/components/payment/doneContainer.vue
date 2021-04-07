<template>
<v-app>
    <navbar/>
    
    <main class="h-100">
        <div class="fluid">
            <section class="top-space">
                <v-container class="py-12">
                    <v-row>
                        <v-col>
                            <v-card raised max-width="600px" class="mx-auto p-md-4">
                                <v-card-title><v-icon large color="green" left>mdi-checkbox-marked-circle-outline</v-icon>Donasi anda berhasil</v-card-title>
                                <v-list max-width="550px" class="ml-5">
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Anda mendonasikan</v-list-item-title>
                                            <v-list-item-subtitle>{{donasi}}</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    
                                    <v-divider class="my-1"></v-divider>

                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Metode donasi</v-list-item-title>
                                            <v-list-item-subtitle>{{bank}}</v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                    
                                    <v-divider class="my-1"></v-divider>

                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Penggalang</v-list-item-title>
                                            <div class="d-flex align-center pt-2">
                                                <v-avatar left>
                                                    <img :src="'/storage/profile/'+foto" >
                                                </v-avatar>
                                                <div class="mx-3">
                                                    <span class="green--text">{{author}}<v-icon right color="green">mdi-check-circle mdi-18px</v-icon></span>
                                                    <div class="caption">Identitas terverifikasi</div>
                                                </div>
                                            </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                    
                                    <v-divider class="my-1"></v-divider>

                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>Penerima Manfaat</v-list-item-title>
                                                <div class="d-flex align-center pt-2">
                                                    <v-avatar left>
                                                        <v-icon>mdi-account-circle mdi-48px</v-icon>
                                                    </v-avatar>
                                                    <div class="mx-3">
                                                        <span>{{target}}</span>
                                                        <div class="caption">Sesuai dokumen medis<v-icon color="green">mdi-check-circle-outline mdi-18px</v-icon></div>
                                                    </div>
                                                </div>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>

                                <v-card-actions>
                                    <v-btn large color="error" block @click="reroutes('/')">Kembali</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
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
        author: '',
        target:'',
        title: '',
        donasi: '',
        bank: '',
        foto:'',
        icon: '/icon/BCA.png',
    }),
    created() {
        this.loadData();
    },
    computed: {
        loggedin: {
            get() {
                return this.$store.state.user.loggedin;
            }
        },
        currentUser: {
            get() {
                return this.$store.state.user.user;
            }
        }
    },
    methods: {
        loadData() {
        axios.get("/api/donation/done").then(response => {
            this.title = response.data[0].submisi_judul;
            this.author = response.data[0].user_name;
            this.target = response.data[0].submisi_penerima;
            this.donasi = response.data[0].donation_nominal;
            this.bank = response.data[0].payment_type;
            this.foto = response.data[0].user_foto;

            if(response.data[0].payment_type == "BCA"){
                this.icon =  '/icon/BCA.png';
            }else if (response[0].data.payment_type == "BNI"){
                this.icon = '/icon/BNI.png';
            }else{
                this.icon = '/icon/Permata.png';
            }

        });
        },
        reroutes: function (url) {
            this.$router.push({ path: url });
        },
        goBack: function () {
            this.$router.go(-1);
        }
    }
}
</script>