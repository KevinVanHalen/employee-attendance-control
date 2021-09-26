<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">EMPLEADOS CON DIAS A LA SEMANA</p>
        </div>
        <div class="row justify-content-center">
        <p><b>Para asignar dias de trabajo o modificar los dias de trabajo, de click en el icono respectivo</b></p>
            <div class="col-md-8">
                <v-data-table
                    :headers="headers"
                    :items="empleados"
                >
                    <template v-slot:[`item.actions`]="{item}">
                        <v-icon color="#EE6A82" class="ml-4" @click="editarDias(item)">
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
    name: 'ver-working-days',
    data() {
        return {
            headers: [
                {
                    text: 'Nombre', value: 'name_complete'
                },
                {
                    text: 'Dias a trabajar por semana', value: 'total_working_days'
                },
                {
                    text: 'Dias especificos', value: 'working_days'
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
        editarDias(item) {
            this.$store.commit('setEmployeeSelected', item)
            this.$router.push('/employee/update-working-days')
        }
    }
}
</script>