<div class="modal fade" id="addAvans<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?= 'ФИО: ' . $value['surname'] . ' ' . $value['name'] . ' ' . $value['father'] ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/money/add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="money" required placeholder="Cумма">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="type" type="hidden" value="a">
                    <input name="worker" type="hidden" value="<?= $value['id'] ?>">

                    <input name="moneyAdd" type="submit" class="btn btn-primary">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addFoot<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?= 'ФИО: ' . $value['surname'] . ' ' . $value['name'] . ' ' . $value['father'] ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="money/add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="money" required placeholder="Cумма">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="type" type="hidden" value="f">
                    <input name="worker" type="hidden" value="<?= $value['id'] ?> ">

                    <button name="moneyAdd" type="submit" class="btn btn-primary">Добавить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addShtraf<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?= 'ФИО: ' . $value['surname'] . ' ' . $value['name'] . ' ' . $value['father'] ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="money/add" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="money" required placeholder="Cумма">
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="type" type="hidden" value="s">
                    <input name="worker" type="hidden" value="<?= $value['id'] ?> ">

                    <button name="moneyAdd" type="submit" class="btn btn-primary">Добавить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="moneyInfo<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?= 'ФИО: ' . $value['surname'] . ' ' . $value['name'] . ' ' . $value['father'] ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row ">
                    <div class="col-1 font-weight-bold ">№</div>
                    <div class="col-2 font-weight-bold text-left">Дата</div>
                    <div class="col-2 font-weight-bold text-left">Тип</div>
                    <div class="col-2 font-weight-bold text-left">Сумма</div>
                    <div class="col-1 font-weight-bold text-left">Статус</div>
                    <div class="col font-weight-bold text-center"></div>
                </div>
                <?php $index = 1;
                foreach ($value['money'] as $key => $money) { ?>
                    <div class="row ">
                        <div class="col-1 text-cener"><?= $index++ ?></div>
                        <div class="col-2 text-left"><?= $money['date'] ?></div>
                        <div class="col-2 text-left"><?= $money['type'] ?></div>
                        <div class="col-2 text-left"><?= $money['sum'] ?></div>
                        <div class="col-1 text-left"><?= $money['payout'] ?></div>
                        <div class="col text-center">
                            <a href="/money/close/<?= $money['id'] ?>">Закрыть</a>
                            <a href="/money/delete/<?= $money['id'] ?>">Удалить</a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
            
        </div>
    </div>
</div>