<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySalesSummary extends Model
{
    protected $table = 'v_daily_sales_summary';

    public $timestamps = false;
    public $incrementing = false;
}
