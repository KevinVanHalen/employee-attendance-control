<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\NonAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        $array = array();
        foreach($employees as $employee) {
            $object = new \stdClass;
            $object->id = $employee->id;
            $object->name_complete = $employee->first_name . ' ' . $employee->last_name_1 . ' ' . $employee->last_name_2;
            $object->last_name_1 = $employee->last_name_1;
            $object->last_name_2 = $employee->last_name_2;
            $object->first_name = $employee->first_name;
            $object->login_key = $employee->login_key;
            $object->status = $employee->status;
            $object->job_title = $employee->job_title;
            $object->status = $employee->status;
            
            $array_days = array();
            $working_days = $employee->workingDays;
            if ($working_days !== null) {
                $days = "";
                if ($working_days->monday) {
                    $days = $days . 'Lunes';
                    array_push($array_days, 'Lunes');
                }
                if ($working_days->tuesday) {
                    $days = strlen($days) === 0 ? $days . 'Martes' : $days . ', Martes';
                    array_push($array_days, 'Martes');
                }
                if ($working_days->wednesday) {
                    $days = strlen($days) === 0 ? $days . 'Miercoles' : $days . ', Miercoles';
                    array_push($array_days, 'Miercoles');
                }
                if ($working_days->thursday) {
                    $days = strlen($days) === 0 ? $days . 'Jueves' : $days . ', Jueves';
                    array_push($array_days, 'Jueves');
                }
                if ($working_days->friday) {
                    $days = strlen($days) === 0 ? $days . 'Viernes' : $days . ', Viernes';
                    array_push($array_days, 'Viernes');
                }
                if ($working_days->saturday) {
                    $days = strlen($days) === 0 ? $days . 'Sabado' : $days . ', Sabado';
                    array_push($array_days, 'Sabado');
                }
                if ($working_days->sunday) {
                    $days = strlen($days) === 0 ? $days . 'Domingo' : $days . ', Domingo';
                    array_push($array_days, 'Domingo');
                }
                $object->working_days_register = $working_days;
                $object->working_days = $days;
                $object->array_days = $array_days;
                $object->total_working_days = $working_days->total_working_days;
            } else {
                $object->working_days_register = null;
                $object->working_days = "SIN ASIGNAR";
                $object->array_days = [];
                $object->total_working_days = 0;
            }
            

            array_push($array, $object);
        }

        return response()->json([
            "status" => "ok",
            "message" => "Empleados obtenidos con exito",
            "empleados" => $array
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

            $exist = Employee::where('login_key', $request->login_key)->exists();
            if ($exist) {
                return response()->json([
                    "status" => "exist",
                    "message" => "La clave de acceso ya la tiene otro usuario, intenta con otra"
                ], 200);
            }

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

            $exist = Employee::where('login_key', $request->login_key)->exists();
            $register = Employee::where('login_key', $request->login_key)->first();
            if ($exist && $employee->id != $register->id) {
                return response()->json([
                    "status" => "exist",
                    "message" => "La clave de acceso ya la tiene otro usuario, intenta con otra"
                ], 200);
            }

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

    public function getReportByEmployee(Request $request)
    {
        // Guardamos en variables las cosas que necesitaremos para obtener el reporte individual
        // Empleado
        $employee = Employee::find($request->id);
        // Dias de trabajo
        $working_days = $employee->workingDays;
        // Asistencias que tuvo en el rango de fechas
        $attendances_in_date_range = Attendance::where('employee_id', $request->id)
                                                ->whereDate('date', '>=', $request->start_date)
                                                ->whereDate('date', '<=', $request->end_date)
                                                ->get();
        // Inasistencias que tuvo en el rango de fechas
        $non_attendances_in_date_range = NonAttendance::where('employee_id', $request->id)
                                                    ->whereDate('date', '>=', $request->start_date)
                                                    ->whereDate('date', '<=', $request->end_date)
                                                    ->get();
        
        $days_must_work = 0;
        $days_must_not_work = 0;
        $days_real_work = 0;
        $days_real_not_work = 0;

        // Obtenemos un array con todas las fechas entre el rango de fechas
        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        
        $array_days_must_work_in_range = array();

        // Recorremos el array con todas las fechas del rango y verificamos si corresponde
        // a un dia entre semana que debio trabajar comparando el nombre del dia de la semana
        // Si un dia coincide en que si debio trabajar se suma el contador y esa fecha la
        // pasamos a un arreglo para ocuparla despues
        foreach ($period as $date) {
            $day_of_week_period = $date->dayOfWeek;
            
            switch ($day_of_week_period) {
                case 0:
                    // Sunday
                    if ($working_days->sunday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 1:
                    // Monday
                    if ($working_days->monday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 2:
                    // Tuesday
                    if ($working_days->tuesday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 3:
                    // Wednesday
                    if ($working_days->wednesday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 4:
                    // Thursday
                    if ($working_days->thursday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 5:
                    // Friday
                    if ($working_days->friday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
                case 6:
                    // Saturday
                    if ($working_days->saturday) {
                        $days_must_work++;
                        array_push($array_days_must_work_in_range, $date->toDateString());
                    } else {
                        $days_must_not_work++;
                    }
                    break;
            }
        }

        // Numero de dias que debio trabajar
        // $num_days_must_work = count($array_days_must_work_in_range);
        // Numero real de dias que trabajo
        $num_days_real_work = count($attendances_in_date_range);
        $days_non_attendance = count($non_attendances_in_date_range);

        $num_days_justified = 0;
        $num_days_not_justified = 0;
        foreach($non_attendances_in_date_range as $date) {
            if ($date->justified) {
                $num_days_justified++;
            } else {
                $num_days_not_justified++;
            }
        }

        $days_not_work_and_not_non_attendance = $days_must_work - $num_days_real_work - $days_non_attendance;

        $array_front_end = array();
        $object = new \stdClass;
        $object->empleado = $employee->first_name . ' ' . $employee->last_name_1 . ' ' . $employee->last_name_2;
        $object->asistencias_teoricas = $days_must_work;
        $object->asistencias_reales = $num_days_real_work;
        $object->inasistencias = $days_non_attendance;
        $object->justificadas = $num_days_justified;
        $object->no_justificadas = $num_days_not_justified;
        $object->dias_perdidos = $days_not_work_and_not_non_attendance;
        array_push($array_front_end, $object);

        return response()->json([
            "status" => "ok",
            "message" => "Datos obtenidos con exito",
            "empleado" => $employee->first_name . ' ' . $employee->last_name_1 . ' ' . $employee->last_name_2,
            "fechas en las que debio trabajar" => $array_days_must_work_in_range,
            "asitencias_teoricas" => $days_must_work,
            "asistencias_reales" => $num_days_real_work,
            "inasistencias" => $days_non_attendance,
            "justificados" => $num_days_justified,
            "no_justificados" => $num_days_not_justified,
            "dias_perdidos" => $days_not_work_and_not_non_attendance,
            "data" => $array_front_end
        ], 200);
    }
}
