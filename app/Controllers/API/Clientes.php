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

    public function create()
    {
        try {

            $cliente = $this->request->getJSON();

            if ($this->model->insert($cliente)) {
                $cliente->id = $this->model->insertID();
                return $this->respondCreated($cliente);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    public function edit($id = null)
    {
        try {

            if ($id == null) {
                return $this->failValidationErrors("Não foi passado um ID válido");
            }

            $cliente = $this->model->find($id);

            if ($cliente == null) {
                return $this->failNotFound("Não foi encontrado nenhum cliente com o ID: $id");
            }

            return $this->respond($cliente);
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    public function update($id = null)
    {
        try {

            if ($id == null) {
                return $this->failValidationErrors("Não foi passado um ID válido");
            }

            $clienteVerificado = $this->model->find($id);

            if ($clienteVerificado == null) {
                return $this->failNotFound("Não foi encontrado nenhum cliente com o ID: $id");
            }

            $cliente = $this->request->getJSON();

            if ($this->model->update($id, $cliente)) {
                $cliente->id = $id;
                return $this->respondUpdated($cliente);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    public function delete($id = null)
    {
        try {

            if ($id == null) {
                return $this->failValidationErrors("Não foi passado um ID válido");
            }

            $clienteVerificado = $this->model->find($id);

            if ($clienteVerificado == null) {
                return $this->failNotFound("Não foi encontrado nenhum cliente com o ID: $id");
            }

            if ($this->model->delete($id)) {

                return $this->respondDeleted($clienteVerificado);
            } else {
                return $this->failServerError('Não foi possivel deletar o registro');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }
}
