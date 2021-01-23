import Login from './components/login/Login.vue'
import Home from './components/Home.vue'

import MainAttendance from './components/attendances/MainAttendance.vue'
import CheckInOut from './components/attendances/CheckInOut.vue'
import DeleteAttendance from './components/attendances/DeleteAttendance.vue'

import MainNonAttendance from './components/non_attendances/MainNonAttendance.vue'
import NonAttendanceStore from './components/non_attendances/NonAttendanceStore.vue'
import DeleteNonAttendance from './components/non_attendances/DeleteNonAttendances.vue'

import MainEmployees from './components/employees/MainEmployees.vue'
import EmployeeStore from './components/employees/EmployeeStore.vue'
import ShowEmployees from './components/employees/ShowEmployees.vue'
import EmployeeUpdate from './components/employees/EmployeeUpdate.vue'
import VerWorkingDays from './components/employees/VerWorkingDays.vue'
import UpdateWorkingDays from './components/employees/UpdateWorkingDays.vue'

import MainAttendanceReport from './components/attendance_reports/MainAttendanceReport.vue'
import ReportEmployee from './components/attendance_reports/ReportEmployee.vue'

export const routes = [
    {
        path: '/',
        component: Login,
    },
    {
        path: '/home',
        component: Home
    },
    {
        path: '/main-attendance',
        component: MainAttendance
    },
    {
        path: '/check-in-out',
        component: CheckInOut
    },
    {
        path: '/delete-attendance',
        component: DeleteAttendance
    },



    {
        path: '/main-non-attendance',
        component: MainNonAttendance
    },
    {
        path: '/non-attendance/store',
        component: NonAttendanceStore
    },
    {
        path: '/delete-non-attendance',
        component: DeleteNonAttendance
    },



    {
        path: '/main-employees',
        component: MainEmployees
    },
    {
        path: '/employee/store',
        component: EmployeeStore
    },
    {
        path: '/employee/show-all',
        component: ShowEmployees
    },
    {
        path: '/employee/update',
        component: EmployeeUpdate
    },
    {
        path: '/employees/ver-working-days',
        component: VerWorkingDays
    },
    {
        path: '/employee/update-working-days',
        component: UpdateWorkingDays
    },


    {
        path: '/main-reports',
        component: MainAttendanceReport
    },
    {
        path: '/report/employee',
        component: ReportEmployee
    }
]