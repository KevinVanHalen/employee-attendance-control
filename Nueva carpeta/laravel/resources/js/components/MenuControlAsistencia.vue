<template>
    <div>
        <v-toolbar color="#EE6A82">
            <v-tabs class="hidden-sm-and-down" dark center-active fixed-tabs>
                <v-tabs-slider color="#92C145"></v-tabs-slider>
                <v-tab to="/home" class="noline">
                    Inicio
                </v-tab>
                <v-tab to="/main-reports" class="noline">
                    Reportes
                </v-tab>
                <v-tab to="/main-attendance" class="noline">
                    Asistencias
                </v-tab>
                <v-tab to="/main-non-attendance" class="noline">
                    Inasistencias
                </v-tab>
                <v-tab to="/main-employees" class="noline">
                    Empleados
                </v-tab>
                <v-menu offset-y :close-on-click="closeOnClick">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            text
                            class="align-self-center mr-4"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon left>
                                mdi-account
                            </v-icon>
                            Administrador
                            <v-icon right>
                                mdi-menu-down
                            </v-icon>
                        </v-btn>
                    </template>
                    <v-list class="grey lighten-3">
                        <v-list-item>
                            Settings
                        </v-list-item>
                        <v-list-item @click.prevent="logout">Cerrar Sesión</v-list-item>
                    </v-list>
                </v-menu>
            </v-tabs>
            <v-menu offset-y class="hidden-md-and-up">
                <template v-slot:activator="{ on, attrs }">
                    <v-tabs class="hidden-md-and-up" dark fixed-tabs>
                        <v-tabs-slider color="#92C145"></v-tabs-slider>
                        <v-tab v-on="on" v-bind="attrs" class="noline">
                            <v-icon class="mr-5">mdi-menu</v-icon>
                            MENU
                        </v-tab>
                    </v-tabs>
                </template>
                <v-list>
                    <v-list-item-group>
                        <v-list-item to="/home" class="noline">
                            <v-list-item-content>
                                <v-list-item-title>Inicio</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/main-reports" class="noline">
                            <v-list-item-content>
                                <v-list-item-title>Reportes</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/main-attendance" class="noline">
                            <v-list-item-content>
                                <v-list-item-title>Asistencias</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/main-non-attendance" class="noline">
                            <v-list-item-content>
                                <v-list-item-title>Inasistencias</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item to="/main-employees" class="noline">
                            <v-list-item-content>
                                <v-list-item-title>Empleados</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click.prevent="logout" class="noline">
                            <v-list-item-icon>
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Cerrar Sesión</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-toolbar>
    </div>
</template>

<script>
export default {
    name: 'menu-control-asistencia',
    data() {
        return {
            closeOnClick: true,
        }
    },
    computed: {
        currentUser() {
            this.$store.getters.getUser
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('logout')
            return this.$router.push('/')
        }
    }
}
</script>