<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="BSF" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Golden West College</span>
    </a>
    <div class="sidebar">
        @auth
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(Auth::user()->avatar()) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    @if (Auth::user()->student)
                        {{ Auth::user()->student->student->first_name }}
                    @elseif (Auth::user()->faculty)
                        {{ Auth::user()->faculty->faculty->first_name }}
                    @endif
                    ({{ Auth::user()->role->role->name }})
                </a>
            </div>
        </div>
        @endauth
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Register
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>
                                Login
                            </p>
                        </a>
                    </li>
                @endguest
                @auth
                    {{-- @if(Auth::user()->hasrole('System Administrator') || Auth::user()->hasrole('Administrator'))
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @endif --}}
                    @can('evaluations.index')
                    <li class="nav-item">
                        <a href="{{ route('evaluations.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-poll-people"></i>
                            <p>
                                Evaluations
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('students.index')
                    <li class="nav-item">
                        <a href="{{ route('students.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>
                                Students
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('faculties.index')
                    <li class="nav-item">
                        <a href="{{ route('faculties.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Faculties
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('classes.index')
                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-class"></i>
                            <p>
                                Classes
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('courses.index')
                    <li class="nav-item">
                        <a href="{{ route('courses.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Courses
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('departments.index')
                    <li class="nav-item">
                        <a href="{{ route('departments.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-network-wired"></i>
                            <p>
                                Departments
                            </p>
                        </a>
                    </li>
                    @endcan
                    @can('users.index')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-lock"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    @endcan
                    @canany('questions.index', 'questions_groups.index')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>
                                Question Mangement
                                <i class="fas fa-angle-left right"></i>
                                {{-- <span class="badge badge-info right">6</span> --}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('questions.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Questions</p>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    @endcanany
                    @canany('roles.index', 'permission.index')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Configuration
                                <i class="fas fa-angle-left right"></i>
                                {{-- <span class="badge badge-info right">6</span> --}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('roles.index')
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles/Permissions</p>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li> --}}
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>