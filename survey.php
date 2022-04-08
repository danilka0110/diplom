<?php
ob_start();
date_default_timezone_set('Moscow');
$date = date('Y-m-d', time());

require_once 'db.php';
require_once 'includes/functions-surveys.php';
$user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));






if (isset($_POST['survey'])) { 

    $survey_id = (int)$_POST['survey']; // sql injection crash
    unset($_POST['survey']);
 

    $survey_all_data = get_test_data($survey_id);

    $survey_correct = survey_correct($survey_id, $survey_all_data); 
    if (!is_array($survey_correct)) exit('Ошибка! kek'); 

    if($_POST) {
        
        
        if ($user):
            save($survey_id, $user->id);
        else:
    
        endif;
        echo print_result($survey_id);

    } else exit('Ошибка!');

    die;
    
    // echo("_POST");   
    // print_arr($_POST);
    // echo("survey_all_data");
    // print_arr($survey_all_data);

}

// список опросов

$surveys = get_surveys();


if (isset($_GET['survey'])) {
    $survey_id = (int)$_GET['survey']; // sql injection crash
    $survey_data = get_survey_data($survey_id);
    $survey_name_and_description = get_survey_name($survey_id);
    foreach($survey_name_and_description as $item) {
		$survey_name = $item['survey_name'];
		$survey_description = $item['description'];
        $survey_img_link = $item['img_link'];
        $survey_author = $item['author'];
    }
    if(is_array($survey_data)) {
        $count_questions = count($survey_data);
        $pagination = pagination($count_questions, $survey_data);
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradigm Tests</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tests.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <?php if($user) : ?>
                <img src="img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top"
                    style="margin-right: 80px; margin-top: -3px;">
                <span class="brand">Paradigm Tests</span>
                <?php else : ?>
                <img src="img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top"
                    style="margin-right: 16px; margin-top: -3px;">
                <span class="brand-else">Paradigm Tests </span>
                <?php endif ; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="tests">Тесты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="surveys">Опросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about">О нас</a>
                    </li>
                </ul>
                <?php if($user) : ?>
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Профиль
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="profile"><?php echo $user->login?></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="account/logout">Выход</a></li>
                        </ul>
                    </li>
                </ul>
                <?php else : ?>
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="account/login">Вход</a>
                    </li>
                </ul>
                <?php endif ; ?>
            </div>
        </div>
    </nav>
    <div class="main">
        <div class="container">
            <div class="wrap">


                <?php if ($surveys):?>
                <div class="content">
                    <?php if(isset($survey_data)) :?>


                        <div class="test-head">
                            <a style="font-size: 26px" class="test-name"><?=$survey_name?></a>
                            <div>
                                <img src="<?=$survey_img_link?>" alt="img" width="150px" height="150px" class="test-img">
                                <span class="test-description"><?=$survey_description?></span>
                            </div>
                            <p>Всего вопросов: <?=$count_questions?></p>
                            <p>Автор: <?=$survey_author?></p>

                            <button class="btn btn-primary" id="test-start">Пройти тест</button>
                        </div>


                    <div class="test-show none">
                        <span style="font-size: 26px" class="test-name"><?=$survey_name?></span>
                        <hr>
                        <?=$pagination?>
                        <span class="none" id="survey-id"><?=$survey_id?></span>
                        <div class="test-data">
                            <?php foreach($survey_data as $id_question => $item): // получаем каждый конкретный вопрос + ответы ?>



                                
                            <div class="question" data-id="<?=$id_question?>" id="question-<?=$id_question?>">
                                <?php foreach($item as $id_answer => $answer): // проходимся по массиву вопрос/ответы?>



                                    <?php if($item['type'] == 'radio'): ?>

                                        <?php if (!$id_answer): //выводим вопрос?>
                                        <p class="q radio"><?=$answer?></p>
                                        <?php elseif ($id_answer != 'type'): // выводим варианты ответов?>
                                        <p class="a">
                                            <input required class="input-ans radio" type="radio" name="question-<?=$id_question?>"
                                                id="answer-<?=$id_answer?>" value="<?=$id_answer?>">
                                            <label for="answer-<?=$id_answer?>"><?=$answer?></label>
                                        </p>
                                        <?php endif; // id_answer?>




                                    <?php elseif($item['type'] == 'checkbox'): // id_answer?>

                                        <?php if (!$id_answer): //выводим вопрос?>
                                        <p class="q checkbox"><?=$answer?></p>
                                        <?php elseif ($id_answer != 'type'): // выводим варианты ответов?>
                                        <p class="a">
                                            <input required class="input-ans checkbox-answers" type="checkbox" name="question-<?=$id_question?>"
                                                id="answer-<?=$id_answer?>" value="<?=$id_answer?>">
                                            <label for="answer-<?=$id_answer?>"><?=$answer?></label>
                                        </p>
                                        <?php endif; // id_answer?>

                                    <?php endif; // id_answer?>









                                <?php endforeach; //$item ?>
                            </div>
                            <?php endforeach; //$test_data ?>
                        </div>


                        <p class="none result-error" style="color:red">Вы ответили не на все вопросы</p>
                        <!-- <p class="none next-error" style="color:red">Вопросов больше нет</p> -->
                        <div class="buttons text-center">
                            <button type="submit" class="center btn-finish btn btn-success" id="btn">Закончить
                                тест</button>
                        </div>
                    <?php else: header('Location: surveys'); ob_end_flush(); // isset($test_data) ?>
                    <?php endif; // isset($test_data) ?>
                    </div>
                </div>
                <?php  else: //tests ?>
                <h3>Нет тестов</h3>
                <?php endif //tests ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="js/survey.js"></script>
</body>

</html>