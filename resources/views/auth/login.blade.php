@extends('layouts.app')
@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="d-grid gap-2 col-6 mx-auto mt-5"> 
            <div class="mb-3">
                <label>E-mail</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"" name="email" value="{{ old('email')}}" required>
                @if ($errors->has('email'))
                    <span class=" invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"" type="password" name="password" required>
                @if ($errors->has('password'))
                    <span class=" invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="mb-3">
                <div class=" form-check">
                    <input class=" form-check-input" type="checkbox" name="remember" value="{{ old('remember') ? 'checked' : '' }}">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
@endsection