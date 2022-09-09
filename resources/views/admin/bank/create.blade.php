@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Add Bank') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{route('admin.bank_store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">Name</label>
                <input type="text" class="form-control"  name="name" id="name" required>
            </div>
            <div class="form-group">
                <label class="required" for="bank_name">Bank Name</label>
                <input type="text" class="form-control"  name="bank_name" id="bank_name" required>
            </div>
            <div class="form-group">
                <label class="required" for="loandamoutn">{{ trans('Total Balance') }}</label>
                <input class="form-control {{ $errors->has('total_balance') ? 'is-invalid' : '' }}" type="number" name="total_balance" id="loandamoutn"  step="1" required>
            </div>
    
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

