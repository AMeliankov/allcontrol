<?php require_once ROOT . '/views/layouts/header.php'; ?>

<div class="container">
    <h3 style="text-align: center;">Расчет</h3><br>
    <div class="row">

        <div class="col-lg-2">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Год:</div>
                </div>
                <select class="form-control" id="year">
                    <?php foreach ($yearArray as  $value) {
                        if ($value ==  date("Y")) {
                            echo '<option selected style="color: red; " value="' . $value . '">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Месяц:</div>
                </div>
                <select class="form-control" id="month">
                    <?php foreach ($monthArray as $key => $value) {
                        if ($key ==  date("m")) {
                            echo '<option style="color: red; " selected value="' . $key . '">' . $value . '</option>';
                        } else {
                            echo '<option  value="' . $key . '">' . $value . '</option>';
                        }
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">Бригадир:</div>
                </div>
                <select class="form-control" id="commander">
                    <?php foreach ($commanderList as $key => $value) {

                        echo '<option value="' . $value['w_id'] . '">';
                        echo $value['surname'] . ' ' . $value['name'];
                        echo '</option>';
                    } ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3">
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

    <div class="border" style="height: 60vh; overflow-y: scroll; overflow-x: scroll;">
        <div id="result"></div>
        <div id="loader" style="text-align: center; margin-top: 15%;  ">
            <div class="spinner-border text-dark" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

</div>



<script>
    $('#commander, #year, #month, #search').bind('input', function() {
        $.ajax({
            beforeSend: function() {
                $('#loader').show();
                $('#result').hide();
            },
            complete: function() {
                $('#loader').hide();
                $('#result').show();
            },
            url: '/money',
            method: 'post',
            dataType: 'html',
            data: {
                commander: $('#commander').val(),
                year: $('#year').val(),
                month: $('#month').val(),
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
            url: '/money',
            method: 'post',
            dataType: 'html',
            data: {
                commander: $('#commander').val(),
                year: $('#year').val(),
                month: $('#month').val(),
                search: $('#search').val()
            },
            success: function(data) {
                $('#result').html(data);
            }
        });
    });
</script>

<?php require_once ROOT . '/views/layouts/footer.php'; ?>