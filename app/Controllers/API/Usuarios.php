<?php

namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    public function __construct()
    {
        $this->model = new UsuarioModel();
    }

    public function index()
    {
        $usuarios = $this->model->findAll();
        return $this->respond($usuarios);
    }

    public function create()
    {
        try {
            $usuario = $this->request->getJSON();
            $usuario->password = hashPassword($usuario->password);

            if ($this->model->insert($usuario)) {
                $usuario->id = $this->model->insertID();
                return $this->respondCreated($usuario);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }
}
