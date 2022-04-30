<?php require_once ROOT. '/views/layouts/header.php';?>

<div class="container">
    <h3 style="text-align: center;">Пользователи</h3><br>
    <a class=" btn btn-light mb-2" href="users/add">
        <img src="/template/img/add.png" alt="">Добавить
    </a>  
    <table class="table table-bordered table-responsive-lg table-hover table-sm" >
        <thead class="thead-light">
            <tr>
                <th class="align-middle text-center" scope="col">ID</th>
                <th scope="col">Логин</th>
                <th scope="col">Имя</th>
                <th scope="col">Роль</th>
                <th scope="col">Статус</th>
                <th class="align-middle text-center" scope="col">Функции</th>
            </tr>
        </thead>
        <tbody> 
        <?php
            $i = 1;
            foreach ($userList as $key => $value) { ?>
            <tr>
                <td class="align-middle text-center"><?= $value['u_id'] ?></td> 
                <td class="align-middle text-left"><?= $value['login'] ?></td> 
                <td class="align-middle text-left"><?= $value['name'] ?></td>    
                <td class="align-middle text-left"><?= $value['role'] ?></td>
                <td class="align-middle text-left"><?= $value['status'] ?></td>
                <td class="align-middle text-center">
                    <a class=" btn btn-light  btn-sm " href="/users/edit/<?= $value['u_id'] ?>" > 
                        <img src="/template/img/edit.png" alt="">Изменить</a> 
                    <a class=" btn btn-light  btn-sm " href="/users/delete/<?= $value['u_id'] ?>" >
                        <img src="/template/img/del.png" alt="">Удалить</a> 
                </td>
            </tr>
        <?php } ?>
        </tbody>  
    </table>
</div>

<?php require_once ROOT. '/views/layouts/footer.php';?>