<template>
    <v-snackbar top v-model="snackbar" :color="this.color" :timeout="timeout" class="top-space">
        <div :class="this.colorText" class="d-flex">
            <v-icon :color="this.colorIcon" left>mdi-check-circle</v-icon>
            <span style="font-size: 16px;">{{this.message}}</span>
        </div>
    </v-snackbar>
</template>

<script>
    export default {
        props: ['message', 'color', 'colorIcon', 'colorText'],
        data: () => ({
            snackbar: true,
            timeout: 4000
        }),
    }
</script>

<style>
    .top-space {
        padding-top: 90px!important;
    }

    .v-btn:focus {
        outline: 0;
    }
</style>