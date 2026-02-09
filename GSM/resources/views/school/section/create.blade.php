@extends('school.layouts.master')
@section('title', 'Add New Section')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Add New Section</h5>
        </div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('school.section.store') }}">
                @csrf
                {{-- School Name (Frozen) --}}
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <input type="text" class="form-control" value="{{ $school->school_name }}" disabled>
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                </div>

                {{-- Select Class --}}
                <div class="mb-3">
                    <label class="form-label">Select Class</label>
                    <select name="class_id" class="form-select form-control @error('class_id') is-invalid @enderror" >
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section Name --}}
                <div class="mb-3"> 
                    <label class="form-label">Section Name</label>
                    <input type="text" name="section_name" value="{{old('section_name')}}" class="form-control @error('section_name') is-invalid @enderror" >
                    @error('section_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    @if(session('section_exists_error'))
                    <div class="text-danger">{{session('section_exists_error')}}</div>
                    @endif
                    
                </div>

                <button type="submit" class="btn btn-success">Save Section</button>
                <a href="{{ route('school.section.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
