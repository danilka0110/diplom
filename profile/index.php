<?php 
    require "../db.php";
    require_once '../includes/functions.php';
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
    $my_tests = get_test_by_author($user->login);
    $count_my_test = count($my_test);
    $count_my_test = 0;
    foreach ($my_tests as $item) {
        if($item['enable'] == 1) {
            $count_my_test += 1;
        }
       
    }
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
    <link rel="stylesheet" href="../css/tests.css">
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
            <li><a class="active" href="index"><?php echo $user->login?></a></li>
            <li><a href="tests">Мои тесты</a></li>
            <li><a href="surveys">Мои опросы</a></li>
            <?php if ($user->role == 1) :?>
            <li><a href="admin">Админ. панель</a></li>
            <?php endif ;?>
        </ul>
    </div>

    <div class="main-profile">
        <p class="p-my-profile">Мой профиль</p>
        <?php 

    $tests_user = R::getAll("SELECT test_id, test_name, correct_score, all_count, date
        FROM usersandtests
            WHERE user_id = $user->id");
    // print_arr($tests_user);

    ?>
        <div class="card card-index-profile">
            <div class="card-header text-center">
                <span><?php echo $user->login?></span>
                <p class="user-email"><?php echo $user->email?></p>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <span style="color: blue">Мои тесты:</span>
                        <a href="tests"><p style="font-size: 20px; color: black"><?=$count_my_test;?></p></a>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <span style="color: blue">Мои опросы:</span>
                        <p style="font-size: 20px">#</p>
                    </div>
                </div>
                <hr>

                <?php
                    if (isset($_GET['test'])) {
                        $test_id = (int)$_GET['test'];
                    }   
                    $test_data = get_test_data($test_id);
                ?>

                            
                <div id="search-input-sidenav">
                            
                    <div class="test_data">
                        <h4 class="text-center">Пройденные тесты:</h4>
                        <table id="dtBasicExample" class="table mt-3 table-striped table-bordered table-secondary" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="th-sm">Название теста</th>
                                    <th scope="col" class="th-sm">Дата прохождения</th>
                                    <th scope="col" class="th-sm">%</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tests_user as $test_one):?>
                                    <tr class="sidenav-item sidenav-link">
                                        <td><a href="index?test=<?=$test_one['test_id']?>"><?=$test_one['test_name']?>
                                        </td>
                                        <td><?=$test_one['date']?></td>
                                        <td><?=round( ($test_one['correct_score'] / $test_one['all_count'] * 100 ), 2)?>%
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach;?>
                            </tbody>
                        </table>
                        <?php if($test_data) :?>
                        <div class="result">
                            <?php 
                                $query_choice = R::getAll("SELECT question_id, answer_id
                                    FROM usertestresult
                                        WHERE test_id = $test_id AND user_id = $user->id");
                                // print_Arr($test_user_choice);
                                $user_choice = null;
                                foreach ($query_choice as $item) {
                                    $user_choice[$item['question_id']] = $item['answer_id'];
                                }
                                $result = get_correct_answers($test_id);
                                $test_all_data_result_user = get_test_data_result_for_user_profile($test_data, $result, $user_choice);
                                echo print_result_for_user_profile($test_all_data_result_user, $test_id);
                            ?>
                        </div>




                        <?php else : ?>
                        <p>Выберите тест</p>
                        <?php endif; ?>
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