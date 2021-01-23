<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">Inasistencias</p>
        </div>
        <div class="mt-12 justify-content-between">
            <div class="text-center">
                <div class="my-2">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="agregarInasistencia"
                    >
                        REGISTRAR INASISTENCIA
                    </v-btn>
                </div>
                <!-- <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                    >
                        MODIFICAR INASISTENCIAS
                    </v-btn>
                </div> -->
                <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="eliminarInasistencia"
                    >
                        ELIMINAR INASISTENCIAS
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'main-non-attendance',
    methods: {
        async agregarInasistencia() {
            try {
                let response = await axios.get('/api/employees')
                if (response.data.status === "ok") {
                    this.$store.commit('setEmployees', response.data.empleados)
                    this.$router.push('/non-attendance/store')
                } else {
                    alert('HUBO UN ERROR, VUELVE A DAR CLICK POR FAVOR. VERIFICA TU CONEXION A INTERNET')
                }
            } catch (error) {
                alert('HUBO UN ERROR, VUELVE A DAR CLICK POR FAVOR. VERIFICA TU CONEXION A INTERNET')
            }
        },
        async eliminarInasistencia() {
            try {
                let response = await axios.get('/api/non-attendances')
                if (response.data.status === "ok") {
                    this.$store.commit('setNonAttendances', response.data.inasistencias)
                    this.$router.push('/delete-non-attendance')
                } else {
                    alert('Hubo un error, vuelve a dar click por favor. Verifica tu conexion a internet')
                }
            } catch (error) {
                alert('Hubo un error, vuelve a dar click por favor. Verifica tu conexion a internet')
            }
        }
    }
}
</script>