<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Stylist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;  // Asegúrate de importar la fachada Log



class StylistController extends Controller
{
    public function index()
    {
        return response()->json(Stylist::orderBy('id', 'ASC')
            //  ->with('appointments.stylist', 'appointments.service')
            ->get());
    }


public function register(Request $request)
{
    try {
        // Validar los datos recibidos del formulario
        $request->validate([
            'name' => 'required|string',
            'photo' => 'nullable|string',
            'phone' => 'required|string',
            'sucursal' => 'required|string',
            'score' => 'required|numeric',
            'working_days' => 'required|array',
        ]);

        // Obtener los datos del formulario
        $data = $request->only([
            'name',
            'photo',
            'phone',
            'sucursal',
            'score',
            'working_days',
        ]);

        // Procesar los datos de working_days antes de almacenarlos
        $workingDays = [];
        foreach ($data['working_days'] as $dayInfo) {
            // Verificar si la información del día contiene las claves necesarias
            if (isset($dayInfo['day']) && isset($dayInfo['time'])) {
                // Crear un nuevo array con el formato deseado
                $workingDays[] = [
                    'day' => $dayInfo['day'],
                    'time' => $dayInfo['time'],
                ];
            }
        }

        // Reemplazar el campo working_days con el nuevo formato
        $data['working_days'] = $workingDays;

        // Crear un nuevo estilista con los datos proporcionados
        $stylist = Stylist::create($data);

        // Retornar una respuesta con el mensaje "Stylist guardado"
        return response()->json(['message' => 'Stylist guardado'], 200);
    } catch (\Exception $e) {
        // Log de la excepción
        Log::error('Error al guardar el estilista: ' . $e->getMessage());

        // Retornar una respuesta con el mensaje de error
        return response()->json(['error' => 'Error al guardar el estilista'], 500);
    }
}


// listar por sucursal

public function indexBySucursal($sucursal)
{
    return response()->json(Stylist::where('sucursal', $sucursal)
        ->orderBy('id', 'ASC')
        ->get());
}



    // get single
    public function show($id)
    {
        return response()
            ->json(Stylist::where('id', $id)
                //     ->with('appointments.stylist', 'appointments.service')
                //->orderByDesc('email', 'DESC')
                ->get());
    }

	// Buscar
	public function searchById(Request $request)
{
    $id = $request->input('id');
	
    $stylist = Stylist::find($id);

    if (!$stylist) {
        return response()->json(['message' => 'Stylist no encontrado'], 404);
    }

    return response()->json($stylist);
}



    //delete post
    public function destroy($id)
    {
        $stylist = Stylist::find($id);


        // $client->comments()->delete();
        // $client->likes()->delete();
        $stylist->delete();

        return response([
            'message' => 'stylist deleted.'
        ], 200);
    }


	public function update(Request $request, $id)
{
    // Validar los datos recibidos del formulario
    $request->validate([
        'name' => 'string',
        'photo' => 'nullable|string',
        'phone' => 'string',
        'score' => 'numeric',
	'sucursal'=> 'string',
        'working_days' => 'array',
    ]);

    // Obtener el estilista por su ID
    $stylist = Stylist::find($id);

    if (!$stylist) {
        return response()->json(['message' => 'Stylist no encontrado'], 404);
    }

    // Obtener los datos actualizados del formulario
    $data = $request->only([
        'name',
        'photo',
        'phone',
	'sucursal',
        'score',
        'working_days',
    ]);

    // Actualizar los datos del estilista
    $stylist->update($data);

    // Retornar una respuesta con el mensaje "Stylist actualizado"
    return response()->json(['message' => 'Stylist actualizado'], 200);

}

// aca es donde estamos en la actualizar






  public function getScheduleForDay($id, $day)
    {
        try {
            // Obtener el estilista por su ID
            $stylist = Stylist::findOrFail($id);

            // Filtrar los datos en working_days por el día proporcionado en la URL
            $filteredSchedule = collect($stylist->working_days ?? [])->filter(function ($item) use ($day) {
                return stristr($item['day'], $day) !== false;
            });

            // Log de información para verificar los datos
            Log::info('Requested Stylist:', $stylist->toArray());
            Log::info('Filtered Schedule:', $filteredSchedule->toArray());

            // Retornar los datos filtrados
            return response()->json([
                'name' => $stylist->name,
                'working_days' => $filteredSchedule->toArray(),
            ], 200);
        } catch (\Exception $e) {
            // Log de la excepción
            Log::error('Error al obtener el horario del estilista: ' . $e->getMessage());

            // Retornar una respuesta con el mensaje de error
            return response()->json(['error' => 'Error al obtener el horario del estilista'], 500);
        }
    }






}
