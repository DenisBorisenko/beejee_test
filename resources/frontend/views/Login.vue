<template>
    <v-container fill-height fluid>
        <v-row justify="center">
            <v-col cols="5">
                <login-form />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import LoginForm from '@/components/LoginForm'

    export default {
        components: {
            LoginForm,
        },
    }
</script>
