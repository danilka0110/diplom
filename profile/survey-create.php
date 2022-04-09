<?php 
    require "../db.php";
    require "../includes/functions-surveys.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
    date_default_timezone_set('Moscow');
    $date = date('Y-m-d', time());
    $categories = category_list();

    if (isset($_POST['btn-save'])) {
        (header("Location: surveys"));
        ob_end_flush();
    }
?>


<?php if($user) : ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Создание опроса</title>
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
    <li><a href="tests">Мои тесты</a></li>
    <li><a class="active" href="surveys">Мои опросы</a></li>
    <?php if ($user->role == 1) :?>
    <li><a href="admin">Админ. панель</a></li>
    <?php endif ;?>
  </ul>
</div>


<div class="main-profile">
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="survey-create" method="post" id="addTest">
                    <div class="card mt-4 card-create">
                        <div class="card-header">
                            <h2 class="text-center">Создание опроса</h2>
                        </div>

                        <div class="card-body">
                            <div class="head-block">
                                <div>
                                    <label for="survey_name" class="form-label">Название опроса</label>
                                    <input required type="text" name="survey_name" id="survey_name" class="form-control" autocomplete="off" placeholder="Название опроса" maxlength="64">
                                </div>
                                <div>
                                    <label for="survey_name" class="form-label mt-4">Описание опроса</label>
                                    <textarea required type="text" name="survey_description" id="survey_description" class="form-control" autocomplete="off" placeholder="Описание опроса" maxlength="255"></textarea>
                                </div>
                                <div>
                                    <label for="survey_name" class="form-label mt-4">Ссылка на картинку</label>
                                    <input type="text" name="img_link" id="img_link" class="form-control" autocomplete="off" placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg" maxlength="255">
                                </div>
                                <div class="card card-test mt-4" style="width: 14rem;">
                                    <div>
                                        <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                        <span class="test-date-for-img"><?=$date?></span>
                                    </div>
                                    <img src="https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200" class="card-img-test create-test-img" alt="...">    
                                    <a class="test-name-for-img create-survey-name">Название опроса</a>  
                                    <div class="test-author-for-img mt-1">
                                        <img src="../img/author.png" alt="author.png" style="width:14px">
                                        <span><?=$user->login?></span>
                                    </div> 
                                    <div class="card-body">
                                        <p class="card-text create-survey-description">Описание опроса</p>
                                        <div class="text-center">
                                            <a class="btn btn-primary btn-test">Пройти опрос</a>
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


                                        
                                        <div>
                                            <input type="checkbox" name="ifcheckbox_1" id="ifcheckbox_1" data-question="1">
                                            <label for="ifcheckbox_1" class="form-label">Множественный выбор</label>
                                        </div>
                                       
                                            

                                        <input required type="text" name="question_1" id="question_1" class="form-control" autocomplete="off" placeholder="Вопрос #1" maxlength="255">
                                        <div class="answers">
                                            <div class="answer-items">
                                                
                                            </div>
       
                                            <button type="button" class="btn btn-primary border addAnswer" data-question="1" data-answer="0" style="display: inline; margin-top: 15px;">+</button>

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
                                $survey = R::dispense('survey');
                                $survey->survey_name = trim($_POST['survey_name']);
                                $survey->description = trim($_POST['survey_description']);
                                $survey->author = $user->login;

                                if ($_POST['img_link'] == '') {
                                    $survey->img_link = 'https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200';
                                } else {
                                    $survey->img_link = trim($_POST['img_link']);
                                }
                                
                                R::store($survey);
                                $survey_id = $survey->id;
                                $questionNum = 1;
                                
                                while (isset($_POST['question_' . $questionNum])) {
                                    $survey_questions = R::dispense('surveyquestions');
                                    
                                    
                                    $question_name = trim($_POST['question_' . $questionNum]);
                                    
                                    if (isset($_POST['ifcheckbox_' . $questionNum])) {
                                        $type = 'checkbox';
                                    } else {
                                        $type = 'radio';
                                    }

                                    if (!isset($survey_questions)) {
                                        continue;
                                    }
                            
                                    
                                    $survey_questions->survey_id = $survey_id;
                                    $survey_questions->question = $question_name;
                                    $survey_questions->type = $type;
                                    R::store($survey_questions);
                                    $questionId = $survey_questions->id;
                            
                                    $answerNum = 1;
                                    while (isset($_POST['answer_text_' . $questionNum . '_' . $answerNum])) {
                                        $survey_answer = R::dispense('surveyanswers');
                                        
                                        $answer_name = trim($_POST['answer_text_' . $questionNum . '_' . $answerNum]);
                                        
                                        if (!isset($survey_answer)) {
                                            continue;
                                        }
                                        
                                        $survey_answer->question_id = $questionId;
                                        $survey_answer->answer = $answer_name;
                        
                                        R::store($survey_answer);
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
                                    
                                    $last_survey = R::findLast('survey');
                                    $survey_id = $last_survey->id;
                                    $surveys_category = R::dispense('surveyscategory');
                                    $surveys_category->survey_id = $survey_id;
                                    $surveys_category->category = trim($_POST["category"]);
                                    R::store($surveys_category);
                                }
                                    
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
  <script src="../js/survey-create.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
