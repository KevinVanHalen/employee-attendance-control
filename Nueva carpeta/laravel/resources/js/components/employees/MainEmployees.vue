<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">Empleados</p>
        </div>
        <div class="mt-12 justify-content-between">
            <div class="text-center">
                <div class="my-2">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="registrarEmpleado"
                    >
                        REGISTRAR EMPLEADO
                    </v-btn>
                </div>
                <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="modificarEmpleado"
                    >
                        MODIFICAR EMPLEADO
                    </v-btn>
                </div>
                <div class="mt-8">
                    <v-btn
                        x-large
                        color="#084A77"
                        dark
                        @click="verDiasDeTrabajo"
                    >
                        ASIGNAR DIAS DE TRABAJO
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'main-employees',
    methods: {
        registrarEmpleado() {
            this.$router.push('/employee/store')
        },
        async modificarEmpleado() {
            try {
                let response = await axios.get('/api/employees')
                if (response.data.status === "ok") {
                    this.$store.commit('setEmployees', response.data.empleados)
                    this.$router.push('/employee/show-all')
                } else {
                    alert('HUBO UN ERROR, VUELVE A DAR CLICK POR FAVOR. VERIFICA TU CONEXION A INTERNET')
                }
            } catch (error) {
                alert('HUBO UN ERROR, VUELVE A DAR CLICK POR FAVOR. VERIFICA TU CONEXION A INTERNET')
            }
        },
        verDiasDeTrabajo() {
            this.$router.push('/employees/ver-working-days')
        }
    }
}
</script>