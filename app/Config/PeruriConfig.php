<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PeruriConfig extends BaseConfig {
    public $host = 'https://apgdev.peruri.co.id:9044/gateway/';
    public $jwtUrl = 'jwtSandbox/1.0/getJsonWebToken/v1';
    public $documemtTier = 'digitalSignatureFullJwtSandbox/1.0/sendDocumentTier/v1';
    public $documemtSubmit = 'digitalSignatureFullJwtSandbox/1.0/sendDocument/v1';
    public $systemId = "BRI-SATKOMINDO";
    public $xGatewayApiKey = "147cb11d-41c2-4677-984a-e95bb998b635";
}