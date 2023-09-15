<?php

namespace App\Controllers\API;

use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class Cuentas extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new CuentaModel());
    }

    public function index()
    {
        $cuentas = $this->model->findAll();

        return $this->respond($cuentas);
    }

    public function create()
    {
        try {
            $cuenta = $this->request->getJSON();

            if ($this->model->insert($cuenta)) {
                $cuenta->id = $this->model->insertID();
                return $this->respondCreated($cuenta);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $th) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    public function edit($id = null)
    {
        try {

            if ($id == null) {
                return $this->failValidationErrors("Não foi passado um ID válido");
            }

            $cuenta = $this->model->find($id);

            if ($cuenta == null) {
                return $this->failNotFound("Não encontramos a cuenta com o ID: $id");
            }

            return $this->respond($cuenta);
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

            $cuentaVerificado = $this->model->find($id);

            if ($cuentaVerificado == null) {
                return $this->failNotFound("Não foi encontrado nenhum cliente com o ID: $id");
            }

            $cuenta = $this->request->getJSON();

            if ($this->model->update($id, $cuenta)) {
                $cuenta->id = $id;
                return $this->respondUpdated($cuenta);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Throwable $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('Não foi passado um ID válido');
            }

            $cuentaVerificado = $this->model->find($id);

            if ($cuentaVerificado == null) {
                return $this->failNotFound("Não foi encontrado nenhuma cuenta com o ID: $id");
            }
            if ($this->model->delete($id)) {
                return $this->respond($cuentaVerificado);
            } else {
                return $this->failServerError('Não foi possivel excluir a cuenta');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor');
        }
    }
}
