@extends('admin.layouts.master')
@section('title', 'Edit Class')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Edit Class</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.classes.update', $class->id) }}">
                @csrf 
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <select name="school_id" class="form-select form-control" >
                        <option value="">Select School</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ $class->school_id == $school->id ? 'selected' : '' }}>
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Class Name</label>
                    <input type="text" name="class_name" value="{{ $class->class_name }}" class="form-control @error('class_name') is-invalid @enderror" >
                      @error('class_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    @if(session('class_exists_error'))
                    <div class="text-danger">{{session('class_exists_error')}}</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-warning text-white">Update</button>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
