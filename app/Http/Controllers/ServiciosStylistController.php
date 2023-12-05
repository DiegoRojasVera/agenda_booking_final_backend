<?php

namespace App\Http\Controllers;

use App\Models\Service_stylist;
use Illuminate\Http\Request;

class ServiciosStylistController extends Controller
{
    public function index()
    {
        $service_stylist = Service_stylist::all();
        return response()->json($service_stylist);
    }

    public function register(Request $request)
    {
        // Validate fields
        $attrs = $request->validate([
            'service_id' => 'required|string',
            'stylist_id' => 'required|string',
        ]);

        // Check if a record with the same stylist and service already exists
        $existingRecord = Service_stylist::where('service_id', $attrs['service_id'])
            ->where('stylist_id', $attrs['stylist_id'])
            ->first();

        if ($existingRecord) {
            return response([
                'message' => 'This stylist already has this service assigned.',
            ], 400);
        }

        try {
            // If no existing record, create a new one
            $servicestylist = Service_stylist::create([
                'service_id' => $attrs['service_id'],
                'stylist_id' => $attrs['stylist_id'],
            ]);

            return response([
                'message' => 'servicestylist created.',
                'Stylist' => $servicestylist,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error while creating servicestylist: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json(Service_stylist::find($id));
    }

    public function showServicesStylist($stylist_id)
    {
        $services = Service_stylist::where('stylist_id', $stylist_id)->get();

        if ($services->isEmpty()) {
            return response()->json(['message' => 'No services found for the given stylist.'], 404);
        }

        return response()->json($services);
    }

    public function destroy($id)
    {
        $stylist = Service_stylist::find($id);
        $stylist->delete();

        return response([
            'message' => 'stylist deleted.'
        ], 200);
    }

// aca  empiezan los  cambios:

public function getStylistsForServiceAndDay($serviceId, $day)
{
    // Obtener el listado de service_stylist para el servicio dado
    $serviceStylists = Service_stylist::with('stylist', 'service')
        ->where('service_id', $serviceId)
        ->get();

    // Recopilar los datos necesarios de los estilistas que trabajan en el día especificado
    $stylistsData = [];

    // Obtener el nombre y precio del servicio
    $service = $serviceStylists->first() ? $serviceStylists->first()->service : null;
    $serviceName = $service ? $service->name : null;
    $servicePrice = $service ? $service->price : null;

    foreach ($serviceStylists as $serviceStylist) {
        $stylist = $serviceStylist->stylist;

        // Verificar si el estilista existe y trabaja en el día especificado
        if ($stylist && $this->stylistWorksOnDay($stylist, $day)) {
            $stylistData = [
                'id' => $stylist->id,
                'name' => $stylist->name,
                'photo' => $stylist->photo,
                'service_name' => $serviceName,
                'service_price' => $servicePrice,
                'working_days' => $stylist->working_days,
                // ... y así sucesivamente
            ];

            $stylistsData[] = $stylistData;
        }
    }

    // Devolver la información en formato JSON
    return response()->json(['stylists' => $stylistsData]);
}

// Función para verificar si el estilista trabaja en el día especificado
private function stylistWorksOnDay($stylist, $day)
{
    // Iterar sobre los días trabajados del estilista
    foreach ($stylist->working_days as $workingDay) {
        // Verificar si el día proporcionado está presente en los datos del estilista
        if (isset($workingDay[$day])) {
            return true;
        }
    }

    // Si no se encuentra el día en los datos del estilista, devolver falso
    return false;
}


}
