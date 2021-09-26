<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">REPORTE DE ASISTENCIA POR EMPLEADO</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-form ref="form" v-model="valid">
                    <v-autocomplete
                        v-model="data.id" 
                        :rules="employeeRules"
                        :items="empleados" 
                        item-text="name_complete" 
                        item-value="id" 
                        label="Seleccione un empleado"
                        required
                    ></v-autocomplete>
                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.start_date"
                                :rules="dateStartRules"
                                type="date"
                                label="Ingrese la fecha inicial para el reporte"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.end_date"
                                :rules="dateEndRules"
                                type="date"
                                label="Ingrese la fecha final para el reporte"
                                required
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click.prevent="getReport"
                        >
                            Obtener Reporte
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-data-table
                    :headers="headers"
                    :items="employeReport"
                >
                </v-data-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'report-employee',
    data() {
        return {
            valid: true,
            data: {
                id: null,
                start_date: null,
                end_date: null,
            },
            employeeRules: [
                v => !!v || 'Debe seleccionar un empleado'
            ],
            dateStartRules: [
                v => !!v || 'La fecha inicial del rango es obligatoria'
            ],
            dateEndRules: [
                v => !!v || 'La fecha final del rango es obligatoria'
            ],
            headers: [
                {
                    text: 'Empleada(o)', value: 'empleado'
                },
                {
                    text: 'N° de días que debio trabajar', value: 'asistencias_teoricas'
                },
                {
                    text: 'Asistencias', value: 'asistencias_reales'
                },
                {
                    text: 'Inasistencias', value: 'inasistencias'
                },
                {
                    text: 'Justificadas', value: 'justificadas'
                },
                {
                    text: 'No justificadas', value: 'no_justificadas'
                }
            ]
        }
    },
    computed: {
        employeReport() {
            return this.$store.getters.getEmployeeReport
        },
        empleados() {
            return this.$store.getters.getEmployees
        }
    },
    methods: {
        async getReport() {
            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.post('/api/employee/report', this.data)
                    if (response.data.status === "ok") {
                        alert(response.data.message.toUpperCase())
                        this.$store.commit('setEmployeeReport', response.data.data)
                        // this.$router.push('/home')
                    } else {
                        alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                    }
                } catch (error) {
                    alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                }
            }
        }
    }
}
</script>