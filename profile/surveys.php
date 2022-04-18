<?php 
    require "../db.php";
    require "../includes/functions-surveys.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>


<?php if($user) : ?>

<?php 
    $surveys = get_survey_by_author($user->id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Опросы</title>
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
    <link rel="stylesheet" href="css/tests-profile.css">
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
                        <li><a class="dropdown-item" href="me"><?php echo $user->login?></a></li>
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
                            <img src="../img/user-profile-nav.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                        <?php else: ?>
                            <img src="<?=$user->img_link?>" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
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
                    <img src="../img/user-profile-nav.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                <?php else: ?>
                    <img src="<?=$user->img_link?>" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                <?php endif; ?>  
                <span>Профиль</span>
            </div>
        </a>          
        <a href="tests" class="btn btn-outline-primary mt-1 mb-1">
            <div class="nav-profile-item">
                <img src="../img/tests.png" alt="tests-profile-nav" width=24px height=24px
                    style="margin-left: 3px">
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
                    <li class="breadcrumb-item"><a href="tests">Опросы</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Мои опросы</li>
                </ol>
            </nav>

            <div class="btns-nav-tests-block text-center">

                    <button type="button" class="btn btn-outline-primary btn-show-profile-tests btn-show-my-tests-in-profile active"><span>Мои опросы</span></button>
                  
                    <a href="survey-create" type="button" class="btn btn-outline-primary btn-show-profile-tests btn-test-create"><span>Создать опрос</span></a>

            </div>


            <div class="input-group mb-3 mt-3">
                <input type="text" class="form-control" placeholder="Поиск" id="search_surveys">
            </div>


            <?php if ($surveys): ?>
                <div class="row mt-4">
                    <?php foreach($surveys as $survey):?>

                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 sidenav-item sidenav-link elastic">

                                <?php if($survey['enable'] == 0) : ?>
                                    <div class="card card-test">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$survey['date']?></span>
                                        </div>
                                        <img src="<?=$survey['img_link']?>" class="card-img-test card-img-test-0" alt="...">   
                                        <a href="" class="test-name-for-img"><?=$survey['survey_name']?></a>
                                        <div class="test-author-for-img mt-1 text-center">

                                            <?php if($user->img_link): ?>

                                                <img src="<?=$user->img_link?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php else: ?>

                                                <img src="../img/user-profile-nav.png" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php endif; ?>

                                            <span><?=$survey['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$survey['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text test_description"><?=$survey['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:red"> в разработке</span>
                                            <div class="text-center">
                                                <a href="" class="btn btn-primary btn-test">Статистика</a>
                                            </div>
                                        </div>
                                    </div>


                                <?php elseif($survey['enable'] == 1) : ?> 
                                    <div class="card card-test">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$survey['date']?></span>
                                        </div>
                                        <a href="../survey?survey=<?=$survey['id']?>"><img src="<?=$survey['img_link']?>" class="card-img-test card-img-test-1" alt="..."> </a>  
                                        <a href="../survey?survey=<?=$survey['id']?>" class="test-name-for-img"><?=$survey['survey_name']?></a>
                                        <div class="test-author-for-img mt-1 text-center">

                                            <?php if($user->img_link): ?>

                                                <img src="<?=$user->img_link?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php else: ?>

                                                <img src="../img/user-profile-nav.png" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php endif; ?>

                                            <span><?=$survey['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$survey['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text test_description"><?=$survey['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:green"> открыт</span>
                                            <div class="text-center">
                                                    <a href="" class="btn btn-primary btn-test">Статистика</a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ; ?>

                            </div>

                    <?php endforeach ?>
                    </div>
                </div>
                <?php  else: //tests ?>
                    <h3 class="mt-2" style="text-align: center">Нет опросов</h3>
                <?php endif //tests ?>





        </div>
    </div>
</div>








	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="js/profile-surveys.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
