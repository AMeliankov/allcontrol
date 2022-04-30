<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <h3 style="text-align: center;">Просмотр</h3><br>
    <div class="row">
        <div class="col-lg">
            <img class="" style="  " src="/photo/<?= $workersView['code'] ?>.png" alt="">
        </div>
        <div class="col-lg">
            <input type="hidden" id="id" value="<?= $workersView['w_id'] ?>">
            <label><?= "ID: " . $workersView['w_id']; ?></label><br>
            <label><?= "ФИО: " . $workersView['surname'] . " " . $workersView['name'] . " " . $workersView['father'] ?></label><br>
            <label><?= "Пропуск: " . $workersView['code']; ?></label><br>
            <label><?= "Смена: " . $workersView['smena']; ?> </label><br>
            <label><?= "Специальность: " . $workersView['profession'] ?> </label><br>
            <label><?= "Бригадир: " . $workersView['commander']; ?> </label><br>
            <label><?= "Телефон: " . $workersView['phone'] ?> </label><br>
            <label><?= "Статус: " . $workersView['status'] ?> </label><br>
        </div>
    </div>
</div>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>