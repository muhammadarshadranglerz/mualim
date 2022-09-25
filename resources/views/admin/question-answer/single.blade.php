@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <h3 class="py-3">Q. {{ $question->question }}</h3>
                </div>
                <div class="col-md-3 col-6  p-3 @php echo $question->correct == 1 ?'txt-primary font-weight-bold':'';@endphp" >A. {{ $question->first_option }}</div>
                <div class="col-md-3 col-6 p-3 @php echo $question->correct == 2 ?'txt-primary font-weight-bold':'';@endphp">B. {{ $question->second_option }}</div>
                <div class="col-md-3 col-6 p-3 @php echo $question->correct == 3 ?'txt-primary font-weight-bold':'';@endphp">C. {{ $question->third_option }}</div>
                <div class="col-md-3 col-6 p-3 @php echo $question->correct == 4 ?'txt-primary font-weight-bold':'';@endphp">D. {{ $question->fourth_option }}</div>
                <hr>
                <div class="col-12">
                    <h4 class="">Details</h4>
                    <p>
                        {{ $question->details }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
