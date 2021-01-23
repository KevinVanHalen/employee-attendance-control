<template>
    <div container>
        <div class="text-center mt-10">
            <p class="titulo">Check In/Out</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <v-form ref="form" v-model="valid" @submit.prevent="checkInOut">
                    <v-text-field
                        v-model="data.login_key"
                        :rules="loginKeyRules"
                        label="Ingrese la clave de acceso del empleado"
                        required
                        type="password"
                    ></v-text-field>
                    <div class="text-center mt-4">
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click.prevent="checkInOut"
                        >
                            Check In/Out
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'check-in-out',
    data() {
        return {
            valid: true,
            data: {
                login_key: ''
            },
            loginKeyRules: [
                v => !!v || 'La clave de acceso es obligatoria'
            ],
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters.getUser
        }
    },
    methods: {
        async checkInOut() {
            if (this.$store.state.user === null) {
                alert('ERROR, VUELVE A INICIAR SESION POR FAVOR')
                this.$router.push('/')
            } else {
                try {
                    let response = await axios.post('/api/attendance/check-in-out', this.data)
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