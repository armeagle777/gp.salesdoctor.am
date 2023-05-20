<?php
include '../db.php';
header('Content-Type: application/json');
if (isset($_GET) && isset($_GET['user_id'])) {
    $tasks = array();
    $user_id = mysqli_real_escape_string($con, $_GET['user_id']);
    $tasks_query = mysqli_query($con, "SELECT * FROM tasks WHERE manager_id='$user_id' and created_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() ORDER BY admin_task_ok ASC LIMIT 100 OFFSET 0;");
    while ($row = mysqli_fetch_assoc($tasks_query)) {
        array_push($tasks, $row);
    }
    echo json_encode($tasks);
} else {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $ok = mysqli_real_escape_string($con, $_POST['ok']);
    mysqli_query($con, "UPDATE tasks SET answer='$comment', manager_task_ok='$ok', answer_date=NOW() WHERE manager_id='$user_id' and id='$id';");
    $task_query = mysqli_query($con, "SELECT *  FROM tasks WHERE id='$id';");
    echo json_encode(mysqli_fetch_assoc($task_query));
}
mysqli_close($con);
exit;
