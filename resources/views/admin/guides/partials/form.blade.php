<div class="bg-surface-800 border border-surface-700 rounded-xl p-6 space-y-4">
    <div>
        <label class="block text-sm mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $guide->title ?? '') }}" class="w-full px-3 py-2 rounded-lg bg-surface-900 border border-surface-700">
    </div>
    <div>
        <label class="block text-sm mb-1">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug', $guide->slug ?? '') }}" class="w-full px-3 py-2 rounded-lg bg-surface-900 border border-surface-700">
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category', $guide->category ?? 'general') }}" class="w-full px-3 py-2 rounded-lg bg-surface-900 border border-surface-700">
        </div>
        <div>
            <label class="block text-sm mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 rounded-lg bg-surface-900 border border-surface-700">
                <option value="draft" @selected(old('status', $guide->status ?? 'draft') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $guide->status ?? '') === 'published')>Published</option>
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm mb-1">Step-by-step Content</label>
        <textarea name="steps" rows="12" class="w-full px-3 py-2 rounded-lg bg-surface-900 border border-surface-700">{{ old('steps', $guide->steps ?? '') }}</textarea>
        <p class="text-xs text-surface-400 mt-1">Use numbered steps or markdown-like formatting.</p>
    </div>
</div>
<div class="flex gap-3">
    <button class="px-4 py-2 bg-brand-600 rounded-lg text-white">Save Guide</button>
    <a href="{{ route('admin.guides.index') }}" class="px-4 py-2 bg-surface-700 rounded-lg">Cancel</a>
</div>
