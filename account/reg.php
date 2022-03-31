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
    <title>Регистрация</title>
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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index">
            <img src="../img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top" style="margin-right: 16px;">
            <span class="brand-else">Paradigm Tests</span>
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
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../account/login">Вход</a>
                    </li>
                </ul>
        </div>
    </div>
</nav>
<div class="acc-form">
    <section class="vh-100">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 50px;">
                    <div class="card-body p-5">
                    <h2 class="text-uppercase text-center mb-5">Регистрация</h2>
                    <form action="reg" method="POST" class="sign_form">
                        <div class="form-outline mb-4">
                        <input required type="login" class="form-control form-control-lg" placeholder = "Логин" name="login" maxlength="20">
                        </div>
                        <div class="form-outline mb-4">
                        <input required type="email" class="form-control form-control-lg" placeholder = "Email" name="email">
                        </div>
                        <div class="form-outline mb-4">
                        <input required type="password" class="form-control form-control-lg" placeholder = "Пароль" name="password" maxlength="32">
                        </div>
                        <div class="form-outline mb-4">
                        <input required type="password" class="form-control form-control-lg" placeholder = "Введите пароль еще раз" name="password_2" maxlength="32">
                        </div>
                            <?php
                                $data = $_POST;
                                if(isset($data['reg']))
                                {
                                    $errors = array();
                                    if(trim($data['login']) == '') {
                                        $errors[] = 'Введите логин!';
                                    }

                                    if(strlen($data['login']) < 4 || strlen($data['login']) > 20) {
                                        $errors[] = 'Введите логин от 4 до 20 сивмолов!';
                                    }

                                    if (!preg_match("/^[a-z0-9_]+$/i", $data['login'])) {
                                        $errors[] = 'Вы используете запрещенные символы! Разрешенные символы: a-z, A-Z цифры 0-9, символ "_"';
                                    }

                                    if(trim($data['email']) == '') {
                                        $errors[] = 'Введите Email!';
                                    }
                            

                                    if(($data['password']) == '') {
                                        $errors[] = 'Введите пароль!';
                                    }
                            
                                    if(strlen($data['password']) < 6 || strlen($data['login']) > 32) {
                                        $errors[] = 'Введите пароль от 6 до 32 сивмолов!';
                                    }

                                    if($data['password_2'] != $data['password'])
                                    {
                                        $errors[] = 'Пароли не совпадают';
                                    }
                            
                                    if(R::count('users', "login = ?", array($data['login'])) > 0 )
                                    {
                                        $errors[] = 'Пользователь с таким логином уже зарегистрирован!';
                                    }
                            
                                    if(R::count('users', "email = ?", array($data['email'])) > 0 )
                                    {
                                        $errors[] = 'Пользователь с таким Email уже зарегистрирован!';
                                    }
                                    
                            
                                    if(empty($errors))
                                    {
                                        $user = R::dispense('users');
                                        $user->login = $data['login'];
                                        $user->email = $data['email'];
                                        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                                        R::store($user);
                                        header('Location: /'); 
                                        ob_end_flush();
                                    } else
                                    {
                                        echo '<div style="color: red;">'.array_shift($errors).'</div><br>';
                                    }
                                }               
                            ?>
                        <div class="form-check d-flex justify-content-center mb-4">
                        <input required
                            class="form-check-input me-2"
                            type="checkbox"
                            value=""
                            id="form2Example3cg"
                        />
                        <label class="form-check-label">
                            Я соглашаюсь с <a href="#!" class="text-body"><u>правилами пользования</u></a> сайта
                        </label>
                        </div>
                        <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" name="reg">Регистрация</button>
                        </div>
                        <p class="text-center text-muted mt-3 mb-0">Уже зарегистрированы? <a href="login" class="fw-bold text-body"><u>Войти</u></a></p>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
	integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>
</body>
</html>
<?php endif ; ?>