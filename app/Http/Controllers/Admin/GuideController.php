<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    public function index(Request $request)
    {
        $query = Guide::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $guides = $query->latest()->paginate(20)->withQueryString();

        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guides.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:guides,slug',
            'category' => 'required|string|max:100',
            'steps' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Guide::create([
            ...$validated,
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
        ]);

        return redirect()->route('admin.guides.index')->with('success', 'Guide created successfully.');
    }

    public function edit(Guide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, Guide $guide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:guides,slug,' . $guide->id,
            'category' => 'required|string|max:100',
            'steps' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $guide->update([
            ...$validated,
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
        ]);

        return redirect()->route('admin.guides.index')->with('success', 'Guide updated successfully.');
    }

    public function destroy(Guide $guide)
    {
        $guide->delete();

        return redirect()->route('admin.guides.index')->with('success', 'Guide deleted successfully.');
    }
}
