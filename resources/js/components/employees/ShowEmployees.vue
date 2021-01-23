<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">EMPLEADOS REGISTRADOS</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-data-table
                    :headers="headers"
                    :items="empleados"
                >
                    <template v-slot:[`item.actions`]="{item}">
                        <v-icon color="#EE6A82" class="ml-4" @click="editar(item)">
                            mdi-account-edit
                        </v-icon>
                    </template>
                </v-data-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'show-employees',
    data() {
        return {
            headers: [
                {
                    text: 'Nombre', value: 'name_complete'
                },
                {
                    text: 'Acciones', value: 'actions'
                }
            ]
        }
    },
    computed: {
        empleados() {
            return this.$store.getters.getEmployees
        }
    },
    methods: {
        editar(item) {
            this.$store.commit('setEmployeeSelected', item)
            this.$router.push('/employee/update')
        }
    }
}
</script>