<?php

namespace App\Controllers;

use CodeIgniter\CLI\CLI;
use FtpClient\FtpClient;
use App\Models\FileUploadModel;
use App\Models\FileContent;

Class FileController extends BaseController {
     // Step to Digital Signning
    // 1. Read file from folder input SFTP 
    // 2. Validate every line 
    // 3. Send to Peruri
    // 3. Send Email to Penandatanganan if no 2 success
    // 4. cek 1 kali 24 jam jika tidak ada proses maka jadi failed
    // 5. Callback 
    public static function file_process() {
        CLI::write('Start file process', 'green');
        $ftpConfig = new \Config\FtpConfig();
        CLI::write($ftpConfig->host, 'yellow');
        $ftp = new FtpClient();
        $ftp->connect($ftpConfig->host,false, $ftpConfig->port,$ftpConfig->timeOut)->login($ftpConfig->username, $ftpConfig->password);
        
        $listFile = $ftp->nlist($ftpConfig->folderIn,false);
        foreach($listFile as $vava){
            CLI::write($vava);
            $strFileDest = $ftpConfig->localFolderIn  . "/" . $vava;
            
        }
        CLI::write('Start to copy all files in ' . $ftpConfig->folderIn, 'green');
        $ftp->getAll($ftpConfig->folderIn, $ftpConfig->localFolderIn);
        $ftp->cleanDir($ftpConfig->folderIn);
        CLI::write('End to copy all files in ' . $ftpConfig->folderIn, 'green');


        $globCsvFile = glob($ftpConfig->localFolderIn . "/*.csv");
        foreach ($globCsvFile as $file) {
            $status = 0;
            $fileToRead = $ftpConfig->localFolderIn . "/" . basename($file);
            $importData_arr = array();
            $i = 0;
            $numberOfFields = 10; // Total number of fields
            if (($open = fopen($fileToRead,"r")) !== FALSE){

                    $fileID = \App\Services\FileUploadServices::SaveFileUploadModuleReturnID($file,1,"Success read file");

                    while (($filedata = fgetcsv($open, 1000, ";")) !== FALSE) 
                    {       
                        $num = count($filedata);
                        // Skip first row & check number of fields
                        if($i > 0 && $num == $numberOfFields){ 
                            $resultValidasi = \App\Services\FileUploadServices::ValidateField($filedata, $fileToRead, $numberOfFields);
                            if (strlen($resultValidasi) > 0){
                                \App\Services\FileUploadServices::SaveFileContentOnError($fileID,$resultValidasi,implode(";",$filedata),99,$i);
                            }else{
                                \App\Services\FileUploadServices::SaveFileContent($fileID, $filedata,0, $i,"Sukses Insert Data", implode(";", $filedata));
                            }
                        }
                       
                        $i++;
                    }
                    fclose($open);
            }else{
                \App\Services\FileUploadServices::SaveFileUploadModule($file,99,"Error reading file");
            } 
        }

    

        $ftp->putAll($ftpConfig->localFolderIn, $ftpConfig->folderOut);
        
        $ftp->quit();  

        \App\Services\FileUploadServices::MoveAllFileToOtherDirectory($ftpConfig->localFolderIn,$ftpConfig->localFolderOut);
        CLI::write('End Process', 'green');
    }
}