@extends('admin.layouts.master')
@section('title', 'Add Section')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-lg rounded-3">
        <div class="card-header custom-bg text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Section</h5>
            <a href="{{ route('admin.section.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Back to List
            </a>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('admin.section.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- SCHOOL DROPDOWN --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">School</label>
                        <select name="school_id" id="schoolSelect" class="form-control @error('school_id') is-invalid @enderror">
                            <option value="">-- Select School --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CLASS DROPDOWN --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Class</label>
                        <select name="class_id" id="classSelect" class="form-control @error('class_id') is-invalid @enderror">
                            <option value="">-- Select Class --</option>
                            @if(old('class_id'))
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" 
                                            {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('class_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SECTION NAME --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Section Name</label>
                        <input type="text" name="section_name" class="form-control @error('section_name') is-invalid @enderror"  value="{{ old('section_name') }}" placeholder="Enter Section Name">
                        @error('section_name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        
                         @if(session('section_exists_error'))
                    <div class="text-danger">{{session('section_exists_error')}}</div>
                    @endif
                    
                    
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Save Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- AJAX SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#schoolSelect').on('change', function() {
        let schoolId = $(this).val();
        $('#classSelect').empty().append('<option value="">-- Select Class --</option>');

        if (schoolId) {
            $.ajax({
                url: '/admin/get-classes/' + schoolId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(index, classItem) {
                        $('#classSelect').append('<option value="'+ classItem.id +'">'+ classItem.class_name +'</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
