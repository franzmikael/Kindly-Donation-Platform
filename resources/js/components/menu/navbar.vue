<template>

    <v-app-bar id="navbar" fixed elevate-on-scroll class="py-2 h-auto">
        <v-spacer/>

        <v-toolbar-title @click="reroutes('/')" class="headline font-weight-medium d-flex align-center" style="cursor: pointer">
            <v-img :src="logo" height="36" width="36" class="mr-2" contain/>{{brand}}
        </v-toolbar-title>

        <v-spacer/>

        <v-text-field class="mr-2 only-lg" @mousedown="reroutes('/search')" rounded filled hide-details dense placeholder="Cari galang dana" prepend-inner-icon="search"/> 
        <v-btn class="mr-2 only-md" @mousedown="reroutes('/search')" icon><v-icon>mdi-magnify</v-icon></v-btn>
        <v-btn @click="reroutes('/campaign')" large text class="mr-3 only-lg">Donasi</v-btn>
        <v-btn @click="ifLoggedIn('/start')" large text class="mr-3 only-lg" v-if="!currentUser.user_is_admin">Galang Dana</v-btn>

        <template v-if="loggedin == false">
            <v-dialog v-model="logindialog" max-width="600px">
                <template v-slot:activator="{ on }">
                    <v-btn @click="reroutes('/register')" large color="error" class="mr-3">Daftar</v-btn>
                    <v-btn large text color="error" class="mr-3" v-on="on">Masuk</v-btn>
                </template>
                <v-card tile color="#F1F1F1">
                    <v-card-title class="d-flex justify-center pt-6">
                        <div class="headline">Masuk</div>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-form @submit.prevent="callLogin" id="form-login">
                                <v-row>
                                    <v-col cols="12" class="py-0">
                                        <v-alert type="error" text dense transition="slide-y-transition" v-if="message">{{message}}</v-alert>
                                        <v-text-field solo flat label="Email" required v-model="login.email" :error-messages="errors.login.email"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" class="py-0">
                                        <v-text-field solo flat label="Password" type="password" required v-model="login.password" :error-messages="errors.login.password"></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-btn type="submit" form="form-login" color="red darken-1" dark block large>Masuk Sekarang</v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                            <v-row>
                                <v-col cols="12" class="text-center">
                                    <p>Belum punya akun Kindly? <a @click="reroutes('/register')">Daftar</a></p>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </template>
        
        <template v-else>
            <v-menu offset-y open-on-hover transition="slide-y-transition" bottom>
                <template v-slot:activator="{ on }">
                    <v-btn large text v-on="on">
                        <template v-if="loggedin == true">
                            <v-avatar size="40" class="mr-2">
                                <img :src="'/storage/profile/'+currentUser.user_foto">
                            </v-avatar>
                            {{currentUser.user_name}}
                        </template>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item @click="reroutes('/dashboard')" v-if="currentUser.user_is_admin == 1">
                        <v-list-item-title>
                            <v-icon left>mdi-apps</v-icon>Dashboard
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="reroutes('/campaign')">
                        <v-list-item-title>
                            <v-icon left>mdi-charity</v-icon>Donasi
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="ifLoggedIn('/start')" v-if="!currentUser.user_is_admin">
                        <v-list-item-title>
                            <v-icon left>mdi-flag-plus</v-icon>Galang Dana
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="reroutes('/profile')">
                        <v-list-item-title>
                            <v-icon left>mdi-account</v-icon>Profil
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="callLogout">
                        <v-list-item-title>
                            <v-icon left>mdi-logout-variant</v-icon>Keluar
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </template>

        <v-spacer/>
    </v-app-bar>

</template>

<script>
    export default {
        data: () => ({
            brand: 'Kindly', 
            logo: '/img/brand.png',
            navbar: '#navbar',
            logindialog: false,

            login: {
                email: '',
                password: ''
            },
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
                }
            },
            errors: {
                get() {
                    return this.$store.state.user.errors;
                }
            },
            message: {
                get() {
                    return this.$store.state.user.messageDialog;
                }
            }
        },
        created() {
            this.$store.dispatch('user/getUser');
        },
        methods: {
            reroutes(url) {
                this.$router.push({ path: url });
            },
            ifLoggedIn(url) {
                if(!this.loggedin) {
                    this.$data.logindialog = true;
                } else {
                    this.reroutes(url);
                }
            },
            handleScroll() {
                if(window.scrollY > 0) {
                    navbar.classList.add("nav-bg");
                } else {
                    navbar.classList.remove("nav-bg");
                }
            },
            callLogin() {
                this.$store.dispatch("user/login", this.$data.login)
                .then(() => {
                    if(this.$route.path == '/register') {
                        this.$router.push({path: '/'});
                    }
                });
            },
            callLogout() {
                this.$store.dispatch("user/logout")
                .then(() => {
                    this.$data.logindialog = false;
                    this.$router.go();
                });
            }
        },
        mounted() {
            this.handleScroll();
            window.addEventListener('scroll', this.handleScroll);
        }
    }
</script>

<style>
    #navbar {
        background: transparent;
    }

    #navbar .only-lg {
        display: flex;
        align-items: center;
    }

    #navbar .only-md {
        display: none;
    }

    @media only screen and (max-width: 959px) {
        #navbar .only-lg {
            display: none;
        }

        #navbar .only-md {
            display: block;
        }
    }

    .nav-bg {
        background: linear-gradient(to right, #E7E1F7, #FCBFBB)!important;
    }

    .v-btn:focus {
        outline: 0;
    }
    
    a.v-btn:hover, a.v-list-item, .v-chip:hover {
        text-decoration: none;
    }
</style>