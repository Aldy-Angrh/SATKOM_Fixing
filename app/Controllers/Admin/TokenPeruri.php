<?php

namespace App\Controllers\Admin;

use App\Controllers\MyController;
use Config\Services;

class TokenPeruri extends MyController
{

    /**
     * @var string
     * Store bearer token
     */
    protected $bearerToken;
    protected $userModel;

    protected $model      = '\App\Models\TokenPeruri';
    protected $viewFolder = 'admin/token-peruri/';

    protected $data = [
        'title'       => 'Manage Token',
        'subtitle'    => 'Manajemen Token',
        'url'         => 'admin.token-peruri',
        'primary_key' => 'id',
    ];

    protected $fields = [
        'id' => [
            'label' => 'ID',
            'show'  => false,
        ],
        'token' => [
            'label' => 'Token',
            'show'  => false,
        ],
        'expired_time' => [
            'label' => 'Tanggal Kadaluarsa',
            'show'  => false,
        ],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->model       = new $this->model;
        $this->bearerToken = $this->model->getBearerToken();

        $this->userModel = new \App\Models\User;
    }

    public function index()
    {
        return view($this->viewFolder . '/index', $this->data);
    }

    public function get()
    {
        $data = $this->model->getBearerToken(true);

        if ($data) {
            return $this->respond(200, [
                'status' => true,
                'data'   => $data,
            ]);
        }

        return $this->respond(404, [
            'status' => false,
            'data'   => [],
            "message" => "Token tidak ditemukan",
        ]);
    }

    public function refresh()
    {
        $existToken = $this->model->getBearerToken();
        if ($existToken) {
            return $this->respond(200, [
                'status'  => true,
                'message' => 'Token sudah ada',
                'data'    => [
                    'token' => $existToken,
                ],
            ]);
        }

        try {

            // peruri generate token
            $token = $this->_request("/jwtSandbox/1.0/getJsonWebToken/v1");
            $token = json_decode(json_encode($token), true);


            if ($token['status']) {
                $data = $token['data']['data'];

                $session = Services::session();
                $idUser  = $session->get('login_token');
                $user    = $this->userModel->find($idUser);

                $this->model->insert([
                    'token'        => $data['jwt'],
                    'expired_time' => $data['expiredDate'],
                    'created_at'   => date('Y-m-d H:i:s'),
                    'created_by'   => $user->id,
                ]);

                return $this->respond(200, [
                    'status'  => true,
                    'message' => 'Token berhasil di refresh',
                    'data'    => [
                        'token' => $data['jwt'],
                    ],
                ]);
            } else {
                return $this->respond($token['code'], [
                    'status'  => false,
                    'message' => $token['message'],
                ]);
            }
        } catch (\Throwable $th) {
            $smg = "Unexpected error occured. Please contact administrator";

            if (ENVIRONMENT == 'development') {
                $smg = $th->getMessage();
            }

            return $this->respond(500, [
                'status'  => false,
                'message' => $smg,
            ]);
        }
    }

    private function _request($url, $options = [])
    {
        $systemId  = getenv('PERURI_SYSTEM_ID');
        $gatewayId = getenv('PERURI_GATEWAY_ID');
        $base_url  = getenv('PERURI_BASE_URL');

        if(!$systemId || !$gatewayId || !$base_url) {
            return [
                'status' => false,
                'code' => 500,
                'message' => 'Peruri configuration not found',
            ];
        }

        $curl = curl_init();

        $post = [
            "param" => [
                "systemId" => $systemId,
            ]
        ];

        $header = [
            'x-Gateway-APIKey: ' . $gatewayId,
            'Content-Type: application/json',
        ];

        if ("/digitalSignatureFullJwtSandbox/1.0/signing/v1" == $url) {
            $post = [
                "requestSigning" => array_merge([
                    "systemId" => $systemId,
                ], $options['body']['requestSigning'])
            ];
        } else if ("/digitalSignatureFullJwtSandbox/1.0/signingBulk/v1" == $url) {
            $post = [
                "requestSigning" => array_merge([
                    "systemId" => $systemId,
                ], $options['body']['requestSigning'])
            ];
        } else if ("/digitalSignatureFullJwtSandbox/1.0/getOtpBulk/v1" == $url) {
            $post = [
                "requestGetOtpBulk" => array_merge([
                    "systemId" => $systemId,
                ], $options['body']['requestGetOtpBulk'])
            ];
        } else {
            if (isset($options['body'])) $post["param"] = array_merge($post['param'], isset($options['body']['param']) ? $options['body']['param'] : []);
            if (isset($options['header'])) $header      = array_merge($header, $options['header']);
        }

        if ($this->bearerToken != "" && $url != "/jwtSandbox/1.0/getJsonWebToken/v1") {
            $header[] = "Authorization: Bearer " . $this->bearerToken;
        }

        $post = json_encode($post);

        $config = array(
            CURLOPT_URL            => $base_url . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $post,
            CURLOPT_HTTPHEADER     => $header,
        );

        curl_setopt_array($curl, $config);

        $response = json_decode(curl_exec($curl));
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return [
                "status"  => false,
                "code"    => 404,
                "message" => $err,
            ];
        } else if (is_object($response) && property_exists($response, "Exception")) {
            return [
                "status"  => false,
                "code"    => 400,
                "message" => $response->Exception
            ];
        } else {
            return [
                "status" => true,
                "data"   => (array)$response,
                "code"   => 200,
            ];
        }
    }

    private function respond($statuCode, $data = [])
    {
        $this->response->setStatusCode($statuCode);
        return $this->response->setJSON($data);
    }
}
