<?php
ob_start();
date_default_timezone_set('Moscow');
$date = date('Y-m-d', time());

require_once 'db.php';
require_once 'includes/functions.php';
$user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
if (isset($_POST['test'])) {
    $test_id = (int)$_POST['test']; // sql injection crash
    unset($_POST['test']);

    
    $test_type = R::getRow("SELECT type
                                FROM test
                                    WHERE id = $test_id");



    if(($test_type['type']) == 'Обычный') {
        $result = get_correct_answers($test_id);
        if (!is_array($result)) exit('Ошибка!');
        // данные теста
        $test_all_data = get_test_data($test_id);
        // 1 - массив вопрос/ответы, 2 - правильные ответы, 3 - ответы пользователя ($_POST)
        $test_all_data_result = get_test_data_result($test_all_data, $result);
        if($_POST) {
    
            $test_for_count_passes = R::findOne('test', 'id = :test_id', [':test_id' => $test_id]);
            $count_passes = $test_for_count_passes->count_passes;
            $count_passes++;
            $test_for_count_passes->count_passes = $count_passes;
            R::store($test_for_count_passes);
    
            if($user) :
            save($test_id, $user);
            save_result($test_all_data_result, $test_id, $user->id, $date);     
            else :
            endif ;
            echo print_result($test_all_data_result, $test_id); // вывод результатов
        } 
        
        else 
            exit('Ошибка! ');
    }

    else if (($test_type['type']) == 'Психологический') {

        $test_all_data = get_psychology_test_data($test_id);


        if($test_all_data) {
            $test_for_count_passes = R::findOne('test', 'id = :test_id', [':test_id' => $test_id]);
            $count_passes = $test_for_count_passes->count_passes;
            $count_passes++;
            $test_for_count_passes->count_passes = $count_passes;
            R::store($test_for_count_passes);
            $choises = $_POST;
                if ($user) {
                    save($test_id, $user);
                    savePsychologyTest($test_all_data, $test_id, $user->id, $date);
                }
            echo print_result_psychology_test($test_all_data, $test_id, $choises); // вывод результатов психологического теста
        } 
        
        else 
            exit('Ошибка!');
    }

    
    die;

    // echo("_POST");   
    // print_arr($_POST);
    // echo("result");
    // print_arr($result);
    // echo("test_all_data");
    // print_arr($test_all_data);
    // echo("test_all_data_result");
    // print_arr($test_all_data_result);
}

// список тестов

$tests = get_tests();

if (isset($_GET['test'])) {
    $test_id = (int)$_GET['test']; // sql injection crash
    $test_data = get_test_data($test_id);
    $test_name_and_description = get_test_name($test_id);
    foreach($test_name_and_description as $item) {
		$test_name = $item['test_name'];
		$test_description = $item['description'];
        $test_img_link = $item['img_link'];
        $test_author = $item['author'];
    }
    if(is_array($test_data)) {
        $count_questions = count($test_data);
        $pagination = pagination($count_questions, $test_data);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест №<?=$test_id?></title>
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
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="css/test-carousel.css">
    <link rel="stylesheet" href="css/comments.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark index-navbar bg-dark">
      <div class="container-fluid">
          <a class="navbar-brand" href="/">
          <?php if($user) : ?>
              <img src="img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-top: -5px;">
          <?php else : ?> 
              <img src="img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-right: 12px; margin-top: -5px;">
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
                      <a class="nav-link active active-nav-page" aria-current="page" href="tests">
                        <img src="img/tests.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Тесты</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="surveys">
                        <img src="img/surveys.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Опросы</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="contacts">
                        <img src="img/contacts.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Контакты</span>
                      </a>
                  </li>
                  <li class="nav-item" style="margin-right: 28px">
                      <a class="nav-link" href="about">
                        <img src="img/about.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">О нас</span>
                      </a>
                  </li>
              </ul>
              <?php if($user) : ?>
              <ul class="navbar-nav ml-auto mb-2 mb-lg-0 navbar-profile navbar-profile-dropdown">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <?php if($user->img_link == '0'): ?>
                              <img src="../img/user-profile-nav.png" alt="" width="34" height="34" class="navbar-profile-img" style="border-radius: 50%; object-fit: cover;">
                          <?php else: ?>
                              <img src="<?=$user->img_link?>" alt="" width="35" height="35" class="navbar-profile-img" style="border-radius: 50%; object-fit: cover;">
                          <?php endif; ?>  
                          <span style="margin-left: 1px;">Профиль</span>
                      </a>
                      <ul class="dropdown-menu nav-dropdown-menu" aria-labelledby="navbarDropdown">
                          <li>

                            <a class="dropdown-item" href="profile">
                              <?php if($user->img_link == '0'): ?>
                                  <img src="../img/user-profile-nav.png" alt="" width="24" height="24" class="navbar-profile-img" style="border-radius: 50%; object-fit: cover;">
                              <?php else: ?>
                                  <img src="<?=$user->img_link?>" alt="" width="24" height="24" class="navbar-profile-img" style="border-radius: 50%; object-fit: cover;">
                              <?php endif; ?>  
                              <span style="margin-left: 2px;"><?php echo $user->login?></span>
                            </a>

                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item" href="account/logout">
                              <img src="img/logout.png" alt="" width=24px height=24px>
                              <span style="margin-left: 2px;">Выход</span>
                            </a>
                          </li>
                      </ul>
                  </li>
              </ul>
              <?php else : ?>  
                  <ul class="navbar-nav mr-auto mb-2 mb-lg-0 navbar-profile">
                      <li class="nav-item">
                          <a class="nav-link btn btn-outline-secondary" href="account/login">Вход</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link btn btn-outline-secondary" href="account/reg">Регистрация</a>
                      </li>
                  </ul>
              <?php endif ; ?>
          </div>
      </div>
  </nav>




    
    <div class="main">
        <div class="container">
            <div class="wrap">
               <?php if ($tests): ?>
                <div class="content">
                    <?php if(isset($test_data)) : ?>
                        
                    <div class="test-head">
                        <div class="text-center">
                            <img src="<?=$test_img_link?>" alt="img" width="160px" height="160px" class="test-img">
                            <p style="font-size: 32px" class="test-head-test-name mt-4"><?=$test_name?></p>
                            <button class="btn btn-primary mt-4" id="test-start">Начать тест</button>
                        </div>

                        <div class="test-description mt-5">
                            <i class="desc-title">Описание теста: </i><span class="desc-text"><?=$test_description?></span>
                            <hr>
                            <i class="desc-title">Всего вопросов: </i><span class="desc-text"><?=$count_questions?></span>
                            <hr>
                            <i class="desc-title">Автор: </i><span class="desc-text"><?=$test_author?></span>
                            <hr>
                        </div>
                    </div>

                    <div class="test-show none test-decoration">
                    <?=$pagination?>
                        <span class="none" id="test-id"><?=$test_id?></span>
                        <div class="test-data">

                            <?php foreach($test_data as $id_question => $item): // получаем каждый конкретный вопрос + ответы ?>
                                <div class="question" data-id="<?=$id_question?>" id="question-<?=$id_question?>">

                                    <?php foreach($item as $id_answer => $answer): // проходимся по массиву вопрос/ответы?>

                                    <?php if (!$id_answer): //выводим вопрос?>
                                    <p class="q question-show"><?=$answer?></p>
                                    <?php else: // выводим варианты ответов?>
                                    <p class="a question-show">
                                        <input required class="input-ans" type="radio" name="question-<?=$id_question?>"
                                            id="answer-<?=$id_answer?>" value="<?=$id_answer?>">
                                        <label for="answer-<?=$id_answer?>"><?=$answer?></label>
                                    </p>

                                    <?php endif; // id_answer?>

                                    <?php endforeach; //$item ?>
                                
                                </div>
                                <?php endforeach; //$test_data ?>
                            </div>



                            

                                

                        <p class="next-error none" style="color: red; font-size: 16px;">Вопросов больше нет</p>

                        <p class="none result-error" style="color:red; font-size: 16px;">Вы ответили не на все вопросы</p>

                        <div class="buttons text-center">
                            <button type="submit" class="center btn-finish btn btn-success none" id="btn">Закончить тест
                                <span class="spinner-border spinner-border-sm none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>

                        <button class="center btn-next btn btn-primary" id="btn-next">Далее</button>

                    <?php else: header('Location: tests'); ob_end_flush(); // isset($test_data) ?>

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
    <script src="js/test.js"></script>
</body>

</html>