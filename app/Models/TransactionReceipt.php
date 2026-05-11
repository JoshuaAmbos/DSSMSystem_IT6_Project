<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionReceipt extends Model
{
    protected $table = 'v_transaction_receipts';
    public $timestamps = false;
    public $incrementing = false;
}
