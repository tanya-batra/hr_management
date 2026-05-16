<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sidebar-bg: #22252a;
            --sidebar-text: #8a909d;
            --sidebar-hover: #ffffff;
            --sidebar-active-bg: #2d3035;
            --theme-accent: #ff9800;
            --body-bg: #f4f7f6;
            --card-bg: #ffffff;
            --text-main: #333333;
        }

        body {
            background: var(--body-bg);
            font-family: 'Ubuntu', sans-serif;
            overflow-x: hidden;
            color: var(--text-main);
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
            border-bottom: 1px solid #2d3035;
            text-decoration: none;
        }

        .sidebar .brand img {
            width: 35px;
            margin-right: 10px;
        }

        .sidebar .brand i {
            color: var(--theme-accent);
            font-size: 28px;
            margin-right: 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: 0.3s;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar-menu a i {
            width: 25px;
            font-size: 18px;
            text-align: center;
            margin-right: 10px;
        }

        .sidebar-menu a:hover {
            color: var(--sidebar-hover);
        }

        .sidebar-menu a.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-hover);
            border-left: 4px solid var(--theme-accent);
        }

        .main-wrapper {
            margin-left: 260px;
            padding: 20px 30px;
            transition: all 0.3s ease;
        }

        .topbar {
            background: var(--card-bg);
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h5 {
            font-weight: 600;
            margin: 0;
        }

        .dashboard-card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: none;
            margin-bottom: 30px;
        }

        .dashboard-card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .table> :not(caption)>*>* {
            padding: 15px 10px;
            border-bottom-color: #f1f1f1;
            vertical-align: middle;
        }

        .table thead th {
            font-weight: 600;
            color: #888;
            border-bottom: 2px solid #e8e8e8;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-wrapper {
                margin-left: 0;
                padding: 15px;
            }

            .topbar {
                padding: 15px;
            }
        }

        #page-loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(244, 247, 246, 0.8);
            z-index: 9999;
            text-align: center;
        }

        .spinner-border {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>

<body>

    <div id="page-loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="sidebar" id="sidebar">
        <a href="{{ route('employee.dashboard') }}" class="brand ajax-link">
            <i class="fa fa-cubes"></i> Emp<span style="color: var(--theme-accent);">Dashboard</span>
        </a>
        <ul class="sidebar-menu">
            <li><a href="{{ route('employee.dashboard') }}" class="ajax-link"><i class="fa fa-home"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('employee.attendance') }}" class="ajax-link">
                    <i class="fa fa-calendar-check"></i> My Attendance
                </a>
            </li>

            <li>
                <a href="{{ route('employee.leave') }}" class="ajax-link">
                    <i class="fa fa-plane"></i> Apply Leaves
                </a>
            </li>

            <li>
                <a href="{{ route('employee.profile') }}" class="ajax-link">
                    <i class="fa fa-user"></i> Profile
                </a>
            </li>
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div>
                <button class="btn btn-light d-md-none" id="toggle-sidebar"><i class="fa fa-bars"></i></button>
                <h5 class="mb-0 d-inline-block ms-2">Welcome</h5>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out-alt me-1"></i>
                    Logout</button>
            </form>
        </div>

        <div id="dynamic-content">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            $('#toggle-sidebar').off('click').on('click', function() {
                $('#sidebar').toggleClass('show');
            });

            $(document).off('click', '.ajax-link').on('click', '.ajax-link', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $('.sidebar-menu a').removeClass('active');
                $(this).addClass('active');

                loadPage(url);
            });

            $(document).off('submit', '.ajax-form').on('submit', '.ajax-form', function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method') || 'POST';
                let formData = new FormData(this);

                $('#page-loader').show();
                $('.text-danger').remove();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#page-loader').hide();
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            if (response.redirect_url) loadPage(response.redirect_url);
                        }
                    },
                    error: function(xhr) {
                        $('#page-loader').hide();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                let input = form.find('[name="' + key + '"]');
                                input.after(
                                    '<span class="text-danger small mt-1 d-block"><i class="fa fa-exclamation-circle"></i> ' +
                                    value[0] + '</span>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        }
                    }
                });
            });

            window.onpopstate = function() {
                loadPage(window.location.href, false);
            };

            function loadPage(url, pushState = true) {
                $('#page-loader').show();
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#page-loader').hide();
                        let content = response.html ? response.html : response;
                        $('#dynamic-content').html(content);
                        if (pushState) window.history.pushState("", "", url);
                    },
                    error: function() {
                        $('#page-loader').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Page could not be loaded.'
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
