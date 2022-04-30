<?php include_once ROOT . '/views/layouts/header.php'; ?>

<style type="text/css">
    #image-preview {
        width: 350px;
        height: 300px;
        position: relative;
        overflow: hidden;
        background-color: #fff;
        color: #ecf0f1;
        margin: 0 auto;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    #image-preview input {
        line-height: 200px;
        font-size: 200px;
        position: absolute;
        opacity: 0;
        z-index: 10;
    }

    #image-preview label {
        position: absolute;
        z-index: 5;
        opacity: 0.8;
        cursor: pointer;
        background-color: #bdc3c7;
        width: 200px;
        height: 50px;
        font-size: 20px;
        line-height: 50px;
        text-transform: uppercase;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
        text-align: center;
        border-radius: 4px;
    }
</style>

<div class="container" style=" margin: 0 auto; width: 400px;">
    <h3 style="text-align: center;">Добавление</h3><br>
    <form action="/workers/add" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col">

                <div class="form-group border" id="image-preview">
                    <label for="image-upload" id="image-label">ФОТО</label>
                    <input type="file" name="image" id="image-upload" required accept=".jpeg, .png, .gif, .jpg" />
                </div>

                <div class="form-group">
                    <label for="surname">Фамилия:</label>
                    <input class="form-control" type="text" name="surname" required>
                </div>

                <div class="form-group">
                    <label for="name">Имя:</label>
                    <input class="form-control" type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label for="father">Отчество:</label>
                    <input class="form-control" type="text" name="father">
                </div>

                <div class="form-group mt-1">
                    <label for="phone">Телефон:</label>
                    <input class="form-control phone" type="text" name="phone">
                </div>

                <div class="form-group">
                    <label for="change">Смена:</label>
                    <select class="form-control" name="smena">
                        <?php foreach ($smena as $value) {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profession">Специальность:</label>
                    <select class="form-control" name="profession">
                        <?php foreach ($profession as $value) {
                            echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="commander">Бригадир:</label>
                    <select class="form-control" name="commander">
                        <option selected value="0">Бригадир</option>
                        <?php foreach ($commanderList as $value) {
                            echo '<option value="' . $value['id'] . '">' . $value['surname'] . ' ' . $value['name'] . '</option>';
                        } ?>
                    </select>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary " type="submit" name="add" value="Добавить">
                </div>

            </div>
        </div>
    </form>
</div>

<!-- https://opoloo.github.io/jquery_upload_preview/ -->
<script src="/template/js/jquery.uploadPreview.min.js"></script>
<script src="/template/js/jquery.maskedinput.min.js"></script>

<script>
    $(".phone").mask("+7 (999) 999-99-99");

    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "ФОТО", // Default: Choose File
            label_selected: "Изменить", // Default: Change File
            no_label: false // Default: false
        });
    });
</script>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>