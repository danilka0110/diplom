<?php
    require "../db.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>

<?php if($user) :
     header('Location: /'); 
     ob_end_flush();
?>
<?php else : ?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля</title>
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
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark index-navbar bg-dark">
      <div class="container-fluid">
          <a class="navbar-brand" href="/">
              <img src="../img/icon.svg" alt="favicon" width="191" height="40" class="d-inline-block align-text-top" style="margin-right: 12px">
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
                <li class="nav-item" style="margin-right: 28px">
                    <a class="nav-link" href="../about">О нас</a>
                </li>
            </ul>  
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0 navbar-profile">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-secondary" href="login">Вход</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-secondary" href="reg">Регистрация</a>
                </li>
            </ul>
          </div>
      </div>
  </nav>


  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mb-4">
          <img src="../img/log.svg" alt="img" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Восстановление пароля</h3>
            </div>
            <form action="forgot" method="POST" class="sign_form">
                <div class="form-outline mb-4">
                    <input required type="email" class="form-control form-control-lg sign_form" placeholder = "Email" name="email">
                </div>
              
                <?php
                    $data = $_POST;

                    if(isset($data['forgot'])) {
                        $user = R::findOne('users', 'email = ?', array($data['email']));
                        if($user) {
                            $key = md5($user->login.rand(1000, 9999));
                            $user->change_key = $key;
                            R::store($user);

                            $url = $site_url.'account/newpass?key='.$key;
                            $message = $user->login.", был выполнен запрос на изменение вашего пароля. \n\n Для изменения перейдите по ссылке: ".$url."\n\n Если это были не Вы, то советуем вам изменить ваш пароль!";

                            mail($data['email'], 'Подтвердите действие', $message, "From: paradigm.tests.help@gmail.com \r\n");
                            header('Location: /'); 
                            ob_end_flush();
                        } else {
                            echo '<div style="color: red;"><p>Данный Email не зарегистрирован!</p></div>';
                            
                        }
                    }
                ?>

                        
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-acc btn-lg" name="forgot">Восстановить</button>
                    </div>
                </form>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
</body>
</html>
<?php endif ; ?>