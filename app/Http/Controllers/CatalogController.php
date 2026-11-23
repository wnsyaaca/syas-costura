<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $collections = [
            'woman' => 'Woman',
            'men' => 'Men',
            'kids' => 'Kids',
            'family' => 'Family',
        ];

        $collection = $request->query('collection', 'woman');

        if (!array_key_exists($collection, $collections)) {
            $collection = 'woman';
        }

        $categories = Category::where('collection', $collection)
            ->orderBy('name')
            ->get();

        $services = Service::with('category')
            ->whereHas('category', function ($query) use ($collection) {
                $query->where('collection', $collection);
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', compact(
            'services',
            'categories',
            'collections',
            'collection'
        ));
    }

    public function show(Service $service)
    {
        $service->load('category');

        return view('catalog.show', compact('service'));
    }
}
