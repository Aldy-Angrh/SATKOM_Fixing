<?php

namespace App\Services;

use App\Models\TokenPeruri;
use CodeIgniter\Config\BaseService;
use CodeIgniter\CLI\CLI;

class PeruriServices extends BaseService {
    public static function SendEmail($from, $to,$subject){
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom($from, 'Confirm Registration');

        $email = \Config\Services::email();
        $email->setSubject($subject);
        $email->setMessage('Haii Tanda tangan donk');
        if ($email->send()) {
            echo 'Email successfully sent';
            return true;
        } 
        return false;
    }

    public static function GetTokenFromDb() {
        CLI::write('GetTokenFromDb', 'yellow');
        $db = \Config\Database::connect();
        $query = $db->query("select * from token_peruri where expired_time < NOW() limit 1");
        $row = $query->getRowArray();
        if (isset($row)) {
            return $row['token'];
        }else{
            $client = \Config\Services::curlrequest();
            $peruriConfig = new \Config\PeruriConfig();

            $curl = curl_init($peruriConfig->host . $peruriConfig->jwtUrl);

            $dataMentah = array(
                "param" => array(
                    "systemId" => $peruriConfig->systemId
                )
                );
            $data = json_encode($dataMentah);

            /* Set JSON data to POST */
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            /* Define content type */
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type:application/json',
                'x-Gateway-APIKey: ' . $peruriConfig->xGatewayApiKey
            ));

            /* Return json */
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            /* make request */
            $result = curl_exec($curl);
            $obj = json_decode($result,true);
            CLI::write($obj['data']['jwt'], 'green');

            $tokenPeruri = new TokenPeruri();
            $tokenPeruri->insert([
                "token" => $obj['data']['jwt'],
                "expired_time" => $obj['data']['expiredDate'],
            ]);

            /* close curl */
            curl_close($curl);

            return $obj['data']['jwt'];
        }

    }

    
}