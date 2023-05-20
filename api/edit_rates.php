<?php 
include 'db.php';
if(isset($_POST)):
    
    $hy_2 = mysqli_real_escape_string($con, $_POST['hy_2']);
    $en_2 = mysqli_real_escape_string($con, $_POST['en_2']);
    $ru_2 = mysqli_real_escape_string($con, $_POST['ru_2']);
    $active_2 = isset($_POST['active_2']) ? 1  :  0;

    $hy_3 = mysqli_real_escape_string($con, $_POST['hy_3']);
    $en_3 = mysqli_real_escape_string($con, $_POST['en_3']);
    $ru_3 = mysqli_real_escape_string($con, $_POST['ru_3']);
    $active_3 = isset($_POST['active_3']) ? 1  :  0;
    
    $hy_4 = mysqli_real_escape_string($con, $_POST['hy_4']);
    $en_4 = mysqli_real_escape_string($con, $_POST['en_4']);
    $ru_4 = mysqli_real_escape_string($con, $_POST['ru_4']);
    $active_4 = isset($_POST['active_4']) ? 1  :  0;
    
    $hy_5 = mysqli_real_escape_string($con, $_POST['hy_5']);
    $en_5 = mysqli_real_escape_string($con, $_POST['en_5']);
    $ru_5 = mysqli_real_escape_string($con, $_POST['ru_5']);
    $active_5 = isset($_POST['active_5']) ? 1  :  0;
    
    $hy_6 = mysqli_real_escape_string($con, $_POST['hy_6']);
    $en_6 = mysqli_real_escape_string($con, $_POST['en_6']);
    $ru_6 = mysqli_real_escape_string($con, $_POST['ru_6']);
    $active_6 = isset($_POST['active_6']) ? 1  :  0;
    
    $hy_7 = mysqli_real_escape_string($con, $_POST['hy_7']);
    $en_7 = mysqli_real_escape_string($con, $_POST['en_7']);
    $ru_7 = mysqli_real_escape_string($con, $_POST['ru_7']);
    $active_7 = isset($_POST['active_7']) ? 1  :  0;
    
    $hy_8 = mysqli_real_escape_string($con, $_POST['hy_8']);
    $en_8 = mysqli_real_escape_string($con, $_POST['en_8']);
    $ru_8 = mysqli_real_escape_string($con, $_POST['ru_8']);
    $active_8 = isset($_POST['active_8']) ? 1  :  0;
    
    $hy_9 = mysqli_real_escape_string($con, $_POST['hy_9']);
    $en_9 = mysqli_real_escape_string($con, $_POST['en_9']);
    $ru_9 = mysqli_real_escape_string($con, $_POST['ru_9']);
    $active_9 = isset($_POST['active_9']) ? 1  :  0;
    
    $hy_10 = mysqli_real_escape_string($con, $_POST['hy_10']);
    $en_10 = mysqli_real_escape_string($con, $_POST['en_10']);
    $ru_10 = mysqli_real_escape_string($con, $_POST['ru_10']);
    $active_10 = isset($_POST['active_10']) ? 1  :  0;

    $sql = "INSERT INTO rates (id, title_hy, title_en, title_ru,active)
            VALUES  
            (2, '$hy_2', '$en_2', '$ru_2','$active_2'),
            (3, '$hy_3', '$en_3', '$ru_3','$active_3'),
            (4, '$hy_4', '$en_4', '$ru_4','$active_4'),
            (5, '$hy_5', '$en_5', '$ru_5','$active_5'),
            (6, '$hy_6', '$en_6', '$ru_6','$active_6'),
            (7, '$hy_7', '$en_7', '$ru_7','$active_7'),
            (8, '$hy_8', '$en_8', '$ru_8','$active_8'),
            (9, '$hy_9', '$en_9', '$ru_9','$active_9'),
            (10, '$hy_10', '$en_10', '$ru_10','$active_10')
            ON DUPLICATE KEY UPDATE 
                    id=VALUES(id),
                    title_hy=VALUES(title_hy),
                    title_en=VALUES(title_en),
                    title_ru=VALUES(title_ru),
                    active=VALUES(active)";

    $query_update = mysqli_query($con,$sql);
    
	if($query_update) {
		echo "Հաջողությամբ թարմացված է";
	}else{
		echo "Ստուգեք տվյալները";
	}
endif;


?>
