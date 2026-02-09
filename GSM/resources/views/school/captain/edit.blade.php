@extends('school.layouts.master')
@section('title', 'Update Section Captain')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-light">
            <h5>Update Captain</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('school.captain.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                     {{-- School Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">School Name</label>
                        <input type="text" class="form-control"
                               value="{{ $student->school->school_name ?? 'N/A' }}" disabled>
                        <input type="hidden" name="school_id" value="{{ $student->school_id }}">
                    </div>
                    {{-- Select Class --}}
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Class</label>
                        <select name="class_id" id="class_id" class="form-select form-control">
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Section --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Section</label>
                        <select name="section_id" id="section_id" class="form-select form-control">
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $student->section_id == $section->id ? 'selected' : '' }}>
                                    {{ $section->section_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select Student --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select form-control">
                            @foreach($students as $std)
                                <option value="{{ $std->id }}" {{ $student->id == $std->id ? 'selected' : '' }}>
                                    {{ $std->student_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-sync-alt"></i> Update Captain
                </button>
                <a href="{{ route('school.captain.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

{{-- AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').html('<option>Loading...</option>');
        $.get('/school/get-sections/' + class_id, function(data) {
            var options = '<option value="">-- Select Section --</option>';
            data.forEach(function(section) {
                options += '<option value="' + section.id + '">' + section.section_name + '</option>';
            });
            $('#section_id').html(options);
            $('#student_id').html('<option value="">-- Select Student --</option>');
        });
    });

    $('#section_id').change(function() {
        var section_id = $(this).val();
        $('#student_id').html('<option>Loading...</option>');
        $.get('/school/get-students/' + section_id, function(data) {
            var options = '<option value="">-- Select Student --</option>';
            data.forEach(function(student) {
                options += '<option value="' + student.id + '">' + student.student_name + '</option>';
            });
            $('#student_id').html(options);
        });
    });
});
</script>
@endsection
