<template>
    <v-row align="center">
        <v-col class="d-flex align-center">
            <span class="font-weight-bold">
                Сортировать по:
            </span>

            <div>
                <v-btn :class="{'primary': isSortByNameActive}"
                        class="ml-6"
                       @click="changeSort('user_name')">
                    Имя
                </v-btn>

                <v-btn :class="{'primary': isSortByStatusActive}"
                        class="ml-2"
                       @click="changeSort('is_completed')">
                    Статус
                </v-btn>

                <v-btn :class="{'primary': isSortByEmailActive}"
                        class="ml-2"
                       @click="changeSort('user_email')">
                    Почта
                </v-btn>
            </div>
        </v-col>
        <v-col class="align-center">
            <v-radio-group v-model="currentSortType"
                           class="ml-4">

                <v-radio value="DESC"
                         label="По убыванию"/>

                <v-radio value="ASC"
                         label="По возврастанию"/>

            </v-radio-group>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data: () => ({
            currentSortColumn: null,
            currentSortType: 'DESC',
        }),
        watch: {
            currentSortColumn() {
                this.fireEvent()
            },
            currentSortType() {
                this.fireEvent()
            },
        },
        computed: {
            isSortByEmailActive() {
                return this.currentSortColumn === 'user_email'
            },
            isSortByNameActive() {
                return this.currentSortColumn === 'user_name'
            },
            isSortByStatusActive() {
                return this.currentSortColumn === 'is_completed'
            },
        },
        methods: {
            changeSort(mode) {
                this.currentSortColumn = mode
            },
            fireEvent() {
                this.$emit('task:update-sort', {
                    sortColumn: this.currentSortColumn,
                    sortType: this.currentSortType,
                })
            },
        },
    }
</script>
