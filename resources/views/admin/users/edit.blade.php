@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Edit User') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @if($errors->has('name'))
                    <div class="txt-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gender">Gender</label>
                <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender"  required>
                        <option value="Male" @if ($user->gender == "Male")selected @endif>Male</option>
                        <option value="Female" @if ($user->gender == "Female")selected @endif>Female</option>
                </select>
                @if($errors->has('gender'))
                    <div class="txt-danger">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="subject">Subject</label>
                <select class="form-control select2 {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" name="subject_id" id="subject"  required>
                    @foreach($subject as $id => $subject)
                    <option value="{{ $id }}" @if($user->subject_id == $id)selected @endif>{{ $subject }}</option>
                @endforeach
                </select>
                @if($errors->has('subject_id'))
                    <div class="txt-danger">
                        {{ $errors->first('subject_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="organization">Organization</label>
                <input class="form-control {{ $errors->has('organization') ? 'is-invalid' : '' }}" type="text" name="organization" id="organization" value="{{ $user->organization}}" required>
                @if($errors->has('organization'))
                    <div class="txt-danger">
                        {{ $errors->first('organization') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="designation">designation</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ $user->designation }}" required>
                @if($errors->has('designation'))
                    <div class="txt-danger">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="phone">Phone</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{$user->phone }}" required>
                @if($errors->has('phone'))
                    <div class="txt-danger">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @if($errors->has('email'))
                    <div class="txt-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="txt-danger">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="txt-danger">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="qualification">Qualification</label>
                <input class="form-control {{ $errors->has('qualification') ? 'is-invalid' : '' }}" type="text" name="qualification" id="qualification" value="{{ $user->qualification }}" required>
                @if($errors->has('qualification'))
                    <div class="txt-danger">
                        {{ $errors->first('qualification') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="experience">Experience</label>
                <input class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}" type="number" name="experience" id="experience" value="{{ $user->experience }}" required>
                @if($errors->has('experience'))
                    <div class="txt-danger">
                        {{ $errors->first('experience') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="cnic">CNIC</label>
                <input class="form-control {{ $errors->has('cnic') ? 'is-invalid' : '' }}" type="text" name="cnic" id="cnic" value="{{ $user->cnic }}" required>
                @if($errors->has('cnic'))
                    <div class="txt-danger">
                        {{ $errors->first('cnic') }}
                    </div>
                @endif
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
