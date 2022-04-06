@extends('layouts.app')

@section('title', 'Úprava mailingu')

@section('content')
<form action="{{ route('mailing.update', ['mailing' => $mailing->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="d-flex align-items-center pb-5 border-bottom mb-5">
        <h1 class="flex-grow-1 mb-0">Úprava mailingu</h1>
        <input type="submit" value="Uložit" class="btn btn-success">
    </div>
    
    <div class="row mx-0">
        <h3 class="mb-4">Informace o mailingu</h3>
        <div class="row g-3 align-items-center">
            <div class="col-2">
                <label for="name" class="col-form-label">Název mailingu</label>
            </div>
            <div class="col-6">
                <input type="text" id="name" name="name" class="form-control" value="{{ $mailing->name }}" required>
            </div>
        </div>
        <div class="row g-3 align-items-center mt-1">
            <div class="col-2">
                <label for="slogan" class="col-form-label">Slogan</label>
            </div>
            <div class="col-6">
                <textarea id="slogan" name="slogan" class="form-control">{{ $mailing->slogan }}</textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center mt-1">
            <div class="col-2">
                <label for="theme" class="col-form-label">Šablona</label>
            </div>
            <div class="col-6">
                <select class="form-select" id="theme" name="theme">
                    @foreach ($themes as $theme)
                    <option value="{{ $theme->id }}" {{ optional($mailing->theme ?? null)->id == $theme->id ? 'selected' : '' }} ">{{ $theme->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mt-5 border-top mb-5 mx-0">
        @foreach ($products as $key => $product)
        <div class="product-box col-12 col-sm-6 col-lg-4 mt-4 mb-3">
            <h3 class="mb-4">Produkt {{ $loop->iteration }}</h3>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="productName-{{ $key }}" name="products[{{ $product->id }}][name]" placeholder="productName" value="{{ $product->name }}">
                <label for="productName-{{ $key }}">Název</label>
            </div>
            <div class="form-floating mb-3">
                @php
                $price = 'products.'.$product->id.'.price'
                @endphp
                <input type="text" class="form-control @error('products.'.$product->id.'.price') is-invalid @enderror"
                    id="productPrice-{{ $key }}"
                    name="products[{{ $product->id }}][price]"
                    placeholder="productPrice"
                    value="{{ $product->price }}">
                    {{-- value="{{ old($price, optional($product->price ?? null)->price) }}"> --}}
                    {{-- value="{{ optional($product->manufacturer ?? null) }}"> --}}
                    {{-- {{ optional($product->manufacturer ?? null)->name =='safasf' ? 'selected' : '' }}> --}}
                @error('products.'.$product->id.'.price')
                    <div class="invalid-feedback" id="productPrice-{{ $key }}">{{ $message }}</div>
                @enderror
                <label for="productPrice-{{ $key }}">Cena</label>
            </div>
            <div class="form-floating mb-3">
                @php
                $oldPrice = 'products.'.$product->id.'.oldPrice'
                @endphp
                <input type="text" class="form-control @error($oldPrice) {{ old($oldPrice) == null ? '' : 'is-invalid' }}@enderror" id="productOldPrice-{{ $key }}"
                    name="products[{{ $product->id }}][oldPrice]"
                    placeholder="{{ $product->old_price == null ? 'old-price' : $product->old_price }}"
                    value="{{$product->old_price }}"
                    aria-describedby="productOldPrice-{{ $key }}">
                @error($oldPrice)
                <div class="invalid-feedback" id="productPrice-{{ $key }}">{{ $message }}</div>
                @enderror
                <label for="productOldPrice-{{ $key }}">Původní cena</label>
            </div>
            <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="description-{{ $key }}"
                    name="products[{{ $product->id }}][description]"
                    placeholder="description"
                    style="height: 300px">{{ $product->description }}
                </textarea>
                <label for="description-{{ $key }}">Popis produktu</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="productUrl-{{ $key }}"
                    name="products[{{ $product->id }}][url]"
                    placeholder="productUrl"
                    value="{{ $product->url }}">
                <label for="producUrl-{{ $key }}">Odkaz na produkt</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="manufacturer-{{ $key }}" name="products[{{ $product->id }}][manufacturer]">
                    @foreach ($manufacturers as $manufacturer)
                    <option value="{{ $manufacturer->id }}" {{ optional($product->manufacturer ?? null)->name == $manufacturer->name ? 'selected' : '' }}>{{ $manufacturer->name }}</option>
                    {{ $manufacturer->name }}
                    @endforeach
                </select>
                <label for="manufacturer-{{ $key }}">Výrobce</label>
            </div>
            <div class="row mb-3">
                <div class="col-4 m-auto {{ $product->img_url == null ? 'd-none' : '' }}">
                    <img class="img-thumbnail" src="{{ $product->img_url }}" alt="" >
                </div>
                <div class="mb-3 col-8">
                    <label for="productImage-{{ $key }}" class="form-label">{{ $product->img_url == null ? 'Vložit obrázek' : 'Vložit jiný obrázek' }}</label>
                    <input class="form-control form-control-sm" type="file" id="productImage-{{ $key }}" name="products[{{ $product->id }}][newImage]">
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class=" text-center mb-4"><input type="submit" value="Uložit" class="btn btn-success"></div>
</form>
@foreach ($errors->all() as $error)
    {{ $error }}<br/>
@endforeach


@endsection