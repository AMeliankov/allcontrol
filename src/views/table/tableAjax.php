<style>
    thead th {
        position: sticky;
        top: 0;
    }

    tbody th {
        position: sticky;
    }
</style>

<table class="table  table-sm table-bordered table-hover table-sm">
    <thead class="thead-light">
        <tr>
            <th class="align-middle text-center">№</th>
            <th class="align-middle text-center">ФИО</th>
            <th class="align-middle text-center">Часов</th>
            <th class="align-middle text-center">Минут</th>
            <?php foreach ($dayName as $key => $value) {
                if ($value['dayNum'] == date('d')) {
                    echo '<th ><span style="color: red;">' . $value['dayNum'] . '</span><br>' . $value['dayName'] . '</th>';
                } else {
                    echo '<th>' . $value['dayNum'] . '<br>' . $value['dayName'] . '</th>';
                }
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if (!empty($tableAjax)) {
            foreach ($tableAjax as $key => $worker) {  ?>
                <tr>
                    <td class="align-middle text-center"><?= $i++ ?></td>
                    <td class="align-middle text-left"><a href="/workers/view/<?= $worker['id'] ?>">
                            <?= $worker['surname'] . ' ' . $worker['name'] . ' ' . $worker['father'] ?></a>
                    </td>
                    <td class="align-middle text-center"><?= $worker['hourMonth'] ?></td>
                    <td class="align-middle text-center"><?= $worker['minMonth'] ?></td>
                    <?php foreach ($worker['info'] as $key => $value) {
                        if ($value !== 0) {
                            echo '<td class="align-middle text-center" ><a data-toggle="modal" href="#modalTable' . $worker['id'] . $key . '" >';
                            echo $value['hourDay'] . '<a></td>';
                            require ROOT . '/views/table/tableModal.php';
                        } else {
                            echo '<td></td>';
                        }
                    } ?>
                </tr>
        <?php
            }
        } ?>
    </tbody>
</table>