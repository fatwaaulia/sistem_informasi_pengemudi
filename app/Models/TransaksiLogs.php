<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiLogs extends Model
{
    protected $table         = 'transaksi_logs';
    protected $protectFields = false;
    protected $useTimestamps = true;
}
