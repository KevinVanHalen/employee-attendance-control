<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">AGREGAR INASISTENCIA</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-form ref="form" v-model="valid">
                    <v-autocomplete
                        v-model="data.employee_id" 
                        :rules="employeeRules"
                        :items="empleados" 
                        item-text="name_complete" 
                        item-value="id" 
                        label="Seleccione el empleado que tendra inasistencia"
                        required
                    ></v-autocomplete>
                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.date"
                                :rules="dateRules"
                                type="date"
                                label="Ingrese la fecha de la inasistencia"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-lg-5 col-auto">
                            <v-select
                                v-model="data.flag"
                                :rules="justifiedRules"
                                label="Seleccione si es falta justificada"
                                :items="['SI', 'NO']"
                                required
                            ></v-select>
                        </div>
                    </div>
                    <v-textarea 
                        v-model="data.reason" 
                        label="Motivo de la falta" 
                        outlined
                        color="teal"
                    ></v-textarea>
                    <div class="text-center mt-4">
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click.prevent="agregarInasistencia"
                        >
                            Agregar Inasistencia
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'non-attendance-store',
    data() {
        return {
            valid: true,
            data: {
                date: '',
                flag: null,
                justified: null,
                reason: '',
                employee_id: null,
            },
            dateRules: [
                v => !!v || 'La fecha de la inasistencia es obligatoria'
            ],
            justifiedRules: [
                v => !!v || 'Debe seleccionar si la falta es justificada o no'
            ],
            employeeRules: [
                v => !!v || 'Debe seleccionar un empleado'
            ],
        }
    },
    computed: {
        empleados() {
            return this.$store.getters.getEmployees
        }
    },
    methods: {
        async agregarInasistencia() {
            this.data.justified = this.data.flag == 'SI' ? 1 : 0

            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.post('/api/employee/non-attendance/store', this.data)
                    if (response.data.status === "ok") {
                        alert(response.data.message.toUpperCase())
                        this.$router.push('/home')
                    } else {
                        alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                    }
                } catch (error) {
                    alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                }
            }
        },
        validate() {
            this.$refs.form.validate()
        }
    }
}
</script>