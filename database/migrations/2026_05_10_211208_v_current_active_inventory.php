<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_current_active_inventory");
        DB::unprepared("
            CREATE VIEW v_current_active_inventory AS
            SELECT
                i.id AS item_id,
                c.name AS category_name,
                i.item_code,
                i.description AS item_name,
                i.price AS tag_price,
                i.quantity AS stock_left,
                (i.price * i.quantity) AS potential_revenue
            FROM items i
            JOIN categories c ON i.category_id = c.id
            WHERE i.is_sold = 0
                AND i.quantity > 0;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_current_active_inventory");
    }
};
