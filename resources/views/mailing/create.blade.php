@extends('layouts.app')

@section('title', 'Tvorba mailingu')

@section('content')
    
<div class="d-flex align-items-center">
    <h1 class="flex-grow-1 mb-0">Vytvoření nového mailingu</h1>
    <button class="btn btn-danger me-3" href="" id="download-btn">Stáhnout XML feed - AJAX</button>
    <div class="spinner-border spinner-border-sm" id="loading-spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <svg id="loading-done" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-check-circle no-visible transition-check" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
        <path
            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
    </svg>
</div>
<div class="text-center">
    <form action="{{ route('mailing.store') }}" method="POST">
        @csrf
        <div class="d-flex flex-wrap border-top mt-5">
            <div class="flex-grow-1 mt-4 text-start">
                <h3 class="mb-4">Informace o mailingu</h3>
                <div class="row g-3 align-items-center">
                    <div class="col-3">
                        <label for="name" class="col-form-label">Název mailingu</label>
                    </div>
                    <div class="col-6">
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row g-3 align-items-center mt-1">
                    <div class="col-3">
                        <label for="slogan" class="col-form-label">Slogan</label>
                    </div>
                    <div class="col-6">
                        <textarea id="slogan" name="slogan" class="form-control">{{ old('slogan') }}</textarea>
                    </div>
                </div>
                <div class="row g-3 align-items-center mt-1">
                    <div class="col-3">
                        <label for="theme" class="col-form-label">Šablona</label>
                    </div>
                    <div class="col-6">
                        <select class="form-select" id="theme" name="theme">
                            @foreach ($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="submit" value="Krok 2: Upravit produkty v mailingu" class="btn btn-success mt-5">
            </div>
            <div class="flex-grow-1 mt-4 text-start">
                <div class=" d-flex align-items-center justify-content-start mb-4">
                    <h3 class="mb-0">Objednací kódy produktů</h3>
                    <div class="d-flex align-items-center justify-content-start ms-4">
                        <button type="button" class="btn btn-secondary me-2 rounded-circle lh-sm"
                            onclick="add()">+</button>
                        <button type="button" class="btn btn-secondary rounded-circle lh-sm"
                            onclick="remove()">-</button>
                    </div>
                </div>
                <div id="new_chq">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="id_1" class="col-form-label">Objednací kód</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="id_1" name="product_id[]" class="form-control" value="{{ old('id_1') }}" required>
                        </div>
                    </div>
                    <div class="mt-1 row g-3 align-items-center" id="new_2">
                        <div class="col-auto">
                            <label for="id_2" class="col-form-label">Objednací kód</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="id_2" name="product_id[]" class="form-control" value="{{ old('id_2') }}" required>
                        </div>
                    </div>
                    <div class="mt-1 row g-3 align-items-center" id="new_3">
                        <div class="col-auto">
                            <label for="id_3" class="col-form-label">Objednací kód</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="id_3" name="product_id[]" class="form-control" value="{{ old('id_3') }}" required>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="3" id="total_chq">
            </div>
        </div>
    </form>
</div>


<script>
    var $loading = $('#loading-spinner').hide();
    $(document)
        .ajaxStart(function() {
            $loading.show();
        })
        .ajaxStop(function() {
            $loading.hide();
            $('#loading-done').css({
                'visibility': 'visible',
                'opacity': '1',
            });
        });

    $(document).ready(function() {
        $('#download-btn').click(function(e) {

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('downloadFeed') }}",
                method: 'get',
                data: {},
                success: function() {},
                complete: function() {
                    $('#download-btn').toggleClass('btn-danger btn-success')
                }
            });
        });
    });



    $('.add').on('click', add);
    $('.remove').on('click', remove);

    function add() {
        var initial_inputs_number = 3;
        var new_chq_no = parseInt($('#total_chq').val()) + 1;
        var new_input = "<div class='mt-1 row g-3 align-items-center' id='new_" + new_chq_no +
            "'><div class='col-auto'><label for='id_" + new_chq_no +
            "' class='col-form-label'>Objednací kód</label></div><div class='col-auto'><input class='form-control' type='text' id='id_" +
            new_chq_no + "' name='product_id[]' required></div></div>";

        $('#new_chq').append(new_input);

        $('#total_chq').val(new_chq_no);
    }

    function remove() {
        var last_chq_no = $('#total_chq').val();

        if (last_chq_no > 1) {
            $('#new_' + last_chq_no).remove();
            $('#total_chq').val(last_chq_no - 1);
        }
    }
</script>

@endsection
