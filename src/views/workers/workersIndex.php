<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <h3 style="text-align: center;">Работники</h3><br>
    <div class="row">
        <div class="col-lg-auto">
            <div class="form-group ">
                <a class=" btn  btn-light" href="workers/add">
                    <img src="/template/img/add.png" alt="">Добавить
                </a>
            </div>
        </div>
        <div class="col-lg-auto">
            <div class="form-group ">
                <button type="button" class="btn  btn-light  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/template/img/info.png" alt="">Информация
                </button>
                <div class="dropdown-menu p-3 " style="width: 165px;">
                    <?php echo 'Всего: ' . $countWorkersAll . '<br>';
                    foreach ($countWorkersProfession as $key => $value) {
                        echo $value['name'] . ': ' . $value['count'] . '<br>';
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <img src="/template/img/search.png" alt="">
                    </div>
                </div>
                <input type="text" id="search" placeholder="Поиск" class="form-control">
            </div>
        </div>
    </div>
    <div class="border" style="height: 60vh; overflow-y: scroll; overflow-x: scroll; ">
        <div id="loader" style="text-align: center; margin-top: 15%;  ">
            <div class="spinner-border text-dark" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div id="result"></div>
    </div>
</div>

<script>
    $('#search').bind('input', function() {
        $.ajax({
            beforeSend: function() {
                $('#loader').show();
                $('#result').hide();
            },
            complete: function() {
                $('#loader').hide();
                $('#result').show();
            },
            url: '/workers',
            method: 'post',
            data: {
                search: $('#search').val()
            },
            success: function(data) {
                $('#result').html(data);
            }
        });
    });

    $(window).on('load', function() {
        $.ajax({
            beforeSend: function() {
                $('#loader').show();
                $('#result').hide();
            },
            complete: function() {
                $('#loader').hide();
                $('#result').show();
            },
            url: '/workers',
            method: 'post',
            data: {
                search: $('#search').val()
            },
            success: function(data) {
                $('#result').html(data);
            }
        });
    });

</script>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>