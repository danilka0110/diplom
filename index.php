<?php 
    require "db.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
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
	<link rel="stylesheet" href="css/index.css">
</head>
<body>


<div class="index-img">
  <nav class="navbar navbar-expand-lg navbar-dark index-navbar">
      <div class="container-fluid">
          <a class="navbar-brand" href="/">
          <?php if($user) : ?>
              <img src="img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-top: -5px">
          <?php else : ?> 
              <img src="img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-right: 12px; margin-top: -5px">
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
                  <li class="nav-item" style="margin-right: 28px">
                      <a class="nav-link" href="about">О нас</a>
                  </li>
              </ul>
              <?php if($user) : ?>
              <ul class="navbar-nav ml-auto mb-2 mb-lg-0 navbar-profile navbar-profile-dropdown">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <?php if($user->img_link == '0'): ?>
                              <img src="../img/user-profile-nav.png" alt="" width="34" height="34" class="navbar-profile-img" style="border-radius: 50%">
                          <?php else: ?>
                              <img src="<?=$user->img_link?>" alt="" width="34" height="34" class="navbar-profile-img" style="border-radius: 50%">
                          <?php endif; ?>  
                          <span style="margin-left: 2px;">Профиль</span>
                      </a>
                      <ul class="dropdown-menu nav-dropdown-menu" aria-labelledby="navbarDropdown">
                          <li>

                            <a class="dropdown-item" href="profile">
                              <?php if($user->img_link == '0'): ?>
                                  <img src="../img/user-profile-nav.png" alt="" width="24" height="24" class="navbar-profile-img" style="border-radius: 50%">
                              <?php else: ?>
                                  <img src="<?=$user->img_link?>" alt="" width="24" height="24" class="navbar-profile-img" style="border-radius: 50%">
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
  <section class="vh-100">
    <div class="container">
      <div class="wrap-index">
        <h1 class="index-title anim-items">Тесты. Опросы. Статистика</h1>
        <h2 class="index-desc anim-items">Мы рады приветствовать тебя на нашем сайте!</h2>
        <div class="d-flex">
          <a href="#first-block" class="btn-get-started scrollto anim-items index-btn">Поехали</a>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="main" id="main">

<div id="first-block">
  <div class="container">
    <div class="row first-block">
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 justify-content-start anim-items">
        <div class="card text-center first-card-index anim-show-first-block-first-card">
          <img src="img/tests.png" alt="tests" class="img-card-index">
          <h5 class="card-title mt-4">Тесты</h5>
          <div class="card-body">
            <p class="card-text">На нашем сайте вы можете протестироваться по интересующей Вас теме</p>
            <a href="tests" class="btn btn-primary first-block-btn-card">К тестам</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 justify-content-center anim-items">
        <div class="card text-center first-card-main-index anim-show-first-block-second-card">
          <img src="img/icon.png" alt="tests" class="img-card-main-index">
          <h5 class="card-title mt-4">Paradigm Test</h5>
          <div class="card-body">
            <p class="card-text">Paradigm test - система, предназначенная для проведения тестирования и опросов. </p>
            <a href="#second-block" class="btn btn-primary first-block-btn-card-main">Дальше</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 justify-content-end anim-items">
        <div class="card text-center first-card-index anim-show-first-block-third-card">
          <img src="img/surveys.png" alt="tests" class="img-card-index">
          <h5 class="card-title mt-4">Опросы</h5>
          <div class="card-body">
            <p class="card-text">Вы сможете пройти опрос и получить статистику, для просмотра ответов других пользоватей</p>
            <a href="surveys" class="btn btn-primary first-block-btn-card">К опросам</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<section class="" id="second-block">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 justify-content-center anim-items block-test-constructor">
        <div class="card text-center first-card-index anim-show-second-block second-cards">
          <img src="img/tests.png" alt="tests" class="img-card-index">
          <h5 class="card-title mt-4">Создавайте тесты</h5>
          <div class="card-body">
            <p class="card-text">Вы может создавать тесты по различным категориям. Нужно всего лишь зарегистрировать аккаунт!</p>
            <a href="profile/test-create" class="btn btn-primary second-block-btn-card-1 mt-2">Создать тест</a>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 justify-content-center anim-items block-survey-constructor">
        <div class="card text-center first-card-index anim-show-second-block second-cards">
          <img src="img/surveys.png" alt="tests" class="img-card-index">
          <h5 class="card-title mt-4">Создавайте опросы</h5>
          <div class="card-body">
            <p class="card-text">Хотите создать опрос и просматривать статистику по нему? Тогда регистрируйся на сайте и создавай!</p>
            <a href="profile/survey-create" class="btn btn-primary second-block-btn-card-2 mt-2">Создать опрос</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<footer class="bg-dark text-center text-white">
  <div class="container p-4">
    <section class="mb-4">
      <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
        distinctio earum repellat quaerat voluptatibus placeat nam,
        commodi optio pariatur est quia magnam eum harum corrupti dicta,
        aliquam sequi voluptate quas.
      </p>
    </section>

    <section class="">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 4</a>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 4</a>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 4</a>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Links</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
              <a href="#!" class="text-white">Link 4</a>
            </li>
          </ul>
        </div>
      </div>
    </section>

  </div>
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    © 2022 Copyright:
    <a class="text-white" href="#">Paradigm Tests</a>
  </div>
</footer>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="js/index.js"></script>
</body>

</html>
