<template>
    <v-form>
        <v-card class="elevation-12">

            <v-toolbar dark flat>
                <v-toolbar-title>
                    Авторизация
                </v-toolbar-title>
            </v-toolbar>

            <v-card-text>
                <v-text-field v-model="form.login"
                              label="Логин"
                              :error-messages="errors.login"
                              prepend-icon="mdi-account"/>

                <v-text-field v-model="form.password"
                              label="Пароль"
                              :error-messages="errors.password"
                              prepend-icon="mdi-lock"
                              type="password"/>
            </v-card-text>

            <v-card-actions>
                <v-spacer/>
                <v-btn dark
                       @click.prevent="send">
                    Войти
                </v-btn>
            </v-card-actions>

        </v-card>
    </v-form>
</template>

<script>
    import {getValidationErrors} from '@/api'
    import AuthRequester from '@/api/AuthRequester'

    export default {
        data: () => ({
            form: {
                login: null,
                password: null,
            },
            errors: {},
        }),
        methods: {
            async send() {
                try {
                    await AuthRequester.login(this.form)
                    this.form = {}
                    this.errors = {}
                    await this.$router.push({name: 'home'})
                } catch (e) {
                    this.errors = getValidationErrors(e)
                }

            },
        },
    }
</script>
