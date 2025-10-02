@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Lawyer Registration') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mobile Field -->
                            <div class="row mb-3">
                                <label for="mobile"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Mobile Number') }}</label>
                                <div class="col-md-6">
                                    <input id="mobile" type="text"
                                        class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                        value="{{ old('mobile') }}" required autocomplete="mobile">
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Chamber Field -->
                            <div class="row mb-3">
                                <label for="chamber_no" class="col-md-4 col-form-label text-md-end">Chamber No</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('chamber_no') is-invalid @enderror"
                                        id="chamber_no" name="chamber_no" value="{{ old('chamber_no') }}">

                                    @error('chamber_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Chamber address Field -->
                            <div class="row mb-3">
                                <label for="chamber_address"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Chamber Address') }}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address"
                                        value="{{ old('address') }}" required autocomplete="address">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>


                            <!-- Bar Number Field -->
                            <div class="row mb-3">
                                <label for="bar_number"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Bar Association Number') }}</label>
                                <div class="col-md-6">
                                    <input id="bar_number" type="number"
                                        class="form-control @error('bar_number') is-invalid @enderror" name="bar_number"
                                        value="{{ old('bar_number') }}" required autocomplete="bar_number">
                                    @error('bar_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
