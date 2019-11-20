@extends('layouts.app', ['page_title' => "Send Feedback"])

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Send Feedback</h3>
                        </div>
                        <div class="col-4 text-right">
                            
                        </div>
                    </div>
                </div>

                @if(Session::has('info'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>{{ Session::get('info') }}</p>
                    </div>
                @endif

                <div class="card-body">

                    <form action="{{ route('feedback.add') }}" method="post">

                        <p>Thank you for taking time out of your day to let us know how we can improve our app. Let us know how we can be better so that we can meet your needs.</p>

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

    @include('layouts.footers.auth')
</div>
@endsection
