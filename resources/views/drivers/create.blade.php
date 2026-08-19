@extends('layouts.app')

@section('title', 'Yeni Sürücü')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>➕ Yeni Sürücü Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('drivers.store') }}" method="POST">
            @csrf
            @include('drivers.partials.form')
        </form>
    </div>
</div>
@endsection