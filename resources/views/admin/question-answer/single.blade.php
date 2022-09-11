@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <h3 class="py-3">Q. {{ $question->question }}</h3>
                </div>
                <div class="col-md-3 col-6 active p-3">A. {{ $question->first_option }}</div>
                <div class="col-md-3 col-6 p-3">B. {{ $question->second_option }}</div>
                <div class="col-md-3 col-6 p-3">C. {{ $question->third_option }}</div>
                <div class="col-md-3 col-6 p-3">D. {{ $question->fourth_option }}</div>
            </div>
        </div>
    </div>
@endsection
