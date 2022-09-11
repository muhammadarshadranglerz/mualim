@extends('layouts.master')
@section('content')
    @can('user_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                    {{ trans('Add User') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('User') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                        <tr>
                            <th> #</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Phone</th>
                            <th> status</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name ?? '' }}</td>
                                <td>{{ $user->email ?? '' }}</td>
                                <td>{{ $user->phone ?? '' }}</td>
                                <td id="approval">
                                    @if ($user->action == 1)
                                        <a href="#" class="btn btn-xs btn-success">Active</a>
                                    @else
                                        <a href="#" class="btn btn-xs btn-danger">Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="media-body text-end icon-state switch-outline">
                                            <label class="switch">
                                                <input type="checkbox" id="{{ $user->id }}"
                                                    {{ $user->action == 1 ? 'checked' : '' }} class="status"><span
                                                    class="switch-state bg-primary"></span>
                                            </label>
                                        </div>

                                        <div>
                                            @can('user_edit')
                                                <a class="btn btn-xs btn-info"
                                                    href="{{ route('admin.users.edit', $user->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                        </div>
                                        <div>
                                            @can('user_delete')
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                                </form>
                                            @endcan
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).on('click', '.switch-state', function() {
        var id = $('.status').attr('id');
        // alert(id);
        $.ajax({
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            url: "{{ route('admin.status') }}",
            data: {
                'id': id
            },
            success: function(response) {
                $('#approval').empty();
                if (response.action == 0) {
                    $('#approval').append(`
                        <a href="#" class="btn btn-xs btn-danger">Deactive</a>
                        `);
                } else {
                    $('#approval').append(`
                        <a href="#" class="btn btn-xs btn-success">active</a>
                        `);
                }
            }
        });
    });
</script>
