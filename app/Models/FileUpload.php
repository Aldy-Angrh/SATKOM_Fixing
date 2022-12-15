<?php

namespace App\Models;

use CodeIgniter\Model;

class FileUpload extends Model
{
    const STATUS_PENDING = '0';
    const STATUS_SIGNED = '1';
    const STATUS_FAILED = '2';

    protected $DBGroup          = 'default';
    protected $table            = 'file_upload';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['file_name', 'status', 'deskrpsi', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'file_name' => 'required',
        'status' => 'required',
        'deskrpsi' => 'required',
    ];

    protected $validationMessages   = [
        'file_name' => [
            'required' => 'Nama file harus diisi',
        ],
        'status' => [
            'required' => 'Status harus diisi',
        ],
        'deskrpsi' => [
            'required' => 'Deskripsi harus diisi',
        ],
    ];
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


    public function createFileAndProcess($file, $process)
    {
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Diproses',
            self::STATUS_SIGNED => 'Sukses',
            self::STATUS_FAILED => 'Gagal',
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

        switch ($status) {
            case self::STATUS_PENDING:
                $class = 'warning';
                break;
            case self::STATUS_SIGNED:
                $class = 'success';
                break;
            case self::STATUS_FAILED:
                $class = 'danger';
                break;
            default:
                $class = 'secondary';
                break;
        }

        return '<span class="label label-' . $class . '">' . $statuses[$status] . '</span>';
    }

    public static function getJumlahGagal($id)
    {
        $model  = new DocumentProcess();
        return $model->where('file_id', $id)->where('status', self::STATUS_FAILED)->countAllResults();
    }

    public static function getJumlahSukses($id)
    {
        $model  = new DocumentProcess();
        return $model->where('file_id', $id)->where('status', self::STATUS_SIGNED)->countAllResults();
    }


    public static function getFileCount()
    {
        $model = new FileUpload();
        return $model;
    }


    public static function getFileFailedCount()
    {
        $model = new FileUpload();
        return $model->where('status', self::STATUS_FAILED);
    }

    public static function getFileSuccessCount()
    {
        $model = new FileUpload();
        return $model->where('status', self::STATUS_SIGNED);
    }
}
