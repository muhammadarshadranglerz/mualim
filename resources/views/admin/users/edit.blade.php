@extends('layouts.master')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('Edit Teacher') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', [$user->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">Teacher Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $user->name) }}" required>
                    @if ($errors->has('name'))
                        <div class="txt-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="gender">Gender</label>
                    <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender"
                        id="gender" required>
                        <option value="Male" @if ($user->gender == 'Male') selected @endif>Male</option>
                        <option value="Female" @if ($user->gender == 'Female') selected @endif>Female</option>
                    </select>
                    @if ($errors->has('gender'))
                        <div class="txt-danger">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required" for="instituion">Institution</label>
                    <input class="form-control {{ $errors->has('instituion') ? 'is-invalid' : '' }}" type="text"
                        name="instituion" id="instituion" value="{{ $user->instituion }}" required>
                    @if ($errors->has('instituion'))
                        <div class="txt-danger">
                            {{ $errors->first('instituion') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="district">District</label>
                    <input class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" type="text"
                        name="district" id="district" value="{{ $user->district }}" required>
                    @if ($errors->has('district'))
                        <div class="txt-danger">
                            {{ $errors->first('district') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="province">Province</label>
                    <select class="form-control select2" name="province" id="province" required>
                        <option selected disabled>Select Province</option>
                        <option value="Punjab" @if ($user->province == 'Punjab') selected @endif>Punjab</option>
                        <option value="Sindh" @if ($user->province == 'Sindh') selected @endif>Sindh</option>
                        <option value="Balochistan" @if ($user->province == 'Balochistan') selected @endif>Balochistan</option>
                        <option value="Khyber Pakhtunkhwa" @if ($user->province == 'Khyber Pakhtunkhwa') selected @endif>Khyber
                            Pakhtunkhwa</option>
                        <option value="Islamabad Capital Territory" @if ($user->province == 'Islamabad Capital Territory') selected @endif>
                            Islamabad Capital Territory</option>
                        <option value="Azad Jammu and Kashmir and Gilgit-Baltistan"
                            @if ($user->province == 'Azad Jammu and Kashmir and Gilgit-Baltistan') selected @endif>Azad Jammu and Kashmir and
                            Gilgit-Baltistan</option>
                    </select>
                    @if ($errors->has('province'))
                        <div class="txt-danger">
                            {{ $errors->first('province') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="designation">Designation</label>
                    <select class="form-control select2" name="designation" id="designation" required>
                        <option {{ $user->designation == 'Teacher' ? 'selected' : '' }}>Teacher</option>
                        <option {{ $user->designation == 'District Officer' ? 'selected' : '' }}>District Officer
                        </option>
                        <option {{ $user->designation == 'District Manager' ? 'selected' : '' }}>District Manager
                        </option>
                        <option {{ $user->designation == 'Manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                    @if ($errors->has('designation'))
                        <div class="txt-danger">
                            {{ $errors->first('designation') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="phone">Phone</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text"
                        name="phone" id="phone" value="{{ $user->phone }}" oninput="maxLengthPhone(this)"
                        maxlength="13" required>
                    @if ($errors->has('phone'))
                        <div class="txt-danger">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                        name="email" id="email" value="{{ old('email', $user->email) }}">
                    @if ($errors->has('email'))
                        <div class="txt-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                        name="password" id="password">
                    @if ($errors->has('password'))
                        <div class="txt-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]"
                        id="roles" multiple required>
                        @foreach ($roles as $id => $role)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('roles', [])) || $user->roles->contains($id) ? 'selected' : '' }}>
                                {{ $role }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <div class="txt-danger">
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="qualification">Qualification</label>
                    <select class="form-control select2" name="qualification" id="qualification" required>
                        <option {{ $user->qualification == 'Matric' ? 'selected' : '' }}>Matric</option>
                        <option {{ $user->qualification == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option {{ $user->qualification == 'Bachlor' ? 'selected' : '' }}>Bachlor</option>
                        <option {{ $user->qualification == 'Master' ? 'selected' : '' }}>Master</option>
                    </select>
                    @if ($errors->has('qualification'))
                        <div class="txt-danger">
                            {{ $errors->first('qualification') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="experience">Experience</label>
                    <input class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}" type="number"
                        name="experience" id="experience" value="{{ $user->experience }}" required>
                    @if ($errors->has('experience'))
                        <div class="txt-danger">
                            {{ $errors->first('experience') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required" for="cnic">CNIC</label>
                    <input class="form-control {{ $errors->has('cnic') ? 'is-invalid' : '' }}" type="text"
                        name="cnic" id="cnic" value="{{ $user->cnic }}" maxlength="15" required>
                    @if ($errors->has('cnic'))
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
        function maxLengthPhone(object) {
            if (object.value.length > object.maxLength)
                object.value = object.value.slice(0, object.maxLength)
        }
    </script>
@endsection
