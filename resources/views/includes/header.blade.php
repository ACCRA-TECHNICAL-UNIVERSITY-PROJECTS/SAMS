<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SAMS</title>


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-9/yo9wSc6fapZfN1caEV3ZuYG2CjkOrK/Ep5Cn6CmCQZlqJKQcBLbJciykFx4uIb/uG4tfcIjzZW1DOmW7JMI5A=="
        crossorigin="anonymous" />

    <!-- Typicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typicons/2.0.10/typicons.min.css"
        integrity="sha512-3m4Wv8l7Qt9p7qBRohZlPm5bTsOLpBGRcaUxwL0c8FX9HKehaaGmq2MDW1SdolC1l6DTFJi86uyX63mZYYQVpA=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Add your additional stylesheets, scripts, or other head content here -->
    <style>
        body {
            padding-top: 56px;
            /* Adjust the top padding to match the height of your navbar */
        }

        @media (min-width: 768px) {
            body {
                padding-top: 0;
            }

            #sidebar {
                position: fixed;
                width: 250px;
                height: 100%;
                top: 0;
                left: 0;
                background-color: #fff;
                /* Set white background */
                color: #000;
                /* Set black text color */
                padding-top: 150px;
                /* Adjust the top padding to match the height of your navbar */
                transition: margin-left 0.3s;
                z-index: 1;
                /* Ensure the sidebar is above other content */
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
                /* Optional: Add a box shadow */
            }

            #sidebar ul li a:hover {
                background-color: #1E90FF;
                /* Hover color */
            }

            #sidebar.active {
                width: 55px;
            }

            #content {
                margin-left: 250px;
            }

            #sidebar.collapsed {
                margin-left: -250px;
            }
        }

        .sidebar-card {
            /* Additional styling for the card if needed */
        }

        .nav-link {
            color: #000 !important;
            /* Set black text color for links */
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #1E90FF;
        }
        
    </style>

</head>

<body>

    <!-- Include Bootstrap JS and Popper.js from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Add JavaScript to handle sidebar collapse/expand
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('collapsed');
            });
        });
    </script>
</body>

</html>
