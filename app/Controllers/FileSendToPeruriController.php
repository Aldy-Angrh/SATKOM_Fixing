<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FileContent;
use CodeIgniter\CLI\CLI;
use DateTime;
use FtpClient\FtpClient;

class FileSendToPeruriController extends BaseController
{
    public static function send_document()
    {
        //populate 
        $token = \App\Services\PeruriServices::GetTokenFromDb();
        CLI::write('Token' . $token, 'green');
        $peruriConfig = new \Config\PeruriConfig();
        $ftpConfig = new \Config\FtpConfig();
        $db = \Config\Database::connect();
        $result = $db->query("select distinct lower(file_id) as file_id , lower(email_peserta) as email_peserta  from file_contents where send_date is null");
        foreach ($result->getResultArray() as $row) {
            $sql = "select * from file_contents where lower(email_peserta) = ?  ORDER BY baris asc";
            $result2 = $db->query($sql, [$row['email_peserta']]);
            $signer = array();
            $fileName = "";
            
            foreach ($result2->getResultArray() as $row2) {
                CLI::write($row2['id'], 'red');
                CLI::write($row2['file_id'], 'red');
                CLI::write($row2['email_peserta'], 'red');
                CLI::write($row2['email_penandatangan'], 'red');
                CLI::write($row2['file_name'], 'red');
                if ($row2['status'] == "1") {
                    break;
                }else if ($row2['status'] == "2"){
                    continue;
                }
                $path = $ftpConfig->localFolderOut . "/" . $row2['file_name'];
                CLI::write($path, 'red');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $id = $row2['id'];
                $fileContent = file_get_contents($path);
                $base64 = base64_encode($fileContent);
                $dataMentah = array(
                    "param" => array(
                        "email" => $row2['email_penandatangan'],
                        "payload" => array(
                            "fileName" => $row2['file_name'],
                            "base64Document" => $base64,
                            "signer" =>array(array(
                                "isVisualSign" => "YES",
                                "lowerLeftX" => $row2['lower_left_x'],
                                "lowerLeftY" => $row2['lower_left_y'],
                                "upperRightX" => $row2['upper_right_x'],
                                "upperRightY" => $row2['upper_right_y'],
                                "page" => $row2['page'],
                                "certificateLevel" => "NOT_CERTIFIED",
                                "varLocation" => "Jakarta",
                                "varReason" => "Signed",
                            ))
                        ),
                        "systemId" => $peruriConfig->systemId,
                        "orderType" => "INDIVIDUAL"
                    )
                );

                $dataJson = json_encode($dataMentah);
                $curl = curl_init($peruriConfig->host . $peruriConfig->documemtSubmit);

                /* Set JSON data to POST */
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);

                /* Define content type */
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type:application/json',
                    'x-Gateway-APIKey:' . $peruriConfig->xGatewayApiKey,
                    'Authorization:' . 'Bearer ' . $token
                ));

