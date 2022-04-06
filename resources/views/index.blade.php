@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class=" text-center">
    <h1 style="font-size: 100px; padding-top:18%;">Mailing creator</h1>
    <div class="pt-4">
        <a href="{{ route('mailing.create') }}" class="btn btn-danger">Vytvořit nový mailing</a>
    </div>
</div>

@endsection