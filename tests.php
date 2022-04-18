<?php 
    require "db.php";
    require_once 'includes/functions.php';
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
    $tests = get_tests();
    $popular_tests = get_popular_tests();
    $categories = category_list();
    if(isset($_GET['category'])) {
        if ($_GET['category'] != NULL) {
          $category_data = $_GET['category'];
          
          if (!in_array("$category_data", $categories)) {
            header('Location: tests');
        } 
            $category_tests = get_tests_for_category($category_data);
        } else {
            header('Location: tests');
        }
      }
    //pagination
    $str = $_GET['page'];
    $page = formatstr($str);
    if($page === false) header('Location: tests');
    $count = 16;
    $page_count = (count($tests)) / $count;
    if ($page > $page_count || $page < 0) header('Location: tests');
    if(isset($_POST['search'])) {
      if ($_POST['search'] != NULL) {
        $search_data = $_POST['search'];
        
        $tests_search = get_tests_for_search($search_data);
        $page_count_search = (count($tests_search)) / $count;
        
      } else {
        header('Location: tests');
      }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты</title>
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
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tests.css">
    <link rel="stylesheet" href="css/tests-carousel.css">
    
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <?php if($user) : ?>
                <img src="img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top"
                    style="margin-right: 80px; margin-top: -3px;">
                <span class="brand">Paradigm Tests</span>
                <?php else : ?>
                <img src="img/icon.png" alt="favicon" width="34" height="34" class="d-inline-block align-text-top"
                    style="margin-right: 16px; margin-top: -3px;">
                <span class="brand-else">Paradigm Tests </span>
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
                        <a class="nav-link active" aria-current="page" href="tests">Тесты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="surveys">Опросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts">Контакты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about">О нас</a>
                    </li>
                </ul>
                <?php if($user) : ?>
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Профиль
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile"><?php echo $user->login?></a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="account/logout">Выход</a></li>
                        </ul>
                    </li>
                </ul>
                <?php else : ?>
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="account/login">Вход</a>
                    </li>
                </ul>
                <?php endif ; ?>
            </div>
        </div>
    </nav>


    <div class="main">
        <?php if ($tests): ?>      
            <?if ($_POST['search'] == NULL && $_GET['category'] == NULL) :?>
                <div class="container-fluid popular-tests-container text-center">
                    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner w-100">
                            <h3>Популярные тесты</h3>
                            <div class="row mt-4">
                                <?php foreach ($popular_tests as $key => $popular_test) :?>
                                    <?php if ($key == 0): ?>
                                        <div class="carousel-item active text-center">
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                <div class="card card-body">
                                                    <a href="test?test=<?=$popular_test['id']?>"><img
                                                            src="<?=$popular_test['img_link']?>" class="popular_test_img" alt="img"></a>
                                                    <a href="test?test=<?=$popular_test['id']?>"
                                                        style="margin-left: 5px;"><?=$popular_test['test_name']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="carousel-item text-center">
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                <div class="card card-body">
                                                    <a href="test?test=<?=$popular_test['id']?>"><img
                                                            src="<?=$popular_test['img_link']?>" class="popular_test_img" alt="img"></a>
                                                    <a href="test?test=<?=$popular_test['id']?>"
                                                        style="margin-left: 5px;"><?=$popular_test['test_name']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach ;?>
                            </div>
                            <button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
                                data-bs-slide="prev">
                                <img src="img/prev.png" alt="" width="34" height="34"></img>
                            </button>
                            <button class="carousel-control-btn" type="button" data-bs-target="#myCarousel"
                                data-bs-slide="next">
                                <img src="img/next.png" alt="" width="34" height="34">
                            </button>
                        </div>
                    </div>
                </div>
            <?php else :?>
            <?php endif ;?>
            



        <div class="container-fluid tests-container">
            <div class="row">
                <?php if ($_POST['search'] == NULL && $_GET['category'] == NULL) :?>

                <div class="container-fluid tests-container text-center">

                    <?php foreach($categories as $category) :?>
                    <a href="tests?category=<?=$category?>"><button class="btn btn-outline-primary mt-2 btn-category"
                            id="<?=$category?>"><?=$category?></button></a>
                    <?php endforeach?>
                </div>
                <form method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Поиск" aria-label="Поиск"
                            aria-describedby="button-addon2" name="search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Поиск</button>
                    </div>
                </form>
                <?php for ($i = $page*$count; $i < (($page+1)*$count); $i++):?>
                <?php if ($tests[$i]['id'] != NULL) :?>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 sidenav-item sidenav-link">
                    <div class="card card-test" style="width: 15rem; min-height: 24rem;">
                        <a href="test?test=<?=$tests[$i]['id']?>"><img src="<?=$tests[$i]['img_link']?>"
                                class="card-img-test" alt="..."></a>

                        <a href="test?test=<?=$tests[$i]['id']?>"
                            class="test-name-for-img"><?=$tests[$i]['test_name']?></a>

                        <div class="test-author-for-img mt-1 text-center">
                            <?php $user_img = get_user_img($tests[$i]['author']); ?>
                            <?php if($user_img): ?>
                                <img src="<?=$user_img?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <img src="img/user-profile-nav.png" alt="author.png" style="width:18px">
                            <?php endif; ?>
                            <span><?=$tests[$i]['author']?></span>
                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                            <span><?=$tests[$i]['count_passes']?></span>
                        </div>

                        <div class="card-body">
                            <p class="card-text test_description"><?=$tests[$i]['description']?></p>
                            <div class="text-center">
                                <a href="test?test=<?=$tests[$i]['id']?>" class="btn btn-primary btn-test">Пройти
                                    тест</a>
                            </div>
                        </div>


                    </div>
                    <hr>
                </div>
                <?php endif ;?>
                <?php endfor ;?>
                <div class="page-list" align="center">
                    <?php for ($p = 0; $p < $page_count; $p++) :?>
                    <?php if ($p == $_GET['page']):?>
                    <a href="tests?page=<?=$p?>"><button class="btn btn-outline-primary active"
                            id="<?=$p?>"><?=$p+1?></button></a>
                    <?php else:?>
                    <a href="tests?page=<?=$p?>"><button class="btn btn-outline-primary page_btn"
                            id="<?=$p?>"><?=$p+1?></button></a>
                    <?php endif;?>
                    <?php endfor ;?>
                </div>
                <?php elseif ($_POST['search'] != NULL && $_GET['category'] == NULL) :?>
                    <h3 class="text-center">Вы искали: <?=$search_data?></h3>
                    <?php if ($tests_search) :?>
                    <?php for ($i = 0; $i < count($tests_search); $i++):?>
                    <?php if ($tests_search[$i]['id'] != NULL) :?>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 sidenav-item sidenav-link">
                        <div class="card card-test" style="width: 14rem;">
                            <a href="test?test=<?=$tests_search[$i]['id']?>"><img src="<?=$tests_search[$i]['img_link']?>"
                                    class="card-img-test" alt="..."></a>

                            <a href="test?test=<?=$tests_search[$i]['id']?>"
                                class="test-name-for-img"><?=$tests_search[$i]['test_name']?></a>



                            <div class="test-author-for-img mt-1 text-center">
                                <?php $user_img = get_user_img($tests_search[$i]['author']); ?>
                                <?php if($user_img): ?>
                                <img src="<?=$user_img?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                <img src="img/user-profile-nav.png" alt="author.png" style="width:18px">
                                <?php endif; ?>
                                <span><?=$tests_search[$i]['author']?></span>
                                <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                <span><?=$tests_search[$i]['count_passes']?></span>
                            </div>

                            <div class="card-body">
                                <p class="card-text test_description"><?=$tests_search[$i]['description']?></p>
                                <div class="text-center">
                                    <a href="test?test=<?=$tests_search[$i]['id']?>" class="btn btn-primary btn-test">Пройти
                                        тест</a>
                                </div>
                            </div>


                        </div>
                    </div>
                    <?php endif ;?>
                    <?php endfor ;?>
                    <?php else :?>
                    <h3 class="text-center">Ничего не найдено</h3>
                    <?php endif ;?>


                <?php else :?>
                    <h3 class="text-center mb-4"><?=$category_data?></h3>
                    <?php if ($category_tests) :?>
                        <?php for ($i = 0; $i < count($category_tests); $i++):?>
                            <?php if ($category_tests[$i]['id'] != NULL) :?>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 sidenav-item sidenav-link">
                                    <div class="card card-test" style="width: 14rem;">
                                        <a href="test?test=<?=$category_tests[$i]['test_id']?>"><img
                                                src="<?=$category_tests[$i]['img_link']?>" class="card-img-test" alt="..."></a>
                                        <a href="test?test=<?=$category_tests[$i]['test_id']?>"
                                            class="test-name-for-img"><?=$category_tests[$i]['test_name']?></a>
                                        <div class="test-author-for-img mt-1 text-center">
                                            <?php $user_img = get_user_img($category_tests[$i]['author']); ?>
                                            <?php if($user_img): ?>
                                            <img src="<?=$user_img?>" alt="author.png" style="width:18px; height: 18px; object-fit: cover; border-radius: 50%;">
                                            <?php else: ?>
                                            <img src="img/user-profile-nav.png" alt="author.png" style="width:18px">
                                            <?php endif; ?>
                                            <span><?=$category_tests[$i]['author']?></span>
                                            <img src="../img/count_passes.png" alt="count_passes.png" style="margin-left: 2%">
                                            <span><?=$category_tests[$i]['count_passes']?></span>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text test_description"><?=$category_tests[$i]['description']?></p>
                                            <div class="text-center">
                                                <a href="test?test=<?=$category_tests[$i]['test_id']?>"
                                                    class="btn btn-primary btn-test">Пройти
                                                    тест</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ;?>
                        <?php endfor ;?>
                    <?php else :?>
                    <h4 class="text-center">Тестов с данной категории пока нет</h4>
                <?php endif ;?>



                <?php unset($_GET['category']); endif ;?>

            </div>
            <?php  else: //tests ?>
            <h3>Нет тестов</h3>
            <?php endif //tests ?>

        </div>
    </div>



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


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/tests.js"></script>



</body>

</html>