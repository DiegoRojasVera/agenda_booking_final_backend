<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puntuacion;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Service;


class PuntuacionController extends Controller
{
    public function store(Request $request)
    {
        $puntuacion = new Puntuacion();

        $puntuacion->calificacion = $request->calificacion;
        $puntuacion->stylist = $request->stylist;
        $puntuacion->comentario = $request->comentario;
        $puntuacion->nombre = $request->nombre;
        $puntuacion->photo = $request->photo;


        $puntuacion->save();

        return response()->json([
            'message' => 'Puntuación guardada correctamente'
        ]);
    }

    public function promedioPorStylist($stylist)
    {
        $promedio = DB::table('ratingbar')
            ->where('stylist', $stylist)
            ->avg('calificacion');

        return response()->json([
            'promedio' => $promedio
        ]);
    }

    public function index()
    {
        $puntuaciones = Puntuacion::all();

        return response()->json($puntuaciones);
    }

    public function listarPorStylist($stylist)
    {
        $puntuaciones = Puntuacion::where('stylist', $stylist)->get();
        return response()->json($puntuaciones);
    }
    //vamos a listar y saber si fue atenda por el stylis

    public function showStylistsAndServices($email)
    {
        $stylistsAndServices = Client::select('stylist', 'service', 'stylistName', 'email')
            ->where('email', $email)
            ->groupBy('stylist', 'service', 'stylistName', 'email')
            ->get();

        return response()->json($stylistsAndServices);
    }

    //saber el nombre del stylist que nos da con la id



public function getServiceName($id)
{
    try {
        // Busca el servicio por ID
        $service = Service::findOrFail($id);

        // Obtiene el nombre del servicio
        $serviceName = $service->name;

        // Regresa una respuesta JSON con el nombre del servicio
        return response()->json(['name' => $serviceName]);
    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error en getServiceName: ' . $e->getMessage());

        // Manejar el error y devolver una respuesta adecuada
        return response()->json(['error' => 'Error al obtener el nombre del servicio'], 500);
    }
}



}
