<template>
    <div>
        <v-btn v-if="!isAuthorized"
               :to="{name: 'login'}">
            Админ. панель
        </v-btn>

        <v-btn v-else @click="logout">
            Выйти
        </v-btn>
    </div>
</template>

<script>
    import AuthRequester from '@/api/AuthRequester'

    export default {
        props: {
            isAuthorized: Boolean,
        },
        methods: {
            async logout() {
                await AuthRequester.logout()
            }
        }
    }
</script>
