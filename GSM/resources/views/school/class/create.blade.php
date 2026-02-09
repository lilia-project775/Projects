@extends('school.layouts.master')
@section('title', 'Add New Class')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Add New Class</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('school.class.store') }}">
                @csrf

                {{-- School Name (Disabled field) --}}
                <div class="mb-3">
                    <label class="form-label">School Name</label>
                    <input type="text" class="form-control" value="{{ $school->school->school_name }}" disabled>
                    <input type="hidden" name="school_id" value="{{ $school->school_id }}">
                </div>
                   
                {{-- Class Name --}}
                <div class="mb-3">
                    <label class="form-label">Class Name</label>
                    <input type="text" name="class_name" value="{{old('class_name')}}" class="form-control @error('class_name') is-invalid @enderror" >
                    
                    @error('class_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                      
                    @if(session('class_exists_error'))
                    <div class="text-danger">{{session('class_exists_error')}}</div>
                    @endif
                </div>


                <button type="submit" class="btn btn-success">Save Class</button>
                <a href="{{ route('school.class.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
