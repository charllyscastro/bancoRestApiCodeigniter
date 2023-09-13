<?php

namespace App\Controllers\API;

use App\Models\ClienteModel;
use CodeIgniter\RESTful\ResourceController;

class Clientes extends ResourceController
{

    public function __construct()
    {   
        // Na classe ResourceController podemos instanciar os models que queremos trabalhar
        $this->model = $this->setModel(new ClienteModel());
    }
    public function index()
    {

        
       $clientes = $this->model->findAll();
        return $this->respond($clientes);
    }
}
