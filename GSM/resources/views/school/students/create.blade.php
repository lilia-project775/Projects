@extends('school.layouts.master')
@section('title', 'Add New Student')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header custom-bg text-white">
            <h5>Add New Student</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('school.students.store') }}">
                @csrf

                {{-- School (auto-filled & disabled) --}}
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <input type="text" class="form-control" 
                           value="{{ Auth::user()->school->school_name }}" disabled>
                    <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                </div>

                {{-- Class --}}
                <div class="mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" id="class_id" class="form-select form-control @error('class_id') is-invalid @enderror">
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                    @error('class_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Section --}}
                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <select name="section_id" id="section_id" class="form-select form-control @error('section_id') is-invalid @enderror">
                        <option value="">Select Section</option>
                    </select>
                    @error('section_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Student Name --}}
                <div class="mb-3">
                    <label class="form-label">Student Name</label>
                    <input type="text" name="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}">
                    @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Student Phone --}}
                <div class="mb-3">
                    <label class="form-label">Student Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">Save Student</button>
                <a href="{{ route('school.students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

{{-- AJAX for sections --}}
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
