<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_current_inactive_inventory");
        DB::unprepared("
            CREATE VIEW v_current_inactive_inventory AS
            SELECT
                i.id AS item_id,
                i.category_id,
                i.bale_id,
                c.name AS category_name,
                b.bale_number AS bale_ref,
                i.item_code,
                i.description AS item_name,
                i.price AS tag_price,
                i.is_sold,
                i.created_at
            FROM items i
            JOIN categories c ON i.category_id = c.id
            LEFT JOIN bales b ON i.bale_id = b.id
            WHERE i.is_sold = 1 OR i.quantity <= 0;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP VIEW IF EXISTS v_current_inactive_inventory;");
    }
};
