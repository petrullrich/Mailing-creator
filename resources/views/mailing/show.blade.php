@extends('layouts.app')

@section('title', 'Mailing')

@section('content')
<input type="text" id="mailing-html" value="{{ $html }}" class="d-none">
<div class="d-flex align-items-center pb-5 border-bottom mb-5">
    <div class="flex-grow-1">
        <h1 class="pb-1">{{ $mailing->name }}</h1>
        <p class="text-secondary">{{ $mailing->slogan }}</p>
    </div>
    <div>
        <button value="copy" class="btn btn-success" onclick="copyToClipboard('mailing-html')">Zkopírovat HTML mailingu</button>
        <a class="btn btn-warning" href="{{ route('mailing.edit', [$mailing->id]) }}">Editovat mailing</a>
    </div>
</div>
@if ($raw)
<h1 class="pb-2">Raw html:</h1>
{{-- {!! nl2br(e()) !!} --}}
{{ $html }}

@else

{!! $html !!}

@endif



<script>
    function copyToClipboard(id) {
        var text = document.getElementById(id);
        text.select();
        navigator.clipboard.writeText(text.value);
    }
</script>

@endsection
