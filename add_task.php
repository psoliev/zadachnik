<?php
ini_set('display_errors','Off');
session_start();
include_once 'db_connect.php';

if(isset($_POST['add_task'])){
    $search_name = $conn->query('SELECT * FROM `authors` WHERE `name` = "'.trim($_POST['task_author']).'"')->fetch_array();
    if(!is_null($search_name)){
        $author_id = $search_name['id'];
    }else{
        $conn->query('INSERT INTO AUTHORS (`name`) VALUES ("'.trim($_POST['task_author']).'")');
        $author_id = $conn->insert_id;
    }
    $conn->query('INSERT INTO tasks (`name`,author_id,tstatus_id) VALUES("'.$_POST['task_name'].'","'.$author_id.'","'.$_POST['task_status'].'")');
    header('Location: index.php');
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Parviz Soliev">
    <title>Задачник</title>

    <!-- Bootstrap core CSS -->
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Task management system -->
    <link href="./assets/tms.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Добавление новой задачи</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="task_name" class="form-label"></label>
                            <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Название задачи" required>
                        </div>
                        <div class="mb-3">
                            <label for="task_author" class="form-label"></label>
                            <input type="text" class="form-control" id="task_author" name="task_author" placeholder="Имя автора" required>
                        </div>
                        <div class="mb-3">
                            <label for="task_status" class="form-label"></label>
                            <select class="form-select" name="task_status">
                                <?php
                                $tasks_statuses = $conn->query("SELECT ts.id,ts.name FROM `tasks_status` ts");
                                while($status = $tasks_statuses->fetch_array()){
                                    echo '<option value="'.$status['id'].'">'.$status['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_task" value="add_task">Добавить задачу</button>
                    </form>
                </div>
                <div class="card-footer clearfix">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){

    })
</script>
</body>
</html>
