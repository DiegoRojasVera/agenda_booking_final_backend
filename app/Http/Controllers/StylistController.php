<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Stylist;

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
    // Validar los datos recibidos del formulario
    $request->validate([
        'name' => 'required|string',
        'photo' => 'nullable|string',
        'phone' => 'required|string',
        'score' => 'required|numeric',
        'working_days' => 'required|array',
    ]);

    // Obtener los datos del formulario
    $data = $request->only([
        'name',
        'photo',
        'phone',
        'score',
        'working_days',
    ]);

    // Crear un nuevo estilista con los datos proporcionados
    $stylist = Stylist::create($data);

    // Retornar una respuesta con el mensaje "Stylist guardado"
    return response()->json(['message' => 'Stylist guardado'], 200);
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
        'score',
        'working_days',
    ]);

    // Actualizar los datos del estilista
    $stylist->update($data);

    // Retornar una respuesta con el mensaje "Stylist actualizado"
    return response()->json(['message' => 'Stylist actualizado'], 200);
}

}
