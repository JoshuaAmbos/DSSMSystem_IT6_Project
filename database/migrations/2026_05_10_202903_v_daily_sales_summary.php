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
        DB::unprepared('DROP VIEW IF EXISTS v_daily_sales_summary');
        DB::unprepared("
            CREATE VIEW v_daily_sales_summary AS
            SELECT
                CAST(created_at AS DATE) AS sales_date,
                COUNT(id) AS total_transactions,
                SUM(total_amount) AS daily_revenue,
                ROUND(SUM(total_amount) / COUNT(id), 2) AS avg_transaction_value
            FROM transactions
            GROUP BY CAST(created_at AS DATE)
            ORDER BY sales_date DESC;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS v_daily_sales_summary');
    }
};
