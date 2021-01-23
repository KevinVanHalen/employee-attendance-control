<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">AGREGAR EMPLEADO</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-form ref="form" v-model="valid">
                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.last_name_1"
                                :rules="lastNameRules"
                                label="Ingrese el apellido paterno"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.last_name_2"
                                :rules="lastNameRules"
                                label="Ingrese el apellido materno"
                                required
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.first_name"
                                :rules="firstNameRules"
                                label="Ingrese el nombre"
                                required
                            ></v-text-field>
                        </div>
                        <div class="col-lg-5 col-auto">
                            <v-text-field
                                v-model="data.login_key"
                                :rules="loginKeyRules"
                                label="Ingrese una clave de acceso para el empleado"
                                required
                            ></v-text-field>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click.prevent="editarEmpleado"
                        >
                            Editar Empleado
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'employee-update',
    data() {
        return {
            valid: true,
            data: {
                id: null,
                last_name_1: '',
                last_name_2: '',
                first_name: '',
                login_key: '',
                status: null,
                job_title: null,
            },
            lastNameRules: [
                v => !!v || 'El apellido es obligatorio'
            ],
            firstNameRules: [
                v => !!v || 'El nombre es obligatorio'
            ],
            loginKeyRules: [
                v => !!v || 'La clave de acceso es obligatoria'
            ],
        }
    },
    created() {
        this.setEmployee()
    },
    methods: {
        setEmployee() {
            let employee = this.$store.getters.getEmployeeSelected
            this.data.id = employee.id
            this.data.last_name_1 = employee.last_name_1
            this.data.last_name_2 = employee.last_name_2
            this.data.first_name = employee.first_name
            this.data.login_key = employee.login_key
            this.data.status = employee.status
            this.data.job_title = employee.job_title
        },
        async editarEmpleado() {
            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.post('/api/employee/update', this.data)
                    if (response.data.status === "exist") {
                        alert('ERROR!!!, LA CLAVE DE ACCESO YA LA TIENE OTRO USUARIO, INGRESA UNA DIFERENTE')
                    } else if (response.data.status === "ok") {
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