<?php

namespace App\Models;

use CodeIgniter\Model;

class Webhook extends Model
{
    protected $table         = 'webhook';
    protected $protectFields = false;
    protected $useTimestamps = true;
}
