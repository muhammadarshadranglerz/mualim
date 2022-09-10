@extends('layouts.master')
@section('content')
<div class="container-fluid">
    @php
        $user = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('title', 'User');
        })->count();
        $subjct = \App\Models\Subject::count();
    @endphp
    <div class="row">
        <div class="col-sm-6 col-xl-6 col-lg-6">
            <div class="card o-hidden border-0">
                <div class="bg-secondary b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
                        <div class="media-body">
                            <span class="m-0">Course</span>
                            <h4 class="mb-0 counter">{{$subjct}}</h4>
                            <i class="icon-bg" data-feather="shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6 col-lg-6">
            <div class="card o-hidden border-0">
                <div class="bg-primary b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                        <div class="media-body">
                            <span class="m-0">User</span>
                            <h4 class="mb-0 counter">{{$user}}</h4>
                            <i class="icon-bg" data-feather="user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent
@endsection
