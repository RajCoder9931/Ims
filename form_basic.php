<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admincast bootstrap 4 &amp; angular 5 admin template, Шаблон админки | Form Validation</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <style>
        #form-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }

        /* Hidden when minimized */
        #form-container.minimized {
            height: 40px; /* Only show the toggle button when minimized */
            overflow: hidden;
        }

        /* Toggle button */
        #toggle-button {
            background: #4db8ff;
            color: white;
            font-size: 20px;
            text-align: end;
            cursor: pointer;
            padding: 10px;
            border-radius: 0 0 5px 5px;
        }

        /* Styling for the form */
        form {
            padding: 15px;
            font-family: Arial, sans-serif;
            transition: opacity 0.3s ease;
        }

        form.hidden {
            display: none;
        }

        /* Form rows */
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        /* Form labels and inputs */
        form label {
            display: block;
            font-size: 14px;
            color: #555;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="date"],
        form input[type="tel"] {
            width: 18rem;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        #Customer-gender{
            width: 18rem;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 3px;
        
        }

        form button {
            padding: 10px;
            background: #4db8ff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        form button:hover {
            background: #3aa6e6;
        }
    </style>
    <!-- PAGE LEVEL STYLES-->
</head>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link" href="index.html">
                    <span class="brand">Admin
                        <span class="brand-tip">Master</span>
                    </span>
                    <span class="brand-mini">AM</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>
                        <form class="navbar-search" action="javascript:;">
                            <div class="rel">
                                <span class="search-icon"><i class="ti-search"></i></span>
                                <input class="form-control" placeholder="Search here...">
                            </div>
                        </form>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="./assets/img/admin-avatar.png" />
                            <span></span>Admin<i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="login.php"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="./assets/img/admin-avatar.png" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong">Ravi Raj</div><small>Administrator</small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li>
                        <a class="active" href="index.php"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Bills</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="invoice.php">Purchase Bill</a>
                            </li>
                            
                            <li>
                                <a href="sell.php">Sell Bill</a>
                            </li>
                           
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Accounts</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="form_basic.php">Day Book</a>
                            </li>
                            <li>
                                <a href="form_advanced.php">Payment</a>                           </li>
                            <li>
                                <a class="active" href="product.php">Receipt</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-table"></i>
                            <span class="nav-label">Reports</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="table_basic.php">Customer Data</a>
                            </li>
                            <li>
                                <a href="datatables.php">Employee Data</a>
                            </li>
                            <li>
                                <a href="product_data.php">Product Data</a>
                            </li>
                            <li>
                                <a class="active" href="Uom data.php">Uom Data</a>
                            </li>
                            <li>
                                <a href="Sell_Report.php">Sale Report </a>
                            </li>
                            <li>
                                <a href="loan data.php">Loan Report </a>
                            </li>
                            <li>
                                <a href="Purchase_Report.php">Purchase Report</a>
                            </li>
                            
                        </ul>
                    </li>
                
                    
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-file-text"></i>
                            <span class="nav-label">Pages</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="Emp_dasboard.php">Employee Dashboard</a>
                            </li>
                            
                            <li>
                                <a href="login.php">Login</a>
                            </li>
                           
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-edit"></i>
                            <span class="nav-label">Master Creation</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="form_basic.php">Customer Creation</a>
                            </li>
                            <li>
                                <a href="form_validation.php">Employee Creation</a>
                            </li>
                            <li>
                                <a class="active" href="product.php">Product Creation</a>
                            </li>
                            <li>
                                <a class="active" href="uom.php">Uom Creation</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Customer Creation</h1>
                
            </div>
            <div class="page-content fade-in-up">
               
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Customer Form</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form method="POST" action="process_Customer.php">
                            <!-- First Row -->
                            <div class="form-row">
                                <div>
                                    <label for="Customer-name">Name:</label>
                                    <input type="text" id="customer_name" name="customer_name" required>
                                    </div>
                                <div>
                                    <label for="Customer-email">Email:</label>
                                    <input type="email" id="Customer-email" name="email" placeholder="Enter Email" required>
                                </div>
                            </div>
            
                            <!-- Second Row -->
                            <div class="form-row">
                                <div>
                                    <label for="Customer-contact">Contact:</label>
                                    <input  type="tel" id="Customer-contact" name="contact" placeholder="Enter Contact" required>
                                </div>
                               
                                <div>
                                    <label for="Customer-branch">Address:</label>
                                    <input type="text" id="Customer-branch" name="branch" placeholder="Enter Branch" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label for="Customer-aadhar">Aadhar Number:</label>
                                    <input type="text" id="Customer-aadhar" name="aadhar" placeholder="Enter Aadhar Number" required>
                                </div>
                                <div>
                                    <label for="Customer-gender">Gender:</label>
                                    <select id="Customer-gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Submit Button Row -->
                            <div class="form-row">
                                <button type="submit" class="btn-design">Create Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    <!-- BEGIN THEME CONFIG PANEL-->
    <div class="theme-config">
        <div class="theme-config-toggle"><i class="fa fa-cog theme-config-show"></i><i class="ti-close theme-config-close"></i></div>
        <div class="theme-config-box">
            <div class="text-center font-18 m-b-20">SETTINGS</div>
            <div class="font-strong">LAYOUT OPTIONS</div>
            <div class="check-list m-b-20 m-t-10">
                <label class="ui-checkbox ui-checkbox-gray">
                    <input id="_fixedNavbar" type="checkbox" checked>
                    <span class="input-span"></span>Fixed navbar</label>
                <label class="ui-checkbox ui-checkbox-gray">
                    <input id="_fixedlayout" type="checkbox">
                    <span class="input-span"></span>Fixed layout</label>
                <label class="ui-checkbox ui-checkbox-gray">
                    <input class="js-sidebar-toggler" type="checkbox">
                    <span class="input-span"></span>Collapse sidebar</label>
            </div>
            <div class="font-strong">LAYOUT STYLE</div>
            <div class="m-t-10">
                <label class="ui-radio ui-radio-gray m-r-10">
                    <input type="radio" name="layout-style" value="" checked="">
                    <span class="input-span"></span>Fluid</label>
                <label class="ui-radio ui-radio-gray">
                    <input type="radio" name="layout-style" value="1">
                    <span class="input-span"></span>Boxed</label>
            </div>
            <div class="m-t-10 m-b-10 font-strong">THEME COLORS</div>
            <div class="d-flex m-b-20">
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Default">
                    <label>
                        <input type="radio" name="setting-theme" value="default" checked="">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-white"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue">
                    <label>
                        <input type="radio" name="setting-theme" value="blue">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-blue"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green">
                    <label>
                        <input type="radio" name="setting-theme" value="green">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-green"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple">
                    <label>
                        <input type="radio" name="setting-theme" value="purple">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-purple"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange">
                    <label>
                        <input type="radio" name="setting-theme" value="orange">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-orange"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink">
                    <label>
                        <input type="radio" name="setting-theme" value="pink">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-pink"></div>
                        <div class="color-small bg-ebony"></div>
                    </label>
                </div>
            </div>
            <div class="d-flex">
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="White">
                    <label>
                        <input type="radio" name="setting-theme" value="white">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Blue light">
                    <label>
                        <input type="radio" name="setting-theme" value="blue-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-blue"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Green light">
                    <label>
                        <input type="radio" name="setting-theme" value="green-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-green"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Purple light">
                    <label>
                        <input type="radio" name="setting-theme" value="purple-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-purple"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Orange light">
                    <label>
                        <input type="radio" name="setting-theme" value="orange-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-orange"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
                <div class="color-skin-box" data-toggle="tooltip" data-original-title="Pink light">
                    <label>
                        <input type="radio" name="setting-theme" value="pink-light">
                        <span class="color-check-icon"><i class="fa fa-check"></i></span>
                        <div class="color bg-pink"></div>
                        <div class="color-small bg-silver-100"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- END THEME CONFIG PANEL-->
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $("#form-sample-1").validate({
            rules: {
                name: {
                    minlength: 2,
                    required: !0
                },
                email: {
                    required: !0,
                    email: !0
                },
                url: {
                    required: !0,
                    url: !0
                },
                number: {
                    required: !0,
                    number: !0
                },
                min: {
                    required: !0,
                    minlength: 3
                },
                max: {
                    required: !0,
                    maxlength: 4
                },
                password: {
                    required: !0
                },
                password_confirmation: {
                    required: !0,
                    equalTo: "#password"
                }
            },
            errorClass: "help-block error",
            highlight: function(e) {
                $(e).closest(".form-group.row").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group.row").removeClass("has-error")
            },
        });
    </script>
</body>

</html>