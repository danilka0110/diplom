<?php 
    require "../db.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>


<?php if($user->role == 1) : ?>

<?php 
    $users_count_query = R::getRow('SELECT COUNT(id) as count_users
                                        FROM users');   
    $users_count = $users_count_query['count_users'];

    $tests_count_query = R::getRow('SELECT COUNT(id) as count_tests
                                        FROM test');   
    $tests_count = $tests_count_query['count_tests'];

    $surveys_count_query = R::getRow('SELECT COUNT(id) as count_surveys
                                        FROM survey');   
    $surveys_count = $surveys_count_query['count_surveys'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Админ. панель</title>
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
	<link rel="stylesheet" href="../profile/css/test-create.css">
    <link rel="stylesheet" href="../profile/css/profile.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>



    <nav class="navbar navbar-expand-lg navbar-dark index-navbar fixed-top">
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

                            <a class="dropdown-item" href="../profile/">
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
                        <span>Админ. профиль</span>
                    </div>
                </a>
            </li>
            <li>
                <a href="users">
                    <div class="nav-profile-item">
                        <img src="../img/adm-users.png" alt="" width=24px height=24px class="navbar-profile-img"
                            style="border-radius: 50%; object-fit: cover">
                        <span>Пользователи</span>
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
                    <span>Админ. профиль</span>
                </div>
            </a>
            <a href="users" class="btn btn-outline-primary mt-1 mb-1">
                <div class="nav-profile-item">
                    <img src="../img/adm-users.png" alt="tests-profile-nav" width=24px height=24px style="margin-left: 3px">
                    <span style="margin-left: -3px">Пользователи</span>
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
        </div>


        <div class="container">
            <div class="main-body">
                <nav aria-label="breadcrumb" class="main-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Админ. профиль</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Мой профиль</li>
                    </ol>
                </nav>
    
                                
                <div class="row first-stats-block-row mt-2">
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block mt-4">
                    <a href="users">
                        <div class="card text-center">
                            <h4 class="card-title mt-4">Пользователей</h4>
                            <div class="card-body">
                            <img src="../img/adm-users.png" alt="" width="54px" height="54px">
                                <span class="card-text stat"><?=$users_count?></span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block mt-4">
                    <a href="tests">
                        <div class="card text-center">
                            <h4 class="card-title mt-4">Тестов</h4>
                            <div class="card-body">
                                <img src="../img/tests.png" alt="" width="54px" height="54px">
                                <span class="card-text stat"><?=$tests_count?></span>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block mt-4">
                    <a href="surveys">
                        <div class="card text-center">
                            <h4 class="card-title mt-4">Опросов</h4>
                            <div class="card-body stat-date">
                                <img src="../img/surveys.png" alt="" width="54px" height="54px">
                                <span class="card-text stat"><?=$surveys_count?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            </div>
        </div>
    </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
  </script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
