@extends('school.layouts.master')
@section('title', 'Assign Section Captain')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Assign Section Captain</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('school.captain.assign') }}" method="POST" id="captainForm">
                @csrf

                <div class="row">
                    {{-- School Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">School Name</label>
                        <input type="text" class="form-control"
                               value="{{ Auth::user()->school->school_name ?? 'N/A' }}" disabled>
                        <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                    </div>

                    {{-- Select Class --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Class</label>
                        <select name="class_id" id="class_id" class="form-select form-control" >
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select Section --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Section</label>
                        <select name="section_id" id="section_id" class="form-select form-control" >
                            <option value="">-- Select Section --</option>
                        </select>
                        @error('section_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Select Student --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select form-control" >
                            <option value="">-- Select Student --</option>
                        </select>
                        @error('student_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-1"></i> Assign as Section Captain
                    </button>
                    <a href="{{ route('school.dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- AJAX Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Load sections based on selected class
    $('#class_id').change(function() {
        var class_id = $(this).val();
        $('#section_id').html('<option>Loading...</option>');
        $.get('/school/get-sections/' + class_id, function(data) {
            var options = '<option value="">-- Select Section --</option>';
            data.forEach(function(section) {
                options += '<option value="' + section.id + '">' + section.section_name + '</option>';
            });
            $('#section_id').html(options);
        });
    });

    // Load students based on selected section
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
