<template>
    <v-container class="fill-height">

        <v-snackbar v-model="isSnackbarVisible"
                    color="green"
                    top>
            Новая задача успешно создана!
        </v-snackbar>

        <v-row>
            <v-spacer/>
            <auth-button :is-authorized="isAuthorized"/>
        </v-row>

        <task-list-sort @task:update-sort="controlChange"/>

        <div style="min-height: 50vh"
             class="full-width">

            <task-list v-if="!isLoading"
                       :tasks="tasks"
                       :is-authorized="isAuthorized"
                       @task:updated="loadTasks"/>
        </div>

        <task-list-pagination :total-tasks-count="totalTasksCount"
                              @task:update-paginate="controlChange"/>

        <task-create class="mt-auto"
                     @task:new-task="newTask"/>
    </v-container>
</template>

<script>
    import TaskList from '@/components/TaskList.vue'
    import TaskCreate from '@/components/TaskCreate.vue'
    import TaskListPagination from '@/components/TaskListPagination.vue'
    import TaskListSort from '@/components/TaskListSort'
    import AuthButton from '@/components/AuthButton'
    import TaskRequester from '@/api/TaskRequester'
    import AuthRequester from '../api/AuthRequester'

    export default {
        components: {
            TaskListSort,
            TaskListPagination,
            TaskList,
            TaskCreate,
            AuthButton,
        },
        data: () => ({
            isAuthorized: false,
            controls: {},
            tasks: [],
            totalTasksCount: 0,
            isLoading: true,
            isSnackbarVisible: false,
        }),
        methods: {
            async controlChange(data) {
                this.conrtols = {
                    ...this.conrtols,
                    ...data,
                }

                await this.loadTasks()
            },
            async loadTasks() {
                this.isLoading = true
                const {data: {data, total}} = await TaskRequester.index(this.conrtols)
                this.tasks = data
                this.totalTasksCount = total
                this.isLoading = false
            },
            async loadUserData() {
                const {data} = await AuthRequester.user()
                this.isAuthorized = data
            },
            async newTask() {
                this.isSnackbarVisible = true
                await this.loadTasks()
            },
        },
        async mounted() {
            await this.loadTasks()
            await this.loadUserData()
        },
    }
</script>
