<!-- https://github.com/davidscotttufts/php-barcode/  -->

<script>
    window.print();
</script>

<?php foreach ($workersPrint as $key => $value) { ?>

    <table style="width: 326px; height: 204px; border: 1px solid; margin: 10px 20px 1px 30px;  display: inline-block;">
        <tr>
            <td align="center" rowspan="2">
                <img style="width: 120px; height: 140px; margin: 0px 5px 0px 5px;  border-radius: 5px;" src="/photo/<?php echo $value['code']; ?>.png" alt="">
            </td>
            <td>
                <div style="width: 170px; margin: 22px 0px 0px 10px; font-size: 15px;">
                    <?php echo $value['surname'] . "<br>"; ?>
                    <?php echo $value['name'] . "<br>"; ?>
                    <?php echo $value['father'] . "<br>"; ?>
                    <?php echo $value['profession'] . "<br>"; ?>
                    <?php echo $value['commander'] . "<br>"; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td height="85" style="text-align: center;">
                <img alt="barcode" src="/components/barcode.php?codetype=Codabar&size=60&text=<?php echo $value['code']; ?>" />
            </td>
        </tr>
    </table>

<?php } ?>