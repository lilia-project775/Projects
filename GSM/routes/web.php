<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ClassController;
use App\Http\Controllers\admin\BaselineController;
use App\Http\Controllers\admin\AdminSectionController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\SchoolController; 
use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\admin\PerformanceController;
use App\Http\Controllers\admin\DomainTargetController;
use App\Http\Controllers\admin\AdminDashboardcontroller;
use App\Http\Controllers\student\StudentActionController;
use App\Http\Controllers\student\StudentProfileController;
use App\Http\Controllers\student\StudentDashboardController;
use App\Http\Controllers\school\SchoolDashboardController;
use App\Http\Controllers\school\ClassSchoolPanelController;
use App\Http\Controllers\school\SchoolPanelPerformanceController;
use App\Http\Controllers\school\SchoolSectionController;
use App\Http\Controllers\school\SchoolStudentController;
use App\Http\Controllers\school\SchoolProfileController;
use App\Http\Controllers\school\CaptainController;

Route::get('/', function () {
    return view('auth.login');
});
  
// Route::prefix('patient')->group(function(){
//     Route::get('/register',[PatientRegisterController::class,'showRegisterForm'])->name('patients.register.form');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// custom auth 
Route::get('register', function () {
    return view('auth.register');
})->name('register')->middleware(middleware: 'redirect.role');

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'userLogin'])->name('user.login');
});

//  admin panel routes
Route::prefix('admin')->as('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('dashboard', [AdminDashboardcontroller::class, 'index'])->name('dashboard');
    Route::get('school-wise-performance-filter', [AdminDashboardcontroller::class, 'schoolWisePerformancefilter'])->name('school.wise.performance.filter');

        Route::resource('schools', SchoolController::class);
        Route::resource('targets', DomainTargetController::class);
        Route::get('performance/{school}', [PerformanceController::class, 'calculateSchoolPerformance'])
            ->name('performance.show');
        Route::resource('classes', ClassController::class);
        Route::resource('baseline', BaselineController::class); 
        Route::resource('section', AdminSectionController::class);
        Route::get('get-classes/{school_id}', [AdminSectionController::class, 'getClasses'])->name('get-classes');
        Route::resource('students', StudentController::class);
        Route::get('students/get-classes/{school_id}', [StudentController::class, 'getClasses']);
        Route::get('students/get-sections/{class_id}', [StudentController::class, 'getSections']);
        
            });
            
            
 //  school panel routes
Route::prefix('school')->as('school.')
    ->middleware(['auth', 'verified', 'role:school'])->group(function () {
        Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');
        Route::resource('class', ClassSchoolPanelController::class);
        
        // profile
        Route::get('profile/show', [SchoolProfileController::class, 'schoolProfile'])->name('profile.show');
       Route::get('/profile/edit', [SchoolProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [SchoolProfileController::class, 'updateProfile'])->name('profile.update');
         
        // class performace
        Route::get('class/performance/{school}', [SchoolPanelPerformanceController::class, 'calculateClassPerformance'])->name('performance.show');
        Route::get('section/performance/{section}', [SchoolPanelPerformanceController::class, 'calculateSectionPerformance'])->name('section.performance.show');
        Route::get('student/performance/{section}', [SchoolPanelPerformanceController::class, 'showStudentPerformance'])->name('student.performance.show');
         
            Route::resource('section', SchoolSectionController::class);
            Route::resource('students', SchoolStudentController::class);
             Route::get('students/get-sections/{class_id}', [SchoolStudentController::class, 'getSections']);
             
   Route::get('assign-captain', [CaptainController::class, 'index'])->name('captain.index');
    Route::get('get-sections/{class_id}', [CaptainController::class, 'getSections']);
    Route::get('get-students/{section_id}', [CaptainController::class, 'getStudents']);
    Route::post('assign-captain', [CaptainController::class, 'assign'])->name('captain.assign');
    Route::get('captain/{id}/edit', [CaptainController::class, 'edit'])->name('captain.edit');
    Route::put('captain/{id}', [CaptainController::class, 'update'])->name('captain.update');
    Route::delete('captain/{id}', [CaptainController::class, 'remove'])->name('captain.remove');
    
    });
    
 
//  student panel routes
Route::prefix('student')->as('student.')
    ->middleware(['auth', 'verified', 'role:student'])->group(function () {
        Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('actions', StudentActionController::class);
        Route::get('actions/{id}', [StudentActionController::class, 'show'])->name('student.actions.show');

    // student profile
    Route::get('/profile', [StudentProfileController::class, 'studentProfile'])->name('profile.show');
    Route::get('/profile/edit/{id}', [StudentProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update/{id}', [StudentProfileController::class, 'updateProfile'])->name('profile.update');

         
    });
 
 

 
