<template>
<v-app>
    <navbar/>

    <main class="h-100">
        <div class="fluid">
            <section class="top-space bg-section-1">
                <v-container class="pb-12">
                    <v-card>
                        <v-card-title>Buat Penggalangan Dana</v-card-title>
                        <v-stepper v-model="step" vertical>
                                <v-stepper-step :complete="step > 1" step="1" color="error">Informasi Penggalangan</v-stepper-step>

                                <v-stepper-content step="1">
                                    <v-card-text>
                                        <v-form>
                                            <v-select prepend-inner-icon="mdi-file-document-box-check" :items="items" filled label="Pilih Kategori Yang Sesuai" v-model="submission.type" :error-messages="errors.submission.type" dense></v-select>
                                            <v-text-field label="Judul Penggalangan Dana" name="title" prepend-inner-icon="mdi-mastodon-variant" type="text" :counter="50" v-model="submission.title" :error-messages="errors.submission.title" required filled clearable/>
                                            <hr/>
                                            <v-text-field label="Penerima Manfaat" name="recipient" prepend-inner-icon="mdi-account-heart" type="text" v-model="submission.recipient" :error-messages="errors.submission.recipient" required filled clearable/>
                                            <v-textarea label="Cerita" name="story" prepend-inner-icon="mdi-chat-processing" type="text" :counter="255" v-model="submission.story" :error-messages="errors.submission.story" required filled auto-grow clearable no-rezise></v-textarea>
                                            <hr/>
                                            <v-text-field label="Target Donasi" name="target" prepend-inner-icon="mdi-cash" prefix="Rp." type="text" v-model="submission.target" :error-messages="errors.submission.target" required filled clearable/>
                                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false" :return-value.sync="submission.date" transition="scale-transition" offset-y min-width="290px">
                                                <template v-slot:activator="{ on }">
                                                <v-text-field v-model="date" label="Batas Waktu Penggalangan Dana" name="Waktu" prepend-inner-icon="event" readonly v-on="on" :error-messages="errors.submission.date" required filled></v-text-field>
                                                </template>
                                                <v-date-picker v-model="date" no-title scrollable>
                                                <v-spacer></v-spacer>
                                                <v-btn text color="red" @click="menu = false">Batal</v-btn>
                                                <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                            <v-btn color="error" @click="callSubmit()" class="mr-2">Lanjut</v-btn>
                                            <v-btn text class="mr-2" @click="goBack">Batal</v-btn>
                                        </v-form>

                                    </v-card-text>
                                </v-stepper-content>

                                <v-stepper-step :complete="step > 2" step="2" color="error">Foto</v-stepper-step>

                                <v-stepper-content step="2">
                                    <v-card-text>
                                        <v-form>
                                            <v-file-input label="Pilih foto utama penggalangan dana mu" filled prepend-icon="" prepend-inner-icon="mdi-camera" accept="image/png, image/jpeg, image/bmp" v-model="submission.image" :error-messages="errors.submission.image" @change="onImageChange" type="file"></v-file-input>
                                            <v-btn color="error" @click="callSubmit()" class="mr-2">Lanjut</v-btn>
                                            <v-btn text class="mr-2" @click="changeStep(1)">Kembali</v-btn>
                                        </v-form>
                                    </v-card-text>
                                </v-stepper-content>

                                <v-stepper-step :complete="step > 3" step="3" color="error">Syarat & Ketentuan</v-stepper-step>

                                <v-stepper-content step="3">
                                    <v-card-text>
                                        <v-form>
                                            <v-card max-width="644" outlined>
                                                <v-card-subtitle>Kindly tidak memfasilitasi: </v-card-subtitle>
                                                <v-alert border="left" icon="mdi-cancel" type="error" text dense class="mx-4">Galang dana untuk diri sendiri</v-alert>
                                                <v-alert border="left" icon="mdi-cancel" type="error" text dense class="mx-4">Galang dana fiktif</v-alert>
                                                <v-alert border="left" icon="mdi-cancel" type="error" text dense class="mx-4">Galang dana untuk kegiatan radikalisme & terorisme</v-alert>
                                                <v-card-actions>
                                                    <v-checkbox class="ml-2" v-model="submission.confirm" label="Saya setuju dengan Syarat & Ketentuan Donasi di Kindly, termasuk biaya administrasi platform sebesar 5% dari total donasi yang terkumpul." :error-messages="errors.submission.confirm" required></v-checkbox>
                                                </v-card-actions>
                                            </v-card>
                                            <v-btn color="error" @click="callSubmit()" class="mr-2 mt-5">Daftar</v-btn>
                                            <v-btn text @click="changeStep(2)" class="mr-2 mt-5">Kembali</v-btn>
                                        </v-form>
                                    </v-card-text>
                                </v-stepper-content>

                        </v-stepper>
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
        menu: false,
        items: ['Pendidikan', 'Bencana Alam', 'Kemanusiaan', 'Lingkungan','Kegiatan Sosial','Sarana dan Infrastruktur'],
        submission: {
            type: "",
            title: "",
            target: "",
            recipient: "",
            story: "",
            date: "",
            image: undefined,
            confirm: false,
        }
    }),
    computed: {
        currentUser: {
            get() {
                return this.$store.state.user.user;
            }
        },
        step: {
            get() {
                return this.$store.state.user.submissionStep;
            }
        },
        errors: {
            get() {
                return this.$store.state.user.errors;
            }
        },
        message: {
            get() {
                return this.$store.state.user.message;
            }
        }
    },
    methods: {
        onImageChange(event) {
                this.submission.image = this.$refs.file.files[0]
                this.submission.imagename = this.$refs.file.files[0].name;
        },
        changeStep(step) {
        this.$store.commit("user/setSubmissionStep", step);
        },
        callSubmit() {
            let temp = this.$data.submission;

            let formData = new FormData();
            formData.append('author', this.currentUser.user_id);
            formData.append('phone', this.currentUser.user_phone);
            formData.append('type', temp.type);
            formData.append('title', temp.title);
            formData.append('target', temp.target);
            formData.append('recipient', temp.recipient);
            formData.append('story', temp.story);
            formData.append('date', temp.date);
            formData.append('image', temp.image);
            if(temp.confirm) {
                formData.append('confirm', temp.confirm);
            }
            formData.append('step', this.step);

            this.$store.dispatch("user/start", formData);
        },
        submitForm(e) {
            e.preventDefault();
        },
        reroutes: function(url) {
            this.$router.push({ path: url });
        },
        goBack: function () {
            this.$router.go(-1);
        },
    }
};
</script>
