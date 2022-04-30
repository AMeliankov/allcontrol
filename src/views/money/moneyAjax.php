<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th class="text-center">№</th>
            <th>ФИО</th>
            <th>Аванс</th>
            <th>Питание</th>
            <th>Штрафы</th>
            <th>Долг</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($workersMoney as $key => $value) { ?>
            <tr>
                <td class="align-middle text-center"><?= $i++ ?></td>
                <td class="align-middle"><a href="/workers/view/<?= $value['id'] ?>">
                        <?= $value['surname'] . ' ' . $value['name'] . ' ' . $value['father'] ?>
                    </a></td>
                <td class="align-middle"><a data-toggle="modal" href="#addAvans<?= $value['id'] ?>">
                        <?= $value['avans'] ?>
                    </a></td>
                <td class="align-middle"><a data-toggle="modal" href="#addFoot<?= $value['id'] ?>">
                        <?= $value['foot'] ?>
                    </a></td>
                <td class="align-middle"><a data-toggle="modal" href="#addShtraf<?= $value['id'] ?>">
                        <?= $value['shtraf'] ?>
                    </a></td>
                <td class="align-middle">
                    <?= $value['kredit'] ?>
                </td>
                <td class="align-middle text-center">
                    <a class="btn btn-primary btn-sm" data-toggle="modal" href="#moneyInfo<?= $value['id'] ?>">Подробно</a>
                    <?php include  ROOT . '/views/money/moneyModal.php';  ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>