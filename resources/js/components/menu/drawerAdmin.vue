<template>

    <v-navigation-drawer permanent expand-on-hover app>
        <v-list>
            <v-list-item link two-line dense class="px-2" @click="reroutes('/profile')">
                <v-list-item-avatar>
                    <v-img :src="'/storage/profile/'+currentUser.user_foto"></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="title">{{currentUser.user_name}}</v-list-item-title>
                    <v-list-item-subtitle class="blue--text">Admin<v-icon color="blue" right>mdi-shield-check mdi-18px</v-icon></v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <v-divider/>

        <v-list nav dense>
            <v-list-item link @click="reroutes('/')">
                <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
                <v-list-item-title>Halaman Utama</v-list-item-title>
            </v-list-item>
        </v-list>

        <v-list nav dense>
            <template v-for="(page, index) in pages" :value="index">
                <v-list-item @click="changePage(page.name)" :dark=page.active :class="{primary: page.active}">
                    <v-list-item-icon><v-icon>{{page.icon}}</v-icon></v-list-item-icon>
                    <v-list-item-title>{{page.title}}</v-list-item-title>
                </v-list-item>
            </template>
        </v-list>

        <v-spacer/>

        <v-list nav dense>
            <v-list-item link @click="reroutes('/profile')">
                <v-list-item-icon><v-icon>mdi-account</v-icon></v-list-item-icon>
                <v-list-item-title>Profil</v-list-item-title>
            </v-list-item>

            <v-list-item link @click="callLogout">
                <v-list-item-icon><v-icon>mdi-logout-variant</v-icon></v-list-item-icon>
                <v-list-item-title>Keluar</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>

</template>

<script>
    export default {
        props: ['start'],
        data: () => ({
            nama: '',
            currentPage: '',
            pages: [
                {name:'feeds', icon:'mdi-apps', title:'Feeds', active:false},
                {name:'campaigns', icon:'mdi-charity', title:'Daftar Penggalangan', active:false},
                {name:'users', icon:'mdi-account-group', title:'Daftar Pengguna', active:false},
                {name:'donations', icon:'mdi-cash-multiple', title:'Daftar Donasi', active:false},
                {name:'withdraws', icon:'mdi-comment-check', title:'Daftar Pencairan', active:false},
            ]
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
        },
        methods: {
            reroutes: function (url) {
                this.$router.push({ path: url });
            },
            changePage(text) {
                this.page = text;
                this.$emit('pageChanged', this.page);
                this.pages.filter(function(elem){
                    if(elem.name == text) elem.active = true;
                    else elem.active = false;
                });
            },
            callLogout() {
                this.$store.dispatch("user/logout")
                .then(() => {
                    this.$router.go('/');
                });
            }
        },
        created() {
            var i = this.start
            this.currentPage = i;
            this.pages.filter(function(elem){
                if(elem.name == i) elem.active = true;
                else elem.active = false;
            });
            
            this.$store.dispatch('user/getUser');
        }
    }
</script>

<style>
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