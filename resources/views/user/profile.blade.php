@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Your Profile Data</div>
                <div class="card-body">

                        @if (count($errors) > 0)

                        <div class="alert alert-danger">
                        
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        
                            <ul>
                        
                                @foreach ($errors->all() as $error)
                        
                                    <li>{{ $error }}</li>
                        
                                @endforeach
                        
                            </ul>
                        
                        </div>
                        @endif
                    
                    <form method="POST" enctype="multipart/form-data" action="{{ route('profile') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ auth()->user()->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile" class="col-md-4 col-form-label text-md-right">Profile</label>

                            <div class="col-md-6">
                                <input id="profile" type="file" class="form-control{{ $errors->has('profile') ? ' is-invalid' : '' }}" name="image" autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Information
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>             
@endsection