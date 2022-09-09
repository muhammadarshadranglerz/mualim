@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.mortage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.mortages.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">Customer</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                <div class="invalid-feedback">
                    {{ $errors->first('user') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="loandamoutn">{{ trans('Loan Amount') }}</label>
                <input class="form-control {{ $errors->has('loandamoutn') ? 'is-invalid' : '' }}" type="number" name="loandamoutn" id="loandamoutn" value="{{ old('loandamoutn', '') }}" step="1" required>
                @if($errors->has('loandamoutn'))
                <div class="invalid-feedback">
                    {{ $errors->first('loandamoutn') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.loandamoutn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="downpayment">{{ trans('cruds.mortage.fields.downpayment') }}</label>
                <input class="form-control {{ $errors->has('downpayment') ? 'is-invalid' : '' }}" type="number" name="downpayment" id="downpayment" value="{{ old('downpayment', '') }}" step="1" required>
                @if($errors->has('downpayment'))
                <div class="invalid-feedback">
                    {{ $errors->first('downpayment') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.downpayment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Interest rate') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="text" name="percentage" id="percentage" value="{{'1%'}}" step="1" required>
                @if($errors->has('percentage'))
                <div class="invalid-feedback">
                    {{ $errors->first('percentage') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.percentage_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="percentage">{{ trans('Terms') }}</label>
                <div class="slidecontainer">
                    <input type="range" min="1" max="20" value="1" name="loan_terms" class="slider" id="start_date">

                    <div class="term">
                        <p style="margin-left: 8px;" id="date"></p>
                        <p>years</p>
                    </div>
                </div>
            </div>

            <!-- <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.mortage.fields.start_date') }}</label>

                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"  >
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.mortage.fields.start_date_helper') }}</span>
            </div> -->
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('Start date') }}</label>
                <input class="form-control date" type="text" name="start_date" id="start_date" >

            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    var slider = document.getElementById("start_date");
    var output = document.getElementById("date");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    }
</script>
@endsection
