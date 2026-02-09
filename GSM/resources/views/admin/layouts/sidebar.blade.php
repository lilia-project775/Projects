<ul class="navbar-nav bg-color sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:green;" >

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
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <!--<hr class="sidebar-divider">-->


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchool"
            aria-expanded="true" aria-controls="collapseSchool">
            <i class="fas fa-fw fa-school"></i>
            <span>Schools</span>
        </a>
        <div id="collapseSchool" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Schools:</h6>
                 <a class="collapse-item" href="{{ route('admin.schools.create') }}">
                    <i class="fas fa-plus-circle"></i> Add School
                    </a>
                    <a class="collapse-item" href="{{ route('admin.schools.index') }}">
                        <i class="fas fa-school"></i> School List
                    </a>

            </div>
        </div>
    </li>

  <!--class-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClasses"
            aria-expanded="true" aria-controls="collapseClasses">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Class</span>
        </a>
        <div id="collapseClasses" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Manage Classes:</h6>
                <a class="collapse-item" href="{{ route('admin.classes.create') }}">
                    <i class="fas fa-plus-circle"></i> Add Class
                </a>

                <a class="collapse-item" href="{{ route('admin.classes.index') }}">
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
            <a class="collapse-item" href="{{ route('admin.section.create') }}">
                <i class="fas fa-plus-circle"></i> Add Section
            </a>
            <a class="collapse-item" href="{{ route('admin.section.index') }}">
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
            <a class="collapse-item" href="{{ route('admin.students.create') }}">
                <i class="fas fa-user-plus"></i> Add Student
            </a>
            <a class="collapse-item" href="{{ route('admin.students.index') }}">
                <i class="fas fa-users"></i> Student List
            </a>
        </div>
    </div>
</li>

    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBaseline"
        aria-expanded="true" aria-controls="collapseBaseline">
        <i class="fas fa-chart-line"></i>
        <span>Monthly Baseline</span>
    </a>
    
    <div id="collapseBaseline" class="collapse" aria-labelledby="headingBaseline" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Baselines:</h6>
            <a class="collapse-item" href="{{ route('admin.baseline.create') }}">
                <i class="fas fa-plus-circle"></i> Add Baseline
            </a>

            <a class="collapse-item" href="{{ route('admin.baseline.index') }}">
                <i class="fas fa-list-ul "></i> Baseline List
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
