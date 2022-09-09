@extends('layouts.master')
@section('content')
@can('mortage_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.balloon_create') }}">
            {{ trans('Add Loan') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('Commercial Loan') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Loan Amount</th>
                        <th>Down Payment</th>
                        <th>Percentage</th>
                        <th>Balloon Period</th>
                        <th>Terms</th>
                        <th>Start date</th>
                        <th>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($balloon as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->user->name}}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->downpayment}}</td>
                        <td>{{$data->percentage}}</td>
                        <td>{{$data->balloon_period}}&nbspyear</td>
                        <td>{{$data->loan_terms}}&nbspyear</td>
                        <td>{{$data->starttime}}</td>
                        <td>
                            <div style="display: flex;">
                                <div>
                                    <a  href="{{url('admin/balloon_delete/'.$data->id)}}" type="button" class="btn btn-xs btn-danger mt-1">Delete</a>
                                </div>
                                <div>
                                    <form action="{{ route('admin.balloon_summary')}}" method="get">
                                        @csrf
                                        <input type="hidden" name="id" id="" value="{{$data->id ?? '' }}">
                                        <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Summary</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
