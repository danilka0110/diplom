<?php 
    require "../db.php";
    require "../includes/functions.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
    date_default_timezone_set('Moscow');
    $date = date('Y-m-d', time());
    $categories = category_list();
?>


<?php if($user) : ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Тесты</title>
	<link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="../img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
	<link rel="manifest" href="../img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../img/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/test-create.css">
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index">
            <img src="../img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top" style="margin-right: 80px; margin-top: -3px;">
            <span class="brand">Paradigm Tests</span> 
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../tests">Тесты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../surveys">Опросы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contacts">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../about">О нас</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Профиль
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../profile"><?php echo $user->login?></a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../account/logout">Выход</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="nav-profile">
  <ul id="ul-nav-profile">
    <li><a href="../profile"><?php echo $user->login?></a></li>
    <li><a class="active" href="tests">Мои тесты</a></li>
    <li><a href="surveys">Мои опросы</a></li>
    <?php if ($user->role == 1) :?>
    <li><a href="admin">Админ. панель</a></li>
    <?php endif ;?>
  </ul>
</div>


<div class="main-profile">
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="test-create" method="post" id="addTest">
                    <div class="card mt-4 card-create">
                        <div class="card-header">
                            <h2 class="text-center">Создание теста</h2>
                        </div>

                        <div class="card-body">
                            <div class="head-block">
                                <div>
                                    <label for="test_name" class="form-label">Название теста</label>
                                    <input required type="text" name="test_name" id="test_name" class="form-control" autocomplete="off" placeholder="Название теста" maxlength="64">
                                </div>
                                <div>
                                    <label for="test_name" class="form-label mt-4">Описание теста</label>
                                    <textarea required type="text" name="test_description" id="test_description" class="form-control" autocomplete="off" placeholder="Описание теста" maxlength="255"></textarea>
                                </div>
                                <div>
                                    <label for="test_name" class="form-label mt-4">Ссылка на картинку</label>
                                    <input type="text" name="img_link" id="img_link" class="form-control" autocomplete="off" placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg" maxlength="255">
                                </div>
                                <div class="card card-test mt-4" style="width: 14rem;">
                                    <div>
                                        <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                        <span class="test-date-for-img"><?=$date?></span>
                                    </div>
                                    <img src="http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg" class="card-img-test create-test-img" alt="...">    
                                    <a class="test-name-for-img create-test-name">Название теста</a>  
                                    <div class="test-author-for-img mt-1">
                                        <img src="../img/author.png" alt="author.png" style="width:14px">
                                        <span><?=$user->login?></span>
                                    </div> 
                                    <div class="card-body">
                                        <p class="card-text create-test-description">Описание теста</p>
                                        <div class="text-center">
                                            <a class="btn btn-primary btn-test">Пройти тест</a>
                                        </div>
                                    </div>
                                </div>



                                <div class="text-center mt-4 category-block">
                                    <button type="button" class="btn btn-secondary addCategory">Добавить категорию</button>
                                    <select name="category" id="1" style="width: 70%;">
                                        <option>Без категории</option>
                                        <?php  foreach($categories as $category):?>
                                            <option><?=$category?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>



                                
                            </div>
                            <div class="mt-4 text-center">
                                <h4>Добавление вопросов</h4>
                            </div>
                            <div class="questions">
                                <div class="question-items">
                                    <div class="question_1 mt-4" data-question="1">
                                        <label for="question_1" class="form-label">Вопрос #1</label>
                                        <input required type="text" name="question_1" id="question_1" class="form-control" autocomplete="off" placeholder="Вопрос #1" maxlength="255">
                                        <div class="answers">
                                            <div class="answer-items">
                                                <div class="row">
                                                    <div class="col-12 col-md-9 col-lg-10 col-xl-10">
                                                        <label for="answer_text_1_1" class="form-label">Ответ</label>
                                                        <input required type="text" name="answer_text_1_1" id="answer_text_1_1" class="form-control" placeholder = "Ответ #1" autocomplete="off" data-numanswer="1" maxlength="255">
                                                    </div>
                                                    <div class="col-12 col-md-3 col-lg-2 col-xl-2">
                                                        <label for="answer_score_1_1" class="form-label">Балл</label>
                                                        <select name="answer_score_1_1" id="answer_score_1_1">
                                                            <option>0</option>
                                                        <option>1</option>  
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
       
                                            <button type="button" class="btn btn-primary border addAnswer" data-question="1" data-answer="1" style="display: inline; margin-top: 15px;">+</button>

                                            <button type="button" class="btn btn-danger border removeAnswer" data-question="1" data-click="0" style="display: inline; margin-top: 15px;">X</button>

                                            <p class="none answer-error" style="color:red" data-question="1">Нечего удалять :)</p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary addQuestion" data-question="1">Добавить вопрос</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 mb-4 card-create">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-success" name="btn-save" id="btn-save">Сохранить</button>
                        </div>
                        <?php 
                        if (isset($_POST['btn-save'])) {

                            $errors = array();
                            if(trim(strlen($_POST['test_name'])) > 255) {
                                $errors[] = 'Больше 255 символов нельзя!!!';
                            }
                            if(trim(strlen($_POST['test_description'])) > 255) {
                                $errors[] = 'Больше 255 символов нельзя!!!';
                            }
                            if(trim(strlen($_POST['question_' . $questionNum])) > 255) {
                                $errors[] = 'Больше 255 символов нельзя!!!';
                            }
                            if(trim(strlen($_POST['answer_text_' . $questionNum . '_' . $answerNum]) > 255)) {
                                $errors[] = 'Больше 255 символов нельзя!!!';
                            }
                            if(empty($errors)) {
                                $test = R::dispense('test');
                                $test->test_name = trim($_POST['test_name']);
                                $test->description = trim($_POST['test_description']);
                                $test->author = $user->login;

                                if ($_POST['img_link'] == '') {
                                    $test->img_link = 'http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg';
                                } else {
                                    $test->img_link = trim($_POST['img_link']);
                                }

                                R::store($test);
                                $parent_test = $test->id;
                        
                                $questionNum = 1;
                        
                                while (isset($_POST['question_' . $questionNum])) {
                                    $question = R::dispense('questions');
                        
                                    
                                    $question_name = trim($_POST['question_' . $questionNum]);
                                    if (!isset($question)) {
                                        continue;
                                    }
                            
                                    
                                    $question->parent_test = $parent_test;
                                    $question->question = $question_name;
                                    R::store($question);
                                    $questionId = $question->id;
                            
                                    $answerNum = 1;
                                    while (isset($_POST['answer_text_' . $questionNum . '_' . $answerNum])) {
                                        $answer = R::dispense('answers');
                        
                                        $answer_name = trim($_POST['answer_text_' . $questionNum . '_' . $answerNum]);
                                        $correct_answer = trim($_POST['answer_score_' . $questionNum . '_' . $answerNum]);
                                        if (!isset($answer)) {
                                            continue;
                                        }
                            
                                        $answer->parent_question = $questionId;
                                        $answer->answer = $answer_name;
                                        $answer->correct_answer = $correct_answer; 
                        
                                        R::store($answer);
                                        $answerNum++;
                                    }
                                    $questionNum++;
                                }

                                if (isset($_POST['category'])) {
                                    if ($_POST["category"] == 'Без категории') {
                                        return false;
                                    } 
                                    if (!in_array($_POST["category"], $categories)) {
                                        return false;
                                    }
                                    
                                    $last_test = R::findLast('test');
                                    $test_id = $last_test->id;
                                    $category = R::dispense('category');
                                    $category->test_id = $test_id;
                                    $category->category = trim($_POST["category"]);
                                    R::store($category);
                                }
                                    
                                


                                    
                                
                                

                                (header("Location: tests"));
                                ob_end_flush();
                            } else {
                                echo '<div style="color: red;" class="text-center">'.array_shift($errors).'</div><br>';
                                die;
                            }
                        }
                    ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
  </script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="../js/test-create.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
