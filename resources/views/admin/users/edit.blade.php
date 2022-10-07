@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('Edit Teacher') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Teacher Name</label>
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
                <label class="required" for="organization">Organization</label>
                <input class="form-control {{ $errors->has('organization') ? 'is-invalid' : '' }}" type="text" name="organization" id="organization" value="{{ $user->organization}}" required>
                @if($errors->has('organization'))
                    <div class="txt-danger">
                        {{ $errors->first('organization') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="designation">Designation</label>
                <select class="form-control select2" name="designation" id="designation"  required>
                    <option {{($user->designation == 'Teacher') ? 'selected' : ''}}>Teacher</option>
                    <option {{($user->designation == 'District Officer') ? 'selected' : ''}}>District Officer</option>
                    <option {{($user->designation == 'District Manager') ? 'selected' : ''}}>District Manager</option>
                    <option {{($user->designation == 'Manager') ? 'selected' : ''}}>Manager</option>
                </select>
                @if($errors->has('designation'))
                    <div class="txt-danger">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="phone">Phone</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{$user->phone }}" oninput="maxLengthPhone(this)" maxlength="13" required>
                @if($errors->has('phone'))
                    <div class="txt-danger">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label  for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}">
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
                <select class="form-control select2" name="qualification" id="qualification" required>
                    <option {{($user->qualification == 'Matric') ? 'selected' : ''}}>Matric</option>
                    <option {{($user->qualification == 'Intermediate') ? 'selected' : ''}}>Intermediate</option>
                    <option {{($user->qualification == 'Bachlor') ? 'selected' : ''}}>Bachlor</option>
                    <option {{($user->qualification == 'Master') ? 'selected' : ''}}>Master</option>
                </select>
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
                <input class="form-control {{ $errors->has('cnic') ? 'is-invalid' : '' }}" type="text" name="cnic" id="cnic" value="{{ $user->cnic }}" maxlength="15" required>
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
@section('footer.script')
<script>
    function maxLengthPhone(object)
    {
      if (object.value.length > object.maxLength)
        object.value = object.value.slice(0, object.maxLength)
    }
  </script>
@endsection