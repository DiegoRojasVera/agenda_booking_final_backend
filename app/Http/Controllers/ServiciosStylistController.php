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
}
