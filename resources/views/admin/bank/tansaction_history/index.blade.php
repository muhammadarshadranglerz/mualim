@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Transaction History') }}
    </div>
    <div style="margin-left: 880px;">
        <form action="{{ route('admin.del_history')}}" method="post">
            @csrf
            <input type="hidden" name="bank_id" id="" value="{{$id}}">
            <button type="submit" class="btn btn-xs btn-dark mt-1 ml-3">Clear history</button>
        </form>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Purpose of Transaction</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->from}}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->status}}</td>
                        <td>{{$data->purpose}}</td>
                        <td>{{$data->date}}</td>

                    </tr>
                    @endforeach

                </tbody>


            </table>
        </div>
    </div>
</div>

@endsection
