<table class="table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
            <th width="1" class="text-center align-middle">№</th>
            <th width="1">ФИО</th>
            <th width="1">Специальность</th>
            <th width="1">Смена</th>   
            <th width="1">Бригадир</th>
            <th>Пришел</th>
            <th width="1"></th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $i = 1;
    foreach($infoAjax as $key => $worker) { ?>
        <tr>
            <td class="text-center align-middle"><?= $i++ ?></td>
            <td><a href="/workers/view/<?= $worker['w_id'] ?>"> 
                    <?= $worker["surname"].' '.$worker['name'].' '.$worker['father'] ?>
            </a></td>
            <td class="text-left align-middle" ><?=  $worker['profession'] ?></td>
            <td class="text-left align-middle" ><?=  $worker['smena'] ?></td>  
            <td class="text-left align-middle"><?=  $worker['commander'] ?></td>
            <td class="text-left align-middle" ><?=  $worker['start'] ?></td>
            <td class="text-left align-middle">
                <a class="btn btn-sm btn-primary " href="/info/exit/<?= $worker['i_id'] ?>/<?= $worker['w_id'] ?>">Ушел</a> 
            </td>
        </tr>
    <?php } ?>
    </tbody> 
</table>    