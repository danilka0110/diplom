<?php
    require "../db.php";
    require_once '../includes/functions.php';
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>

<?php if($user) : ?>

<?php 
    $my_tests = get_test_by_author($user->id);
    $count_my_tests = 0;
    foreach ($my_tests as $item) {
        if($item['enable'] == 1) {
            $count_my_tests += 1;
        }
    }

    $my_surveys = R::getAll("SELECT s.id, s.survey_name, s.description, s.img_link, s.author, s.date, s.count_passes, s.enable
    FROM survey s
        WHERE s.user_id = '$user->id'");
        
    $count_my_surveys = 0;
    foreach ($my_surveys as $item) {
        if($item['enable'] == 1) {
            $count_my_surveys += 1;
        }
    }

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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/index-profile.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark index-navbar fixed-top bg-dark">
      <div class="container-fluid">
          <a class="navbar-brand" href="/">
              <img src="../img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-top: -5px;">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="../tests">
                        <img src="../img/tests.png" alt="" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Тесты</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="../surveys">
                        <img src="../img/surveys.png" alt="" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Опросы</span>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="../contacts">
                        <img src="../img/contacts.png" alt="" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">Контакты</span>
                      </a>
                  </li>
                  <li class="nav-item" style="margin-right: 28px">
                      <a class="nav-link" href="../about">
                        <img src="../img/about.png" alt="" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                        <span style="margin-left: -3px;">О нас</span>
                      </a>
                  </li>
              </ul>
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

                            <a class="dropdown-item" href="">
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
                            <a class="dropdown-item" href="../account/logout">
                              <img src="../img/logout.png" alt="" width=24px height=24px>
                              <span style="margin-left: 2px;">Выход</span>
                            </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
      </div>
  </nav>

    <div class="nav-profile">
        <ul id="ul-nav-profile">
            <hr style="color: #fff; margin-top: -8.5px;">
            <li>
                <a class="active" href="index">
                    <div class="nav-profile-item active">
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
                <a href="surveys">
                    <div class="nav-profile-item">
                        <img src="../img/surveys.png" alt="surveys-profile-nav" width=24px height=24px>
                        <span>Опросы</span>
                    </div>
                </a>
            </li>

            <?php if ($user->role == 1) :?>
            <li>
                <a href="../admin/" class="adm">
                    <div class="nav-profile-item">
                        <img src="../img/admin-profile-nav.png" alt="admin-profile-nav" width=24px height=24px>
                        <span>Админ. панель</span>
                    </div>
                </a>
            </li>
            <?php endif ;?>
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
            <a href="index" class="btn btn-outline-primary mt-1 mb-1 active">
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
            <a href="surveys" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/surveys.png" alt="surveys-profile-nav" width=24px height=24px>
                    <span>Опросы</span>
                </div>
            </a>
            <?php if ($user->role == 1) :?>
            <a href="../admin/" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/admin-profile-nav.png" alt="admin-profile-nav" width=24px height=24px>
                    <span>Админ. панель</span>
                </div>
            </a>
            <?php endif ;?>
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
                        <li class="breadcrumb-item"><a href="">Профиль</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Мой профиль</li>
                    </ol>
                </nav>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">

                                    <button type="button" data-bs-toggle="modal" data-bs-target="#avatar-modal"
                                        style="border-radius: 50%;">
                                        <div class="profile-img">
                                            <?php if($user->img_link == '0'): ?>
                                            <img src="../img/user-profile-nav.png" alt="" width="150" height="150"
                                                style="border-radius: 50%; object-fit: cover;">
                                            <img src="../img/addphoto.png" alt="" width="38" height="35"
                                                class="addphoto">
                                            <?php else: ?>
                                            <img src="<?=$user->img_link?>" alt="" width="150" height="150"
                                                style="border-radius: 50%; object-fit: cover;">
                                            <img src="../img/addphoto.png" alt="" width="38" height="35"
                                                class="addphoto">
                                            <?php endif; ?>
                                        </div>
                                    </button>



                                    <div class="modal fade" id="avatar-modal" tabindex="-1" aria-labelledby="avatar-label" aria-hidden="true">



                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title index-modal-title" id="avatar-label">Введите ссылку на
                                                        картинку</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>


                                                <div class="modal-body">
                                                    <form action="" method="post" id="changeDataModal">
                                                        <div
                                                            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-secondary">
                                                            <div class="input-group input-group-sm flex-nowrap">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg"
                                                                    id="img_link" name="img_link" maxlength="255">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Закрыть</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                name="btn-save-modal" id="btn-save-modal">Сохранить
                                                                изменения</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>



                                        <?php
                                        if (isset($_POST['btn-save-modal'])) {
                                            $errors = array();
                                            if (trim(strlen($_POST['img_link']) > 255)) {
                                                $errors[] = 'Больше 255 в ссылке на изображение не допускается';
                                            }

                                            if (empty($errors)) {

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
                                                    echo '<span style="color: red;" class="text-center">'.array_shift($errors).'</span><br>';
                                                    header("Location: index");
                                                    ob_end_flush();
                                            }
                                        }
                                    ?>

                                    </div>

                                    <div class="mt-3" style="width: 250px">

                                        <?php if($user->surname && $user->firstname && $user->patronymic): ?>

                                        <h4><?=$user->surname?> <?=$user->firstname?> <?=$user->patronymic?></h4>

                                        <?php elseif($user->surname && $user->firstname): ?>

                                        <h4><?=$user->surname?> <?=$user->firstname?></h4>

                                        <?php else: ?>

                                        <h4><?=$user->login?></h4>

                                        <?php endif; ?>

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
                        <div class="card mb-3">
                            <div class="card-body">

                                <form action="" method="post" id="changeData">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-2 my-auto">
                                            <h6 class="mb-0">Фамилия:</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-10 text-secondary">
                                            <?php if($user->surname):?>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <input type="text" class="form-control" placeholder="Фамилия"
                                                    id="surname" name="surname" value="<?=$user->surname?>"
                                                    maxlength="32">
                                            </div>
                                            <?php else:?>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <input type="text" class="form-control" placeholder="Фамилия"
                                                    id="surname" name="surname" maxlength="32">
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
                                                <input type="text" class="form-control" placeholder="Имя" id="firstname"
                                                    name="firstname" value="<?=$user->firstname?>" maxlength="32">
                                            </div>
                                            <?php else:?>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <input type="text" class="form-control" placeholder="Имя" id="firstname"
                                                    name="firstname" maxlength="32">
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
                                                <input type="text" class="form-control" placeholder="Отчество"
                                                    id="patronymic" name="patronymic" value="<?=$user->patronymic?>">
                                            </div>
                                            <?php else:?>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <input type="text" class="form-control" placeholder="Отчество"
                                                    id="patronymic" name="patronymic" maxlength="32">
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
                                                <input type="text" class="form-control"
                                                    placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg"
                                                    id="img_link" name="img_link" value="<?=$user->img_link?>"
                                                    maxlength="255">
                                            </div>
                                            <?php else:?>
                                            <div class="input-group input-group-sm flex-nowrap">
                                                <input type="text" class="form-control"
                                                    placeholder="Пример: http://tic-tomsk.ru/wp-content/uploads/2020/11/scale_1200.jpg"
                                                    id="img_link" name="img_link" maxlength="255">
                                            </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success" name="btn-save"
                                                id="btn-save">Сохранить</button>
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

                                    if ((trim($_POST['surname'] === $user->surname)
                                    && (trim($_POST['firstname'] === $user->firstname))
                                    && (trim($_POST['patronymic'] === $user->patronymic))
                                    && (trim($_POST['img_link'] === $user->img_link))))

                                    {
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
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">
    </script>

</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>
<?php endif ; ?>