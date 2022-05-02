<?php 
    require "../db.php";
    require "../includes/functions-surveys.php";
    $user = R::findOne('users', 'id = ?', array($_SESSION['logged_user']->id));
    ob_start();
?>


<?php if($user) : ?>

<?php 
    if (isset($_GET['survey'])) {
        $survey_id = (int)$_GET['survey'];
    }   

    else {
        header('Location: surveys');
    }

    $check = R::getAll("SELECT * 
                            FROM survey
                                WHERE id = $survey_id AND user_id = $user->id");

    if(!$check) header('Location: surveys');

    $users_passing_count = R::getAll("SELECT COUNT(DISTINCT user_id) 
                                        FROM usersurveydata 
                                             WHERE survey_id = $survey_id");
    foreach ($users_passing_count as $item) {
        foreach ($item as $it) {
                $users_passing_count = $it;
        }
    }

    $get_survey_name = get_survey_name($survey_id);
    foreach ($get_survey_name as $item) {
            $survey_name = $item['survey_name'];
    }

    date_default_timezone_set('Moscow');
    $date = date('Y-m-d');


    $date_for_count_users_this_mounth = date('Y-m');
    $count_users_this_mounth_query = R::getRow("SELECT COUNT(DISTINCT(user_id))
                                            FROM `usersurveydata` 
                                                WHERE survey_id = $survey_id AND date LIKE '$date_for_count_users_this_mounth-%'");

    $count_users_this_mounth = $count_users_this_mounth_query['COUNT(DISTINCT(user_id))'];

    $date_create_query = R::getRow("SELECT date
                                        FROM `survey` 
                                            WHERE id = $survey_id");

    $date_create_temp = $date_create_query['date'];
    $date_temp = date_create($date_create_temp);
	$date_create = date_format($date_temp, 'd.m.Y');

    $survey_data = get_test_data($survey_id);

    $print_stats = print_graps_for_profile_stats($survey_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Статистика</title>
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
    <link rel="stylesheet" href="css/survey-stats.css">
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
                    <li class="breadcrumb-item"><a href="surveys">Опросы</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Опрос № <?=$survey_id?></li>
                </ol>
            </nav>

            <h2 class="text-center"><?=$survey_name?></h2>

            <div class="row first-stats-block-row">
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block">
                    <div class="card text-center">
                        <h6 class="card-title mt-4">Кол-во опрошенных пользователей</h6>
                        <div class="card-body">
                        <img src="../img/stats-count_users.png" alt="" width="54px" height="54px">
                            <span class="card-text stat"><?=$users_passing_count?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block">
                    <div class="card text-center">
                        <h6 class="card-title mt-4">Опрошенные в этом месяце</h6>
                        <div class="card-body">
                            <img src="../img/stats-date.png" alt="" width="54px" height="54px">
                            <span class="card-text stat"><?=$count_users_this_mounth?></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 first-stats-block">
                    <div class="card text-center">
                        <h6 class="card-title mt-4 stat-date-title">Дата создания опроса</h6>
                        <div class="card-body stat-date">
                            <img src="../img/stats-date2.png" alt="" width="54px" height="54px">
                            <span class="card-text stat-date-span"><?=$date_create?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?=$print_stats?>

        </div>
    </div>
</div>








	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
		integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
	</script>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="../js/survey.js"></script>
</body>

</html>
<?php else : 
  header('Location: /'); 
  ob_end_flush();
?>  
<?php endif ; ?>
