<?php
session_start();
//	if(!isset($_SESSION['user_id'])){
//		header("Location: /index.php");
//	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Doctor | Գլխավոր</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="plugins/custom_style.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="display: none;">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown" style="display: none;">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item" style="display: none;">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>

            <li class="nav-item">
                <a href="/logout.php" id="3" class="btn btn-default btn-sm  data-toggle="modal" data-target="#deletemodal" title="Ելք համակարգից"><i class="fa  fa-power-off"></i></a>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="display: none;">
        <!-- Brand Logo -->

        <?php

        if($_SESSION['role'] != '1' ){
            $link_home = '/dashboard.php';
        }

        if($_SESSION['user_role'] == '1' ){
            $link_home = '/pr_new_order.php';
        }else{
            $link_home = '/statistics.php';
        }
        ?>

        <a href="<?php echo $link_home; ?>" class="brand-link">
            <img src="/logo2.png" alt="Sales Doctor" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Sales Doctor</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <?php if($_SESSION['role']!= '1' ): ?>

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                    <div class="image">
                        <?php if($_SESSION['image']!= '' ): ?>
                            <img src="/uploads/<?php echo $_SESSION['image']; ?>" class="img-circle elevation-2" alt="User Image">
                        <?php endif; ?>
                    </div>


                    <div class="info">
                        <a href="/action_user.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="d-block"><?php echo $_SESSION['user_name']; ?></a>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                          with font-awesome or any other icon font library -->

                    <?php if($_SESSION['role']!= '1' &&  $_SESSION['user_role'] == ''): ?>
                        <li class="nav-item">
                            <a href="/partners.php" class="nav-link">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>
                                    Գործընկեր (beta)
                                </p>
                            </a>
                        </li>


                        <li class="nav-item has-treeview">
                            <a href="/finance.php" class="nav-link">
                                <i class="nav-icon fas fa-money-bill-wave"></i>
                                <p>
                                    Ֆինանսական (beta)
                                </p>
                            </a>
                        </li>

                    <?php endif; ?>


                    <?php if($_SESSION['role']!= '1' ): ?>


                        <?php

                        if($_SESSION['user_role'] == '1' ){
                            include 'menus/menu_manager.php';
                        }

                        if($_SESSION['user_role'] == '2' ){
                            include 'menus/menu_gortsavar.php';
                        }

                        if($_SESSION['user_role'] == '3' ){
                            include 'menus/menu_warehouse.php';
                        }

                        if($_SESSION['user_role'] == '4' ){
                            include 'menus/menu_finance.php';
                        }

                        if($_SESSION['user_role'] == '5' ){
                            include 'menus/menu_courier.php';
                        }

                        if($_SESSION['user_role'] == '6' ){
                            include 'menus/menu_admin.php';
                        }
                        if($_SESSION['user_role'] == '' ){
                            include 'menus/main_menu.php';
                        }






                        ?>




                    <?php endif; ?>


                </ul>



            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <?php
    include 'api/db.php';
    $order_type = mysqli_real_escape_string($con, $_GET['order_type']);
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);
    $_SESSION['user_id'] = $user_id;
    $my_shop = mysqli_real_escape_string($con, $_GET['my_shop']);

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <?php if($order_type == '2'){ echo "Նոր վերադարձ"; }else {echo "Նոր պատվեր"; } ?>

                        </h1>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end" style="display: none !important">
                        <?php if($_SESSION['user_role'] != 1): ?>	<a href="/dashboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a> <?php endif; ?>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">



                        <div class="card">
                            <div class="card-header">
                                <div class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" id="success_message">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>


                                </div>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <?php

                                if($my_shop !='null'){

                                    $query_shop_district_region = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM shops LEFT JOIN region ON shops.region = region.id LEFT JOIN district ON shops.district = district.id WHERE shops.id = '$my_shop' "));


                                }

                                ?>
                                <form id="add_partner" action="/api/shop_select.php">

                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="address">Մարզ</label>

                                            <select name="region" id="region" class="form-control">

                                                <option value="0"> Ընտրել </option>
                                                <?php
                                                $query_region = mysqli_query($con, "SELECT * FROM region ORDER by id DESC");
                                                while ($array_regions = mysqli_fetch_array($query_region)):
                                                    $region_id = $array_regions['id'];
                                                    $region_name = $array_regions['region_name'];
                                                    ?>

                                                    <option value="<?php echo $region_id; ?>" <?php if($query_shop_district_region['region'] == $region_id){echo "selected";} ?>> <?php echo $region_name; ?></option>

                                                <?php endwhile; ?>

                                            </select>

                                        </div>




                                        <div class="form-group col-md-6">
                                            <label for="district">Տարածք</label>


                                            <select name="district" id="district" class="form-control">
                                                <?php
                                                if($my_shop !='null'):
                                                    ?>

                                                    <option><?php echo $query_shop_district_region['district_name']; ?></option>

                                                <?php
                                                else:
                                                    ?>

                                                    <option>Ընտրել</option>

                                                <?php
                                                endif;
                                                ?>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="shop">Խանութ</label>

                                            <select name="shop" id="shop" class="form-control">
                                                <?php
                                                if($my_shop !='null'):
                                                    $shop_array = mysqli_fetch_array(mysqli_query($con, "SELECT name, shop_id, address FROM shops WHERE id = '$my_shop' "));
                                                    ?>
                                                    <option value="<?php echo $shop_array['shop_id']; ?>"><?php echo $shop_array['shop_id']; ?>.<?php echo $shop_array['name']; ?> - <?php echo $shop_array['address']; ?></option>

                                                <?php

                                                else:

                                                    ?>
                                                    <option value="0">Ընտրել</option>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="product_group">Ապրանքների խումբ</label>

                                            <select name="product_group" id="product_group" class="form-control">

                                                <option value="0">Ընտրել</option>
                                                <?php

                                                $query_product_group = mysqli_query($con, "SELECT * FROM pr_groups");
                                                while($array_pr_groups = mysqli_fetch_array($query_product_group)){
                                                    echo "<option value='{$array_pr_groups['id']}'>{$array_pr_groups['group_name']}</option>";
                                                }

                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-6" style="display: none;">
                                            <label for="product_payment">Վճարման տիպ</label>

                                            <select name="product_payment" id="product_payment" class="form-control">

                                                <option value="">Ընտրել</option>
                                                <?php

                                                $query_product_payment = mysqli_query($con, "SELECT * FROM pr_payment_type");
                                                while($array_pr_payment = mysqli_fetch_array($query_product_payment)){

                                                    echo "<option value='{$array_pr_payment['id']}'>{$array_pr_payment['payment_name']}</option>";
                                                }

                                                ?>

                                            </select>

                                        </div>


                                        <div class="form-group col-md-6">
                                            <label for="shop_limits">Վճարման տիպ - լիմիտ</label>
                                            <select name="shop_limits" id="limits" class="form-control">
                                            </select>
                                            <span class='total_limit' style="display:none;"></span>
                                        </div>




                                        <div class="form-group col-md-6" id="date_range_picker1" style="">
                                            <label> <?php if($order_type == '2'){ echo "Վերադարձի օր"; }else {echo "Պատվերի օր"; } ?> </label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="order_start_date" value="" name="order_start_date" required>
                                            </div>
                                            <!-- /.input group -->
                                        </div>


                                        <div class="form-group col-md-6" id="date_range_picker" style="display: none;">
                                            <label>Վճարման օր</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                                                </div>
                                                <input type="text" class="form-control float-right" id="depb_date" value="" name="depb_date" required>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->


                                        <div class="form-group col-md-6" style="display: none;">
                                            <label for="order_type">Տեսակ</label>

                                            <select name="order_type" id="order_type" class="form-control">

                                                <option value="1">Նոր պատվեր</option>
                                                <option value="2" <?php if($order_type == '2'){ echo "selected"; } ?>>Վերադարձ</option>

                                            </select>

                                        </div>
                                        <hr style="clear: both; width: 100%;">

                                        <div class="form-group col-md-8 col-sm-6">
                                            <span class="order_success_fix" style="display: none; color: #28a745; margin-bottom: 10px; font-weight: bold;">Պարտքը ֆիքսված է:</span>
                                            <span class="order_false_fix" style="display: none; color: #f00;; margin-bottom: 10px; font-weight: bold;">Պարտքը չի ֆիքսվել:</span>

                                            <span class="network_span" style="display: none;">Ցանցի պարտք՝ <span class="network_balance" style="font-weight: bold;"></span> | Ցանցի լիմիտ՝ <span class="network_limit" style="font-weight: bold;"></span> </span>

                                            Ընդհ. պարտք՝ <span class="balance" style="font-weight: bold;">0</span>  <button type="button" class="btn btn-danger" id="shop_fix">FIX</button>

                                            Վճ. տիպի պարտք՝ <span class="vch_liimit" style="font-weight: bold;">0</span> |
                                            Պատվերի լիմիտ՝ <span class="order_limit" style="font-weight: bold;">0</span>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6">
                                            Ամս. վաճառք՝ <span class="curr_month" style="font-weight: bold;">0</span>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-6">
                                            Մեկնաբանություն՝ <span class="shop_comment" style="font-weight: bold;"></span>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6" style="display: none">
                                            Խմբային լիմիտ՝
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6" style="display: none">
                                            Կրեդիտ՝
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6" style="display: none">
                                            Փոխանց. պարտք՝
                                        </div>


                                        <div class="form-group col-md-12">

                                            <div class="table-responsive">

                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Անվանում</th>
                                                        <th scope="col">Քանակ</th>
                                                        <th scope="col" style="padding: 12px 27px;">%</th>
                                                        <th scope="col">Գին</th>
                                                        <th scope="col">Առկա</th>
                                                        <th scope="col">Price</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody id="products">

                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                        <th scope="col" class='total'></th>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                    </tfoot>

                                                </table>

                                            </div>
                                        </div>




                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="comment">Մեկնաբանություն</label>
                                            <input type="text" class="form-control" id="comment" name="comment" placeholder="Մեկնաբանություն" value="<?php echo $comment; ?>">
                                        </div>
                                    </div>

                                    <span class="total_danger" style="display: none; color: #f00; margin-bottom: 10px;">Պատվերը չի գրանցել: Գումարը գերազանցում է խանութի պարտքի լիմիտը:</span>

                                    <span class="total_danger_network" style="display: none; color: #f00; margin-bottom: 10px;">Պատվերը չի գրանցել: Գումարը գերազանցում է ցանցի պարտքի լիմիտը:</span>


                                    <span class="order_success" style="display: none; color: #28a745; margin-bottom: 10px; font-weight: bold;">Պատվերը գրանցվել է:</span>
                                    <span class="order_false" style="display: none; color: #f00;; margin-bottom: 10px; font-weight: bold;">Պատվերը չի գրանցվել:</span>
                                    <button type="submit" class="btn btn-primary">Ավելացնել</button>

                                </form>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary modal_answere" data-toggle="modal" data-target="#modal_answere" style="display:none;">
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal_answere" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="success_message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
                    <a href="/dashboard.php" class="btn btn-primary">Գլխավոր էջ</a>
                    <a href="/action_shops.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
                </div>
            </div>
        </div>
    </div>




    <?php

    include 'footer.php';

    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->


