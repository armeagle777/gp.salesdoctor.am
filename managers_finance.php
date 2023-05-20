<?php include 'header.php'; ?>
<?php include 'api/db.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Աշխատակիցներ</h1> 
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped modal_table">
                  <thead>
                  <tr>
                    <th>Հ\Հ</th>
                    <th>Մուտքանուն</th>
					<th>Անուն</th>
					<th>Հաշվարկել</th>

                  </tr>
                  </thead>
                  <tbody>
				  
				 <?php 
		
					
					
					$query = mysqli_query($con, "SELECT  * FROM manager WHERE user_role = 1 AND active='on' ");

					while ($array_managers = mysqli_fetch_array($query)):
					$manager_id = $array_managers['id'];
					$login = $array_managers['login'];
					$name = $array_managers['name'];
					$phone = $array_managers['phone'];
					$email = $array_managers['email'];
					$client = $array_managers['client_name'];
					$audit = $array_managers['audit_active'];

					
				 ?> 
				  
                  <tr>
                    <td><?php echo $manager_id; ?></td>
                    <td><?php echo $login; ?></td>
                    <td><?php echo $name; ?></td>
                    <td>
						<a href="/plan_managers.php?manager_id=<?php echo $manager_id; ?>" class="btn btn-success btn-sm rounded-0" title="Հաշվարկել"><i class="nav-icon fas fa-money-bill-wave"></i></a>
					</td>
			

                  </tr>
                 
                 <?php endwhile; ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
				  
                    <th>Հ\Հ</th>
                    <th>Մուտքանուն</th>
					<th>Անուն</th>
					<th>Հաշվարկել</th>
                  </tr>
                  </tfoot>
                </table>
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





	
	
</script>
</body>
</html>
