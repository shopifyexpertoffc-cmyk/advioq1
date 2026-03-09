@extends('layouts.admin')

@section('title', 'Guides')
@section('page_title', 'Guide Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search guides..." class="px-3 py-2 rounded-lg bg-surface-800 border border-surface-700 text-sm">
            <select name="status" class="px-3 py-2 rounded-lg bg-surface-800 border border-surface-700 text-sm">
                <option value="">All status</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
            </select>
            <button class="px-4 py-2 bg-surface-700 rounded-lg text-sm">Filter</button>
        </form>
        <a href="{{ route('admin.guides.create') }}" class="px-4 py-2 bg-brand-600 rounded-lg text-sm text-white">New Guide</a>
    </div>

    <div class="bg-surface-800 border border-surface-700 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-surface-900/50 text-surface-400">
                <tr>
                    <th class="text-left p-3">Title</th>
                    <th class="text-left p-3">Category</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Updated</th>
                    <th class="text-right p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guides as $guide)
                    <tr class="border-t border-surface-700">
                        <td class="p-3">{{ $guide->title }}</td>
                        <td class="p-3">{{ $guide->category }}</td>
                        <td class="p-3">{{ ucfirst($guide->status) }}</td>
                        <td class="p-3">{{ $guide->updated_at->diffForHumans() }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('admin.guides.edit', $guide) }}" class="text-brand-400">Edit</a>
                            <form action="{{ route('admin.guides.destroy', $guide) }}" method="POST" class="inline" onsubmit="return confirm('Delete this guide?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-surface-400">No guides found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $guides->links() }}
</div>
@endsection
