<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\NonAttendance;
use Illuminate\Support\Facades\DB;

class NonAttendanceController extends Controller
{
    public function getNonAttendacesEmployee($id)
    {
        $employee = Employee::find($id);
        $non_attendances = $employee->nonAttendances;

        return response()->json([
            "status" => "ok",
            "message" >= "Registro de inasistencias del empleado",
            "non_attendance_registers" => $non_attendances
        ], 200);
    }

    public function store(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $non_attendance = new NonAttendance;
            $non_attendance->date = $request->date;
            $non_attendance->justified = $request->justified;
            $non_attendance->reason = $request->reason;
            $non_attendance->employee_id = $request->employee_id;
            $non_attendance->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al crear registro de inasistencia",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro de inasistencia creado con exito",
                "employee" => $non_attendance
            ], 200);
        }
    }

    public function updateNonAttendance(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $non_attendance_register = NonAttendance::find($request->id);
            $non_attendance_register->date = $request->date;
            $non_attendance_register->justified = $request->justified;
            $non_attendance_register->reason = $request->reason;
            $non_attendance_register->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al actualizar modificar registro de inasistencia",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro de inasistencia modificado con exito",
            ], 200);
        }
    }

    public function delete($id)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $non_attendance_register = NonAttendance::find($id);
            $non_attendance_register->delete();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al eliminar registro de inasistencia",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro de inasistencia eliminado con exito",
            ], 200);
        }
    }
}
