<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\CurrentActiveInventory;
use App\Models\CurrentInactiveInventory;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = match($filter) {
            'active' => CurrentActiveInventory::query(),
            'inactive' => CurrentInactiveInventory::query(),
            default => Item::with(['category', 'bale']),
        };

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $items = $query->orderByDesc('created_at')->paginate(15);

        $availableCount = CurrentActiveInventory::count();
        $soldCount = CurrentInactiveInventory::count();
        $totalCount = Item::count();
        $categories = Category::all();

        return view('inventory.index', compact(
            'items',
            'categories', 
            'filter',
            'availableCount', 
            'soldCount', 
            'totalCount'
        ));
    }

    public function show($id)
    {
        $item = Item::with(['category', 'bale.supplier', 'transactions'])->findOrFail($id);
        return view('inventory.show', compact('item'));
    }

    public function getInventoryByCategory()
    {
        // This is useful for dashboard charts
        $inventory = Category::withCount(['items' => function ($query) {
            $query->where('is_sold', false);
        }])->get();

        return response()->json($inventory);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        
        return redirect()->route('inventory.index')
            ->with('success', 'Item removed successfully.');
    }
}