<style>
    .loading-screen{
        position : relative !important; 
    }
    .swal2-title{
        font-size: 14px !important;
    }
    .swal2-content{
        font-size: 12px !important;

    }
    .input-g{
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
    }
</style>
<div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="col-md-4">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">Fechamento Folha</span>
                <form id="pesqFolha">
                    <span class="info-box-text">Ano: <?php echo date("Y"); ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?php echo $ano_percent;?>%"></div>
                    </div>
                    <span class="progress-description">  <?php echo $ano_percent;?>% - Faltam <?php echo $dias_fim_ano;?> dias para o encerramento de <?php echo date("Y"); ?></span>
                    <div class="input-group">
                        <input type="hidden" class="form-control input-sm pull-right datepicker-my mask input-g" id="ano" name="ano" value="<?php echo date("Y"); ?>" >  
                    </div>
                    <span id="input_data_error" class="text-danger"></span>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
                <span class="info-box-number">Mês Atual (<?= $mes_atual;?>)</span>
                <span class="info-box-text">O fechamento ocorrerá em: <?= implode('/', array_reverse(explode('-',$data_mes_encerramento)));?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?= $mes_percent;?>%"></div>
                </div>
                <span class="progress-description"><?= $mes_percent;?>% - Faltam <?php echo $dias_fim_mes;?> dias para o fechamento da folha de <b><?php echo $mes_atual; ?></b></span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">Possibilidade de Ajuste</span>
                <span class="info-box-text"><?= $mes_anterior;?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: <?= $mes_percent;?>%"></div>
                </div>
                <span class="progress-description"> O ajuste da folha de <b><?= $mes_anterior;?></b> encerra no mesmo prazo de <b><?= $mes_atual;?></b></span>
            </div>
        </div>
    </div>
<!-- </div> -->
<div class="col-md-12">
    <div id="div_folha_func"></div>
</div>

<script>
    $(document).ready(function(){
        buscaFolha();
        const Toast3 = Swal.mixin({
            customClass:{
                confirmButton: 'btn btn-sm btn-success',
            },buttonsStyling: true
        });
        $('.datepicker-my').datepicker({
            language:"pt-BR",
            view:"years",
            minView:"years",
            dateFormat: 'yyyy',
            autoClose: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
        });
        $(".mask").mask('0000',{placeholder: "Ex: 2001"}, {'translation':{ 0: { pattern: /[0-9*]/}}});
        $('#ano').on('click', function(){
            buscaFolha();
        });
        function buscaFolha(){
            var data = $("#pesqFolha").serialize();
            var url = siteurl + "fechar_folha/buscaFolhas";
            if(formValida()){
                $.ajax({
                    type : "POST",
                    url : url,
                    data : data,
                    dataType : 'html',
                    beforeSend : function(){
                        $(".overlay").show();
                    },
                    success: function (data){
                        $("#div_folha_func").html(data);
                        $(".overlay").hide();
                    }
                });
            }
        }
        function formValida(){
            valid = true;
            // validação campo data 
            if($("#ano").val()==""){
                valid = false;
                $("#ano").css({'border-color': '#a94442'});
                $("#input_data_error").html("Selecione o período");
            }else{
                $("#ano").css({'border-color': 'lightgrey'});
                $("#input_data_error").html('');
            }

            return valid;
        }

    });
</script>