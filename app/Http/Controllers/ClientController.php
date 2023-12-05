<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Asegúrate de tener esta importación
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Client;
use App\Models\Stylist;
use Carbon\Carbon;
use App\Exports\ClientsExport;


class ClientController extends Controller

{

    public function Prueba()
    {
        echo now();
        return now();
    }
    public function index()
    {
        return response()->json(Client::orderBy('inicio', 'DESC')
            ->get());
    }

	public function indexToday()
	{
   	 $today = Carbon::today()->toDateString();
  	  return response()->json(Client::whereDate('inicio', $today)
        ->orderBy('inicio', 'DESC')
        ->with('appointments.stylist', 'appointments.service')
        ->get());
	}


	public function getDataByDateRange(Request $request)
{
    try {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $data = Client::whereBetween('inicio', [$start_date, $end_date])
            ->orderBy('inicio', 'DESC')
            ->get();

        return response()->json($data);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function exportData(Request $request)
{
    try {
        // Obtener datos según tus criterios
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $clients = Client::whereBetween('inicio', [$startDate, $endDate])->get();

        // Exportar datos a un archivo Excel
        return Excel::download(new ClientsExport($clients), 'clients_data.xlsx');
    } catch (\Exception $e) {
        \Log::error('Error al exportar datos: ' . $e->getMessage());

        return response()->json(['error' => 'Error interno del servidor'], 500);
    }
}




    public function showStylist($stylist)
    {
        return response()
            ->json(Client::where('stylist', $stylist)
                //    ->with('appointments.stylist', 'appointments.service')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }
    // get single client
    public function show($email)
    {
        return response()
            ->json(Client::where('email', $email)
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }

    // get single client para ver servicio cada uno se busca por stylista
    public function showall($idservicio)
    {
        return response()
            ->json(Client::where('service', $idservicio)
                // ->with('appointments.stylist')
                ->orderBy('inicio', 'DESC')
                ->get());
    }

    // get single client para ver servicio cada uno
    public function showallID($id)
    {
        return response()
            ->json(Client::where('id', $id)
                //              ->with('appointments.stylist')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }
    // get single client para ver servicio cada uno
    public function showallIDPRueba($id)
    {
        return response()
            ->json(Client::where('id', $id)
                //              ->with('appointments.stylist')
                ->orderByDesc('inicio', 'DESC')
                ->get());
    }


    //delete post
    public function destroy($id)
    {
        $client = Client::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $client->delete();

        return response([
            'message' => 'Client deleted.'
        ], 200);
    }
}
