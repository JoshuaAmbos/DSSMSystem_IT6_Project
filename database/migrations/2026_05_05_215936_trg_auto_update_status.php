<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // for NEW Items
        // Ensures every unique item starts as 'Available' (is_sold = 0)
        DB::unprepared('DROP TRIGGER IF EXISTS before_items_insert_default_state');
        DB::unprepared("
            CREATE TRIGGER before_items_insert_default_state
            BEFORE INSERT ON items
            FOR EACH ROW
            BEGIN
                SET NEW.is_sold = 0;
                SET NEW.quantity = 1; -- Force quantity to 1 for unique items
            END
        ");

        // for UPDATED Items
        // Keeps the is_sold boolean and quantity in sync
        DB::unprepared('DROP TRIGGER IF EXISTS auto_update_inventory_state');
        DB::unprepared("
            CREATE TRIGGER auto_update_inventory_state
            BEFORE UPDATE ON items
            FOR EACH ROW
            BEGIN
                -- if item is marked as sold, quantity = 0
                IF NEW.is_sold = 1 THEN
                    SET NEW.quantity = 0;
                
                -- if quantity is manually set to 0, is_sold = true
                ELSEIF NEW.quantity <= 0 THEN
                    SET NEW.is_sold = 1;
                    SET NEW.quantity = 0;
                
                -- if an item is 'returned' or quantity = 1 again
                ELSEIF NEW.quantity > 0 THEN
                    SET NEW.is_sold = 0;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_items_insert_default_state');
        DB::unprepared('DROP TRIGGER IF EXISTS auto_update_inventory_state');
    }
};