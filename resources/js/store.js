export default {
    state: {
        user: null,
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
        setUser(state, payload) {
            state.user = payload
        },
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
    }
}