<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\WorkingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkingDayController extends Controller
{
    public function store(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $working_days = new WorkingDay;
            $working_days->monday = $request->monday;
            $working_days->tuesday = $request->tuesday;
            $working_days->wednesday = $request->wednesday;
            $working_days->thursday = $request->thursday;
            $working_days->friday = $request->friday;
            $working_days->saturday = $request->saturday;
            $working_days->sunday = $request->sunday;
            $working_days->total_working_days = $request->total_working_days;
            $working_days->employee_id = $request->employee_id;
            $working_days->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al crear dias de trabajo del empleado",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Los dias de trabajo del empleado se agregaron con exito",
                "employee" => $working_days
            ], 200);
        }
    }

    public function getEmployeeWorkingDays($id)
    {
        try {
            $employee = Employee::find($id);
            $working_days = $employee->workingDays;
            return response()->json([
                "status" => "ok",
                "message" => "Los datos se obtuvieron con exito",
                "working_days" => $working_days
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Error al obtener los datos",
                "error" => $th
            ], 500);
        }
    }

    public function updateEmployeeWorkingDays(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $employee_working_days = WorkingDay::find($request->id);
            $employee_working_days->monday = $request->monday;
            $employee_working_days->tuesday = $request->tuesday;
            $employee_working_days->wednesday = $request->wednesday;
            $employee_working_days->thursday = $request->thursday;
            $employee_working_days->friday = $request->friday;
            $employee_working_days->saturday = $request->saturday;
            $employee_working_days->sunday = $request->sunday;
            $employee_working_days->total_working_days = $request->total_working_days;
            $employee_working_days->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al actualizar los dias de trabajo del empleado",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Los dias de trabajo del empleado se actualizaron con exito",
                "working_days" => $employee_working_days
            ], 200);
        }
    }
}
