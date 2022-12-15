<?php

namespace App\Exports;

use App\Models\FileUpload;

class FileUploadExport
{
    protected $model;
    protected $spreadsheet;

    function __construct()
    {
        $this->model = new FileUpload();
        $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    }

    public static function getHeader()
    {
        return [
            'ID',
            'Nama File',
            'Email Penandatangan',
            'Email Peserta',
            'Status',
            'Dibuat Pada',
            'Disign Pada',
        ];
    }

    public function getQuery()
    {
        return $this->model->select(implode(",", self::getHeader()));
    }

    public function getFileName()
    {
        return 'file-upload-' . date('YmdHis');
    }

    public function getSheetName()
    {
        return 'File Upload';
    }

    public function getSheetTitle()
    {
        return 'File Upload';
    }

    public function getSheetDescription()
    {
        return 'Daftar File Upload';
    }

    public function getSheetHeader()
    {
        return self::getHeader();
    }

    public function getSheetHeaderTitle()
    {
        return [
            'ID',
            'Nama File',
            'Email Penandatangan',
            'Email Peserta',
            'Status',
            'Dibuat Pada',
            'Disign Pada',
        ];
    }

    public function getSheetHeaderWidth()
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 20,
            'D' => 20,
            'E' => 10,
            'F' => 15,
            // 'G' => 15,
            // 'H' => 15,
        ];
    }

    public function getSheetHeaderStyle()
    {
        return [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
    }

    public function getSheetHeaderRow()
    {
        return 1;
    }

    public function getSheetData()
    {
        return $this->model
            // join to get success and failed count
            ->join('file_contents', 'file_contents.file_id = file_upload.id', 'left')
            ->select(implode(",", [
                'file_upload.id',
                'file_upload.file_name',
                'file_contents.email_penandatangan',
                'file_contents.email_peserta',
                'file_upload.status',
                // 'file_upload.deskripsi',
                // 'COUNT(CASE WHEN file_contents.status = ' . $this->model::STATUS_SIGNED . ' THEN 1 END) AS success_count',
                // 'COUNT(CASE WHEN file_contents.status = ' . $this->model::STATUS_FAILED . ' THEN 1 END) AS failed_count',
                'file_upload.created_at',
                'file_contents.sign_date',
            ]))
            ->get()
            ->getResultArray();
    }

    public function getSheetDataStyle()
    {
        return [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];
    }

    public function getSheetDataRow()
    {
        return 2;
    }

    public function generate()
    {
        $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $this->spreadsheet->getActiveSheet();

        $sheet->setTitle($this->getSheetName());

        // apply column width
        foreach ($this->getSheetHeaderWidth() as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->fromArray($this->getSheetHeader(), null, 'A1');
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($this->getSheetHeaderStyle());
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getAlignment()->setWrapText(true);

        $sheet->fromArray($this->getSheetData(), null, 'A2');
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($this->getSheetDataStyle());
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

    public function download()
    {
        $this->generate();

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->spreadsheet);
        // download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $this->getFileName() . '.xlsx"');
        header('Cache-Control: max-age=0');
        return $writer->save('php://output');
    }
}
