@extends('layouts.app')

@section('title', 'Seznam mailingů')

@section('content')
<div class="d-flex align-items-center pb-5 border-bottom mb-5">
    <h1 class="flex-grow-1 mb-0">Seznam mailingů</h1>
    <a href="{{ route('mailing.create') }}" class="btn btn-success">Vytvořit nový mailing</a>
</div>
<table class="table table-striped table-responsive table-hover align-middle">
    <thead>
        <tr>
          <th scope="col">Název mailingu</th>
          <th scope="col">Datum vytvoření</th>
          <th scope="col">Datum poslední úpravy</th>
          <th scope="col" class="text-end">Akce</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($mailings as $mailing)
        <tr style="cursor: pointer;" class='clickable-row' data-href='{{ route('mailing.show', [$mailing->id]) }}'>
            <th scope="row">{{ $mailing->name }}</th>
            <td>{{ $mailing->created_at }}</td>
            <td>{{ $mailing->updated_at }}</td>
            <td class="text-end">
                <div class=" d-flex justify-content-end">
                    <a href="{{ route('mailing.show', [$mailing->id]) }}" class="btn btn-primary btn-sm me-1">Zobrazit</a>
                    <a href="{{ route('mailing.html', [$mailing->id, 'html' => true]) }}" class="btn btn-primary btn-sm me-1">Zobrazit HTML</a>
                    <a href="{{ route('mailing.edit', [$mailing->id]) }}" class="btn btn-warning btn-sm me-1">Editovat</a>
                    <form action="{{ route('mailing.destroy', [$mailing->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Smazat" class="btn btn-danger btn-sm">
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <p>Nejsou zatím přidáni žádní výrobci!</p>
        @endforelse
    </tbody>
</table>

<script>
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
@endsection