<script>


    $( "#region" ).change(function() {

        $('#district option').remove();
        var url = 'api/region_select.php';
        var region = $('#region').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {region_select: region},
            success: function(data)
            {

                $('#district').append(data);
                // $('.alert').show()

            }

        });


    });


    $( "#district" ).change(function() {

        var district = $('#district').val();
        $('#shop option').remove();
        var url = 'api/shop_select.php';

        $.ajax({
            type: "POST",
            url: url,
            data: {district: district, mobile_user_id: <?php echo $user_id; ?> },
            success: function(data)
            {

                $('#shop').append(data);
                // $('.alert').show()

            }

        });


    });

    $( "#product_group").change(function() {
        var product_group = $('#product_group').val();
        var shop_id = $('#shop').val();
        $('#products tr').remove();
        var url = 'api/shop_select.php';
        $('.order_success').css("display", "none");

        $.ajax({
            type: "POST",
            url: url,
            data: {product_group: product_group, shop_id: shop_id},
            success: function(data)
            {

                $('#products').append(data);
                // $('.alert').show()

            }

        });
    });



    $(document).on('keyup','.discount', function(){
        var product_id = this.id;
        var product_discount = $(this).val();
        var old_price = $(this).data("price");

        var product_price = old_price - (old_price * (product_discount / 100));
        $('.product_'+product_id).html(product_price);
    });


    products_obj = {};

    $(document).on('change','.product_count, .discount', function(){
        var product_id = this.id;
        var product_count = $('.product_count_' + product_id).val();
        var product_procent =  $('.discount_' + product_id).val();
        var product_discounted_cost = $('.product_'+product_id).text();

        var total_for_each = product_count * product_discounted_cost;

        $( "#totalprice_" + product_id ).text(total_for_each);


        products_obj[product_id] = {prod_id:this.id, prod_count:product_count, prod_procent:product_procent, prod_cost:product_discounted_cost};

        var sum = 0.0;
        $('.totalprice').each(function()
        {
            sum += parseFloat($(this).text());
        });

        $('.total').text(sum);

    });



    $(document).on('submit','#add_partner', function(e){

        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var shop_id = $('#shop').val();
        var product_group = $('#product_group').val();
        var product_payment = $('#limits').val();
        var comment = $('#comment').val();
        var order_type = $('#order_type').val();
        var order_summ = $('.total').text();
        var debt_date = $('#depb_date').val();
        var order_start_date = $('#order_start_date').val();

        var current_limit = parseInt($('.order_limit').text());

        var network_limit = parseInt($('.network_limit').text());
        var network_balance = parseInt($('.network_balance').text());

        var order_summ_checking = parseInt($('.total').text());

        <?php
        if($order_type !='2'):
        ?>

        function isEqual(){

            if(order_summ_checking > current_limit){
                $('.total_danger').css("display", "block");
                throw new Error("Something went badly wrong!");
                //return false;
            }else{
                $('.total_danger').css("display", "none");
            }

        }
        isEqual();

        function isEquals(){

            if((network_balance + order_summ_checking) > network_limit){
                $('.total_danger_network').css("display", "block");
                throw new Error("Something went badly wrong!");
                //return false;
            }else{
                $('.total_danger_network').css("display", "none");
            }

        }

        isEquals();

        <?php
        endif;
        ?>
        if (product_payment == '0'){
            $('#limits').addClass('border border-danger');
            return false;
        }else{
            $('#limits').removeClass('border border-danger');
        }

        if (shop_id == '0'){
            $('#shop').addClass('border border-danger');
            return false;
        }else{
            $('#shop').removeClass('border border-danger');
        }

        if(product_payment == '3' || product_payment == '4'){

            var today = new Date();
            var dd = String(today.getDate() + 1).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            if(debt_date == today){
                $('#depb_date').addClass('border border-danger');
                return false;
            }


        }else{
            $('#depb_date').removeClass('border border-danger');
        }



        $('.btn-primary').prop('disabled', true);

        $.ajax({
            type: "POST",
            url: url,
            data: {
                product: JSON.stringify(products_obj),
                shop_id: shop_id,
                product_group_add: product_group,
                product_payment: product_payment,
                comment: comment,
                order_type: order_type,
                manager_id: <?php echo $user_id; ?>,
                type: 'add_order',
                order_summ: order_summ,
                order_start_date: order_start_date,
                debt_date: debt_date
            },

            error: function(){
                $('.order_false').css("display", "block");
                $('.btn-primary').prop('disabled', false);

                return false;

            },
            success: function(data)

            {
                $('.order_success').css("display", "block");
                $('.order_false').css("display", "none");
                $("#product_group").val('0');
                $('#products tr').remove();
                $('.total').html('');
                $("#comment").val("");
                $('.btn-primary').prop('disabled', false);

                products_obj = {};
            },
            timeout: 10000

        });
    });

    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate()+1);
    var nextmonth=new Date();
    nextmonth.setMonth(nextmonth.getMonth()+1);

    $('#depb_date').daterangepicker({
        //autoUpdateInput: false,
        minDate: tomorrow,

        locale: {
            format: 'YYYY-MM-DD',
            firstDay: 1,
            cancelLabel: 'Clear'
        },
        singleDatePicker: true,
        showDropdowns: true,
    });




    $('#order_start_date').daterangepicker({
        "timePicker": true,
        "timePicker24Hour": true,


        //autoUpdateInput: false,
        minDate: tomorrow,
        maxDate: nextmonth,

        locale: {

            format: 'YYYY-MM-DD H:mm',
            firstDay: 1,
            cancelLabel: 'Clear',

        },

        singleDatePicker: true,
        setDate: "+1d",
        showDropdowns: true,
        //startDate: moment().startOf('hour'),
        //endDate: moment().startOf('hour').add(32, 'hour')

    });


    $(document).on('change','#limits', function(){
        var payment_type = $('#limits').val();

        <?php

        if($order_type !='2'):

        ?>

        if(payment_type == '3' || payment_type == '4'){
            $("#date_range_picker").css("display", "block");
        }else{
            $("#date_range_picker").css("display", "none");
        }

        <?php endif; ?>


        var url = '/api/shop_select.php';
        var shop_id = $('#shop').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                payment_type: payment_type,
                shop_id: shop_id,
                action: 'get_shop_order_limit'
            },

            error: function(){
                $('.order_false').css("display", "block");
                return false;
            },
            success: function(data)

            {
                var get_data = JSON.parse(data)
                $('.vch_liimit').html(get_data[1]);
                $('.order_limit').html(get_data[0]);
                //products_obj = {};
            },
            timeout: 10000

        });





    });



    $( "#shop").change(function() {
        var shop_id = $('#shop').val();
        $('.vch_liimit').html('0');
        $('.order_limit').html('0');

        var url = 'api/shop_select.php';

        $.ajax({
            type: "POST",
            url: url,
            data: {shop_id: shop_id, action: 'shop_details'},
            success: function(data)
            {

                var get_data = JSON.parse(data)

                $('#limits').html(get_data[0]);
                $('.balance').html(get_data[1]);
                $('.total_limit').html(get_data[2]);
                $('.curr_month').html(get_data[3]);
                $('.shop_comment').html(get_data[4]);

                if(get_data[7] > 0){
                    $('.network_span').css("display", "block");
                    $('.network_balance').html(get_data[8]);
                    $('.network_limit').html(get_data[5]);
                }else{
                    $('.network_span').css("display", "none");
                    $('.network_balance').html('');
                    $('.network_limit').html('');
                }

                // alert(get_data[1]);

            }

        });
    });


    <?php
    if($my_shop != ''):
    ?>

    $(window).on('load', function() {
        var shop_id = <?php echo $my_shop; ?>;
        $('.vch_liimit').html('0');
        $('.order_limit').html('0');

        var url = 'api/shop_select.php';

        $.ajax({
            type: "POST",
            url: url,
            data: {shop_id: <?php echo $my_shop; ?>, action: 'shop_details'},
            success: function(data)
            {

                var get_data = JSON.parse(data)

                $('#limits').html(get_data[0]);
                $('.balance').html(get_data[1]);
                $('.total_limit').html(get_data[2]);
                $('.curr_month').html(get_data[3]);
                $('.shop_comment').html(get_data[4]);

                if(get_data[7] > 0){
                    $('.network_span').css("display", "block");
                    $('.network_balance').html(get_data[8]);
                    $('.network_limit').html(get_data[5]);
                }else{
                    $('.network_span').css("display", "none");
                    $('.network_balance').html('');
                    $('.network_limit').html('');
                }

                // alert(get_data[1]);

            }

        });
    });

    <?php
    endif;
    ?>


    $(document).on('click','#shop_fix', function(e){

        var fix_shop_id = $('#shop').val();
        var fix_summ = $('.balance').text();
        var url = '/api/pr_shop_fix.php';

        if (fix_shop_id == '0'){
            $('#shop').addClass('border border-danger');
            return false;
        }else{
            $('#shop').removeClass('border border-danger');
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: 'add_fix',
                fix_shop_id: fix_shop_id,
                fix_summ: fix_summ,
                fixed_user_id: <?php echo $user_id; ?>
            },

            success: function(data)

            {
                $('.order_success_fix').css("display", "block");
                $('.order_false_fix').css("display", "none");
            }

        });
    });


</script>
</body>
</html>
