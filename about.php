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
	<title>О нас</title>
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
	<link rel="stylesheet" href="css/about.css">
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
                      <a class="nav-link" aria-current="page" href="tests">
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
                      <a class="nav-link active active-nav-page" href="about">
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
    <div class="row text-center about-content">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="card">
          <img src="img/tests.png" alt="" width="48" height="48" class="card-img-about">
          <h4>Тесты</h4>
          <p class="mt-2 card-text">Padadigm Test предоставляет возможность проходить множество тестов по различных категориям! В нашем арсенале есть как образовательные тесты, пройдя которые Вы сможете получить статистику пройденного теста (к примеру: средний балл пользователей пройденного теста), а так же сможете посмотреть свой результат в виде правильных и неправильных ответов. Так же у нас предусмотрена возможность прохождения психологического теста, где количество баллов за все ответы будут складываться и в конце будет показываться расшифровка (то, что создатель теста подразумевал в качестве резльутата при набранных определенных баллах)</p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">   
        <div class="card">
          <img src="img/preview.png" alt="" width="48" height="48" class="card-img-about">
          <h4>Создавайте!</h4>
          <p class="mt-2 card-text">После успешной регистрации и авторизации, пользователям предоставляется возможность создавать тесты и опросы! Только что созданные тесты и опросы будут проходить проверку администраторами сайта на выявление неподобающего контента, а так же проверяться на правильной заполнения формы. После успешного принятия теста администратором Ваш тест (опрос) появится в общем пользовании!</p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
        <div class="card">
          <img src="img/surveys.png" alt="" width="48" height="48" class="card-img-about">
          <h4>Опросы</h4>
          <p class="mt-2 card-text">Так же, мы предоставляем возможность прохождения опросов. У множества компаний, предприятий, а так же физических лиц и др. вознимает необходимость или желание провести опрос среди людей, с целью выявления более популярных вещей, продуктов питания, сфер услуг и пр.. Для таких запросов и были добавлены опросы. Пользователь, который пройдет опрос, сможет посмотреть подробную статистику в конце опроса, какие ответы оказались наиболее популярными.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-center text-white">
  <div class="container p-4">
    <section class="mb-4">
      <p>
        Приложение разработано для прохождения и создания тестов и опросов, а так же для просмотра статистика и результатов тестирования. Приятного пользования :)
      </p>
    </section>
		<footer class="footer-06">
			<div class="container">
				<div class="row pt-4">
					<div class="col-md-3 col-lg-6 order-md-last">
						<div class="row justify-content-end">
							<div class="col-md-12 col-lg-9 text-md-right mb-md-0 mb-4">
								<a href="/"><img src="img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-top: -5px;"></a>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-lg-6">
						<div class="row">
							<div class="col-md-4 mb-md-0 mb-4">
								<h2 class="footer-heading">Меню</h2>
                <hr class="first-hr">
                <hr class="second-hr">
								<ul class="list-unstyled">
		              <li>                      
                    <a class="nav-link" aria-current="page" href="tests">
                      <img src="img/tests.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                      <span style="margin-left: -3px;">Тесты</span>
                    </a>
                    
                  </li>

		              <li>                      
                    <a class="nav-link" href="surveys">
                      <img src="img/surveys.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                      <span style="margin-left: -3px;">Опросы</span>
                    </a>
                  </li>
                    
                  <li>                      
                    <a class="nav-link" href="contacts">
                      <img src="img/contacts.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                      <span style="margin-left: -3px;">Контакты</span>
                    </a>
                  </li>

                  <li>                      
                    <a class="nav-link" href="about">
                      <img src="img/about.png" alt="favicon" width="24" height="24" class="d-inline-block align-text-top" style="margin-top: -3px">
                      <span style="margin-left: -3px;">О нас</span>
                    </a>
                  </li>
		            </ul>
							</div>
              <div class="col-md-4 mb-md-0 mb-4">
								<h2 class="footer-heading">Соц. сети</h2>
                <hr class="first-hr">
                <hr class="second-hr">
								<ul class="list-unstyled">
                    <li class="nav-link">
                    <img src="img/vk.png" alt="" width="30px" height="30px">
                    <a href="">ВКонтакте</a>
                  </li>
                  <li class="nav-link">
                    <img src="img/telegram.png" alt="" width="30px" height="30px">
                    <a href="">Телеграм</a>
                  </li>
		            </ul>
							</div>
							<div class="col-md-4 mb-md-0 mb-4">
								<h2 class="footer-heading">Контакты</h2>
                <hr class="first-hr">
                <hr class="second-hr">
                <ul class="list-unstyled">
                  <div>
                    <li class="nav-link">
                      <img src="img/mail.png" alt="" width="30" height="30">
                      <span style="word-break: break-all; color: #fff">paradigm.tests.help@gmail.com</span>
                    </li>
                  </div>
		            </ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
  </div>
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    © <script>document.write(new Date().getFullYear());</script> Copyright:
    <a class="text-white" href="/">Paradigm Tests</a>
  </div>
</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
</body>

</html>
