<?php
    require "../db.php";
    require "../includes/functions.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>


<?php if($user) : ?>

<?php 
    $tests = get_test_by_author($user->id);

    $tests_user = R::getAll("SELECT test_id, test_name, correct_score, all_count, date
    FROM usersandtests
        WHERE user_id = $user->id");

    $psychology_tests_user = R::getAll("SELECT test_id as psychology_test_id, test_name, score, all_count, date
    FROM usersandpsychologytest
        WHERE user_id = $user->id");

    $all_tests_user = array_merge($tests_user, $psychology_tests_user);
?>

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
	<link rel="stylesheet" href="../css/tests.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/tests-profile.css">
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

                            <a class="dropdown-item" href="index">
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
                <a href="tests" class="active">
                    <div class="nav-profile-item active">
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
        <a href="tests" class="btn btn-outline-primary mt-1 mb-1 active">
            <div class="nav-profile-item">
                <img src="../img/tests.png" alt="tests-profile-nav" width=24px height=24px
                    style="margin-left: 3px">
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
                    <li class="breadcrumb-item"><a href="index">Профиль</a></li>
                    <li class="breadcrumb-item"><a href="tests">Тесты</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Мои тесты</li>
                </ol>
            </nav>

            <div class="btns-nav-tests-block text-center">

                    <button type="button" class="btn btn-outline-primary btn-show-profile-tests btn-show-my-tests-in-profile active"><span>Мои тесты</span></button>
                  
                    <button type="button" class="btn btn-outline-primary btn-show-profile-tests btn-show-my-passes-tests-in-profile"><span>Пройденные тесты</span></button>
 
                    <button type="button" class="btn btn-outline-primary btn-show-profile-tests btn-test-create" data-bs-toggle="modal" data-bs-target="#test-create-modal"><span>Создать тест</span></button>
          
                    <div class="modal fade" id="test-create-modal" tabindex="-1" aria-labelledby="test-create-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="test-create-label">Выберите тип теста</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <a href="test-create"><b>Обычный тест</b>
                                    <p><i>Ответы пользователя сопоставляются с правильными ответами и выводится статистика прохождений другими пользователями и результат в виде правильных (неправильных ответов)</i></p>
                                    </a>   
                                                            
                                    <a href="psychology-test-create"><b>Психологический тест</b>
                                    <p><i>Баллы теста суммируются и по прохождению теста выводится Ваш результат</i></p>
                                    </a>  

                                </div>
                            </div>
                        </div>
                    </div>









            </div>

            <div class="my-tests">

                <div class="input-group mb-3 mt-3">
                    <input type="text" class="form-control" placeholder="Поиск" id="search_test">
                </div>

                <?php if ($tests): ?>
                <div class="row mt-4">
                    <?php foreach($tests as $test):?>

                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 sidenav-item sidenav-link elastic">

                                <?php if($test['enable'] == 0) : ?>
                                    <div class="card card-test">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$test['date']?></span>
                                        </div>
                                        <img src="<?=$test['img_link']?>" class="card-img-test card-img-test-0" alt="...">   
                                        <a href="" class="test-name-for-img"><?=$test['test_name']?></a>
                                        <div class="test-author-for-img mt-1 text-center">

                                            <?php if($user->img_link): ?>

                                                <img src="<?=$user->img_link?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php else: ?>

                                                <img src="../img/user-profile-nav.png" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php endif; ?>

                                            <span><?=$test['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$test['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text test_description"><?=$test['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:red"> в разработке</span>
                                            <div class="text-center">
                                                <a href="" class="btn btn-primary btn-test">Пройти тест</a>
                                            </div>
                                        </div>
                                    </div>


                                <?php elseif($test['enable'] == 1) : ?> 
                                    <div class="card card-test">
                                        <div>
                                            <img class="test-date-img" src="../img/date.png" alt="date.png" style="width:16px">
                                            <span class="test-date-for-img"><?=$test['date']?></span>
                                        </div>
                                        <a href="../test?test=<?=$test['id']?>"><img src="<?=$test['img_link']?>" class="card-img-test card-img-test-1" alt="..."> </a>  
                                        <a href="../test?test=<?=$test['id']?>" class="test-name-for-img"><?=$test['test_name']?></a>
                                        <div class="test-author-for-img mt-1 text-center">

                                            <?php if($user->img_link): ?>

                                                <img src="<?=$user->img_link?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php else: ?>

                                                <img src="../img/user-profile-nav.png" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">

                                            <?php endif; ?>

                                            <span><?=$test['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$test['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text test_description"><?=$test['description']?></p>
                                            <span>Статус:</span>
                                            <span style="color:green"> открыт</span>
                                            <div class="text-center">
                                                    <a href="../test?test=<?=$test['id']?>" class="btn btn-primary btn-test">Пройти тест</a>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif ; ?>

                            </div>

                    <?php endforeach ?>
                    </div>
                </div>
                <?php  else: //tests ?>
                    <h3 class="mt-2" style="text-align: center">Нет тестов</h3>
                <?php endif //tests ?>
            </div>



            <div class="my-passes-tests none">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8 offset-xl-2">
                        <div class="card h-100 card-table">
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
                                                <?php foreach ($all_tests_user as $test_one):?>

                                                    <?php 
                                                        $test_id = $test_one['test_id']; 
                                                        $psychology_test_id = $test_one['psychology_test_id'];
                                                        if ($test_id) {
                                                            $test = R::findOne( 'test', ' id LIKE ? ', [ "$test_id" ] );  
                                                        }
                                                        else {
                                                            $test = R::findOne( 'test', ' id LIKE ? ', [ "$psychology_test_id" ] );
                                                        }      
                                                    ?>

                                                    <tr class="sidenav-item sidenav-link">

                                                        <td>

                                                            <img src="<?=$test->img_link?>" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">

                                                            <?php if($test_id): ?>
                                                                <a href="test-result?test=<?=$test_one['test_id']?>" class="table_test_name"><?=$test_one['test_name']?></a>
                                                            <?php else: ?>
                                                                <a href="test-result?test=<?=$test_one['psychology_test_id']?>" class="table_test_name"><?=$test_one['test_name']?></a>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                             <img src="../img/date.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                                                            <?=$test_one['date']?>
                                                        </td>

                                                        <td>

                                                            <?php if($test_id): ?>
                                                                <?php $percent = round( ($test_one['correct_score'] / $test_one['all_count'] * 100 ), 2);?>

                                                                <?=$percent?>%

                                                                <?php if($percent >= 75): ?>
                                                                    <img src="../img/good-passes.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                                                                <?php elseif($percent < 75 && $percent >=50): ?>
                                                                    <img src="../img/okay-passes.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                                                                <?php elseif($percent < 50): ?>
                                                                    <img src="../img/bad-passes.png" alt="" width=24px height=24px class="navbar-profile-img" style="border-radius: 50%; object-fit: cover">
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span><?=$test_one['score']?> б.</span>
                                                            <?php endif; ?>


                                                            





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
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
  </script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
  </script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> 
  <script src="../libs/jquery.dataTables.min.js">
  </script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">
  </script>  
  <script src="js/profile-tests.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
