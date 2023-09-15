<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaccionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaccion';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cuenta_id',
        'tipo_transaccion_id',
        'monto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'cuenta_id'           => 'required|integer',
        'tipo_transaccion_id' => 'required|integer',
        'monto'               => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function TransaccionesPorCliente($clienteId = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('cuenta.id AS NumeroCuenta, cliente.nombre, cliente.apellido');
        $builder->select('tipo_transaccion.descripcion AS Tipo, transaccion.monto');
        $builder->join('cuenta', 'transaccion.cuenta_id = cuenta.id');
        $builder->join('tipo_transaccion', 'transaccion.tipo_transaccion_id = tipo_transaccion.id');
        $builder->join('cliente', 'cuenta.cliente_id = cliente.id');
        $builder->where('cliente.id', $clienteId);

        $query = $builder->get();
        return $query->getResult();
    }
}
