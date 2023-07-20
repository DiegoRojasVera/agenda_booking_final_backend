<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Stylist;


class AppointmentController extends Controller
{
   public function index()
{
    $clients = Client::orderBy('inicio', 'DESC')
        ->with('appointments.stylist', 'appointments.service')
        ->get();

    return response()->json($clients);
}


public function monthlySummary($month = null)
{
    // Obtener el resumen mensual de clientes atendidos
    $monthlySummary = Client::select(
        DB::raw('YEAR(inicio) as year'),
        DB::raw('MONTH(inicio) as month'),
        DB::raw('DAY(inicio) as day'), // Agregamos el día de la cita
        DB::raw('COUNT(id) as clients_count')
    )
    ->when($month, function ($query, $month) {
        return $query->whereMonth('inicio', $month);
    })
    ->groupBy(DB::raw('YEAR(inicio)'), DB::raw('MONTH(inicio)'), DB::raw('DAY(inicio)')) // Agrupamos también por día
    ->orderBy(DB::raw('YEAR(inicio)'), 'ASC')
    ->orderBy(DB::raw('MONTH(inicio)'), 'ASC')
    ->orderBy(DB::raw('DAY(inicio)'), 'ASC') // Ordenamos por día
    ->get();

    return response()->json([
        'monthly_summary' => $monthlySummary,
    ]);
}


public function controlmesservice($month = null, $service = null)
{
    // Obtener el resumen mensual de clientes atendidos
    $monthlySummary = Client::select(
        DB::raw('YEAR(inicio) as year'),
        DB::raw('MONTH(inicio) as month'),
        DB::raw('DAY(inicio) as day'), // Agregamos el día de la cita
        DB::raw('COUNT(id) as clients_count')
    )
    ->when($month, function ($query, $month) {
        return $query->whereMonth('inicio', $month);
    })
    ->when($service, function ($query, $service) {
        return $query->where('service', $service);
    })
    ->groupBy(DB::raw('YEAR(inicio)'), DB::raw('MONTH(inicio)'), DB::raw('DAY(inicio)'), 'service') // Agrupamos también por servicio
    ->orderBy(DB::raw('YEAR(inicio)'), 'ASC')
    ->orderBy(DB::raw('MONTH(inicio)'), 'ASC')
    ->orderBy(DB::raw('DAY(inicio)'), 'ASC') // Ordenamos por día
    ->get();

    return response()->json([
        'Reusmen por servicio' => $monthlySummary,
    ]);
}


	public function controlmesstylist($month = null, $stylist = null)
{
    // Obtener el resumen mensual de clientes atendidos
    $monthlySummary = Client::select(
        DB::raw('YEAR(inicio) as year'),
        DB::raw('MONTH(inicio) as month'),
        DB::raw('DAY(inicio) as day'), // Agregamos el día de la cita
        DB::raw('COUNT(id) as clients_count')
    )
    ->when($month, function ($query, $month) {
        return $query->whereMonth('inicio', $month);
    })
    ->when($stylist, function ($query, $stylist) {
        return $query->where('stylist', $stylist); // Ajustamos el nombre del campo a filtrar
    })
    ->groupBy(DB::raw('YEAR(inicio)'), DB::raw('MONTH(inicio)'), DB::raw('DAY(inicio)')) // Ya no agrupamos por servicio
    ->orderBy(DB::raw('YEAR(inicio)'), 'ASC')
    ->orderBy(DB::raw('MONTH(inicio)'), 'ASC')
    ->orderBy(DB::raw('DAY(inicio)'), 'ASC') // Ordenamos por día
    ->get();

    return response()->json([
        'Resumen por estilista' => $monthlySummary, // Cambiamos el nombre de la respuesta a "Resumen por estilista"
    ]);
}


 public function controlmesstulistlist($month = null)
    {
        // Obtener el resumen mensual de clientes atendidos
        $monthlySummary = Client::select(
            DB::raw('stylistName'),
            DB::raw('COUNT(id) as clients_count')
        )
        ->when($month, function ($query, $month) {
            return $query->whereMonth('inicio', $month);
        })
        ->groupBy('stylistName')
        ->orderBy('stylistName', 'ASC')
        ->get();

        return response()->json([
            'Resumen por estilista' => $monthlySummary,
        ]);
    }


    public function show($id)
    {
        return response([
            'appointment' => Appointment::withCount('dated_at', 'finish_at')->findOrFail($id)
        ], 200);
    }


public function controlmesservicelist($month = null)
{
    // Obtener el resumen mensual de clientes atendidos por cada servicio
    $monthlySummary = Client::leftJoin('services', 'clients.service', '=', 'services.id')
        ->select(
            'services.id',
            'services.name as service_name',
            DB::raw('COUNT(clients.id) as clients_count')
        )
        ->when($month, function ($query, $month) {
            return $query->whereMonth('clients.inicio', $month);
        })
        ->groupBy('services.id', 'services.name')
        ->orderBy('services.name', 'ASC')
        ->get();

    return response()->json([
        'Resumen por servicio' => $monthlySummary,
    ]);
}


public function cantidadmeslist()
{

 // Obtener el resumen mensual de clientes atendidos
    $monthlySummary = Client::select(
        DB::raw('YEAR(inicio) as year'),
        DB::raw('MONTH(inicio) as month'),
        DB::raw('COUNT(id) as clients_count')
    )
    ->groupBy(DB::raw('YEAR(inicio)'), DB::raw('MONTH(inicio)')) // Agrupamos solo por año y mes
    ->orderBy(DB::raw('YEAR(inicio)'), 'ASC')
    ->orderBy(DB::raw('MONTH(inicio)'), 'ASC') // Ordenamos por mes
    ->get();

    return response()->json([
        'monthly_summary' => $monthlySummary,
    ]);


}





}
