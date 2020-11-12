<template>
    <v-card class="full-width mb-5" dark height="110">
        <v-container>
            <v-row>

                <v-col>
                    <v-text-field v-model="taskCopy.body"
                                  label="Задание"
                                  dense
                                  :error-messages="errors.body"
                                  class="mx-1"
                                  :disabled="!isAuthorized"
                                  @change="taskChange($event, 'body')"/>
                </v-col>

                <v-col>
                    <v-text-field v-model="taskCopy.user_name"
                                  label="Имя юзера"
                                  dense
                                  class="mx-1"
                                  :error-messages="errors.user_name"
                                  :disabled="!isAuthorized"
                                  @change="taskChange($event, 'user_name')"/>
                </v-col>

                <v-col>
                    <v-text-field v-model="taskCopy.user_email"
                                  label="Почта юзера"
                                  dense
                                  class="mx-1"
                                  :error-messages="errors.user_email"
                                  :disabled="!isAuthorized"
                                  @change="taskChange($event, 'user_email')"/>
                </v-col>

                <v-col v-if="isAuthorized"
                       class="mt-n4">

                    <v-checkbox v-model="taskCopy.is_completed"
                                label="Готовая задача"
                                @change="taskChange($event, 'is_completed')"/>

                </v-col>
            </v-row>
            <v-row class="px-5">
                <v-chip v-if="+taskCopy.is_completed"
                        class="mr-4"
                        color="green"
                        label
                        x-small>
                    Выполнено
                </v-chip>

                <v-chip v-else
                        class="mr-4"
                        color="blue"
                        label
                        x-small>
                    Не выполнено
                </v-chip>

                <v-chip v-if="+taskCopy.is_changed"
                        color="grey"
                        label
                        x-small>
                    Отредактировано администратором
                </v-chip>
            </v-row>
        </v-container>

        <v-fab-transition>
            <v-btn v-if="isFormChanged"
                   class="primary"
                   bottom
                   small
                   absolute
                   right
                   fab
                   @click="edit">

                <v-icon>mdi-pencil</v-icon>

            </v-btn>
        </v-fab-transition>

    </v-card>
</template>

<script>
    import TaskRequester from '@/api/TaskRequester'
    import {getValidationErrors} from '@/api'

    export default {
        props: {
            task: Object,
            isAuthorized: Boolean,
        },
        data: () => ({
            taskCopy: {},
            updatedForm: {},
            isFormChanged: false,
            errors: {},
        }),
        methods: {
            async edit() {
                try {
                    await TaskRequester.update(this.updatedForm)
                    this.errors = {}
                    this.isFormChanged = false
                    this.$emit('task:updated')
                } catch (e) {
                    this.errors = getValidationErrors(e)
                }
            },
            taskChange($event, mode) {
                this.isFormChanged = true
                this.updatedForm[mode] = $event
            },
        },
        mounted() {
            this.taskCopy = {
                ...this.task,
                is_completed: +this.task.is_completed,
            }

            this.updatedForm = {
                id: this.taskCopy.id,
            }
        },
    }
</script>