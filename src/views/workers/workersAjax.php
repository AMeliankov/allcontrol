<style type="text/css">
    .image {
        display: none;
    }

    a:hover .image {
        position: absolute;
        right: 45vw;
        top: 10vh;
        width: 100px;
        height: 100px;
        display: block;
        z-index: 99999999;
    }
</style>

<form method="post">
    <div class="row-auto functions ">
        <div class="col-lg-auto mt-3">
            <div class="btn-group" role="group" aria-label="Basic example">

                <div class="form-group ">
                    <button formaction="workers/edit" class="btn btn-sm   btn-light " type="submit" name="arreyIdEdit">
                        <img src="/template/img/edit.png" alt="">Изменить
                    </button>
                </div>

                <div class="form-group ">
                    <button formaction="workers/delete" class="btn btn-sm   btn-light" type="submit" name="arreyIdDelete">
                        <img src="/template/img/del.png" alt="">Удалить
                    </button>
                </div>

                <div class="form-group ">
                    <button formaction="workers/print" class="btn  btn-sm  btn-light " type="submit" name="arreyIdPrint">
                        <img src="/template/img/print.png" alt="">Печать
                    </button>
                </div>

            </div>
        </div>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="thead-light">
            <tr>
                <th></th>
                <th>№</th>
                <th></th>
                <th>ФИО</th>
                <th>Пропуск</th>
                <th>Специальность</th>
                <th>Смена</th>
                <th scope="col">Бригадир</th>
                <th scope="col">Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ic = 1;
            foreach ($workersList as $key => $commander) { ?>
                <tr>
                    <td class="align-middle text-center" id="myCollapsible" data-toggle="collapse" href="#collapseExample<?= $commander['id'] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <?php if ($commander['count'] > 0) {
                            echo '<img  class="my_image" src="/template/img/show.png">';
                        } ?>
                    </td>
                    <td class="align-middle text-center"><?= $ic++; ?></td>
                    <td class="align-middle">
                        <input type="checkbox" value="<?= $commander['id'] ?> " name="workers[]">
                    </td>
                    <td class="align-middle"><a href="/workers/view/<?= $commander['id'] ?>">
                            <?= $commander["surname"] . ' ' . $commander['name'] . ' ' . $commander['father'] . ' (' . $commander['count'] . ')' ?>
                            <img class="image" alt="" src="/photo/<?= $commander['code'] ?>.png">
                        </a></td>
                    <td class="align-middle text-center"><?= $commander['code'] ?></td>
                    <td class="align-middle"><?= $commander['profession'] ?></td>
                    <td class="align-middle"><?= $commander['smena'] ?></td>
                    <td class="align-middle"><?= $commander['commander'] ?></td>
                    <td class="align-middle"><?= $commander['status'] ?></td>
                </tr>

                <?php
                $iw = 1;
                foreach ($commander['command'] as $key => $workers) { ?>
                    <tr class="collapse" id="collapseExample<?= $commander['id'] ?>">
                        <td class="align-middle"></td>
                        <td class="align-middle text-center"><?= $iw++; ?></td>
                        <td class="align-middle"><input type="checkbox" value="<?= $workers['id'] ?> " name="workers[]"> </td>
                        <td class="align-middle"><a href="/workers/view/<?= $workers['id'] ?>">
                                <?= $workers["surname"] . ' ' . $workers['name'] . ' ' . $workers['father'] ?>
                                <img class="image" alt="" src="/photo/<?= $workers['code']  ?>.png">
                            </a></td>
                        <td class="align-middle text-center"><?= $workers['code'] ?></td>
                        <td class="align-middle"><?= $workers['profession'] ?></td>
                        <td class="align-middle"><?= $workers['smena'] ?></td>
                        <td class="align-middle"><a href="/workers/view/<?= $commander['id'] ?>">
                                <?= $workers['commander'] ?>
                            </a></td>
                        <td class="align-middle"><?= $workers['status'] ?></td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
</form>

<script>
    $('.functions').hide();

    $('input:checkbox').click(function() {
        var count = $(':checkbox:checked').length;
        if (count > 0) {
            $('.functions').show(200);
        } else {
            $('.functions').hide(200);
        }
    });

    $(".my_image").bind("click", function() {

        var src = $(this).attr("src");

        if (src === "/template/img/show.png") {
            src = "/template/img/hide.png";
        } else {
            src = "/template/img/show.png";
        }

        $(this).attr("src", src);
    });
</script>