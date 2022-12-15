<?php

namespace App\Services;

use CodeIgniter\Config\BaseService;
use App\Models\FileUploadModel;
use App\Models\FileContent;

class FileUploadServices extends BaseService{
    public static function ValidateField(array $data, $fileToRead, $numberColom)
    {
        $result = "";
        if (count($data) < $numberColom) {
            $result = $result . "Kolom data kurang;";
            return $result;
        }

        if (!file_exists($fileToRead)) {
            $result = $result . "File " . $fileToRead . " tidak ada;";
        }

        if (!filter_var($data[0], FILTER_VALIDATE_EMAIL)) {
            $result = $result . "Format email peserta tidak valid;";
        }

        if (strlen($data[1]) == 0) {
            $result = $result . "Nama peserta tidak valid;";
        }

        if (!filter_var($data[2], FILTER_VALIDATE_EMAIL)) {
            $result = $result . "Format email penandatangan tidak valid;";
        }

        if (strlen($data[3]) == 0) {
            $result = $result . "Nama penandatangan tidak valid;";
        }

        if (strlen($data[4]) == 0) {
            $result = $result . "Nama penandatangan tidak valid;";
        }


        if (!filter_var($data[5], FILTER_VALIDATE_INT)) {
            $result = $result . "Lower left x salah;";
        }

        if (!filter_var($data[6], FILTER_VALIDATE_INT)) {
            $result = $result . "Lower left y salah;";
        }

        if (!filter_var($data[7], FILTER_VALIDATE_INT)) {
            $result = $result . "Upper left x salah;";
        }

        if (!filter_var($data[8], FILTER_VALIDATE_INT)) {
            $result = $result . "Upper left y salah;";
        }

        return $result;
    }

    public static function SaveFileUploadModuleReturnID($fileName, $status, $deskripsi)
    {
        $fileUpload = new FileUploadModel();
        $builder = $fileUpload->insert([
            "file_name" => basename($fileName),
            "status" => $status,
            "deskripsi" => $deskripsi
        ]);

        return $builder;
    }

    public static function SaveFileUploadModule($fileName, $status, $deskripsi)
    {
        $fileUpload = new FileUploadModel();
        $builder = $fileUpload->insert([
            "file_name" => basename($fileName),
            "status" => $status,
            "deskripsi" => $deskripsi,
        ]);

        return $builder;
    }

    public static function SaveFileContentOnError($idDocument, $deskripsi, $content, $status, $baris)
    {
        $fileContent = new FileContent();
        $fileContent->insert([
            "file_id" => $idDocument,
            "status" => $status,
            "description" => $deskripsi,
            "content_line" => $content,
            "baris" => $baris,
        ]);
    }

    public static function SaveFileContent($idDocument, array $data,$status, $baris,$deskripsi,$content)
    {
        $fileContent = new FileContent();
        $fileContent->insert([
            "file_id" => $idDocument,
            "status" => $status,
            "baris" => $baris,
            "content_line" => implode(";",$data),
            "email_peserta" => $data[0],
            "nama_peserta" => $data[1],
            "email_penandatangan" => $data[2],
            "nama_penandatangan" => $data[3],
            "file_name" => $data[4],
            "lower_left_x" => $data[5],
            "lower_left_y" => $data[6],
            "upper_left_x" => $data[7],
            "upper_left_y" => $data[8],
            "description" => $deskripsi,
            "content_line" => $content,
            "status_file" => 0,
        ]);
    }

    public static function MoveAllFileToOtherDirectory($baseFolder,$destinationFolder){
        $files = scandir($baseFolder);
        // Identify directories
        $source = $baseFolder."/";
        $destination = $destinationFolder."/";
        // Cycle through all source files
        $delete = array();
        foreach ($files as $file) {
            if (in_array($file, array(".", ".."))) continue;
            // If we copied this successfully, mark it for deletion
            if (copy($source . $file, $destination . $file)) {
                $delete[] = $source . $file;
            }
        }
        // Delete all successfully-copied files
        foreach ($delete as $file) {
            unlink($file);
        }
    }
}

