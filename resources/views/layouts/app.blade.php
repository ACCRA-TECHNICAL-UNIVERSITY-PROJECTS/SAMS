<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.header')
    @include('includes.styles')
</head>

<body>
    <div class="container-fluid" style="padding-top: 120px;">
        <div class="row">
            <!-- Navbar -->
            <div class="col-md-12">
                @include('includes.navbar')
            </div>
        </div>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <!-- Content -->
            <div class="col-md-9">
                <div>
                    @yield('content')
                </div>
            </div>

        </div>
    </div>
</body>

</html>
