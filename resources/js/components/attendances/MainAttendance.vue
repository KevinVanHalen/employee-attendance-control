<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">Asistencias</p>
        </div>
        <div class="mt-12 justify-content-between">
            <div class="text-center">
                <div class="my-2">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="registrarAsistencia"
                    >
                        REGISTRAR ASISTENCIA
                    </v-btn>
                </div>
                <!-- <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                    >
                        MODIFICAR ASISTENCIAS
                    </v-btn>
                </div> -->
                <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="eliminarAsistencia"
                    >
                        ELIMINAR ASISTENCIAS
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'main-attendance',
    methods: {
        registrarAsistencia() {
            this.$router.push('/check-in-out')
        },
        async eliminarAsistencia() {
            try {
                let response = await axios.get('/api/attendances')
                if (response.data.status === "ok") {
                    this.$store.commit('setAttendances', response.data.asistencias)
                    this.$router.push('/delete-attendance')
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