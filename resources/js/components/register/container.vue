<template>
  <v-app>
    <navbar />

    <main class="h-100">
      <div class="fluid">
        <section class="top-space bg-section-1">
          <v-container class="pb-12">
            <v-card>
              <v-card-title>Daftar Akun Baru</v-card-title>
              <v-stepper v-model="step" vertical>
                <v-stepper-step :complete="step > 1" step="1" color="error">Data Pribadi</v-stepper-step>

                <v-stepper-content step="1">
                  <v-card-text>
                    <v-form :value="csrf">
                      <v-text-field label="Nama Depan*" name="firstName" prepend-inner-icon="person" type="text" v-model="register.firstName" :error-messages="errors.register.firstName" required filled clearable />
                      <v-text-field label="Nama Belakang*" name="lastName" prepend-inner-icon="person" type="text" v-model="register.lastName" :error-messages="errors.register.lastName" required filled clearable />
                      <v-text-field label="Email*" name="email" prepend-inner-icon="mail" type="text" v-model="register.email" :error-messages="errors.register.email" required filled clearable />
                      <v-text-field label="Nomor Handphone*" name="phoneNumber" prepend-inner-icon="phone" type="text" v-model="register.phoneNumber" :error-messages="errors.register.phoneNumber" required filled clearable />
                      <v-file-input label="Foto Profil" prepend-icon="" prepend-inner-icon="mdi-camera" accept="image/png, image/jpeg, image/bmp" v-model="register.image" :error-messages="errors.register.image" type="file" filled></v-file-input>
                      <v-btn color="error" @click="callSubmit()" class="mr-2">Lanjut</v-btn>
                      <v-btn text class="mr-2" @click="goBack">Batal</v-btn>
                    </v-form>
                  </v-card-text>
                </v-stepper-content>

                <v-stepper-step :complete="step > 2" step="2" color="error">Password</v-stepper-step>

                <v-stepper-content step="2">
                  <v-card-text>
                    <v-form>
                      <v-text-field id="password" label="Password" name="password" prepend-inner-icon="mdi-lock-open" v-model="register.password" :error-messages="errors.register.password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" required filled clearable />
                      <v-btn color="error" @click="callSubmit()" class="mr-2">Daftar</v-btn>
                      <v-btn text @click="changeStep(1)" class="mr-2">Kembali</v-btn>
                    </v-form>
                  </v-card-text>
                </v-stepper-content>
              </v-stepper>
            </v-card>
          </v-container>
        </section>
      </div>
    </main>

    <footbar />
  </v-app>
</template>

<script>
export default {
  data: () => ({
    show1: false,
    show2: false,

    register: {
      firstName: "",
      lastName: "",
      email: "",
      phoneNumber: "",
      image: undefined,
      password: "",
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
  }),
  computed: {
    step: {
        get() {
            return this.$store.state.user.registerStep;
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
    callSubmit() {
      let temp = this.$data.register;

      let formData = new FormData();
      formData.append('firstName', temp.firstName);
      formData.append('lastName', temp.lastName);
      formData.append('email', temp.email);
      formData.append('phoneNumber', temp.phoneNumber);
      formData.append('image', temp.image);
      formData.append('password', temp.password);
      formData.append('token', temp.csrf);
      formData.append('step', this.$store.state.user.registerStep);

      this.$store.dispatch("user/register", formData);
    },
    changeStep(step) {
      this.$store.commit("user/setRegisterStep", step);
    },
    submitForm(e) {
      e.preventDefault();
    },
    reroutes: function(url) {
      this.$router.push({ path: url });
    },
    goBack: function() {
      this.$router.go(-1);
    }
  }
};
</script>
