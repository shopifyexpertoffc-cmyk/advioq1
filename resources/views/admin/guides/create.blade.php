@extends('layouts.admin')

@section('title', 'Create Guide')
@section('page_title', 'Create Guide')

@section('content')
<form action="{{ route('admin.guides.store') }}" method="POST" class="space-y-6 max-w-4xl">
    @csrf
    @include('admin.guides.partials.form', ['guide' => null])
</form>
@endsection
