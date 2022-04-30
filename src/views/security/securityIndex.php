<?php include_once ROOT . '/views/layouts/header.php'; ?>

<div style=" margin: 0 auto; width: 700px; ">
    <h3 style="text-align: center;">Проходная</h3><br>
    <div id="div_num" class="row p3">
        <div class="col-sm">
            <div class="form-group">
                <input maxlength="13" id="code" type="text" class="form-control" autofocus>
            </div>
        </div>
    </div>
    <span id="result"></span>
</div>


<script>
    $('#code').bind('input', function() {
        if ($('#code').val().length == 13) {
            $.ajax({
                url: '/security',
                method: 'post',
                data: {
                    code: $('#code').val()
                },
                success: function(data) {
                    $('#result').html(data);
                    $('#code').val('');

                    $("#div_num").delay(0).slideUp(0);

                    setTimeout(function() {
                        $("#div_num").show();
                        $('#code').focus();
                    }, 5000);
                }
            });
        }
    });

    document.onclick = function(event) {
        document.getElementById('code').focus();
    };

    $(document).ready(function() {
        $('#code').bind("change keyup input click", function() {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }
        });
    });
</script>

<?php include_once ROOT . '/views/layouts/footer.php'; ?>