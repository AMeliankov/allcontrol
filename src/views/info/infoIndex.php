<?php include_once ROOT. '/views/layouts/header.php'; ?>

<div class="container" >
    <h3 class="text-center" >Информация</h3><br>
    <div class="row">
        <div class="col-lg-4 mb-2">
            <div class="border " style="height: 69vh; overflow-y: scroll; overflow-x: hidden;">
                <table class="table  table-hover table-responsive-lg table-sm table-bordered">
                    <tbody>
                    <?php $i1 = 1; 
                        foreach ($infoList as $key => $commander) { ?>
                            <tr>
                                <td data-toggle="collapse" data-target="#collapseExample<?= $commander['id'] ?>">
                                    <?php
                                        if($commander['count'] > 0){
                                            echo '<img  class="my_image" src="/template/img/show.png">';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $i1++; ?></td>
                                <td>
                                    <a href="/workers/view/<?php echo $commander['id']; ?>">  
                                        <?php echo $commander['surname'].' '.$commander['name'].' '
                                                . ''.$commander['father'].' ('.$commander['count'].')'; ?>
                                    </a>  
                                </td>
                            </tr> 
                    <?php 
                        $i2 = 1;
                        foreach ($commander['command'] as $key => $command) { ?>
                            <tr class="collapse" id="collapseExample<?php echo $commander['id']; ?>" >
                                <td></td>
                                <td><?php echo $i2++; ?></td>
                                <td>
                                    <a href="/workers/view/<?php echo $command['id']; ?>">  
                                        <?php echo $command['surname'].' '.$command['name'].' '.$command['father']; ?>
                                    </a>
                                </td>
                            </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-lg-8 " >
            <div class="row">
                <div class="col-auto " >
                    <div class="form-group ">  
                        <button type="button" class="btn  btn-light  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/template/img/info.png" alt="">Информация
                        </button>
                        <div class="dropdown-menu p-3 "style="width: 165px; " >
                        <?php
                            echo 'Всего: '.$countAllWorkersInfo.'<br>';
                            foreach ($countProfessionWorkesInfo as $key => $value) {
                                echo $value['name'].': '.$value['count'].'<br>';
                            }
                        ?>    
                        </div>
                    </div> 
                </div> 
                <div class="col-lg">            
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
            
            <div class="row">
                <div class="col-lg">
                    <div class="border" style="height: 60vh; overflow-x: scroll; ">
                       
                        <div id="loader" style="text-align: center; margin-top: 20%;  " >
                            <div class="spinner-border text-dark" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>  
                         <div id="result"></div>
                    </div>
                </div>   
            </div>     
        </div>      
    </div>
</div>
<script>
    $('#search').bind('input', function(){
        $.ajax({
            beforeSend: function() {
                $('#loader').show();
                $('#result').hide();
            },
            complete: function() {
                $('#loader').hide();
                $('#result').show();
            },
            url: '/info', 
            method: 'post',
            data: {
                search: $('#search').val() 
            },
            success: function(data) {
                $('#result').html(data);
            }
        });
    });

    $(window).on('load', function () {
        $.ajax({      
            beforeSend: function() {
                $('#loader').show();
                $('#result').hide();
            },
            complete: function() {
                $('#loader').hide();
                $('#result').show();
            },  
            url: '/info', 
            method: 'post',
            data: {
                search: $('#search').val() 
            },
            success: function(data){
                $('#result').html(data);
            }
        });
    });

    $(".my_image").bind("click", function() {

        var src = $(this).attr("src");

        if (src === "/template/img/show.png") {
            src = "/template/img/hide.png" ;
        } else {
            src = "/template/img/show.png" ;
        }
        
        $(this).attr("src", src);
    });
    
</script>

<?php include_once ROOT. '/views/layouts/footer.php'; ?>