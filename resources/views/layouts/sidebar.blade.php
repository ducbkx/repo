@php
$isAdmin = auth()->check() && auth()->user()->is_admin;
@endphp

<div class="navbar-default sidebar" role="navigation" >
    <div class="sidebar-nav navbar-collapse">
       <ul class="nav" id="side-menu">
            <li><a href="{{ route('home') }}"> Home</a></li>
            
            @if(!$isAdmin)
            <li><a href="{{ route('information') }}"> Information</a></li>

            @else
            <li>

                <a href="{{ route('user.index') }}"> List Emloyee</a>
            </li>

            <li>

                <a href="{{ route('users.create') }}">Create Employee</a>

            </li>

            <li>

                <a href="{{ route('showDivision') }}">Division</a>

            </li>


            <li>
                <a href="{{ route('division.create') }}">Create Division</a>
            </li>
            @endif
            
            <li>
                <a href="{{ route('user.employee') }}">Subordinate</a>
            
            </li>
            
            <li>
                <a href="{{ route('users.password.postChange') }}">Change Password</a>
            </li>
            
            
            <li>
                <a href="{{ route('excel') }}"> Export Excel</a>
                
            </li>
            
            <li>
                <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
            </li>

        </ul>


    </div>


</div>