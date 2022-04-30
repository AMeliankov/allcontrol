<div class="modal fade" id="modalTable<?= $worker['id'] . $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <?= 'Дата: ' . $key . '</br>ФИО: ' . $worker['surname'] . ' ' . $worker['name'] . ' ' . $worker['father'] ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-1 font-weight-bold">№</div>
                    <div class="col-3 font-weight-bold ">Пришел</div>
                    <div class="col-3 font-weight-bold ">Ушел</div>
                    <div class="col-2 font-weight-bold">Статус</div>
                    <div class="col-2 font-weight-bold">Время</div>
                </div>
                <?php $i1 = 1;
                foreach ($value['detal'] as $key1 => $value1) { ?>
                    <div class="row">
                        <div class="col-1"><?= $i1++ ?></div>
                        <div class="col-3"><?= $value1['start'] ?></div>
                        <div class="col-3"><?= $value1['finish'] ?></div>
                        <div class="col-2"><?= $value1['flag'] ?></div>
                        <div class="col-2"><?= $value1['time'] . ' мин.' ?></div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>