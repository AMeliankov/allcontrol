<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AllControl</title>
    <link rel="stylesheet" href="/template/css/bootstrap.min.css">
</head>
<body>  
<style>
    body{
        padding-top:8rem;
        padding-bottom:4.2rem;
        background:rgba(0, 0, 0, 0.76);
    }
    .myform {
        padding: 1rem;
        width: 100%;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.2);
        border-radius: 1rem;
        outline: 0;
        max-width: 400px;
    }           
</style>  
<div class="container" >
    <div class="row">
        <div class="col " >
            <div class="myform form " style="margin: 0 auto;">
                <div class="logo m-3">
                    <div class=" text-center">
                        <h1>Авторизация</h1>
                    </div>
                </div>
                <form action="/login" method="post"> 
                    <div class="form-group">
                        <label for="login">Логин <b>admin</b></label>
                        <input type="text" class="form-control" id="login" required name="login">
                    </div>
                    <div class="form-group mx-auto">
                        <label for="password">Пароль <b>1234</b></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group col-6  mx-auto " >         
                        <button type="submit" name="submit" class=" col mt-2  btn btn-primary">Вход</button>
                    </div>                   
                </form>
            </div>
        </div>
    </div>       
</div>   
</body>
</html>