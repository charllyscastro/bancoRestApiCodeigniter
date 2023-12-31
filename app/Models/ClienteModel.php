<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'cliente';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'apellido',
        'telefono',
        'correo'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nombre'   => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido' => 'required|alpha_space|min_length[3]|max_length[75]',
        'telefono' => 'required|exact_length[13]',
        'correo'   => 'permit_empty|valid_email|max_length[85]',
    ];
    protected $validationMessages   = [
        'correo'    => [
            'valid_email' => 'E-mail não é válido'
        ]
    ];
    protected $skipValidation       = false; // Não pode escapar nenhuma validação, tem que seguir a regra
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
}
