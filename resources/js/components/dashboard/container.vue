<template>
<v-app>
    <drawer-admin :start="page" @pageChanged="changePage($event)"/>
    <alert :message="message" color="green lighten-5" colorIcon="success" colorText="success--text" v-if="message"/>
    
    <v-content class="bg-section-1">
        <div class="fluid">
            <section>
                <v-container>
                    <v-card-title class="display-2">Dashboard</v-card-title>
                </v-container>
            </section>

            <section>
                <v-container class="pb-12">
                    <template v-if="page == 'feeds'">
                        <v-row>
                            <v-col cols="12" md="6" lg="3">
                                <v-alert border="left" icon="mdi-charity" prominent colored-border color="blue lighten-1" class="py-0">
                                    <v-card-title class="subtitle-1">Total Galang Dana</v-card-title>
                                    <v-card-subtitle class="title font-weight-bold pr-0">{{campaigns.length}}</v-card-subtitle>
                                </v-alert>
                            </v-col>

                            <v-col cols="12" md="6" lg="3">
                                <v-alert border="left" icon="mdi-account-group" prominent colored-border color="green lighten-1" class="py-0">
                                    <v-card-title class="subtitle-1">Total Pengguna</v-card-title>
                                    <v-card-subtitle class="title font-weight-bold pr-0">{{users.length}}</v-card-subtitle>
                                </v-alert>
                            </v-col>

                            <v-col cols="12" md="6" lg="3">
                                <v-alert border="left" icon="mdi-cash-multiple" prominent colored-border color="cyan lighten-1" class="py-0">
                                    <v-card-title class="subtitle-1">Total Bantuan</v-card-title>
                                    <v-card-subtitle class="title font-weight-bold pr-0">{{totalCampaigns}}</v-card-subtitle>
                                </v-alert>
                            </v-col>

                            <v-col cols="12" md="6" lg="3">
                                <v-alert border="left" icon="mdi-chat-alert" prominent colored-border color="yellow lighten-1" class="py-0">
                                    <v-card-title class="subtitle-1">Butuh Persetujuan</v-card-title>
                                    <v-card-subtitle class="title font-weight-bold pr-0">{{needApprove}}</v-card-subtitle>
                                </v-alert>
                            </v-col>
                        </v-row>

                        <v-card class="mx-auto px-6 py-12 mt-6">
                            <v-card-text>
                                <p class="display-1 font-weight-light text--primary">Hai, {{currentUser.user_name}}!</p>
                                <v-divider/>
                                <div class="subtitle-1 text--primary">Tidak ada aktivitas baru hari ini.</br>Teruskan kerja bagusmu!</div>
                            </v-card-text>
                            <v-card-actions>
                            <v-btn @click="reroutes('/')" class="primary">ke halaman utama!</v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>

                    <template v-if="page == 'campaigns'">
                        <v-card>
                            <v-card-title> 
                                Daftar Penggalangan
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="campaignHeaders" :items="campaigns" :search="search">
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-icon small color="green mr-2" v-on="on" @click="reroutes('/campaign/'+item.submisi_id)">mdi-information</v-icon>
                                        </template>
                                        <span>Lihat penggalangan</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }" v-if="item.submisi_is_active == 'aktif'">
                                            <v-icon small color="orange mr-2" v-on="on" @click="closeCampaign(item)">mdi-close-box</v-icon>
                                        </template>
                                        <span>Tutup penggalangan</span>
                                    </v-tooltip>
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-icon small color="red mr-2" v-on="on" @click="deleteCampaign(item)">mdi-delete</v-icon>
                                        </template>
                                        <span>Hapus penggalangan</span>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-card>
                    </template>

                    <template v-if="page == 'donations'">
                        <v-card>
                            <v-card-title> 
                                Daftar Transfer
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="donationsHeaders" :items="donations" :search="search">
                            </v-data-table>
                        </v-card>
                    </template>

                    <template v-if="page == 'withdraws'">
                        <v-card>
                            <v-card-title> 
                                Daftar Pencairan
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="withdrawsHeaders" :items="withdraws" :search="search">
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip top v-if="item.withdraw_is_approved == 'menunggu persetujuan'">
                                        <template v-slot:activator="{ on }">
                                            <v-icon small color="green mr-2" v-on="on" @click="acceptWithdraw(item)">mdi-checkbox-marked</v-icon>
                                        </template>
                                        <span>Setujui pencairan</span>
                                    </v-tooltip>
                                    <v-tooltip top v-if="item.withdraw_is_approved == 'menunggu persetujuan'">
                                        <template v-slot:activator="{ on }">
                                            <v-icon small color="red mr-2" v-on="on" @click="cancelWithdraw(item)">mdi-close-box</v-icon>
                                        </template>
                                        <span>Tolak pencairan</span>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-card>
                    </template>

                    <template v-if="page == 'users'">
                        <v-card>
                            <v-card-title> 
                                Daftar Pengguna
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="usersHeaders" :items="users" :search="search">
                                <template v-slot:item.actions="{ item }">
                                    <v-tooltip top>
                                        <template v-slot:activator="{ on }">
                                            <v-icon small color="red mr-2" v-on="on" @click="deleteUser(item)">mdi-delete</v-icon>
                                        </template>
                                        <span>Hapus pengguna</span>
                                    </v-tooltip>
                                </template>
                            </v-data-table>
                        </v-card>
                    </template>
                </v-container>
            </section>
        </div>
    </v-content>
