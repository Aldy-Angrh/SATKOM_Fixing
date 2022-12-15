<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentProcessDetail extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'document_process_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_document',
        'email_penandatangan',
        'action',
        'lower_left_x',
        'lower_left_y',
        'upper_right_x',
        'upper_right_y',
        'page',
        'sign_date',
        'send_date',
        'status',
        'description',
    ];

    // Dates
    protected $useTimestamps = false;
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

    public static function getStatuses()
    {
        return [
            0 => 'Belum ditandatangani',
            1 => 'Sudah ditandatangani',
            2 => 'Ditolak',
        ];
    }

    public static function getStatus($status)
    {
        $statuses = self::getStatuses();
        return $statuses[$status] ?? 'Tidak diketahui';
    }

    public static function getStatusLabel($status)
    {
        $statuses = self::getStatuses();
        $label = 'default';
        switch ($status) {
            case 0:
                $label = 'warning';
                break;
            case 1:
                $label = 'success';
                break;
            case 2:
                $label = 'danger';
                break;
            default:
                $label = 'default';
                break;
        }
        return '<span class="label label-' . $label . '">' . ($statuses[$status] ?? 'Tidak diketahui') . '</span>';
    }
}
