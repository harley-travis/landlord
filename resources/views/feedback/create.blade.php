@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">Send Feedback</div>

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('feedback.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('feedback.add') }}" method="post">

                        <div class="form-group">
                            <label for="subject">Subject <small class="text-danger pl-2">required</small></label>
                            <input type="text" class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" name="subject" aria-describedby="subject" placeholder="Enter subject line" value="{{ old('subject') }}">
                            @error('subject')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
							<label for="description">Description <small class="text-danger pl-2">required</small></label>
							<textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="8">{{ old('description') }}</textarea>
                            @error('description')
                            <span class='invalid-feedback'>{{ $message }}</span>
                            @enderror
                        </div>

                        
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}" />


                        @csrf

                        <button type="submit" class="btn btn-success shadow">Send Feedback</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
