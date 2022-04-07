@extends('layouts.app')

@section('title', 'Seznam výrobců')

@section('content')
<div class="d-flex align-items-center pb-5 border-bottom mb-5">
    <h1 class="flex-grow-1 mb-0">Přehled výrobců</h1>
    <a href="{{ route('manufacturer.create') }}" class="btn btn-success">Přidat nového výrobce</a>
</div>
<table class="table table-striped table-responsive table-hover align-middle">
    <thead>
        <tr>
          <th scope="col">Název výrobce</th>
          <th scope="col">Logo výrobce</th>
          <th scope="col" class="text-end">Akce</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($manufacturers as $manufacturer)
    <tr>
        <th scope="row">{{ $manufacturer->name }}</th>
        <td><img src="{{ $manufacturer->image }}" alt="" height="30px" width="auto"></td>
        <td class="d-flex justify-content-end">
            <a href="{{ route('manufacturer.edit', [$manufacturer->id]) }}" class="btn btn-warning btn-sm me-1">Editovat</a>
            <form action="{{ route('manufacturer.destroy', [$manufacturer->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="Smazat" class="btn btn-danger btn-sm">
            </form>
        </td>
    </tr>
    @empty
  
    <tr>
        <td>
            <p>Nejsou zatím přidáni žádní výrobci!</p>
        </td>
    </tr>
    @endforelse
    </tbody>
    </table>
@endsection