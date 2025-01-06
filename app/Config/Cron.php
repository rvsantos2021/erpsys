<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cron extends BaseConfig
{
    public $tasks = [
        'update_accounts_status' => [
            'command'   => 'contas:atualizar-status',
            'schedule'  => '0 0 * * *', // Roda todo dia à meia-noite
        ]
    ];
}