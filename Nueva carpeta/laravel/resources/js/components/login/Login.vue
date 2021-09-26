<template>
    <div class="mt-16">
        <div class="text-center mb-12">
            <p class="titulo">CONTROL DE ASISTENCIA</p>
        </div>
        <v-card elevation="17" class="mx-auto" max-width="400">
            <v-card-title class="fondo_login white--text">
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
                                color="#EE6A82"
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
                email: '',
                password: '',
            },
            userRules: [
                v => !!v || 'El usuario es obligatorio'
            ],
            passwordRules: [
                v => !!v || 'La contraseña es obligatoria'
            ],
        }
    },
    methods: {
        async login() {
            try {
                await axios.get('/sanctum/csrf-cookie').then(async response => {
                    await axios.post('/api/login', this.form).then(response => {
                        if (response.status === 200 && response.statusText === "OK") {
                            this.$store.dispatch('getUser')
                            this.$router.push('/home')
                        } else {
                            alert('Usuario o contraseña invalidos, intente de nuevo por favor')
                        }
                    })
                })
            } catch (error) {
                alert('Error, usuario o contraseña invalidos. Revise su conexión a internet')
            }
        },
        validate() {
            this.$refs.form.validate()
        }
    }
}
</script>