<?php
ini_set('display_errors','Off');
session_start();
include_once 'db_connect.php';

$page = 1;
if(!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);//фильтруем переменная @page
    if(false === $page) {
        $page = 1;
    }
}
$items_per_page = 5; //Количество записи в страниц
$offset = ($page - 1) * $items_per_page;

/*
 * Для удаления задачи с таблица база данных по ID запись
 * */
if($_POST['delete_task'] and $_POST['delete_task'] > 0){
    $conn->query('DELETE FROM tasks WHERE id="'.$_POST['delete_task'].'"');
}

$condition = ''; //Это переменная нужен для отбор записей по условиям
if($_POST['author']>0){
    $_SESSION['selected_author'] = $_POST['author'];//Чтобы при переходе на другую страницу не потерят параметри отбора, использовал сессия
}elseif(isset($_POST['author']) and $_POST['author']==0){
    $_SESSION['selected_author'] = 0;
}

if($_POST['tstatus']>0){
    $_SESSION['selected_status'] = $_POST['tstatus'];
}elseif(isset($_POST['tstatus']) and $_POST['tstatus']==0){
    $_SESSION['selected_status'] = 0;
}

if($_SESSION['selected_author']>0){
    $condition .= ' and t.author_id='.$_SESSION['selected_author'];
}
if($_SESSION['selected_status']>0){
    $condition .= ' and t.tstatus_id='.$_SESSION['selected_status'];
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
                    <form id="filter" action="index.php" method="post">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Задачник</h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="add_task.php" role="button">
                                        Новая задача
                                    </a>
                                </div>
                                <br>
                                <br>
                                <div class="card-form">
                                    <select name="author" id="author">
                                        <?php
                                        /*Выборка из база данных, списко авторов и их количестов задач*/
                                        $tasks_authors = $conn->query("SELECT a.id,a.name,COUNT(*) AS kol FROM `authors` a INNER JOIN `tasks` t ON a.id=t.author_id GROUP BY a.id WITH ROLLUP");
                                        while($author = $tasks_authors->fetch_array()){
                                            if(is_null($author['id'])){//из за того что я использовал ROLL UP строка с пустыми ID это сумма количество задач
                                                echo '<option value="0" ';
                                                if($_SESSION['selected_author']==0){
                                                    echo 'selected';
                                                }
                                                echo ' >Все авторы ('.$author['kol'].')</option>';
                                            }else{
                                                echo '<option value="'.$author['id'].'" ';
                                                if($_SESSION['selected_author']==$author['id']){
                                                    echo 'selected';
                                                }
                                                echo ' >'.$author['name'].' ('.$author['kol'].')</option>';
                                            }
                                        }
                                        ?>
                                    </select>

                                    <select name="tstatus" id="tstatus">
                                        <?php
                                        $tasks_statuses = $conn->query("SELECT ts.id,ts.name,COUNT(*) AS kol FROM `tasks_status` ts INNER JOIN `tasks` t ON ts.id=t.tstatus_id GROUP BY ts.id WITH ROLLUP");
                                        while($status = $tasks_statuses->fetch_array()){
                                            if(is_null($status['id'])){
                                                echo '<option value="0" ';
                                                if($_SESSION['selected_status']==0){
                                                    echo 'selected';
                                                }
                                                echo ' >Все статусы ('.$status['kol'].')</option>';
                                            }else{
                                                echo '<option value="'.$status['id'].'" ';
                                                if($_SESSION['selected_status']==$status['id']){
                                                    echo 'selected';
                                                }
                                                echo ' >'.$status['name'].' ('.$status['kol'].')</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            $tasks = $conn->query("SELECT t.id,t.name,a.name AS author_name,ts.name AS status_name FROM tasks t INNER JOIN `authors` a ON t.author_id=a.id INNER JOIN tasks_status ts ON t.tstatus_id=ts.id WHERE 1=1 ".$condition." LIMIT " . $offset . "," . $items_per_page);
                            $num_rows = $tasks->num_rows;
                            ?>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Название задачи</th>
                                        <th>Автор</th>
                                        <th>Статус</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($num_rows > 0){
                                        while($task = $tasks->fetch_array()){
                                            echo '<tr>';
                                                echo '<td>
                                                    <button type="submit" name="delete_task" value="'.$task['id'].'" class="btn-close" aria-label="Close" onclick="return confirm(\'Вы уверены что хотите удалить эту задачу?\')"></button>
                                                    </td>';
                                                echo '<td>'.$task['name'].'</td>';
                                                echo '<td>'.$task['author_name'].'</td>';
                                                echo '<td>'.$task['status_name'].'</td>';
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo '<tr><td colspan="4">Не найдено ни одной записи</td></tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <?php
                                $all_tasks = $conn->query("SELECT t.id,t.name,a.name AS author_name,ts.name AS status_name FROM tasks t INNER JOIN `authors` a ON t.author_id=a.id INNER JOIN tasks_status ts ON t.tstatus_id=ts.id WHERE 1=1 ".$condition);
                                $row_count = $all_tasks->num_rows;

                                $page_count = 0;
                                if (0 === $row_count) {
                                    // maybe show some error since there is nothing in your table
                                } else {
                                    // determine page_count
                                    $page_count = (int)ceil($row_count / $items_per_page);
                                    // double check that request page is in range
                                    if($page > $page_count) {
                                        // error to user, maybe set page to 1
                                        $page = 1;
                                    }
                                }

                                if($page_count > 0){
                                    echo '<ul class="pagination m-0 float-center">';
                                    if($page>1){
                                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page-1) . '">« Назад</a></li>';
                                    }
                                    for ($i = 1; $i <= $page_count; $i++) {
                                        if ($i === $page) { // this is current page
                                            echo '<li class="page-item"><a class="page-link" href="#">' . $i . '</a></li>';
                                        } else { // show link to other page
                                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                        }
                                    }
                                    if($page<$page_count){
                                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page+1) . '">В перед »</a></li>';
                                    }
                                    echo '</ul>';
                                    ?>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
	    <script src="./assets/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#author').change(function(e){
                    $('#filter').submit();
                });

                $('#tstatus').change(function(e){
                    $('#filter').submit();
                });
            })
        </script>
    </body>
</html>
