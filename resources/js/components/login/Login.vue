<template>
    <div class="mt-16">
        <div class="text-center mb-6">
            <p class="titulo">CONTROL DE ASISTENCIA</p>
        </div>
        <v-card class="mx-auto" max-width="400">
            <v-card-title>
                <v-spacer></v-spacer>
                    <div>
                        <span>INICIAR SESIÓN</span>
                    </div>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-form class="col-12" ref="form" v-model="valid" @submit.prevent="login">
                        <v-col cols="12">
                            <v-text-field
                                v-model="form.email"
                                :rules="userRules"
                                prepend-icon="mdi-account"
                                label="Usuario"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                v-model="form.password"
                                :rules="passwordRules"
                                prepend-icon="mdi-lock"
                                label="Contraseña"
                                type="password"
                            ></v-text-field>
                        </v-col>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                type="submit"
                                :disabled="!valid"
                                @click.prevent="login"
                                class="mb-10"
                            >
                                Entrar
                            </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-form>
                </v-container>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>

export default {
    name: 'login',
    data() {
        return {
            valid: true,
            form: {
                email: 'admin',
                password: '1234',
            },
            userRules: [
                v => !!v || 'El nombre de usuario es requerido'
            ],
            passwordRules: [
                v => !!v || 'La contraseña es requerida'
            ],
        }
    },
    methods: {
        async login() {
            // axios.get('/sanctum/csrf-cookie').then(() => {
            //     axios.post('/api/login', this.form).then(response => {
            //         console.log('User signed in!');
            //         console.log(response)
            //     }).catch(error => console.log(error)); // credentials didn't match
            // });
            try {
                let response = await axios.post('/api/user/login', this.form)
                console.log(response)
                if (response.data.status === "ok") {
                    console.log("Login")
                    this.$store.commit('setUser', response.data.user)
                    this.$router.push('/home')
                    console.log("desde store", this.$store.getters.getUser)
                } else {
                    console.log("usuario no encontrado")
                }
            } catch (error) {
                console.log(error)
                alert("Error al iniciar sesion, verifique su conexion a internet")
            }
        },
        validate() {
            this.$refs.form.validate()
        }
    }
}
</script>