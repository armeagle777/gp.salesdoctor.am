<?php 
include 'db.php';

if(isset($_POST['check_solution'])){

	$solutionid = mysqli_real_escape_string($con, $_POST['solutionid']);
	$companyid = mysqli_real_escape_string($con, $_POST['companyid']);
	$questionid = mysqli_real_escape_string($con, $_POST['questionid']);
	$questioncomment = mysqli_real_escape_string($con, $_POST['questioncomment']);
	
	$query_2 = mysqli_query($con, "SELECT * FROM question_company_to_solution WHERE company_id = '$companyid' AND question_id = '$questionid' AND solution_id = '$solutionid' ");
	$rowcount = mysqli_num_rows($query_2);
	
	if($rowcount == 0){
		mysqli_query($con, "INSERT INTO question_company_to_solution (company_id, question_id, solution_id, solution_comment) VALUES ('$companyid', '$questionid', '$solutionid', '$questioncomment' )");
	}
	
	if($rowcount > 0){
		mysqli_query($con, "DELETE FROM question_company_to_solution WHERE company_id = '$companyid' AND question_id = '$questionid' AND solution_id = '$solutionid' ");
	}

}

if(isset($_POST['check_comment'])){

	$solutionid = mysqli_real_escape_string($con, $_POST['solutionid']);
	$companyid = mysqli_real_escape_string($con, $_POST['companyid']);
	$questionid = mysqli_real_escape_string($con, $_POST['questionid']);
	$questioncomment = mysqli_real_escape_string($con, $_POST['questioncomment']);
	
	$query_2 = mysqli_query($con, "UPDATE question_company_to_solution SET solution_comment = '$questioncomment' WHERE company_id = '$companyid' AND question_id = '$questionid' AND solution_id = '$solutionid' ");

}

if(isset($_POST['question_type1'])){
		
		$question_type1 = mysqli_real_escape_string($con, $_POST['question_type1']);
		$query_questions = mysqli_query($con, "SELECT * FROM  question_categrory WHERE category_parrent = '$question_type1' ");
		//$query = mysqli_query($con, "SELECT id, district_name FROM district WHERE region_id = `$region_id` " );
		$data = "<option value='0'>Ընտրել</option>";
		while($questions_array = mysqli_fetch_array($query_questions)){
			$data .= "<option value='{$questions_array['id']}'>{$questions_array['category_name']}</option>";
		}
		
		echo $data;

}

if(isset($_POST['question_type2'])){
		
		$question_type2 = mysqli_real_escape_string($con, $_POST['question_type2']);
		$query_questions = mysqli_query($con, "SELECT * FROM  question_categrory WHERE category_parrent = '$question_type2' ");
		//$query = mysqli_query($con, "SELECT id, district_name FROM district WHERE region_id = `$region_id` " );
		$data = "<option value='0'>Ընտրել</option>";
		while($questions_array = mysqli_fetch_array($query_questions)){
			$data .= "<option value='{$questions_array['id']}'>{$questions_array['category_name']}</option>";
		}
		
		echo $data;

}
if(isset($_POST['question_types'])){
		
		$question_types = mysqli_real_escape_string($con, $_POST['question_types']);
		$query_questions = mysqli_query($con, "SELECT * FROM  question_categrory WHERE category_type = '$question_types' AND category_parrent = '0' ");
		//$query = mysqli_query($con, "SELECT id, district_name FROM district WHERE region_id = `$region_id` " );
		$data = "<option value='0'>Ընտրել</option>";
		while($questions_array = mysqli_fetch_array($query_questions)){
			$data .= "<option value='{$questions_array['id']}'>{$questions_array['category_name']}</option>";
		}
		
		echo $data;

}


if(isset($_POST['check_note'])){

	$note_text = mysqli_real_escape_string($con, $_POST['note_text']);
	
	$query_update = mysqli_query($con, "UPDATE question_note SET note_text = '$note_text' WHERE id = '1' ");

}

?>