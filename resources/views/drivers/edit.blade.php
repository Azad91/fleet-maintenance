@extends('layouts.app')

@section('title', 'Sürücü Redaktə Et')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>✏️ Sürücü Redaktə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('drivers.update', $driver) }}" method="POST">
            @csrf
            @method('PUT')
            @include('drivers.partials.form')
        </form>
    </div>
</div>
@endsection