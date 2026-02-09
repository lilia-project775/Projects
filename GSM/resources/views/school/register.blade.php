{{-- @extends('Patient.layouts.master')

@section('content') --}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    body {
        background-color: #f2f6fc;
        font-family: 'Poppins', sans-serif;
    }

    .registration-card {
        background: #ffffff;
        border: 1px solid #e0e6ed;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 40px 35px;
        margin-top: 60px;
        transition: all 0.3s ease;
    }

    .registration-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    h3 {
        color: #1a237e;
        font-weight: 600;
        text-align: center;
        margin-bottom: 10px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control, .form-select, textarea {
        border-radius: 10px;
        border: 1px solid #ccd6e0;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 0.15rem rgba(26, 115, 232, 0.25);
    }

    .btn-primary {
        background-color: #1a73e8;
        border: none;
        border-radius: 10px;
        padding: 10px 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #155fc0;
        transform: translateY(-2px);
    }

    small.text-danger {
        font-size: 0.85rem;
    }

    hr {
        border-top: 2px solid #e0e6ed;
        margin-bottom: 25px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="registration-card">
                <h3>🩺 Patient Registration</h3>
                <hr>

                <form action="" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter first name" value="{{ old('first_name') }}">
                            @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter last name" value="{{ old('last_name') }}">
                            @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date of Birth *</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Gender *</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Blood Group</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Enter full address">{{ old('address') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-5">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- @endsection --}}
