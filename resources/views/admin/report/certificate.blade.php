@extends('layouts.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="text-center">Certificate</h4>
                            </div>
                            @php
                                $user = \App\Models\User::find($certificate[0]->teacher_id);
                            @endphp
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <div class=" border border-dark p-1">
                                            {{$user->name}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Gender</label>
                                        <div class="border border-dark p-1">
                                           {{$user->gender}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Qualification</label>
                                        <div class=" border border-dark p-1">
                                            {{$user->qualification}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>CNIC</label>
                                        <div class="border border-dark p-1">
                                           {{$user->cnic}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Organization</label>
                                        <div class=" border border-dark p-1">
                                            {{$user->organization}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Designation</label>
                                        <div class="border border-dark p-1">
                                           {{$user->designation}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <div class=" border border-dark p-1">
                                            {{$user->email}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Phone</label>
                                        <div class="border border-dark p-1">
                                           {{$user->phone}}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header">
                                    <h4 class="text-center">Educational Detail</h4>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                                        <thead>
                                            <tr>
                                                <th> Subject</th>
                                                <th> Chapter</th>
                                                <th> Total Marks</th>
                                                <th> Obtain Marks</th>
                                                <th> Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($certificate as $key => $data)
                                            
                                                <tr>
                                                    <td>{{$data->subject->name ?? ''}}</td>
                                                    <td>{{$data->chapter->name ?? ''}}</td>
                                                    <td>100</td>
                                                    <td>{{$data->score}}</td>
                                                    <td>{{$data->score}}%</td>
                                                    
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="fw-bold">{{100*$count}}</td>
                                                    <td class="fw-bold">{{$obtain}}</td>
                                                    <td class="fw-bold">{{round($obtain/$count)}}%</td>
                                                    
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a class="btn-info p-1 mt-4 float-right" href="#" id="pdf">print</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
@section('footer.script')
    <script>
        $(document).ready(function(){
            $(document).on('click','#pdf', function(event){
              $('.main-header-right').hide();
                $('.main-nav').hide()
                $('.right_main').css('margin-left', 0)
                $('#pdf').hide();
                window.print();
                $('.main-header-right').show();
                $('.main-nav').show()
                $('.right_main').css('margin-left', '255px')
                $('#pdf').show();

            });

        });
    </script>
@endsection