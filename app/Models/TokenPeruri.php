<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenPeruri extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'token_peruri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'token',
        'expired_time',
        'created_at',
        'created_by',
    ];

    public function getBearerToken($full = false)
    {
        $data = $this->where([
            'expired_time >' => date('Y-m-d H:i:s'),
        ])->first();

        if ($full) {
            return $data;
        }

        if ($data) {
            return $data->token;
        }

        return '';
    }
}
