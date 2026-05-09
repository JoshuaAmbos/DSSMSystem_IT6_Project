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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanitize_supplier_insert');
        DB::unprepared("
            CREATE TRIGGER trg_sanitize_supplier_insert
            BEFORE INSERT on suppliers
            FOR EACH ROW
            BEGIN
                -- remove accidental leading/trailing spaces
                SET NEW.name = TRIM(NEW.name);

                -- prevent saving a blank or empty name
                IF NEW.name IS NULL OR LENGTH(TRIM(NEW.name)) = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Validation Error: Supplier name connot be empty.';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanitize_supplier_insert');
    }
};
