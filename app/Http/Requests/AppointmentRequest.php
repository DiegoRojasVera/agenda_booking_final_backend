<?php

namespace App\Http\Requests;

use App\Models\Stylist;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use NunoMaduro\Collision\Adapters\Phpunit\Style;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $stylist_id = $this->get('stylist_id');
        $dated_at = $this->get('dated_at');

        return [
            'client.name' => ['required', 'string', 'max:50'],
            'client.phone' => ['required', 'string', 'max:20'],
            'client.email' => ['required', 'string', 'max:1000'],
            'dated_at' => ['required', 'date', 'after:' .
                Carbon::now()->addHours(1)->format('Y-m-d H:i:s')], // se va la modificacion para el ahorario
            'stylist_id' => ['required', 'string'],
            'service_id' => [
                'required', 'exists:services,id',
                function ($attribute, $value, $fail) use ($stylist_id, $dated_at) {
                    // Validar que el servicio seleccionado si sea
                    // prestado por el estilista seleccionado.

                    $exists = DB::table('service_stylist')
                        ->where([
                            'service_id' => $value,
                            'stylist_id' => $stylist_id,
                        ])
                        ->exists();

                    if (!$exists) {
                        $fail('El servicio seleccionado no es prestado por el estilista seleccionado.');
                    }

                    // Validar que el estilista esté disponible desde
                    // la fecha dated_at hasta el final de la hora.

                    if ($exists && $dated_at != null) {
                        $start_at = Carbon::createFromFormat('Y-m-d H:i:s', $dated_at);
                        $end_at = Carbon::createFromFormat('Y-m-d H:i:s', $dated_at)->addMinutes(60)->subSeconds(1);

                        $count_appointments = Appointment::query()
                            ->where('stylist_id', $stylist_id)
                            ->where(function ($q) use ($start_at, $end_at) {
                                $q->whereBetween('dated_at', [
                                    $start_at->format('Y-m-d H:i:s'),
                                    $end_at->format('Y-m-d H:i:s'),
                                ])->orWhereBetween('finish_at', [
                                    $start_at->format('Y-m-d H:i:s'),
                                    $end_at->format('Y-m-d H:i:s'),
                                ]);
                            })
                            ->count();

                        if ($count_appointments > 0) {
                            $fail("El estilista seleccionado ya tiene el horario ingresado ($start_at) ocupado.");
                        }
                    }
                },
            ],
        ];
    }
}
