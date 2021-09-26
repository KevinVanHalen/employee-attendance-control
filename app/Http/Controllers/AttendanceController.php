<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all()->reverse();

        $array = array();
        foreach($attendances as $attendance) {
            $object = new \stdClass;
            $object->id = $attendance->id;
            $object->date = $attendance->date;
            $object->entrance_hour = $attendance->entrance_hour;
            $object->exit_hour = $attendance->exit_hour;
            $object->employee = $attendance->employee->first_name . ' ' . $attendance->employee->last_name_1 . ' ' . $attendance->employee->last_name_2;
            array_push($array, $object);
        }

        return response()->json([
            "status" => "ok",
            "message" => "Registros obtenidos con exito",
            "asistencias" => $array
        ], 200);
    }

    public function checkInOut(Request $request)
    {
        $exito = true;
        $check_in = true;

        DB::beginTransaction();
        
        try {
            $today = Carbon::now();
            // $exist = Employee::where('login_key', $request->login_key)->exists();
            $name = $request->first_name;
            $exist = Employee::where('first_name', $name)->exists();

            // SI no existe el empleado
            if (!$exist) {
                return response()->json([
                    "status" => "no-content",
                    "message" => "Usuario no encontrado"
                ], 200);
            }
            // $employee = Employee::where('login_key', $request->login_key)->first();
            $employee = Employee::where('first_name', $name)->first();
            $last_check = $employee->attendances->last();

            // Verificar que haya un ultimo registro, si no lo hay es porque es el primer registro de asistencia del empleado en la historia
            if ($last_check) {
                
                $difference_last_check = $today->diffInMinutes($last_check->updated_at);

                // En caso de que realizar un check in/out recientemente
                if ($difference_last_check < 1) {
                    return response()->json([
                        "status" => "recent",
                        "message" => "Hola " . $employee->first_name . " " . $employee->last_name_1 . ". Advertencia, acabas de realizar un registro recientemente"
                    ], 200);
                }

                // Verificar que en el ultimo registro se haya echo check in y check out
                if ($last_check->check_in && $last_check->check_out) {
                    // Si es correcto, generara un nuevo registro (nuevo dia de trabajo)
                    $attendance = new Attendance;
                    $attendance->employee_id = $employee->id;
                    $attendance->date = $today->toDateString();
                    $attendance->entrance_hour = $today->toTimeString();
                    $attendance->check_in = 1;
                    $attendance->check_out = 0;
                    $attendance->save();
                } else {
                    // Como aun no se hizo el check out del ultimo registro encontrado hay 2 opciones
                    if ($today->toDateString() === $last_check->date) {
                        // Si es el mismo dia aun, se hace un check out en el registro encontrado
                        $last_check->exit_hour = $today->toTimeString();
                        $last_check->check_out = 1;

                        // Guardamos la diferencia que hubo en minutos de la hora de entrada y la salida
                        $last_check_date = new Carbon($last_check->date . $last_check->entrance_hour);
                        $difference = $today->diffInMinutes($last_check_date);
                        $last_check->total_minutes_worked = $difference;
                        
                        $last_check->correct_check = 1;
                        $last_check->save();
                        $check_in = false;
                    } else {
                        // Si ya es un dia diferente se debe poner una hora de salida (check out) del ultimo dia y generar un nuevo registro actual (check in)
                        if ($last_check->entrance_hour > '14:00:00') {
                            // Si la hora de entrada del ultimo registro es despues de las 2, la salida se pondra a las 22 horas de forma automatica
                            // Obtenemos la diferencia en minutos para guardarlar
                            $last_check_date = new Carbon($last_check->date . $last_check->entrance_hour);
                            $last_check_date_pivot = new Carbon($last_check->date . '22:00:00');
                            $difference = $last_check_date_pivot->diffInMinutes($last_check_date);
                            
                            $last_check->exit_hour = '22:00:00';
                            $last_check->check_out = 1;
                            $last_check->total_minutes_worked = $difference;
                            $last_check->correct_check = 0;
                            $last_check->save();

                            // Se crea el check in del dia actual
                            $attendance = new Attendance;
                            $attendance->employee_id = $employee->id;
                            $attendance->date = $today->toDateString();
                            $attendance->entrance_hour = $today->toTimeString();
                            $attendance->check_in = 1;
                            $attendance->check_out = 0;
                            $attendance->save();
                        } else {
                            // Si la hora de entrada del ultimo registro no fue despues de las 2, significa que entro en la mañana, la salida se pondra a las 15 horas de forma automatica
                            // Obtenemos la diferencia en minutos para guardarlar
                            $last_check_date = new Carbon($last_check->date . $last_check->entrance_hour);
                            $last_check_date_pivot = new Carbon($last_check->date . '15:00:00');
                            $difference = $last_check_date_pivot->diffInMinutes($last_check_date);
                            
                            $last_check->exit_hour = '15:00:00';
                            $last_check->check_out = 1;
                            $last_check->total_minutes_worked = $difference;
                            $last_check->correct_check = 0;
                            $last_check->save();

                            // Se crea el check in del dia actual
                            $attendance = new Attendance;
                            $attendance->employee_id = $employee->id;
                            $attendance->date = $today->toDateString();
                            $attendance->entrance_hour = $today->toTimeString();
                            $attendance->check_in = 1;
                            $attendance->check_out = 0;
                            $attendance->save();
                        }
                    }
                }
            } else {
                // Creando el primer registro de asistencia del empleado
                $attendance = new Attendance;
                $attendance->employee_id = $employee->id;
                $attendance->date = $today->toDateString();
                $attendance->entrance_hour = $today->toTimeString();
                $attendance->check_in = 1;
                $attendance->check_out = 0;
                $attendance->save();
            }
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al realizar registros. Verifique su conexión a internet e intente de nuevo por favor.",
                "error" => $th
            ], 200);
        }

        if ($exito) {
            if ($check_in) {
                return response()->json([
                    "status" => "ok",
                    "message" => "Hola " . $employee->first_name . " " . $employee->last_name_1 . ". Check in realizado correctamente",
                    "check_in" => $attendance,
                    "employee" => $employee
                ], 200);
            } else {
                return response()->json([
                    "status" => "ok",
                    "message" => "Hola " . $employee->first_name . " " . $employee->last_name_1 . ". Check out realizado correctamente",
                    "check_out" => $last_check,
                    "employee" => $employee
                ], 200);
            }
        }
    }

    public function updateCheckInOut(Request $request)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $attendance_register = Attendance::find($request->id);
            $attendance_register->date = $request->date;
            $attendance_register->entrance_hour = $request->entrance_hour;
            $attendance_register->exit_hour = $request->exit_hour;
            $attendance_register->check_in = $request->check_in;
            $attendance_register->check_out = $request->check_out;
            $attendance_register->total_minutes_worked = $request->total_minutes_worked;
            $attendance_register->correct_check = $request->correct_check;
            $attendance_register->save();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al actualizar modificar registro de asistencia",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro de asistencia modificado con exito",
            ], 200);
        }
    }

    public function getAttendancesEmployee($id)
    {
        $employee = Employee::find($id);
        $attendances = $employee->attendances;
        
        return response()->json([
            "status" => "ok",
            "message" => "Registro de asistencias del empleado",
            "attendace_registers" => $attendances
        ], 200);
    }

    public function delete($id)
    {
        $exito = false;

        DB::beginTransaction();

        try {
            $attendance_register = Attendance::find($id);
            $attendance_register->delete();

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Error al eliminar registro de|     asistencia",
                "error" => $th
            ], 500);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro de asistencia eliminado con exito",
            ], 200);
        }
    }
}
