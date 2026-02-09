@extends('school.layouts.master')
@section('title', 'Edit Student')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Edit Student</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('school.students.update', $student->id) }}">
                @csrf
                @method('PUT')

                {{-- School (Fixed) --}}
                <div class="mb-3">
                    <label class="form-label">School Name</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->school->school_name }}" disabled>
                    <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                </div>

                {{-- Class --}}
                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-select form-control @error('class_id') is-invalid @enderror">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Section --}}
                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <select name="section_id" id="section_id" class="form-select form-control @error('section_id') is-invalid @enderror">
                        <option value="">Select Section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ $student->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->section_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('section_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Student Name --}}
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" value="{{ $student->student_name }}" class="form-control @error('student_name') is-invalid @enderror">
                    @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ $student->phone }}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $student->email }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" name="password" value="{{ $student->password_words }}" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
 
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('school.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

{{-- AJAX Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#class_id').on('change', function() {
    let class_id = $(this).val();
    $('#section_id').html('<option value="">Loading...</option>');
    if (class_id) {
        $.get('/school/students/get-sections/' + class_id, function(data) {
            $('#section_id').empty().append('<option value="">Select Section</option>');
            $.each(data, function(key, value) {
                $('#section_id').append('<option value="' + value.id + '">' + value.section_name + '</option>');
            });
        });
    } else {
        $('#section_id').html('<option value="">Select Section</option>');
    }
});
</script>
@endsection
