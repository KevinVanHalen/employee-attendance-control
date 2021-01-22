<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return response()->json([
            "status" => "ok",
            "message" => "Empleados obtenidos con exito",
            "empleados" => $employees
        ], 200);
    }

    public function store(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $employee = new Employee;
            $employee->last_name_1 = $request->last_name_1;
            $employee->last_name_2 = $request->last_name_2;
            $employee->first_name = $request->first_name;
            $employee->login_key = $request->login_key;
            $employee->status = 1;
            $employee->job_title = $request->job_title;
            $employee->save();
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al crear empleado",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "El empleado fue agrego con exito",
                "employee" => $employee
            ], 200);
        }
    }

    public function update(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $employee = Employee::find($request->id);
            $employee->last_name_1 = $request->last_name_1;
            $employee->last_name_2 = $request->last_name_2;
            $employee->first_name = $request->first_name;
            $employee->login_key = $request->login_key;
            $employee->status = $request->status;
            $employee->job_title = $request->job_title;
            $employee->save();
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al actualizar empleado",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "El empleado fue actualizado con exito",
                "employee" => $employee
            ], 200);
        }
    }
}
