@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Send Feedback</div>

                <div class="card-body">

                    <div class="mb-3 text-right">
                        <a href="{{ route('feedback.index') }}" class="btn btn-info text-white">Go Back</a>
                    </div>
                    
                    <form action="{{ route('feedback.add') }}" method="post">

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" aria-describedby="subject" placeholder="Enter subject line">
                        </div>

                        <div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" name="description" rows="8"></textarea>
						</div>

                        
                        <input type="hidden" name="user_id" value="" />
                        <input type="hidden" name="company_id" value="" />


                        @csrf

                        <button type="submit" class="btn btn-success">Send Request</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
