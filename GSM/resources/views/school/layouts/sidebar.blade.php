<ul class="navbar-nav bg-color sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: green;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            {{-- <img src="{{ asset('img/logo.jpeg') }}" alt="logo"
                style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;"> --}}
        </div>
        <div class="sidebar-brand-text " style="font-size: 1rem; font-weight: 800;">
            {{-- Green Schools Morocco --}}
            Green Schools Morocco
        </div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
         <a class="nav-link" href="{{route('school.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
   <li class="nav-item">
    <a class="nav-link" href="{{ route('school.captain.index') }}">
        <i class="fas fa-user-check"></i>
        <span>Assign Captain</span>
    </a>
</li>

 
    <!-- Nav Item - Pages Collapse Menu -->
    
    <!--class-->
 <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClasses"
            aria-expanded="true" aria-controls="collapseClasses">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Class</span>
        </a>
        <div id="collapseClasses" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Schools:</h6> --}}

                <a class="collapse-item" href="{{ route('school.class.create') }}">
                  <i class="fas fa-plus-circle"></i> Add Class
                </a>

                <a class="collapse-item" href="{{ route('school.class.index') }}">
                   <i class="fas fa-list-ul"></i> Class List
                </a>

            </div>
        </div>
    </li>
  
   
<!--section-->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSection"
        aria-expanded="true" aria-controls="collapseSection">
        <i class="fas fa-layer-group"></i>
        <span>Sections</span>
    </a> 
    <div id="collapseSection" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
             <h6 class="collapse-header">Manage Sections:</h6>
            <a class="collapse-item" href="{{ route('school.section.create') }}">
                <i class="fas fa-plus-circle"></i> Add Section
            </a>
            <a class="collapse-item" href="{{ route('school.section.index') }}">
                <i class="fas fa-list-ul"></i> Section List
            </a>
        </div>
    </div>
</li>


<!--students-->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
        aria-expanded="true" aria-controls="collapseStudents">
        <i class="fas fa-user-graduate"></i>  
        <span>Students</span>
    </a>
    <div id="collapseStudents" class="collapse" aria-labelledby="headingStudents" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Students:</h6>
            <a class="collapse-item" href="{{ route('school.students.create') }}">
                <i class="fas fa-user-plus"></i> Add Student
            </a>
            <a class="collapse-item" href="{{ route('school.students.index') }}">
                <i class="fas fa-users"></i> Student List
            </a>
        </div>
    </div>
</li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
