<div class="mt-5 border-top mb-5 row pt-3 flex-wrap">
    <div class="col-12 col-sm-7 col-md-8 mt-3">
        <div class="mb-3">
            <label for="name" class="form-label">Název výrobce</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($manufacturer ?? null)->name) }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">{{ optional($manufacturer ?? null)->image == null ? 'Vložit obrázek' : 'Vložit jiný obrázek' }}</label>
            <input class="form-control form-control-sm" type="file" id="image" name="image">
        </div>
    </div>
    <div class="mt-3 mb-3 col-12 col-sm-5 col-md-4" style="max-width: 400px;">
        <p class="form-label">Logo výrobce</h4>
        <div class="border p-3">
            @if (optional($manufacturer ?? null)->image)
            
            <img src="{{ $manufacturer->image }}" alt="logo" width="100%">
            @endif
        </div>
    </div>
</div>
