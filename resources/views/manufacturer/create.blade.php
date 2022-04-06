@extends('layouts.app')

@section('title', 'Seznam výrobců')

@section('content')

<form action="{{ route('manufacturer.store') }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex align-items-center">
        <h2 class="flex-grow-1 mb-0">Přidání nového výrobce</h1>
        <input type="submit" value="Uložit" class="btn btn-success">
    </div>
    @csrf
    @include('manufacturer.partials.form')
    
</form>

@endsection