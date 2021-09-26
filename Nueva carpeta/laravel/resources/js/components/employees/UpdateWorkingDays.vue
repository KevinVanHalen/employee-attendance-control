<template>
    <div class="container">
        <div class="text-center mt-10">
            <p class="titulo">MODIFICAR DIAS DE TRABAJO</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <v-form ref="form">
                    <v-text-field
                        v-model="data.employee"
                        label="Nombre del empleado"
                        disabled
                    ></v-text-field>
                    <v-select
                        v-model="data.days"
                        :items="days"
                        label="Selecciona los dias que le corresponden trabajar a este empleado"
                        multiple
                        hint="Puedes agregar o quitar los dias que necesites"
                        persistent-hint
                    ></v-select>
                    <div class="text-center mt-4">
                        <v-btn
                            color="success"
                            @click.prevent="editarDias"
                        >
                            Editar Dias
                        </v-btn>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'update-working-days',
    data() {
        return {
            days: [
                'Lunes',
                'Martes',
                'Miercoles',
                'Jueves',
                'Viernes',
                'Sabado',
                'Domingo'
            ],
            data: {
                employee: '',
                days: [],
                working_days_id: null,
                employee_id: null,
            },
            data_update: {
                id: null,
                monday: 0,
                tuesday: 0,
                wednesday: 0,
                thursday: 0,
                friday: 0,
                saturday: 0,
                sunday: 0,
                total_working_days: null,
            },
            data_new: {
                monday: 0,
                tuesday: 0,
                wednesday: 0,
                thursday: 0,
                friday: 0,
                saturday: 0,
                sunday: 0,
                total_working_days: null,
                employee_id: null
            }
        }
    },
    created() {
        this.setEmployeeWorkingDays()
    },
    methods: {
        setEmployeeWorkingDays() {
            let employee = this.$store.getters.getEmployeeSelected
            console.log(employee)
            this.data.employee = employee.name_complete
            this.data.days = employee.array_days
            this.data.working_days_id = employee.working_days_register ? employee.working_days_register.id : null
            this.data.employee_id = employee.id
        },
        async editarDias() {
            this.data_update.monday = 0
            this.data_new.monday = 0
            this.data_update.tuesday = 0
            this.data_new.tuesday = 0
            this.data_update.wednesday = 0
            this.data_new.wednesday = 0
            this.data_update.thursday = 0
            this.data_new.thursday = 0
            this.data_update.friday = 0
            this.data_new.friday = 0
            this.data_update.saturday = 0
            this.data_new.saturday = 0
            this.data_update.sunday = 0
            this.data_new.sunday = 0

            let contador = 0
            this.data.days.forEach(element => {
                switch (element) {
                    case 'Lunes':
                        this.data_update.monday = 1
                        this.data_new.monday = 1
                        contador += 1
                        break;
                    case 'Martes':
                        this.data_update.tuesday = 1
                        this.data_new.tuesday = 1
                        contador += 1
                        break;
                    case 'Miercoles':
                        this.data_update.wednesday = 1
                        this.data_new.wednesday = 1
                        contador += 1
                        break;
                    case 'Jueves':
                        this.data_update.thursday = 1
                        this.data_new.thursday = 1
                        contador += 1
                        break;
                    case 'Viernes':
                        this.data_update.friday = 1
                        this.data_new.friday = 1
                        contador += 1
                        break;
                    case 'Sabado':
                        this.data_update.saturday = 1
                        this.data_new.saturday = 1
                        contador += 1
                        break;
                    case 'Domingo':
                        this.data_update.sunday = 1
                        this.data_new.sunday = 1
                        contador += 1
                        break;
                }
            })
            this.data_update.total_working_days = contador
            this.data_new.total_working_days = contador

            if (this.data.working_days_id) {
                this.data_update.id = this.data.working_days_id
                try {
                    let response = await axios.post('/api/employee/working-days/update', this.data_update)
                    if (response.data.status === "ok") {
                        alert(response.data.message.toUpperCase())
                        this.$router.push('/home')
                    } else {
                        alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                    }
                } catch (error) {
                    alert('NO SE PUDO REGISTRAR, INTENTA DE NUEVO POR FAVOR. REVISA TU CONEXION A INTERNET.')
                }
            } else {
                this.data_new.employee_id = this.data.employee_id
                try {
                    let response = await axios.post('/api/employee/working-days/store', this.data_new)
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
        }
    }
}
</script>