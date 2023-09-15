<?php

namespace App\Controllers\API;

use App\Models\TiposTransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class TiposTransaccion extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new TiposTransaccionModel());
    }
    public function index()
    {
        $tipoTransaccion = $this->model->findAll();

        return $this->respond($tipoTransaccion);
    }

    public function create()
    {
        try {
            $tipoTransaccion = $this->request->getJSON();

            if ($this->model->insert($tipoTransaccion)) {
                $tipoTransaccion->id = $this->model->insertID();
                return $this->respondCreated($tipoTransaccion);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }
}
