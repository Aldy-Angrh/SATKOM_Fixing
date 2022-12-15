<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentProcess extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'document_process';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'email_file_owner',
        'status',
        'file_id',
        'name_owner',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'description',
        'data',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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


    public static function create($data)
    {
        $model = new DocumentProcess();
        if ($model->insert($data)) {
            return $model->getInsertID();
        } else {
            return false;
        }
    }

    public static function getStatuses()
    {
        return [
            '0' => 'Pending',
            '1' => 'Approved',
            '2' => 'Rejected',
        ];
    }

    public static function getStatus($status)
    {
        $statuses = self::getStatuses();
        return $statuses[$status];
    }

    public static function getStatusLabel($status)
    {
        $statuses = self::getStatuses();
        $label = 'default';
        switch ($status) {
            case '0':
                $label = 'warning';
                break;
            case '1':
                $label = 'success';
                break;
            case '2':
                $label = 'danger';
                break;
            default:
                $label = 'default';
                break;
        }
        return '<span class="label label-' . $label . '">' . ($statuses[$status] ?? 'Tidak Diketahui') . '</span>';
    }
}
