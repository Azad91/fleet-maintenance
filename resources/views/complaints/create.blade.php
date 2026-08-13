@extends('layouts.app')

@section('title', 'Yeni Kart')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📋 Yeni Kart Əlavə Et</h4>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="complaintForm" action="{{ route('complaints.store') }}" method="POST">
            @csrf
            @include('complaints.partials.form')
        </form>
    </div>
</div>
@endsection
