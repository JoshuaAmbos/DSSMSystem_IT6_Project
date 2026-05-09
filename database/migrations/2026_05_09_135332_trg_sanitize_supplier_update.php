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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanitize_supplier_update');
        DB::unprepared("
            CREATE TRIGGER trg_sanitize_supplier_update
            BEFORE UPDATE ON suppliers
            FOR EACH ROW
            BEGIN
                -- remove leading/trailing spaces
                SET NEW.name = TRIM(NEW.name);

                -- prevent saving a blank/empty space
                IF NEW.name IS NULL OR LENGTH(TRIM(NEW.name)) = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Validation Error: Supplier name cannot be empty.';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanitize_supplier_update');
    }
};
