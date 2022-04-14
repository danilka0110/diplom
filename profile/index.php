<?php
    require "../db.php";
    require_once '../includes/functions.php';
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>

<?php if($user) : ?>

<?php 
    $my_tests = get_test_by_author($user->login);
    $count_my_tests = 0;
    foreach ($my_tests as $item) {
        if($item['enable'] == 1) {
            $count_my_tests += 1;
        }
    }

    $my_surveys = R::getAll("SELECT s.id, s.survey_name, s.description, s.img_link, s.author, s.date, s.count_passes, s.enable
    FROM survey s
        WHERE s.author = '$user->login'");
        
    $count_my_surveys = 0;
    foreach ($my_surveys as $item) {
        if($item['enable'] == 1) {
            $count_my_surveys += 1;
        }
    }

    $tests_user = R::getAll("SELECT test_id, test_name, correct_score, all_count, date
        FROM usersandtests
            WHERE user_id = $user->id");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$user->login?></title>
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
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/index-profile.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index">
                <img src="../img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top"
                    style="margin-right: 80px; margin-top: -3px;">
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
                            <li><a class="dropdown-item" href=""><?php echo $user->login?></a></li>
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
                <a class="active" href="index">
                    <div class="nav-profile-item active">
                        <?php if($user->img_link == '0'): ?>
                            <img src="../img/user-profile-nav.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%">
                        <?php else: ?>
                            <img src="<?=$user->img_link?>" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%">
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
                <a href="surveys">
                    <div class="nav-profile-item">
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
        <div class="container">
            <div class="main-body">
                <nav aria-label="breadcrumb" class="main-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Профиль</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Мой профиль</li>
                    </ol>
                </nav>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">

                                    <?php if($user->img_link == '0'): ?>
                                        <img src="../img/user-profile-nav.png" alt="" width="150" height="150" class="navbar-profile-img" style="border-radius: 50%">
                                    <?php else: ?>
                                        <img src="<?=$user->img_link?>" alt="" width="150" height="150" class="navbar-profile-img" style="border-radius: 50%">
                                    <?php endif; ?>  

                                    <div class="mt-3" style="width: 250px">
                                        <h4><?=$user->login?></h4>
                                        <div class="text-secondary">
                                            <?=$user->email?>
                                        </div>
                                        <div class="row text-center mt-2">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <span style="color: blue">Мои тесты:</span>
                                                <a href="tests">
                                                    <p style="font-size: 20px; color: black"><?=$count_my_tests;?></p>
                                                </a>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <span style="color: blue">Мои опросы:</span>
                                                <a href="surveys">
                                                    <p style="font-size: 20px; color: black"><?=$count_my_surveys;?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <form action="" method="post" id="changeData">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 my-auto">
                                            <h6 class="mb-0">Фамилия:</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10 text-secondary">
                                            <?php if($user->surname):?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Фамилия" id="surname" name="surname" value="<?=$user->surname?>" maxlength="32">
                                                </div>
                                            <?php else:?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Фамилия" id="surname" name="surname" maxlength="32">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 my-auto">
                                            <h6 class="mb-0">Имя:</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10 text-secondary">
                                            <?php if($user->firstname):?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Имя" id="firstname" name="firstname" value="<?=$user->firstname?>" maxlength="32">
                                                </div>
                                            <?php else:?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Имя" id="firstname" name="firstname" maxlength="32">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 my-auto">
                                            <h6 class="mb-0">Отчество:</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10 text-secondary">
                                            <?php if($user->patronymic):?>
                                                <div class="input-group input-group-sm flex-nowrap" maxlength="32">
                                                    <input type="text" class="form-control" placeholder="Отвество" id="patronymic" name="patronymic" value="<?=$user->patronymic?>">
                                                </div>
                                            <?php else:?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Отвество" id="patronymic" name="patronymic" maxlength="32">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 my-auto">
                                            <h6 class="mb-0">Изображение для профиля:</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10 text-secondary">
                                            <?php if($user->img_link):?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg" id="img_link" name="img_link" value="<?=$user->img_link?>" maxlength="255">
                                                </div>
                                            <?php else:?>
                                                <div class="input-group input-group-sm flex-nowrap">
                                                    <input type="text" class="form-control" placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg" id="img_link" name="img_link" maxlength="255">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success" name="btn-save" id="btn-save">Сохранить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                if (isset($_POST['btn-save'])) {

                                    $errors = array();
                                    if (trim(strlen($_POST['surname'])) > 32) {
                                        $errors[] = 'Введите фамилию менее 32 сивмолов';
                                    }
                                    if (trim(strlen($_POST['firstname'])) > 32) {
                                        $errors[] = 'Введите имя менее 32 сивмолов';
                                    }
                                    if (trim(strlen($_POST['patronymic'])) > 32) {
                                        $errors[] = 'Введите отчество менее 32 сивмолов';
                                    }
                                    if (trim(strlen($_POST['img_link']) > 255)) {
                                        $errors[] = 'Больше 255 в ссылке на изображение не допускается';
                                    }
                                    if (trim($_POST['surname'] == $user->surname)
                                    && (trim($_POST['firstname'] == $user->firstname))
                                    && (trim($_POST['patronymic'] == $user->patronymic))
                                    && (trim($_POST['img_link'] == $user->img_link))) {
                                        $errors[] = 'Вы должны изменить данные!';
                                    }
                                    if (empty($errors)) {
                                        $user->surname = trim($_POST['surname']);
                                        $user->firstname = trim($_POST['firstname']);
                                        $user->patronymic = trim($_POST['patronymic']);

                                        if ($_POST['img_link'] == '') {
                                            $user->img_link = '0';
                                        } else {
                                            $user->img_link = trim($_POST['img_link']);
                                        }
                                        R::store($user);
                                        header("Location: index");
                                        ob_end_flush();
                                    }
                                        else {
                                            echo '<div style="color: red;" class="text-center">'.array_shift($errors).'</div><br>';
                                    }
                                }
                            ?>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10 offset-xl-1 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div id="search-input-sidenav">
                                    <div class="test_data">
                                        <h4 class="text-center">Пройденные тесты:</h4>
                                        <table id="dtBasicExample" class="table mt-3 table-striped table-bordered table-secondary" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class='table-dark' scope="col" class="th-sm">Название теста</th>
                                                    <th class='table-dark' scope="col" class="th-sm">Дата прохождения</th>
                                                    <th class='table-dark' scope="col" class="th-sm">%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($tests_user as $test_one):?>
                                                    <tr class="sidenav-item sidenav-link">
                                                        <td><a href="test-result?test=<?=$test_one['test_id']?>"><?=$test_one['test_name']?>
                                                        </td>
                                                        <td><?=$test_one['date']?></td>
                                                        <td><?=round( ($test_one['correct_score'] / $test_one['all_count'] * 100 ), 2)?>%
                                                        </td>
                                                        
                                                    </tr>
                                                    <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
    </div>













    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="../libs/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="../js/profile.js"></script>

</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>
<?php endif ; ?>