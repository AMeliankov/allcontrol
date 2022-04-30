<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AllControl</title>
    <script type="text/javascript" src="/template/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/template/js/popper.min.js"></script>
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
    <script type="text/javascript" src="/template/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/template/js/sweetalert2.js"></script>
</head>
<body> 
<?php 
    if(isset($_SESSION['userId']))
    {
        $infoUsers = UsersModel::getInfoUsersById($_SESSION['userId']); 
    }     
?>        
<nav class="navbar  navbar-expand-lg  navbar-dark bg-dark"  >
    <div class="navbar-brand" >
        <?= $infoUsers['name']?>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <?php 
            $array = [
                'admin' => [
                    'Проходная' => '/security',
                    'Работники' => '/workers',
                    'Иформация' => '/info',
                    'Табель' => '/table',
                    'Расчет' => '/money', 
                    'Пользователи' => '/users',
                ],
                'moderator' => [
                    'Работники' => '/workers',
                    'Иформация' => '/info',
                    'Табель' => '/table', 
                ],
                'security' => [
                    'Проходная' => '/security',
                    'Иформация' => '/info',
                ],
                'view' => [
                    'Работники' => '/workers',
                    'Иформация' => '/info',
                    'Табель' => '/table',
                    'Расчет' => '/money',
                ],
            ];        
            
            foreach ($array as $key => $value) {
                if($key == $infoUsers['role']){
                    foreach ($value as $name => $src) {
                        echo '<li class="nav-item "><a class="nav-link" href="'.$src.'">'.$name.'</a></li>'; 
                    }
                }
            } 
        ?>    
            <li class="nav-item ">
                <a class="nav-link" href="/exit">Выход</a>
            </li>
        </ul>
    </div>
</nav>  
<br>




