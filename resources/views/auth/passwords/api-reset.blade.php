@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ config('app.name') }}</h1>

                <p class="text-muted">{{ trans('global.reset_password') }}</p>

                <form method="GET" action="{{ url('api/password_change') }}">
                    @csrf

                    <input name="token" value="{{ $token }}" type="hidden">
                    <div class="form-group">
                        <input id="password" type="password" name="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required placeholder="{{ trans('global.login_password_confirmation') }}">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ trans('global.reset_password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection