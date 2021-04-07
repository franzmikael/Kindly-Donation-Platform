<template>

<v-footer dark padless>
    <v-card flat tile class="gradient-bg white--text text-center w-100">
        <v-card-text>
            <v-btn v-for="icon in icons" :key="icon" class="mx-4 white--text" icon>
            <v-icon size="24px">{{ icon }}</v-icon>
            </v-btn>
        </v-card-text>

        <v-card-text class="white--text pt-0">
            Perjalanan hidup ini indah ketika kita mampu berbagi, bukan menikmatinya sendiri.
        </v-card-text>
        
        <v-divider></v-divider>
        
        <v-card-text class="white--text">
            {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
        </v-card-text>
    </v-card>  
</v-footer>

</template>

<script>
    export default {
        data: () => ({
            icons: [
                'mdi-facebook-box',
                'mdi-twitter',
                'mdi-google-plus',
                'mdi-linkedin',
                'mdi-instagram',
            ],
        }),
    }
</script>

<style>
    .gradient-bg {
        background: linear-gradient(to right, #F69983, #e35d5b);
    }

    .v-btn:focus {
        outline: 0;
    }
    
    a.v-btn:hover, .v-chip:hover {
        text-decoration: none;
    }
</style>