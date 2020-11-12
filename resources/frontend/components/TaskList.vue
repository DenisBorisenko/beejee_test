<template>
    <v-row>
        <task-list-item v-for="(task,index) in tasks"
                        :key="index"
                        :task="task"
                        :is-authorized="isAuthorized"
                        @task:updated="$emit('task:updated')"/>
    </v-row>
</template>

<script>
    import TaskListItem from '@/components/TaskListItem.vue'

    export default {
        components: {
            TaskListItem,
        },
        props: {
            tasks: Array,
            isAuthorized: Boolean,
        },

    }
</script>