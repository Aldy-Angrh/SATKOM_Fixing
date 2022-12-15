<?php

namespace App\Models\V2;

use CodeIgniter\Model;

class FileUpload extends Model
{
    const STATUS_BARIS_SUCCESS_PARSING = '0';
    const STATUS_SUCCESS_PARSING = '1';
    const STATUS_SUCCESS_PARSING_ERROR = '2';
    
    const STATUS_ERRDOWNLOAD_DOCUMENT = '96';
    const STATUS_ERRPROCESS_DOCUMENT = '97';
    const STATUS_ERRSEND_DOCUMENT = '98';
    const STATUS_ERRPARSE_FILE = '99';

    const STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA = '1';
    const STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA = '2';
    const STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA = '3';

    const STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN = '4';
    const STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN = '5';
    const STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN = '6';
    const STATUS_SUCCESS_DOWNLOAD = '7';

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

    public static function getStatuses()
    {
        return [
            self::STATUS_BARIS_SUCCESS_PARSING => 'Berhasil Parsing File',
            self::STATUS_SUCCESS_PARSING => 'Berhasil Parsing File',
            self::STATUS_SUCCESS_PARSING_ERROR => 'Berhasil Parsing File, Ada Error',
    
            self::STATUS_ERRDOWNLOAD_DOCUMENT => 'Gagal Unduh Dokumen',
            self::STATUS_ERRPROCESS_DOCUMENT => 'Gagal Proses Dokumen',
            self::STATUS_ERRSEND_DOCUMENT => 'Gagal Kirim Dokumen',
            self::STATUS_ERRPARSE_FILE => 'Gagal Parsing File',


            self::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA => 'Kirim Dokumen ke peserta',
            self::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN => 'Kirim Dokumen ke penandatangan',

            self::STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA => 'Menunggu tandatangan peserta',
            self::STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN => 'Menunggu tandatangan',

            self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA => 'Sudah ditandatangani peserta',
            self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN => 'Sudah ditandatangani',
            self::STATUS_SUCCESS_DOWNLOAD => 'Selesai',
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
            case self::STATUS_BARIS_SUCCESS_PARSING:
            case self::STATUS_SUCCESS_PARSING:
            case self::STATUS_SUCCESS_PARSING_ERROR:
            case self::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA:
                $label = 'info';
                break;
            case self::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN:
                $label = 'primary';
                break;
            case self::STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA:
                $label = 'info';
                break;
            case self::STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN:
                $label = 'primary';
                break;
            case self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA:
                $label = 'info';
                break;
            case self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN:
                $label = 'primary';
                break;
            case self::STATUS_SUCCESS_DOWNLOAD:
                $label = 'success';
                break;
            case self::STATUS_ERRPROCESS_DOCUMENT:
                $label = 'warning';
                break;
            case self::STATUS_ERRDOWNLOAD_DOCUMENT:
            case self::STATUS_ERRSEND_DOCUMENT:
            case self::STATUS_ERRPARSE_FILE:
                $label = 'danger';
                break;
            default:
                $label = 'default';
                break;
        }
        return '<span class="label label-' . $label . '">' . ($statuses[$status] ?? 'Tidak Diketahui') . '</span>';
    }

    public static function getCountOfSuccessContent($id = null)
    {
        $model  = new FileContent();
        if ($id) {
            $model->where('file_id', $id);
        }
        return $model->where('status', FileContent::STATUS_ALREADY_SIGN)->countAllResults();
    }

    public static function getCountOfFailedContent($id = null)
    {
        $model  = new FileContent();
        if ($id) {
            $model->where('file_id', $id);
        }
        return $model->where('status', FileContent::STATUS_ERRPROCESS_DOCUMENT)->countAllResults();
    }


    public static function getCountOfFile()
    {
        $model = new FileUpload();
        return $model->countAllResults();
    }


    public static function getCountOfFailedFile()
    {
        $model = new FileUpload();
        return $model->whereIn('status', [
            self::STATUS_SUCCESS_PARSING_ERROR,
        ])->countAllResults();
    }


    public static function getCountOfSuccessFile()
    {
        $model = new FileUpload();
        return $model->whereIn('status', [
            self::STATUS_SUCCESS_PARSING,
        ])->countAllResults();
    }
}
