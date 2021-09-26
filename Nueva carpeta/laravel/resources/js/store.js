import axios from "axios"

export default {
    state: {
        user: null,
        auth: false,
        employees: [],
        attendances: [],
        non_attendances: [],
        employee_selected: null,
        employee_report: [],
    },
    getters: {
        getUser(state) {
            return state.user
        },
        getAuth(state) {
            return state.auth
        },
        getEmployees(state) {
            return state.employees
        },
        getAttendances(state) {
            return state.attendances
        },
        getNonAttendances(state) {
            return state.non_attendances
        },
        getEmployeeSelected(state) {
            return state.employee_selected
        },
        getEmployeeReport(state) {
            return state.employee_report
        }
    },
    mutations: {
        SET_USER(state, user) {
            state.user = user
            state.auth = Boolean(user)
        },
        // setUser(state, payload) {
        //     state.user = payload
        // },
        setEmployees(state, payload) {
            state.employees = payload
        },
        setAttendances(state, payload) {
            state.attendances = payload
        },
        setNonAttendances(state, payload) {
            state.non_attendances = payload
        },
        setEmployeeSelected(state, payload) {
            state.employee_selected = payload
        },
        setEmployeeReport(state, payload) {
            state.employee_report = payload
        }
    },
    actions: {
        async login({ dispatch }, credentials) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                let response = await axios.post('/api/login', credentials)
                console.log("desde store",response)
                return dispatch('getUser')
            } catch (error) {
                console.log("errr", error)
            }
        },
        async logout({ dispatch }) {
            await axios.post('/api/logout')
            return dispatch('getUser')
        },
        getUser ({ commit }) {
            axios.get('/api/user').then(response => {
                commit('SET_USER', response.data)
            }).catch(() => {
                commit('SET_USER', null)
            })
        }
    }
}