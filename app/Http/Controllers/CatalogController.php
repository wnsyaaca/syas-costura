<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $services = Service::with('category')
            ->when($request->q, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->category, fn($q, $c) => $q->whereHas('category', fn($x) => $x->where('slug', $c)))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('catalog.index', compact('services', 'categories'));
    }
}
