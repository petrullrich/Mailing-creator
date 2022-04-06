@extends('layouts.app')

@section('title', 'Seznam výrobců')

@section('content')

<form action="{{ route('manufacturer.update', ['manufacturer' => $manufacturer->id]) }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex align-items-center">
        <h2 class="flex-grow-1 mb-0">Úprava výrobce: <span class="text-black-50">{{ $manufacturer->name }}</span></h1>
        <input type="submit" value="Uložit změny" class="btn btn-success">
    </div>
    @csrf
    @method('PUT')
    @include('manufacturer.partials.form')
    
</form>

@endsection