<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentInactiveInventory extends Model
    {
        protected $table = 'v_current_inactive_inventory';
        public $timestamps = false;
        public $incrementing = false;
        protected $primaryKey = 'item_id';
    }
