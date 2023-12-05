<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientsExport implements FromCollection
{
    protected $clients;

    // Constructor para recibir la colección de clientes
    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    // Método para devolver la colección de clientes
    public function collection()
    {
        // Puedes personalizar este método para incluir solo los campos necesarios
        return $this->clients;
    }
}
