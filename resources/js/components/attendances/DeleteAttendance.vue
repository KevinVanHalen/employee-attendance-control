<template>
    <div container>
        <div class="text-center mt-10">
            <p class="titulo">REGISTRO GENERAL DE LAS ULTIMAS ASISTENCIAS</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-data-table
                    :headers="headers"
                    :items="attendances"
                >
                    <template v-slot:[`item.actions`]="{item}">
                        <v-icon color="#EE6A82" class="ml-4" @click="eliminar(item)">
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'delete-attendance',
    data() {
        return {
            headers: [
                {
                    text: 'Fecha', value: 'date'
                },
                {
                    text: 'Hora de entrada', value: 'entrance_hour'
                },
                {
                    text: 'Hora de salida', value: 'exit_hour'
                },
                {
                    text: 'Empleado', value: 'employee'
                },
                {
                    text: 'Acciones', value: 'actions'
                }
            ]
        }
    },
    computed: {
        attendances() {
            return this.$store.getters.getAttendances
        }
    },
    methods: {
        async eliminar(item) {
            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.get(`/api/employee/attendance/${item.id}/delete`)
                    if (response.data.status === "ok") {
                        alert('Registro eliminado con exito')
                        let response = await axios.get('/api/attendances')
                        this.$store.commit('setAttendances', response.data.asistencias)
                    } else {
                        alert('ERROR AL INTENTAR ELIMINAR REGISTRO, INTENTA DE NUEVO POR FAVOR. VERIFICA TU CONEXION A INTERNET')
                    }
                } catch (error) {
                    alert('ERROR AL INTENTAR ELIMINAR REGISTRO, INTENTA DE NUEVO POR FAVOR. VERIFICA TU CONEXION A INTERNET')
                }
            }
        }
    }
}
</script>