</v-app>
</template>

<script>
    export default {
        data: () => ({
            search: '',
            totalCampaigns: 'Rp 0',
            needApprove: 0,
            message: '',
            errors: {},

            campaigns: [],
            campaignHeaders: [
                { text: 'Id', align: 'start', sortable: false, value: 'submisi_id' },
                { text: 'Judul', value: 'submisi_judul' },
                { text: 'Penggalang', value: 'user.user_name' },
                { text: 'Terkumpul', value: 'submisi_terkumpul' },
                { text: 'Target', value: 'submisi_target' },
                { text: 'Sisa Hari', value: 'sisa_hari' },
                { text: 'Status', value: 'submisi_is_active' },
                { text: 'Dibuat', value: 'submisi_created_at' },
                { text: 'Diperbarui', value: 'submisi_updated_at' },
                { text: 'Aksi', value: 'actions', sortable: false },
            ],

            donations: [],
            donationsHeaders: [
                { text: 'Id', align: 'start', sortable: false, value: 'donation_id' },
                { text: 'Submisi', value: 'submission.submisi_judul' },
                { text: 'Nominal', value: 'donation_nominal' },
                { text: 'Nama', value: 'donation_name' },
                { text: 'Email', value: 'donation_mail' },
                { text: 'No. Telepon', value: 'donation_phone' },
                { text: 'Akun', value: 'user_id' },
                { text: 'Anonim', value: 'donation_is_anonymous' },  
                { text: 'Dibuat', value: 'donation_created_at' },  
                { text: 'Diperbarui', value: 'donation_updated_at' },
            ],

            withdraws: [],
            withdrawsHeaders: [
                { text: 'Id', align: 'start', sortable: false, value: 'withdraw_id' },
                { text: 'Submisi', value: 'submission.submisi_judul' },
                { text: 'Nama', value: 'user.user_name' },
                { text: 'Nominal', value: 'withdraw_nominal' },
                { text: 'Status', value: 'withdraw_is_approved' },
                { text: 'Dibuat', value: 'withdraw_created_at' },
                { text: 'Diperbarui', value: 'withdraw_updated_at' },  
                { text: 'Aksi', value: 'actions', sortable: false },
            ],

            users: [],
            usersHeaders: [
                { text: 'Id', align: 'start', sortable: false, value: 'user_id' },
                { text: 'Nama', value: 'user_name' },
                { text: 'Email', value: 'user_mail' },
                { text: 'No. Telepon', value: 'user_phone' },
                { text: 'Akses', value: 'user_is_admin' },
                { text: 'Status', value: 'user_is_active' },
                { text: 'Dibuat', value: 'user_created_at' },
                { text: 'Diperbarui', value: 'user_updated_at' },  
                { text: 'Aksi', value: 'actions', sortable: false },
            ],
        }),
        computed: {
            page: {
                get() {
                    return this.$store.state.user.dashPage;
                }
            },
            loggedin: {
                get() {
                    return this.$store.state.user.loggedin;
                }
            },
            currentUser: {
                get() {
                    return this.$store.state.user.user;
                }
            },
        },
        created() {
            axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("access_token");
            this.loadData();
            this.$store.dispatch('user/getUser');

        },
        methods: {
            reroutes: function (url) {
                this.$router.push({ path: url });
            },
            changePage(page) {
                this.$store.commit('user/setDashboardPage', page)
            },
            loadData() {
                axios
                    .get("/api/dashboard/all")
                    .then(response => {
                        if(response.data != null) {
                            this.$data.campaigns = response.data.campaigns;
                            this.$data.totalCampaigns = response.data.totalCampaigns;
                            this.$data.donations = response.data.donations;
                            this.$data.withdraws = response.data.withdraws;
                            this.$data.needApprove = response.data.needApprove;
                            this.$data.users = response.data.users;
                        }
                    });
            },
            closeCampaign(item) {
                if(confirm('Apakah kamu yakin menutup galang dana ini?')) {
                    axios
                        .put("/api/dashboard/submission/close", {
                            id: item.submisi_id
                        })
                        .then(response => {
                            if (response.data.response == 'success') {
                                var editedItem = item;
                                editedItem.submisi_is_active = 'ditutup';
                                Object.assign(this.campaigns[this.campaigns.indexOf(item)], this.editedItem);

                                this.message = response.data.message;
                                setTimeout(() => {
                                    this.message = "";
                                }, 4050);
                            }
                        })
                        .catch(e => {
                            if (e.response.status == 422) {
                                this.errors = e.response.data.errors;
                                this.message = "";
                            }
                        });
                };
            },
            deleteCampaign(item) {
                if(confirm('Apakah kamu yakin menghapus galang dana ini?')) {
                    axios
                        .delete("/api/dashboard/submission/destroy", {
                            data: {id: item.submisi_id}
                        })
                        .then(response => {
                            if (response.data.response == 'success') {
                                const index = this.campaigns.indexOf(item);
                                this.campaigns.splice(index, 1);
                                this.loadData();
                                this.message = response.data.message;
                                setTimeout(() => {
                                    this.message = "";
                                }, 4050);
                            }
                        })
                        .catch(e => {
                            if (e.response.status == 422) {
                                this.errors = e.response.data.errors;
                                this.message = "";
                            }
                        });
                };
            },
            deleteUser(item) {
                if(confirm('Apakah kamu yakin menghapus pengguna ini?')) {
                    axios
                        .delete("/api/dashboard/user/destroy", {
                            data: {id: item.user_id}
                        })
                        .then(response => {
                            if (response.data.response == 'success') {
                                const index = this.users.indexOf(item);
                                this.users.splice(index, 1);
                                this.loadData();
                                this.message = response.data.message;
                                setTimeout(() => {
                                    this.message = "";
                                }, 4050);
                            }
                        })
                        .catch(e => {
                            if (e.response.status == 422) {
                                this.errors = e.response.data.errors;
                                this.message = "";
                            }
                        });
                };
            },
            acceptWithdraw(item) {
                axios
                    .put("/api/dashboard/withdraw/accept", {
                        id: item.withdraw_id
                    })
                    .then(response => {
                        if (response.data.response == 'success') {
                            var editedItem = item;
                            editedItem.withdraw_is_approved = 'disetujui';
                            Object.assign(this.withdraws[this.withdraws.indexOf(item)], this.editedItem);

                            this.message = response.data.message;
                            setTimeout(() => {
                                this.message = "";
                            }, 4050);
                        }
                    })
                    .catch(e => {
                        if (e.response.status == 422) {
                            this.errors = e.response.data.errors;
                            this.message = "";
                        }
                    });
            },
            cancelWithdraw(item) {
                axios
                    .put("/api/dashboard/withdraw/decline", {
                        id: item.withdraw_id
                    })
                    .then(response => {
                        if (response.data.response == 'success') {
                            var editedItem = item;
                            editedItem.withdraw_is_approved = 'ditolak';
                            Object.assign(this.withdraws[this.withdraws.indexOf(item)], this.editedItem);

                            this.message = response.data.message;
                            setTimeout(() => {
                                this.message = "";
                            }, 4050);
                        }
                    })
                    .catch(e => {
                        if (e.response.status == 422) {
                            this.errors = e.response.data.errors;
                            this.message = "";
                        }
                    });
            },
        }
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
        padding-top: 80px!important;
    }

    .v-btn:focus {
        outline: 0;
    }
    
    a.v-btn:hover, .v-chip:hover {
        text-decoration: none;
    }
    /*@import './assets/styles/yourstyles.css';*/
</style>