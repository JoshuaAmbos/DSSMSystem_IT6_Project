<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentActiveInventory extends Model
    {
        protected $table = 'v_current_active_inventory';
        
        public $timestamps = false;
        public $incrementing = false;
        protected $primaryKey = 'item_id'; 
    }