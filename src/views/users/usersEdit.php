<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container" style=" margin: 0 auto; width: 400px;">
    <h3 style="text-align: center;">Изменение </h3><br>
    <form action="/users/edit/<?= $userEdit['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col">

                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input class="form-control" type="text" value="<?= $userEdit['login'] ?>" name="login" required>
                </div>

                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input class="form-control" type="text" value="<?= $userEdit['name'] ?>" name="name" required>
                </div>

                <div class="form-group">
                    <label for="status">Статус:</label>
                    <select class="form-control" name="status">
                        <?php if ($userEdit['status'] == 1) {
                            echo '<option selected style="color: red; " value="1">Активен</option>';
                            echo '<option value="0">Не активен</option>';
                        } else {
                            echo '<option style="color: red; " value="0">Не активен</option>';
                            echo '<option value="1">Активен</option>';
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Роль:</label>
                    <select class="form-control" name="role">
                        <?php foreach ($roleList as $key => $value) {
                            if ($value['r_role'] == $userEdit['role']) {
                                echo '<option selected style="color: red; " value="' . $value['r_id'] . '">' . $value['r_role'] . '</option>';
                            } else {
                                echo '<option  value="' . $value['r_id'] . '">' . $value['r_role'] . '</option>';
                            }
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="passwordChek">
                    <label for="passwordChek">Изменить пароль</label>

                </div>

                <div class="form-group" id="passwordGroup">
                    <label for="password">Новый пароль:</label>
                    <input class="form-control" type="text" placeholder="Введите новый пароль" id="password" name="password">
                </div>

                <div class="form-group">
                    <input class="btn btn-light " type="submit" name="userEdit" value="Изменить">
                    <a href="/users" class="btn btn-light ">Отмена</a>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    $('#passwordGroup').hide();
    $('#passwordChek').click(function() {
        if ($(this).is(':checked')) {
            $('#passwordGroup').show(100);
        } else {
            $('#passwordGroup').hide(100);
            $('#password').val('');
        }
    });
</script>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>