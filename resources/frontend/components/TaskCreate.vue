<template>
    <v-row>
        <v-card dark class="full-width px-10 py-3 d-flex">
            <v-col cols="3">
                <v-text-field v-model="form.userName"
                              :error-messages="errors.userName"
                              label="Имя"
                              dense
                              filled/>
            </v-col>

            <v-col cols="3">
                <v-text-field v-model="form.userEmail"
                              :error-messages="errors.userEmail"
                              label="Почта"
                              dense
                              filled/>
            </v-col>

            <v-col cols="4">
                <v-text-field v-model="form.body"
                              :error-messages="errors.body"
                              label="Задача"
                              dense
                              filled/>
            </v-col>

            <v-col cols="2">
                <v-btn class="mt-1"
                       large
                       light
                       block
                       @click.prevent="store">
                    Создать
                </v-btn>
            </v-col>
        </v-card>
    </v-row>
</template>

<script>
    import TaskRequester from '@/api/TaskRequester'
    import {getValidationErrors} from '@/api'
    import EventBus from '../eventBus'

    export default {
        data: () => ({
            form: {
                userName: null,
                userEmail: null,
                body: null,
            },
            errors: {},
        }),
        methods: {
            async store() {
                try {
                    await TaskRequester.store(this.form)
                    this.$emit('task:new-task')
                    this.errors = {}
                    this.form = {}
                    // вывести уведомление
                } catch (e) {
                    this.errors = getValidationErrors(e)
                }
            },
        },
    }
</script>
