<?php

namespace App\Http\Controllers;

use App\Models\CurrentActiveInventory;
use App\Models\DailySalesSummary;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\DailyRevenue;
use App\Models\TransactionItem;
use App\Models\CategoryInventory;
use App\Models\TransactionReceipt;


use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');

    }
    public function dailySales(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $stats = DailySalesSummary::where('sales_date', $date)->first();

        $transactions = Transaction::with(['user', 'items.category', 'paymentMethod'])
            ->whereDate('created_at', $date)
            ->orderByDesc('created_at')
            ->get();

        $totalSales = $stats->daily_revenue ?? 0;
        $totalTransactions = $stats->total_transactions ?? 0;

        $avgSale = $stats->avg_transaction_value ?? 0;
        
        $totalItemsSold = TransactionItem::whereHas('transaction', function ($query) use ($date) {
            $query->whereDate('created_at', $date);
        })->count();

        $paymentBreakdown = $transactions->groupBy(function ($txn) {
            return $txn->paymentMethod->method_name ?? 'Unknown';
        })->map(fn ($group) => $group->sum('total_amount'));

        return view('reports.daily-sales', compact(
            'transactions',
            'date',
            'totalSales',
            'totalTransactions',
            'totalItemsSold',
            'paymentBreakdown'
        ));
    }

    public function inventoryStatus(Request $request)
    {
        $categoryId = $request->input('category');
        
        // detailed items list
        $inventoryQuery = Item::with(['category', 'bale.supplier']);
        if ($categoryId) {
            $inventoryQuery->where('category_id', $categoryId);
        }
        $items = $inventoryQuery->orderByDesc('created_at')->paginate(15);

        $categorySummary = CategoryInventory::all();

        $overallStats = [
            'total' => $categorySummary->sum('total_items'),
            'available' => $categorySummary->sum('available'),
            'sold' => $categorySummary->sum('sold'),
            'total_value' => $categorySummary->sum('potential_revenue'),
        ];

        return view('reports.inventory-status', compact('items', 'categorySummary', 'overallStats'));
    }

    public function transactionReceipt(Transaction $transaction)
    {
        $receiptItems = TransactionReceipt::where('transaction_id', $transaction->id)->get();

        return view('reports.receipt', compact('transaction', 'receiptItems'));
    }

    // v_daily_sales_summary
    public function dailySalesSummary()
    {
        $revenueData = DailySalesSummary::orderBy('sales_date', 'desc')->take(30)->get();
        return view('reports.daily_sales_summary', compact('revenueData'));
        
    }

    // v_current_active_inventory
    public function currentActiveInventory()
    {
        $inventory = CurrentActiveInventory::orderBy('item_code')->paginate(20);

        $totalPotentialValue = CurrentActiveInventory::sum('potential_revenue');

        return view('reports.current_active_inventory', compact('inventory', 'totalPotentialValue'));
    }
}