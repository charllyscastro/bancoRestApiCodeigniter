<?php

namespace App\Controllers\API;

use App\Models\ClienteModel;
use App\Models\CuentaModel;
use App\Models\TransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class Transacciones extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new TransaccionModel());
    }
    public function index()
    {
        $transacciones = $this->model->findAll();
        return $this->respond($transacciones);
    }

    public function create()
    {
        try {
            $transaccion = $this->request->getJSON();

            if ($this->model->insert($transaccion)) {
                $transaccion->id = $this->model->insertID();

                $transaccion->resultado = $this->actualizarFondoCuenta($transaccion->tipo_transaccion_id, $transaccion->monto, $transaccion->cuenta_id);
                return $this->respondCreated($transaccion);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor.');
        }
    }

    public function getTransaccionesByCliente($id = null)
    {

        try {
            $modelCliente = new ClienteModel();

            if ($id == null) {
                return $this->failValidationErrors('Não foi passado nenhum id válido');
            }

            $cliente = $modelCliente->find($id);

            if ($cliente == null) {
                return $this->failNotFound("Não foi encontrado um cliente com o id: {$id}");
            }

            $transacciones = $this->model->TransaccionesPorCliente($id);

            return $this->respond($transacciones);
        } catch (\Throwable $th) {
            return $this->failServerError('Ocorreu um erro no servidor.');
        }
    }


    private function actualizarFondoCuenta($tipoTransaccioId, $monto, $cuentaId)
    {
        $modelCuenta = new CuentaModel();

        $cuenta = $modelCuenta->find($cuentaId);

        switch ($tipoTransaccioId) {
            case 1:
                $cuenta["fondo"] += $monto;
                break;
            case 2:
                $cuenta["fondo"] -= $monto;
                break;
        }

        if ($modelCuenta->update($cuentaId, $cuenta)) {
            return array('TransaccionExitosa' => true, 'NuevaFondo' => $cuenta['fondo']);
        } else {
            return array('TransaccionExitosa' => false, 'NuevaFondo' => $cuenta['fondo']);
        }
    }
}
