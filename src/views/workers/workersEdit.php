<?php include_once ROOT . '/views/layouts/header.php'; ?>

<script src="/template/js/jquery.maskedinput.min.js"></script>

<div class="container">

    <h3 style="text-align: center;">Изменение</h3><br>
    <form action="/workers/edit" id="form1" method="post">
        <div class="row">
            <?php $index = 0;
            foreach ($workersEdit as $key => $valueEdit) { ?>
                <div class="col-sm-3 border border-primary m-1">

                    <input type="hidden" value="<?= $valueEdit['id'] ?>" name="workers[<?= $index ?>][id]">

                    <div class="form-group">
                        <label for="name">Имя:</label>
                        <input class="form-control form-control-sm" type="text" value="<?php echo $valueEdit['name']; ?>" name="workers[<?= $index ?>][name]">
                    </div>
                    <div class="form-group">
                        <label for="surname">Фамилия:</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $valueEdit['surname'] ?>" name="workers[<?= $index ?>][surname]">
                    </div>
                    <div class="form-group">
                        <label for="father">Отчество:</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $valueEdit['father'] ?>" name="workers[<?= $index ?>][father]">
                    </div>
                    <div class="form-group">
                        <label for="change">Смена:</label>
                        <select class="form-control form-control-sm" name="workers[<?= $index ?>][smena]">
                            <?php foreach ($smenaList as $value) {
                                if ($value == $valueEdit['smena']) {
                                    echo '<option selected style=" color: red;" value="' . $value . '" >' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $value . '" >' . $value . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profession">Специальность:</label>
                        <select class="form-control form-control-sm" name="workers[<?= $index ?>][profession]">
                            <?php $i = 0;
                            foreach ($professionList as $key => $value) {
                                if ($valueEdit['profession'] == $value['id']) {
                                    echo '<option selected value="' . $value['id'] . '"style="color: red;">' . $value['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $value['id'] . '" >' . $value['name'] . '</option>';
                                }
                                $i++;
                            } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="commander">Бригадир:</label>
                        <select class="form-control form-control-sm" value="<?= $valueEdit['commander'] ?>" name="workers[<?= $index ?>][commander]">
                            <?php $i = 0;
                            if ($valueEdit['commander'] == 0) {
                                echo '<option selected style="color: red;" value ="0">Бригадир</option>';
                            } else {
                                echo '<option value ="0">Бригадир</option>';
                            }
                            foreach ($commanderList as $key => $value) {
                                if ($valueEdit['commander'] == $value['w_id']) {
                                    echo '<option selected  value="' . $value['w_id'] . '" style="color: red;">' . ++$i . '. ' . $value['name'] . ' ' . $value['surname'] . '</option>';
                                } else {
                                    echo '<option value="' . $value['w_id'] . '" >' . ++$i . '. ' . $value['name'] . ' ' . $value['surname'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="commander">Статус:</label>
                        <select class="form-control form-control-sm" value="<?= $valueEdit['status'] ?>" name="workers[<?= $index ?>][status]">
                            <?php
                            if ($valueEdit['status'] == 1) {
                                echo '<option selected style="color: red; " value ="1">Работает</option>';
                                echo '<option value ="0">Не работает</option>';
                            } else {
                                echo '<option  value ="1">Работает</option>';
                                echo '<option selected style="color: red; " value ="0">Не работает</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон:</label>
                        <input class="form-control form-control-sm phone" type="text" value="<?= $valueEdit['phone'] ?>" name="workers[<?= $index ?>][phone]">
                    </div>
                </div>
            <?php $index++;
            } ?>
        </div>
        <input class="btn btn-primary" type="submit" name="workersformedit" id="submit1" value="Изменить">
        <a class="btn btn-primary" href="/workers" value="">Отмена</a>
    </form>
</div>

<script>
    $('.phone').mask("+7 (999) 999-99-99");
</script>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>