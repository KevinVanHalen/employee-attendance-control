<template>
    <div class="container">
        <div class="text-center border-asistencias mt-10">
            <div class="titulo">SISTEMA DE CONTROL DE ASISTENCIAS</div>
        </div>

        <div class="row justify-content-around mt-10">
            <div class="col-auto mt-4">
                <router-link to="/main-reports" class="noline">
                    <boton-principal text="REPORTES" icon="mdi-file-multiple"></boton-principal>
                </router-link>
            </div>
            <div class="col-auto mt-4">
                <router-link to="/main-attendance" class="noline">
                    <boton-principal text="REGISTRAR ASISTENCIAS" icon="mdi-calendar-check"></boton-principal>
                </router-link>
            </div>
        </div>
        <div class="row justify-content-around mt-10 mb-10">
            <div class="col-auto mt-4">
                <router-link to="/main-non-attendance" class="noline">
                    <boton-principal text="REGISTRAR INASISTENCIAS" icon="mdi-calendar-remove"></boton-principal>
                </router-link>
            </div>
            <div class="col-auto mt-4">
                <router-link to="/main-employees" class="noline">
                    <boton-principal text="ADMINISTRAR EMPLEADOS" icon="mdi-account-group"></boton-principal>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import BotonPrincipal from './BotonPrincipal'

export default {
    name: 'home',
    components: {
        BotonPrincipal
    },
    created() {
        this.obtenerEmpleados()
    },
    methods: {
        async obtenerEmpleados() {
            try {
                let response = await axios.get('/api/employees')
                if (response.data.status === "ok") {
                    this.$store.commit('setEmployees', response.data.empleados)
                }
                console.log("error")
            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>