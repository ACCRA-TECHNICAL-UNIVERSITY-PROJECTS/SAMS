<nav class="navbar navbar-expand-lg navbar-dark bg-dark col-lg-12 col-12 p-0 fixed-top py-3" style="background: linear-gradient(to right, #1e2a3a, #35424a);">
        <button class="navbar text-white bg-primary px-5" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="sidebarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand ml-auto" href="#">
                <img src="images/logo.jpeg" alt="School Logo" style="width: 120px; height: 80px; margin-right: 10px;">
                <h4 class="mb-0" style="color: #ffff; font-weight: bold; display: inline-block;">KADE TECHNICAL SHS</h4>
            </a>
            
        <div class="d-flex ml-auto">
            <div class="card text-white bg-primary ml-auto">
                <div class="card-body p-2">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ADM
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-user text-primary"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt text-primary"></i> Logout</a>
                            <form id="logout-form" action="" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card text-white bg-primary ml-2">
                <div class="card-body">
                    <h6 class="mb-0">Today : {{ now()->format('l, F j, Y') }}</h6>
                </div>
            </div>
        </div>
    </div>   
</nav>







