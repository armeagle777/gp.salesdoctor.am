<?php include 'header.php'; ?>
<?php
	include 'api/db.php';
		$user_id =  mysqli_real_escape_string($con, $_GET['user_id']);
		$action =  mysqli_real_escape_string($con, $_GET['action']);
		$query_data_user = mysqli_query($con, "SELECT * FROM users WHERE id='$user_id' ");
		$array_user = mysqli_fetch_array($query_data_user);
		
		$login_old = $array_user['login'];
		$password_old = $array_user['password'];
		$name_old = $array_user['name'];
		$image_old = $array_user['image'];
		
		
		
		
		
if($action=="edit"){
	
	
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	  if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	  } else {
		echo "File is not an image.";
		$uploadOk = 0;
	  }
	}

	// Check if file already exists
	if (file_exists($target_file)) {
	  echo "Sorry, file already exists.";
	  $uploadOk = 0;
	}

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	  echo "Sorry, your file is too large.";
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	  $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	  } else {
		echo "Sorry, there was an error uploading your file.";
	  }
	}
	
	$image_name = $_FILES["fileToUpload"]["name"];
	$login = $_POST['login'];
	$name = $_POST['name'];
	$password = $_POST['password'];
	
	if($password !=''){
		$password_hashed = hash('sha256', $password);
	}else{
		$query_for_pas = mysqli_query($con, "SELECT password FROM users WHERE id = '$user_id' ");
		$array_for_pas = mysqli_fetch_array($query_for_pas);
		$password_hashed = $array_for_pas['password'];

	}	
	
	
	if($image_name !=''){
		$image_name = $image_name;
	}else{
		$query_for_img = mysqli_query($con, "SELECT image FROM users WHERE id = '$user_id' ");
		$array_for_img = mysqli_fetch_array($query_for_img);
		$image_name = $array_for_img['image'];

	}
	
	$query = mysqli_query($con, "UPDATE users SET password='$password_hashed', login='$login', name='$name', image='$image_name' WHERE id='$user_id' ");
	echo "<script>window.location.href = '/action_user.php?user_id=$user_id';</script>";
	
}		
		
		
		
		
		
		
	
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
			<?php 
			if($action == 'add'){
				echo "Ավելացնել տվյալներ";
			}elseif($action == 'edit'){
				echo "Խմբագրել տվյալներ";
			}
			
			?>
			
			</h1>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
			<a href="/dahsboard.php" class="btn btn-info"><i class="fa fa-window-close"></i></a>
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
               
			   
			<form id="add_partner" action="/action_user.php?action=edit&user_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">

			  <div class="form-group col-md-12">
				<label for="login">Մուտքանուն</label>
				<input type="text" class="form-control" id="login" name="login" placeholder="Մուտքանուն" value="<?php echo $login_old; ?>">
			  </div>
			  <div class="form-group col-md-12">
				<label for="name">Անուն</label>
				<input type="text" class="form-control" id="name" name="name" value="<?php echo $name_old; ?>"  placeholder="Անուն">
			  </div>
			  <div class="form-group col-md-12">
				<label for="password">Գաղտնաբառ</label>
				<input type="password" class="form-control" id="password" name="password" value=""  placeholder="Գաղտնաբառ">
			  </div>

			  <div class="form-group col-md-12">
				<label for="name">Նկար</label>
				<input type="file" name="fileToUpload" id="fileToUpload">
			  </div>

			  
			<input type="hidden" name="action" id="action" value="<?php echo $_GET['action']; ?>">
			
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET['user_id']; ?>">
			
			<?php 
			if($action == 'add'):
			?>
			  <button type="submit" class="btn btn-primary">Ավելացնել</button>
			<?php else: ?> 
			
			  <button type="submit" class="btn btn-primary">Թարմացնել</button>

			<?php endif; ?>
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
        <a href="/action_partners.php?action=add" class="btn btn-success">Ավելացնել նորը</a>
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
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->



</body>
</html>
