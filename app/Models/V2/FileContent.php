<?php

namespace App\Models\V2;

use CodeIgniter\Model;

class FileContent extends Model
{
    const STATUS_SUCCESS_PARSING = '0';
    const STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA = '1';
    const STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA = '2';
    const STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA = '3';

    const STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN = '4';
    const STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN = '5';
    const STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN = '6';
    const STATUS_SUCCESS_DOWNLOAD = '7';

    const STATUS_SUCCESS_PARSING_ERROR = '2';
  
    const STATUS_ALREADY_SIGN = '2';
    const STATUS_DOWNLOAD = '3';
    const STATUS_ALREADY_SEND_TO_SAU = '4';
    const STATUS_ERRDOWNLOAD_DOCUMENT = '96';
    const STATUS_ERRPROCESS_DOCUMENT = '97';
    const STATUS_ERRSEND_DOCUMENT = '98';
    const STATUS_ERRPARSE_FILE = '99';

    protected $table = 'file_contents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'file_id',
        'email_peserta',
        'nama_peserta',
        'email_penandatangan',
        'nama_penandatangan',
        'action',
        'lower_left_x',
        'lower_left_y',
        'upper_right_x',
        'upper_right_y',
        'page',
        'sign_date',
        'send_date',
        'status',
        'content_line',
        'description',
        'baris',
        'result_code',
        'result_desc',
        'status_file',
        'order_id',
    ];

    protected $useTimestamps = true;


    public static function getStatuses()
    {
        return [
            self::STATUS_SUCCESS_PARSING => 'Berhasil Parsing File',
            self::STATUS_SUCCESS_PARSING_ERROR => 'Berhasil Parsing File, Ada Error',

            self::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA => 'Kirim Dokumen ke peserta',
            self::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN => 'Kirim Dokumen ke penandatangan',

            self::STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA => 'Menunggu tandatangan peserta',
            self::STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN => 'Menunggu tandatangan',

            self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA => 'Sudah ditandatangani peserta',
            self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN => 'Sudah ditandatangani',
            self::STATUS_SUCCESS_DOWNLOAD => 'Selesai',


            self::STATUS_ALREADY_SIGN => 'Sudah Ditandatangani',
            self::STATUS_DOWNLOAD => 'Sudah Diunduh',
            self::STATUS_ALREADY_SEND_TO_SAU => 'Sudah Dikirim ke SAU',
            self::STATUS_ERRDOWNLOAD_DOCUMENT => 'Gagal Unduh Dokumen',
            self::STATUS_ERRPROCESS_DOCUMENT => 'Gagal Proses Dokumen',
            self::STATUS_ERRSEND_DOCUMENT => 'Gagal Kirim Dokumen',
            self::STATUS_ERRPARSE_FILE => 'Gagal Parsing File',
        ];
    }

    public static function getStatus($status)
    {
        $statuses = self::getStatuses();
        return $statuses[$status];
    }

    public function scenario()
    {
        return [
            'update' => [
                'id' => 'required',
                'email_peserta' => 'required|valid_email',
                'email_penandatangan' => 'required|valid_email',
            ],
        ];
    }

    public static function getStatusLabel($status)
    {
        $statuses = self::getStatuses();
        $label = 'default';
        switch ($status) {
            case self::STATUS_SUCCESS_PARSING:
            case self::STATUS_SUCCESS_PARSING_ERROR:
            case self::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA:
                $label = 'success';
                break;
            case self::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN:
                $label = 'info';
                break;
            case self::STATUS_SUCCESS_CHECK_DOCUMENT_PEKERJA:
                $label = 'primary';
                break;
            case self::STATUS_SUCCESS_CHECK_DOCUMENT_PENANDATANGAN:
                $label = 'primary';
                break;
            case self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PEKERJA:
                $label = 'success';
                break;
            case self::STATUS_SUCCESS_DOWNLOAD_DOCUMENT_PENANDATANGAN:
                $label = 'success';
                break;
            case self::STATUS_ALREADY_SIGN:
            case self::STATUS_DOWNLOAD:
                $label = 'info';
                break;
            case self::STATUS_ALREADY_SEND_TO_SAU:
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
}
