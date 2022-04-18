<?php 
    require "../db.php";
    require "../includes/functions-surveys.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>


<?php if($user) : ?>

<?php 
    date_default_timezone_set('Moscow');
    $date = date('Y-m-d', time());
    $categories = category_list();

    if (isset($_POST['btn-save'])) {
        header('Location: surveys'); 
        ob_end_flush();
    }
?>

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
	<link rel="stylesheet" href="../css/tests.css">
	<link rel="stylesheet" href="css/test-create.css">
    <link rel="stylesheet" href="css/profile.css">
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
            <hr style="color: #fff; margin-top: -15px;">
            <li>
                <a href="index">
                    <div class="nav-profile-item">
                        <?php if($user->img_link == '0'): ?>
                        <img src="../img/user-profile-nav.png" alt="" width=24px height=24px class="navbar-profile-img"
                            style="border-radius: 50%; object-fit: cover">
                        <?php else: ?>
                        <img src="<?=$user->img_link?>" alt="" width=24px height=24px class="navbar-profile-img"
                            style="border-radius: 50%; object-fit: cover">
                        <?php endif; ?>
                        <span>Профиль</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="tests">
                    <div class="nav-profile-item">
                        <img src="../img/tests.png" alt="tests-profile-nav" width=24px height=24px
                            style="margin-left: 3px">
                        <span style="margin-left: -3px">Тесты</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="surveys" class="active">
                    <div class="nav-profile-item active">
                        <img src="../img/surveys.png" alt="surveys-profile-nav" width=24px height=24px>
                        <span>Опросы</span>
                    </div>
                </a>
            </li>

            <?php if ($user->role == 1) :?>
            <li>
                <a href="admin" class="adm">
                    <div class="nav-profile-item">
                        <img src="../img/admin-profile-nav.png" alt="admin-profile-nav" width=24px height=24px>
                        <span>Админ. панель</span>
                    </div>
                </a>
            </li>
            <?php endif ;?>
            <li>
                <a href="help">
                    <div class="nav-profile-item">
                        <img src="../img/help.png" alt="help" width=24px height=24px>
                        <span>Помощь</span>
                    </div>
                </a>
            </li>
            <li class="drop-nav-profile-item">
                <hr style="color: #fff; margin-bottom: 10px;">
                <a href="../account/logout">
                    <div class="nav-profile-item">
                        <img src="../img/logout.png" alt="logout" width=24px height=24px>
                        <span>Выход</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-profile">
        <div class="row none mobile-nav text-center">
            <a href="index" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <?php if($user->img_link == '0'): ?>
                    <img src="../img/user-profile-nav.png" alt="" width=24px height=24px class="navbar-profile-img"
                        style="border-radius: 50%; object-fit: cover">
                    <?php else: ?>
                    <img src="<?=$user->img_link?>" alt="" width=24px height=24px class="navbar-profile-img"
                        style="border-radius: 50%; object-fit: cover">
                    <?php endif; ?>
                    <span>Профиль</span>
                </div>
            </a>
            <a href="tests" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/tests.png" alt="tests-profile-nav" width=24px height=24px style="margin-left: 3px">
                    <span style="margin-left: -3px">Тесты</span>
                </div>
            </a>
            <a href="surveys" class="btn btn-outline-primary mt-1 mb-1 active">
                <div class="nav-profile-item">
                    <img src="../img/surveys.png" alt="surveys-profile-nav" width=24px height=24px>
                    <span>Опросы</span>
                </div>
            </a>
            <?php if ($user->role == 1) :?>
            <a href="admin" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/admin-profile-nav.png" alt="admin-profile-nav" width=24px height=24px>
                    <span>Админ. панель</span>
                </div>
            </a>
            <?php endif ;?>
            <a href="help" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/help.png" alt="help" width=24px height=24px>
                    <span>Помощь</span>
                </div>
            </a>
            <a href="../account/logout" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/logout.png" alt="logout" width=24px height=24px>
                    <span>Выход</span>
                </div>
            </a>
        </div>
        <div class="container">

            <div class="main-body">
                <nav aria-label="breadcrumb" class="main-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index">Профиль</a></li>
                        <li class="breadcrumb-item"><a href="surveys">Опросы</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Создание опроса</li>
                    </ol>
                </nav>





                <form action="survey-create" method="post" id="addTest">
                    <div class="create-test-head">

                        <div class="test-create-title mb-5">
                            <h2 class="text-center">Создание опроса</h2>
                        </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 order-xl-first order-lg-first order-md-first order-sm-last order-last">

                                    <div class="text-center preview">
                                        <img src="../img/preview.png" alt="" width="26px" height="26px" class="preview-img">
                                        <span class="text-center">Предпросмотр</span>
                                    </div>

                                    <div class="card card-test mt-2 text-center">
                                        <img src="https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200" class="card-img-test create-test-img"
                                            class="card-img-test create-test-img" alt="...">
                                        <a class="test-name-for-img create-survey-name">Название опроса</a>
                                        <div class="test-author-for-img mt-1 text-center">

                                            <?php if($user->img_link): ?>

                                            <img src="<?=$user->img_link?>" alt="author.png"
                                                style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php else: ?>

                                            <img src="../img/user-profile-nav.png" alt="author.png"
                                                style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php endif; ?>

                                            <span><?=$user->login?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png"
                                                style="margin-left: 2%">
                                            <span>0</span>

                                        </div>

                                        <div class="card-body">
                                            <p class="card-text create-survey-description test_description">Описание опроса</p>
                                            <div class="text-center">
                                                <a class="btn btn-primary btn-test">Пройти опрос</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
                                    <div>
                                        <img src="../img/test-name-test-create.png" alt="" width="26px" height="26px"
                                            class="preview-img">
                                        <label for="survey_name" class="form-label">Название опроса</label>
                                        <input required type="text" name="survey_name" id="survey_name" class="form-control"
                                            autocomplete="off" placeholder="Название опроса" maxlength="64">
                                    </div>

                                    <div>
                                        <img src="../img/test-description-test-create.png" alt="" width="26px" height="26px"
                                            class="preview-img">
                                        <label for="survey_description" class="form-label mt-4">Описание опроса</label>
                                        <textarea required type="text" name="survey_description" id="survey_description"
                                            class="form-control" autocomplete="off" placeholder="Описание опроса"
                                            maxlength="255"></textarea>
                                    </div>
                                    <div>
                                        <img src="../img/test-url-test-create.png" alt="" width="26px" height="26px"
                                            class="preview-img">
                                        <label for="img_link" class="form-label mt-4">Ссылка на картинку</label>
                                        <input type="text" name="img_link" id="img_link" class="form-control"
                                            autocomplete="off"
                                            placeholder="Пример: https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200" class="card-img-test create-test-img"
                                            maxlength="255">
                                    </div>
                                    <div>
                                        <img src="../img/test-category-test-create.png" alt="" width="26px" height="26px"
                                            class="preview-img">
                                        <label for="category" class="form-label mt-4">Выберите категорию</label>
                                        <div class="select">
                                            <select class="form-select" name="category" id="category-select">
                                                <option>Без категории</option>
                                                <?php  foreach($categories as $category):?>
                                                <option><?=$category?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <span class="focus"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>

                    <hr class="hr-head-body">


                    <div class="create-test-body">
                        <div class="test-create-title mt-5">
                            <h3 class="text-center">Добавление вопросов</h3>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-sm-12 col-lg-10 col-xl-10 offset-lg-1 offset-xl-1">

                                <div class="questions">
                                    <div class="question-items">
                                        <div class="question_1 question-st" data-question="1">
                                            <label for="question_1" class="form-label">Вопрос #1</label>

                                            <div>
                                                <input type="checkbox" name="ifcheckbox_1" id="ifcheckbox_1" data-question="1" class="checkbox-for-question">
                                                <label for="ifcheckbox_1" class="form-label">Множественный выбор</label>
                                            </div>
                                            
                                            <input required type="text" name="question_1" id="question_1"
                                                class="form-control" autocomplete="off" placeholder="Вопрос #1"
                                                maxlength="255">

                                            <div class="answers">
                                                <div class="answer-items survey-answer-items">
                                                    
                                                </div>

                                                <button type="button" class="btn btn-success border addAnswer"
                                                    data-question="1" data-answer="0"
                                                    style="display: inline; margin-top: 15px;">+</button>

                                                <button type="button" class="btn btn-danger border removeAnswer"
                                                    data-question="1" data-click="0"
                                                    style="display: inline; margin-top: 15px;">X</button>

                                                <p class="none answer-error" style="color:red" data-question="1">
                                                    Нечего удалять :)</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center addQ">
                                        <button type="button" class="btn btn-primary addQuestion" data-question="1">Добавить
                                            вопрос</button>
                                    </div>





                                    <div class="text-center mt-4 saveTest">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Сохранить
                                        </button>
                                    </div> 
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Сохранить тест?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Пожалуйста, проверьте все данные. Если вы уверены, что все заполнено верно, нажмите "Сохранить"
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                    <button type="submit" class="btn btn-success" name="btn-save" id="btn-save">Сохранить</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
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
                                $survey->user_id = $user->id;
                                $survey->survey_name = trim($_POST['survey_name']);
                                $survey->description = trim($_POST['survey_description']);
                                $survey->author = $user->login;

                                if ($_POST['img_link'] == '') {
                                    $survey->img_link = 'https://avatars.mds.yandex.net/get-zen_doc/1860332/pub_5e5e171223f6716bacbc56cd_5e5e1718618046487a51ff7d/scale_1200';
                                } else {
                                    $survey->img_link = trim($_POST['img_link']);
                                }
                                
                                $survey->date = $date;
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
  </script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/survey-create.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