                /* Return json */
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                /* make request */
                $resultUrl = curl_exec($curl);
                CLI::write("start decode", 'red');
                $obj = json_decode($resultUrl, true);
                CLI::write("end decode", 'red');
                $fileContent = new FileContent();
                $now = date('Y-m-d H:i:s');
                if (!in_array("Exception", $obj)){
                    if ($obj['resultCode'] == 0) {
                        $fileContent->update($id, [
                            "send_date" => $now,
                            "status" => 1,
                            "order_id" => $obj['data']['orderId'],
                            "updated_at" => $now,
                            "result_code" => $obj['resultCode'],
                            "result_desc" => $obj['resultCode'],
                        ]);
                    }else{
                        $fileContent->update($id, [
                            "updated_at" => $now,
                            "status" => 98,
                            "result_code" => $obj['resultCode'],
                            "result_desc" => $obj['resultCode'],
                        ]);
                    }
                }else{
                    $fileContent->update($id, [
                        "updated_at" => $now,
                        "status" => 98,
                    ]);
                }
                var_dump($obj);
                /* close curl */
                curl_close($curl);
            }
        }
    }

    public function chackby_orderid() {
        $token = \App\Services\PeruriServices::GetTokenFromDb();
        CLI::write('Token' . $token, 'green');
        $peruriConfig = new \Config\PeruriConfig();
        $ftpConfig = new \Config\FtpConfig();
        $db = \Config\Database::connect();
            $sql = "select * from file_contents where status = 1  ORDER BY baris asc";
            $result2 = $db->query($sql);
            $signer = array();
            $fileName = "";

            foreach ($result2->getResultArray() as $row2) {
                CLI::write($row2['id'], 'red');
                CLI::write($row2['file_id'], 'red');
                CLI::write($row2['email_peserta'], 'red');
                CLI::write($row2['email_penandatangan'], 'red');
                CLI::write($row2['file_name'], 'red');
                $id = $row2['id'];
                
                $dataMentah = array(
                    "param" => array(
                        "orderId" => $row2['order_id'],
                    )
                );

                $dataJson = json_encode($dataMentah);
                $curl = curl_init($peruriConfig->host . $peruriConfig->documemtSubmit);

                /* Set JSON data to POST */
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);

                /* Define content type */
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type:application/json',
                    'x-Gateway-APIKey:' . $peruriConfig->xGatewayApiKey,
                    'Authorization:' . 'Bearer ' . $token
                ));

                /* Return json */
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                /* make request */
                $resultUrl = curl_exec($curl);
                CLI::write("start decode", 'red');
                $obj = json_decode($resultUrl, true);
                CLI::write("end decode", 'red');
                $fileContent = new FileContent();
                $now = date('Y-m-d H:i:s');
                if (!in_array("Exception", $obj)) {
                    if ($obj['resultCode'] == '0') {
                        $fileContent->update($id, [
                            "sign_date" => $now,
                            "status" => 2,
                        "updated_at" => $now,
                            "result_code" => $obj['resultCode'],
                            "result_desc" => $obj['resultDesc'],
                        ]);
                    }else{
                        $fileContent->update($id, [
                            "updated_at" => $now,
                            "result_code" => $obj['resultCode'],
                            "result_desc" => $obj['resultDesc'],
                            "status" => 97,
                        ]);   
                    }
                } else {
                    $fileContent->update($id, [
                    "updated_at" => $now,
                        "status" => 97,
                    ]);
                }
                var_dump($obj);
                /* close curl */
                curl_close($curl);
            }
    }

    public function download_document() {
        $token = \App\Services\PeruriServices::GetTokenFromDb();
        CLI::write('Token' . $token, 'green');
        $peruriConfig = new \Config\PeruriConfig();
        $ftpConfig = new \Config\FtpConfig();
        $db = \Config\Database::connect();
        $sql = "select * from file_contents where status = 2  ORDER BY baris asc";
        $result2 = $db->query($sql);
        $signer = array();
        $fileName = "";

        foreach ($result2->getResultArray() as $row2) {
            CLI::write($row2['id'], 'red');
            CLI::write($row2['file_id'], 'red');
            CLI::write($row2['email_peserta'], 'red');
            CLI::write($row2['email_penandatangan'], 'red');
            CLI::write($row2['file_name'], 'red');
            $id = $row2['id'];

            $dataMentah = array(
                "param" => array(
                    "orderId" => $row2['order_id'],
                )
            );

            $dataJson = json_encode($dataMentah);
            $curl = curl_init($peruriConfig->host . $peruriConfig->documemtSubmit);

            /* Set JSON data to POST */
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);

            /* Define content type */
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json',
                'x-Gateway-APIKey:' . $peruriConfig->xGatewayApiKey,
                'Authorization:' . 'Bearer ' . $token
            ));

            /* Return json */
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            /* make request */
            $resultUrl = curl_exec($curl);
            CLI::write("start decode", 'red');
            $obj = json_decode($resultUrl, true);
            CLI::write("end decode", 'red');
            $fileContent = new FileContent();
            $now = date('Y-m-d H:i:s');
            if (!in_array("Exception", $obj)) {
                if ($obj['resultCode'] == '0') {
                    $isError = false;
                    $bin = base64_decode($obj['data']['base64Document'], true);
                    if (strpos($bin, '%PDF') !== 0) {
                        $isError = true;
                    }
                    # Write the PDF contents to a local file

                    $date = DateTime::createFromFormat('YmdHms', '12312010');
                    $fileNameDone = $ftpConfig->localFolderOutSuccess . "/" . $row2['file_name'] . "_" . $date . "_done" . "pdf";
                    file_put_contents($fileNameDone, 2);

                    $fileContent->update($id, [
                        "send_date" => $now,
                        "status" => $isError == true ? 96 : 3,
                        "updated_at" => $now,
                        "result_code" => $obj['resultCode'],
                        "result_desc" => $obj['resultDesc'],
                        "file_name_done" => $fileNameDone,
                    ]);
                } else {
                    $fileContent->update($id, [
                        "status" => 97,
                        "updated_at" => $now,
                        "result_code" => $obj['resultCode'],
                        "result_desc" => $obj['resultDesc'],
                    ]);
                }
            } else {
                $fileContent->update($id, [
                    "updated_date" => $now,
                    "status" => 97,
                ]);
            }
            var_dump($obj);
            /* close curl */
            curl_close($curl);
        }
    }

    public function send_back_file() {
        $db = \Config\Database::connect();
        $sql = "select * from file_contents where (status = 3 or status = 97) and status_file = 0  ORDER BY baris asc";
        $result2 = $db->query($sql);
        $ftpConfig = new \Config\FtpConfig();

        $date = DateTime::createFromFormat('YmdHms', '12312010');
        $fileName = $ftpConfig->localFolderOutSuccess . '/ResultFile_' . $date . ".csv";
        $fp = fopen($fileName, 'wb');
        foreach ($result2->getResultArray() as $row2) {
            CLI::write($row2['id'], 'red');
            CLI::write($row2['file_id'], 'red');
            CLI::write($row2['email_peserta'], 'red');
            CLI::write($row2['email_penandatangan'], 'red');
            CLI::write($row2['file_name'], 'red');
            $mydata = [$row2['content_line'], $row2['status'] , $row2['result_desc']];
            fputcsv($fp, $mydata,";");
        }
        fclose($fileName);

        //send all file 

        $ftpConfig = new \Config\FtpConfig();
        CLI::write($ftpConfig->host, 'yellow');
        $ftp = new FtpClient();
        $ftp->connect($ftpConfig->host, false, $ftpConfig->port, $ftpConfig->timeOut)->login($ftpConfig->username, $ftpConfig->password);
    
        $ftp->put($ftpConfig->folderResult . "/" . basename($fileName),$fileName);

        foreach ($result2->getResultArray() as $row2) {
            CLI::write($row2['id'], 'red');
            CLI::write($row2['file_id'], 'red');
            CLI::write($row2['email_peserta'], 'red');
            CLI::write($row2['email_penandatangan'], 'red');
            CLI::write($row2['file_name'], 'red');
            $id = $row2['id'];
            if ($row2['status'] == 3){
                $ftp->put($ftpConfig->folderResult . "/" . $row2['file_name_done'], $ftpConfig->localFolderOutSuccess . "/" . $row2['file_name_done']);
            }
            $now = date('Y-m-d H:i:s');
            $fileContent = new FileContent();
            $fileContent->update($id, [
                "updated_at" => $now,
                "status_file" => 4,
            ]);
        }
    }


}
