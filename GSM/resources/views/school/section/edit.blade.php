@extends('school.layouts.master')
@section('title', 'Edit Section')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Edit Section</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('school.section.update', $section->id) }}">
                @csrf
                @method('PUT')
                {{-- School --}}
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <input type="text" class="form-control" value="{{ $school->school_name }}" disabled>
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                </div>

                {{-- Class --}}
                <div class="mb-3">
                    <label class="form-label">Select Class</label>
                    <select name="class_id" class="form-select form-control" >
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ $class->id == $section->class_id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section Name --}}
                <div class="mb-3">
                    <label class="form-label">Section Name</label>
                    <input type="text" name="section_name" class="form-control @error('section_name') is-invalid @enderror" value="{{ $section->section_name }}" >
                    @error('section_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                     @if(session('section_exists_error'))
                    <div class="text-danger">{{session('section_exists_error')}}</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Update Section</button>
                <a href="{{ route('school.section.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
