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
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_transaction_total');
        DB::unprepared("
            CREATE TRIGGER trg_update_transaction_total
            AFTER INSERT ON transaction_items
            FOR EACH ROW
            BEGIN
                -- add new line item's subtotal to transaction record
                UPDATE transactions
                SET total_amount = (total_amount + NEW.subtotal)
                WHERE id = NEW.transaction_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_transaction_total');
    }
};
