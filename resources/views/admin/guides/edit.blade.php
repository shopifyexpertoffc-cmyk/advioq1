@extends('layouts.admin')

@section('title', 'Edit Guide')
@section('page_title', 'Edit Guide')

@section('content')
<form action="{{ route('admin.guides.update', $guide) }}" method="POST" class="space-y-6 max-w-4xl">
    @csrf
    @method('PUT')
    @include('admin.guides.partials.form', ['guide' => $guide])
</form>
@endsection
