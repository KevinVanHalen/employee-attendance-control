<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">REGISTRO GENERAL DE LAS ULTIMAS INASISTENCIAS</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-data-table
                    :headers="headers"
                    :items="nonAttendances"
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
    name: 'delete-non-attendance',
    data() {
        return {
            headers: [
                {
                    text: 'Fecha', value: 'date'
                },
                {
                    text: 'Falta justificada', value: 'justified'
                },
                {
                    text: 'Motivo de la fatal', value: 'reason'
                },
                {
                    text: 'Acciones', value: 'actions'
                }
            ]
        }
    },
    computed: {
        nonAttendances() {
            return this.$store.getters.getNonAttendances
        }
    },
    methods: {
        async eliminar(item) {
            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.get(`/api/employee/non-attendance/${item.id}/delete`)
                    if (response.data.status === "ok") {
                        alert('Registro eliminado con exito')
                        let response = await axios.get('/api/non-attendances')
                        this.$store.commit('setNonAttendances', response.data.inasistencias)
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