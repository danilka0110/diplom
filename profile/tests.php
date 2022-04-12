<?php 
    require "../db.php";
    require "../includes/functions.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
    $tests = get_test_by_author($user->login);

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
    <link rel="stylesheet" href="../css/profile.css">
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
                    <div class="nav-profile-item active"> 
                        <img src="../img/user-profile-nav.png" alt="user-profile-nav" width=24px height=24px>
                        <span><?php echo $user->login?></span>
                    </div>
                </a>
            </li>
            <li>
                <a href="tests" class="active">
                    <div class="nav-profile-item">
                        <img src="../img/tests-profile-nav.png" alt="tests-profile-nav" width=24px height=24px>
                        <span>Мои тесты</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="surveys">
                    <div class="nav-profile-item">
                        <img src="../img/surveys-profile-nav.png" alt="surveys-profile-nav" width=24px height=24px>
                        <span>Мои опросы</span>
                    </div>
                </a>
            </li>
            <?php if ($user->role == 1) :?>
            <li>

                <a href="admin">
                    <div class="nav-profile-item">
                        <img src="../img/admin-profile-nav.png" alt="admin-profile-nav" width=24px height=24px>
                        <span>Админ. панель</span>
                    </div>
                </a>
            </li>
            <?php endif ;?>
        </ul>
    </div>


<div class="main-profile">
    <div class="container"> 
        <div class="text-center mt-4">
            <a href="test-create" type="button" class="btn btn-primary">Создать тест</a>
        </div>



        <?php if ($tests): ?>
        <div class="row mt-4">
              <?php foreach($tests as $test):?>


                  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 sidenav-item sidenav-link">

                                <?php if($test['enable'] == 0) : ?>
                                    <div class="card card-test" style="width: 14rem;">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$test['date']?></span>
                                        </div>
                                        <img src="<?=$test['img_link']?>" class="card-img-test card-img-test-0" alt="...">   
                                        <a href="test?test=<?=$test['id']?>" class="test-name-for-img"><?=$test['test_name']?></a>
                                        <div class="test-author-for-img mt-1">
                                            <img src="../img/author.png" alt="author.png" style="width:14px">
                                            <span><?=$test['author']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?=$test['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:red"> в разработке</span>
                                            <div class="text-center">
                                                <a href="" class="btn btn-primary btn-test">Пройти тест</a>
                                            </div>
                                        </div>
                                    </div>




                                <?php elseif($test['enable'] == 1) : ?> 
                                    <div class="card card-test" style="width: 14rem;">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$test['date']?></span>
                                        </div>
                                        <a href="../test?test=<?=$test['id']?>"><img src="<?=$test['img_link']?>" class="card-img-test card-img-test-1" alt="..."> </a>  
                                        <a href="../test?test=<?=$test['id']?>" class="test-name-for-img"><?=$test['test_name']?></a>
                                        <div class="test-author-for-img mt-1">
                                            <img src="../img/author.png" alt="author.png" style="width:14px">
                                            <span><?=$test['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$test['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?=$test['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:green"> открыт</span>
                                            <div class="text-center">
                                                 <a href="../test?test=<?=$test['id']?>" class="btn btn-primary btn-test">Пройти тест</a>
                                            </div>
                                        </div>
                                    </div>






                                <?php else : ?> 
                                    <div class="card card-test" style="width: 14rem;">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$test['date']?></span>
                                        </div>
                                        <img src="<?=$test['img_link']?>" class="card-img-test" alt="...">   
                                        <a href="test?test=<?=$test['id']?>" class="test-name-for-img"><?=$test['test_name']?></a>
                                        <div class="test-author-for-img mt-1">
                                            <img src="../img/author.png" alt="author.png" style="width:14px">
                                            <span><?=$test['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$test['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?=$test['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:red"> непонятный</span>
                                            <div class="text-center">
                                                <a href="test?test=<?=$test['id']?>" class="btn btn-primary btn-test">Пройти тест</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ; ?>



                      






                    </div>
              <?php endforeach ?>
            </div>
        </div>
    <?php  else: //tests ?>
        <h3>Нет тестов</h3>
    <?php endif //tests ?>





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
