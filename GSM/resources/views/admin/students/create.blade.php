@extends('admin.layouts.master')
@section('title', 'Add Student')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Add New Student</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.students.store') }}">
                @csrf

                {{-- School --}}
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <select name="school_id" id="school_id" class="form-select form-control @error('school_id') is-invalid @enderror" >
                        <option value="">Select School</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->school_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Class --}}
                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-select form-control @error('class_id') is-invalid @enderror" >
                        <option value="">Select Class</option>
                    </select>
                    @error('class_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Section --}}
                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <select name="section_id" id="section_id" class="form-select form-control @error('section_id') is-invalid @enderror" >
                        <option value="">Select Section</option>
                    </select>
                    @error('section_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Student Name --}}
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}" >
                    @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                
                <!--phone-->
                <div class="mb-3">
                    <label class="form-label">Student Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" >
                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" >
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
 
                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" >
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

{{-- AJAX SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#school_id').on('change', function() {
        let school_id = $(this).val();
        $('#class_id').html('<option value="">Loading...</option>');
        $('#section_id').html('<option value="">Select Section</option>');
        if (school_id) {
            $.get('/admin/students/get-classes/' + school_id, function(data) {
                $('#class_id').empty().append('<option value="">Select Class</option>');
                $.each(data, function(key, value) {
                    $('#class_id').append('<option value="' + value.id + '">' + value.class_name + '</option>');
                });
            });
        } else {
            $('#class_id').html('<option value="">Select Class</option>');
        }
    });

    $('#class_id').on('change', function() {
        let class_id = $(this).val();
        $('#section_id').html('<option value="">Loading...</option>');
        if (class_id) {
            $.get('/admin/students/get-sections/' + class_id, function(data) {
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
