<template>
    <v-row justify="center">
        <v-pagination v-model="currentPage"
                      :length="pagesCount"
                      @input="fireEvent"/>
    </v-row>
</template>

<script>
    export default {
        props: {
            totalTasksCount: String,
        },
        data: () => ({
            currentPage: 1,
        }),
        computed: {
            pagesCount() {
                return Math.ceil(this.totalTasksCount / 3)
            },
            fireEvent() {
                this.$emit('task:update-paginate', {
                    offset: (this.currentPage - 1) * 3,
                })
            },
        },
    }
</script>
