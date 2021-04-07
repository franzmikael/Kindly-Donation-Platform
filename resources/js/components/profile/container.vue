<template>
<v-app>
    <navbar/>
    <alert :message="message" color="green lighten-5" colorIcon="success" colorText="success--text" v-if="message"/>
    <main class="h-100">
        <div class="fluid">
            <section class="top-space bg-section-1">
                <v-container class="pb-12">
                    <v-card>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-card-text>
                                    <div class="d-flex align-center mx-4 mr-md-0">
                                        <v-avatar size="102" left>
                                            <img :src="'storage/profile/'+currentUser.user_foto">
                                        </v-avatar>
                                        <div class="mx-3">
                                            <v-card-title class="headline font-weight-bold pb-6">{{currentUser.user_name}}</v-card-title>
                                            <v-card-subtitle class="pb-0" v-if="currentUser.user_is_admin"><v-icon left color="blue">mdi-shield-check mdi-18px</v-icon>Admin</v-card-subtitle>
                                            <v-card-subtitle class="pt-0" v-if="currentUser.user_is_active"><v-icon left color="green">mdi-check-circle mdi-18px</v-icon>Identitas terverifikasi</v-card-subtitle>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-card flat color="error" dark class="mx-4 ml-md-0">
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="12" md="auto">
                                                <v-card-subtitle class="py-1">Total Mendonasikan</v-card-subtitle>
                                                <v-card-title class="headline font-weight-bold py-1">{{participation.total_donation}}</v-card-title>
                                            </v-col>
                                            <v-col cols="12" md="auto">
                                                <v-card-subtitle class="py-1">Pasien terdonasikan</v-card-subtitle>
                                                <v-card-title class="headline font-weight-bold py-1">{{participation.total_participant}}</v-card-title>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-container>
            </section>

            <section class="bg-section-2">
                <v-container class="py-12">
                    <v-card>
                        <v-tabs show-arrows vertical hide-slider background-color="error">
                            <v-tab>
                                <v-icon left>mdi-account</v-icon>Penggalangan Aktif
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-charity</v-icon>Riwayat Penggalangan
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-history</v-icon>Riwayat Donasi
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-bank</v-icon>Pencairan Dana
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-account-edit</v-icon>Ubah Profil
                            </v-tab>
                            <v-tab>
                                <v-icon left>mdi-textbox-password</v-icon>Ganti Password
                            </v-tab>

                            <v-tab-item class="mb-4">
                                <v-card-title>Penggalangan Aktif</v-card-title>
                                <v-card-subtitle>Menampilkan semua penggalangan dana-mu yang sedang aktif.</v-card-subtitle>
                                <template v-if="submisisactive.length">
                                    <v-list two-line>
                                        <template v-for="active in submisisactive">
                                            <v-list-item>
                                                <v-list-item-avatar tile size="70" width="120" @click="reroutes('/campaign/'+active.submisi_id)">
                                                    <v-img :src="'/storage/submission/'+active.submisi_foto"></v-img>
                                                </v-list-item-avatar>
                                            
                                                <v-list-item-content>
                                                    <v-list-item-title v-html="active.submisi_judul"></v-list-item-title>
                                                    <v-list-item-subtitle v-html="active.submisi_terkumpul+' terkumpul dari '+active.submisi_target"></v-list-item-subtitle>
                                                    <v-list-item-subtitle v-html="'aktif sampai '+active.sisa_hari+' hari lagi'"></v-list-item-subtitle>
                                                </v-list-item-content>
                                                
                                                <v-list-item-content style="max-width: 192px">
                                                    <v-btn color="success" @click="reroutes('/campaign/'+active.submisi_id)">Kunjungi</v-btn>
                                                    <v-btn color="error" @click="callCloseSubmisi(active.submisi_id)">Tutup</v-btn>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </template>
                                    </v-list>
                                </template>

                                <template v-else>
                                    <v-alert prominent type="error" text icon="mdi-cancel" class="ma-4">
                                        <v-row align="center">
                                            <v-col class="grow">Kamu sedang tidak memiliki penggalangan dana yang aktif.</v-col>
                                            <v-col class="shrink">
                                                <v-btn outlined color="error" @click="reroutes('/start')">Galang Sekarang</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-alert>
                                </template>
                            </v-tab-item>
                            <v-tab-item class="mb-4">
                                <v-card-title>Riwayat Penggalangan</v-card-title>
                                <v-card-subtitle>Menampilkan semua riwayat penggalangan dana yang sudah kamu buka, mulai dari yang aktif sampai yang sudah tutup.</v-card-subtitle>
                                <template v-if="submisishistory.length">
                                    <v-list two-line>
                                        <template v-for="history in submisishistory">
                                            <v-list-item @click="reroutes('/campaign/'+history.submisi_id)">
                                                <v-list-item-avatar tile size="70" width="120">
                                                    <v-img :src="'/storage/submission/'+history.submisi_foto"></v-img>
                                                </v-list-item-avatar>
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title v-html="history.submisi_judul"></v-list-item-title>
                                                    <v-list-item-subtitle>{{history.submisi_is_active}}</v-list-item-subtitle>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </template>
                                    </v-list>
                                    <v-pagination color="error" v-model="page" :length="lengthHistorySubmission" :page="page" :total-visible="totalVisible" @input="getDataPage(currentUser.user_id,page)"></v-pagination>
                                </template>
                                
                                <template v-else>
                                    <v-alert prominent type="error" text icon="mdi-cancel" class="ma-4">
                                        <v-row align="center">
                                            <v-col class="grow">Kamu belum pernah membuka penggalangan dana.</v-col>
                                            <v-col class="shrink">
                                                <v-btn outlined color="error" @click="reroutes('/start')">Galang Sekarang</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-alert>
                                </template>
                            </v-tab-item>
                            <v-tab-item class="mb-4">
                                <v-card-title>Riwayat Donasi</v-card-title>
                                <v-card-subtitle>Menampilkan semua riwayat donasi yang telah kamu salurkan.</v-card-subtitle>
                                <template v-if="donations.length">
                                    <v-list two-line>
                                        <template v-for="donation in donations">
                                            <v-list-item @click="reroutes('/campaign/'+donation.submisi_id)">
                                                <v-list-item-avatar tile size="70" width="120">
                                                    <v-img :src="'/storage/submission/'+donation.submisi_foto"></v-img>
                                                </v-list-item-avatar>
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title v-html="donation.submisi_judul"></v-list-item-title>
                                                    <v-list-item-subtitle v-html="'Sebesar '+donation.donation_nominal"></v-list-item-subtitle>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </template>
                                    </v-list>
                                    <v-pagination color="error" v-model="page" :length="lengthHistoryDonation" :page="page" :total-visible="totalVisible" @input="getDataPage(currentUser.user_id,page)"></v-pagination>
                                </template>
                                
                                <template v-else>
                                    <v-alert prominent type="error" text icon="mdi-cancel" class="ma-4">
                                        <v-row align="center">
                                            <v-col class="grow">Oh tidak! Kamu belum pernah melakukan donasi.</v-col>
                                            <v-col class="shrink">
                                                <v-btn outlined color="error" @click="reroutes('/start')">Donasi Sekarang</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-alert>
                                </template>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card-title>Pencairan Dana</v-card-title>
                                <v-form>
                                    <v-container class="px-12 pb-12">
                                        <v-select name="totalrequestmoney" :items="submisisactive" item-text="submisi_judul" item-value="submisi_id" label="Pilih Penggalangan Dana" v-model="withdraw.campaign" prepend-inner-icon="mdi-charity" :error-messages="errors.campaign" required filled clearable></v-select>
                                        <v-text-field label="Nominal Pencairan Dana" name="totalrequestmoney" v-model="withdraw.nominal" prepend-inner-icon="mdi-cash" type="text" :error-messages="errors.nominal" required filled clearable/>
                                        <v-text-field label="Nomor Rekening Tujuan" name="bankname" prepend-inner-icon="mdi-bank" v-model="withdraw.bank" type="text" :error-messages="errors.bank" required filled clearable/>
                                        <v-btn color="error" class="mr-2" @click="callSubmitWithdraw()">Ajukan</v-btn>
                                        <v-btn text class="mr-2" @click="resetWithdraw()">Reset</v-btn>
                                    </v-container>
                                </v-form>
                            </v-tab-item>
                            <v-tab-item class="mb-4">
                                <v-card-title>Ubah Profil</v-card-title>
                                <v-card-subtitle></v-card-subtitle>
                                <v-form>
                                    <v-container class="px-12 pb-12">
                                        <div class="d-flex align-center mb-4">
                                            <v-avatar size="106" left>
                                                <img :src="'storage/profile/'+currentUser.user_foto">
                                            </v-avatar>
                                            <v-card-subtitle>Disarankan foto profil memiliki aspect ratio 1:1.</v-card-subtitle>
                                        </div>
                                        <v-file-input label="Ganti foto profil baru" prepend-icon="" prepend-inner-icon="mdi-camera" accept="image/png, image/jpeg, image/bmp" v-model="update.image" type="file" filled clearable/>
                                        <v-divider/>
                                        <v-text-field label="Nama Depan" name="firstname" prepend-inner-icon="person" type="text" v-model="update.firstName" :error-messages="errors.firstName" required filled clearable/>
                                        <v-text-field label="Nama Belakang" name="lastname" prepend-inner-icon="person" type="text" v-model="update.lastName" :error-messages="errors.lastName" required filled clearable/>
                                        <v-text-field label="Nomor Handphone" name="noHandphone" prepend-inner-icon="phone" v-model="update.phoneNumber" type="text" :error-messages="errors.phoneNumber" :counter="14" required filled clearable/>
                                        <v-btn color="error" class="mr-2"  @click="callSubmitUpdateProfile()">Ganti</v-btn>
                                        <v-btn text class="mr-2" @click="resetProfile()">Reset</v-btn>
                                    </v-container>
                                </v-form>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card-title>Ganti Password</v-card-title>
                                <v-card-subtitle></v-card-subtitle>
                                <v-form>
                                    <v-container class="px-12 pb-12">
                                            <v-alert type="error" text dense transition="slide-y-transition"  v-if="messageoldpassword">{{messageoldpassword}}</v-alert>
                                            <v-text-field id="oldpassword" label="Password Saat Ini"  name="oldpassword" :error-messages="errors.oldPassword" prepend-inner-icon="mdi-lock-question" v-model="updatePassword.oldPassword" type="password" required filled clearable/>
                                            <v-text-field id="newpassword" label="Password Baru" name="newpassword" :error-messages="errors.newPassword"  prepend-inner-icon="mdi-lock-open" type="password" v-model="updatePassword.newPassword" required filled clearable/>
                                            <v-text-field id="passwordconfirm" label="Ketik Ulang Password Baru" :error-messages="errors.confirmPassword" name="passwordconfirm" prepend-inner-icon="lock" type="password" v-model="updatePassword.confirmPassword" required filled clearable/>
                                        <v-btn color="error" @click="callSubmitUpdatePassword()" class="mr-2">Ganti</v-btn>
                                        <v-btn text class="mr-2" @click="resetPassword()">Reset</v-btn>
                                    </v-container>
                                </v-form>
                            </v-tab-item>
                        </v-tabs>
                    </v-card>
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
            actives: [],
            submisishistory: [],
            submisisactive: [],
            donations:[],
            participation:[],
            errors:[],
            message:"",
            messageoldpassword:"",
            withdraw: {
                campaign: "",
                nominal: "",
                bank: ""
            },
            update: {
                firstName: "",
                lastName: "",
                phoneNumber: "",
                image: undefined,
            },
            updatePassword: {
                oldPassword: "",
                newPassword: "",
                confirmPassword: "",
            },
            lengthHistoryDonation: 0,
            lengthHistorySubmission: 0,
            nextIcon: 'navigate_next',
            prevIcon: 'navigate_before',
            page: 1,
            totalVisible: 10,
            valid: true,
        }),
        computed: {
            loggedin: {
                get() {
                    return this.$store.state.user.loggedin;
                }
            },
            currentUser: {
                get() {
                    return this.$store.state.user.user;
                    this.loadData();
                }
            },
        },
        watch: {
            currentUser:function (value) {
                this.$data.selected = "";
                this.$data.update.firstName = this.currentUser.user_name.split(" ")[0];
                this.$data.update.lastName = this.currentUser.user_name.split(" ")[1];
                this.$data.update.phoneNumber = this.currentUser.user_phone;
                this.loadData(this.currentUser.user_id);
            },
        },
        created() {
            axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("access_token");
        },
        methods: {
            resetWithdraw() {
                var withdraw = this.$data.withdraw;
                withdraw.campaign = "";
                withdraw.nominal = "";
                withdraw.bank = "";
                this.$data.errors = [];
            },
            resetProfile() {
                var update = this.$data.update;
                update.image = undefined;
                update.firstName = this.currentUser.user_name.split(" ")[0];
                update.lastName = this.currentUser.user_name.split(" ")[1];
                update.phoneNumber = this.currentUser.user_phone;
                this.$data.errors = [];
            },
            resetPassword() {
                var updatePassword = this.$data.updatePassword;
                updatePassword.oldPassword = "";
                updatePassword.newPassword = "";
                updatePassword.confirmPassword = "";
                this.$data.errors = [];
            },

            callSubmitUpdateProfile() {
                let temp = this.$data.update
                let formData = new FormData()
                formData.append('id', this.currentUser.user_id)
                formData.append('firstName', temp.firstName)
                formData.append('lastName', temp.lastName)
                formData.append('phoneNumber', temp.phoneNumber)
                formData.append('image', temp.image)
                axios
                .post("/api/profile/update", formData, {
                    headers: {
                        'accept': 'application/json',
                        'Accept-Language': 'en-US,en;q=0.8',
                        'Content-Type': `multipart/form-data`,
                    }
                })
                .then(response=> {
                    this.reloadPage();
                    this.message = "Berhasil Perbarui Akun!";
                })
                .catch(e => {
                    this.errors = e.response.data.errors;
                })
            },
            callSubmitUpdatePassword() {
                let temp = this.$data.updatePassword
                let formData = new FormData()
                formData.append('id', this.currentUser.user_id)
                formData.append('oldPassword', temp.oldPassword)
                formData.append('newPassword', temp.newPassword)
                formData.append('confirmPassword', temp.confirmPassword)
                formData.append('email', this.currentUser.user_mail)
                axios
                .post("/api/profile/password/change", formData)
                .then(response => {
                    if(response.data.response == "success"){
                        this.reloadPage();
                        this.message = response.data.message;
                    }
                })
                .catch(e => {
                    this.errors = e.response.data.errors;
                })
            },
            callSubmitWithdraw() {
                let temp = this.$data.withdraw
                let formData = new FormData()
                formData.append('id', this.currentUser.user_id)
                formData.append('campaign', temp.campaign)
                formData.append('nominal', temp.nominal)
                formData.append('bank', temp.bank)
                axios
                .post("/api/campaign/withdraw", formData)
                .then(response => {
                    if(response.data.response == "success"){
                        this.reloadPage();                        
                        this.message = response.data.message;
                    }
                })
                .catch(e => {
                    this.errors = e.response.data.errors;
                })
            },
            callCloseSubmisi(id) {
                axios.post("/api/campaign/close/"+id)
                .then(response => {
                    this.reloadPage();
                    this.message = "Berhasil Menutup Penggalangan Dana!";
                })
                .catch(e => {
                    console.log(e);
                })
            },
            loadData(id) {
                axios.get("/api/profile/info/"+id).then(response => {
                    this.donations = response.data.donations.data;
                    this.submisishistory = response.data.submissionhistory.data;
                    this.submisisactive = response.data.submissionactive;
                    this.participation = response.data.participations;
                    this.lengthHistoryDonation = response.data.donations.last_page;
                    this.lengthHistorySubmission = response.data.submissionhistory.last_page;
                });
            },
            getDataPage(id,toPage) {
                axios.get("/api/profile/info/"+id+"?page="+toPage).then(response => {
                    this.donations = response.data.donations.data;
                    this.submisishistory = response.data.submissionhistory.data;
                    this.submisisactive = response.data.submissionactive;
                    this.participation = response.data.participations;
                    this.lengthHistoryDonation = response.data.donations.last_page;
                    this.lengthHistorySubmission = response.data.submissionhistory.last_page;
                });
            },
            reloadPage(){
                window.location.reload()
            },
            reroutes: function (url) {
                this.$router.push({ path: url });
            }
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
        padding-top: 96px!important;
    }

    .v-btn:focus {
        outline: 0;
    }
    
    a.v-btn:hover, .v-chip:hover {
        text-decoration: none;
    }

    .v-tabs--vertical .v-tab {
        justify-content: start;
    }

    @media only screen and (max-width: 768px) {
        .v-tabs--vertical {
            flex-direction: column;
        }
    }
    /*@import './assets/styles/yourstyles.css';*/
</style>