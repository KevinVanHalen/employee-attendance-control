<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">Reporte de asistencia</p>
        </div>
        <div class="mt-12 justify-content-between">
            <div class="text-center">
                <div class="my-2">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                    >
                        REPORTE GENERAL
                    </v-btn>
                </div>
                <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="reporteIndividual"
                    >
                        REPORTE POR EMPLEADO
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'main-attendance-report',
    methods: {
        reporteIndividual() {
            this.$router.push('/report/employee')
        }
    }
}
</script>