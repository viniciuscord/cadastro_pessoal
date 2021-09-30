<style>
    .ui-autocomplete{
        z-index: 9999;
    }
    .ui-menu-item{
        text-transform: uppercase;
    }

    .loading-screen{
        position : relative !important; 
    }
    .swal2-title {
        font-size: 14px !important;
    }
    .swal2-popup.swal2-toast{
        font-size: 14px !important;
        margin: 5px !important;
    }
    .datepicker{
        font-size: 12px !important;
    }

</style>
<?php 
    $title = 'Ocorrências por Motivo';
?>
<div class="box box-primary" id="adm">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title"><?= $title?></h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body" >
        <div class="col-md-12">
            <div class="row">
                <form id="formOcorrencia" method="POST">
                <!-- <form id="formOcorrencia"> -->
                <input type="hidden" id="input_justificativa" name="input_justificativa" value="">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="contrato">Contratos:</label>
                            <select class="form-control input-sm selectpicker" id="contrato" name="contrato[]" multiple>
                                <?php foreach($contratos as $contrato): ?>
                                    <option  value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="input_contrato_error" class="text-danger"></span>              
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="motivo">Motivo:</label>
                            <select class="form-control input-sm selectpicker" id="motivo" name="motivo[]" multiple>
                                <?php foreach($motivos as $motivo): ?>
                                    <!-- <option  value="<?= $motivo['idMotivo'] ?>" data-subtext="<span class='text-green'> | <?= $motivo['DescricaoMotBS']; ?></span> "><?= $motivo['Motivo']; ?></option> -->
                                    <option  value="<?= $motivo['idMotivo'] ?>" data-subtext=" | <?= $motivo['DescricaoMotBS']; ?>"><?= $motivo['Motivo']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="input_motivo_error" class="text-danger"></span>              
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="periodo">Data Início:</label>
                            <input type="text" class="form-control input-sm date-mask" id="dt-ini" name="dt-ini" aria-describedby="emailHelp" value="">
                            <span id="ini_error" class="text-danger"></span>              
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="periodo">Data Fim:</label>
                            <input type="text" class="form-control input-sm datepicker-my date-mask" id="dt-fim" name="dt-fim" aria-describedby="emailHelp" value="">
                            <span id="fim_error" class="text-danger"></span>              
                        </div>   
                    </div>
                </form>
                <div class="col-md-1">
                    <br>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Buscar Colaborador" id="consultar" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- relatório detalhado -->
<div class="box box-success" id="resultado_detalhado" style="display: none;">
<!-- <div class="box box-success" id="resultado_detalhado"> -->
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title"><?= $title?></h4>
        <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool"><i class="glyphicon glyphicon-cloud-download"></i> Exportar Excel</button> -->
            <button type="button" class="btn btn-default btn-box-tool exportar"><i class="glyphicon glyphicon-cloud-download"></i> Exportar</button>
        </div>
    </div>
    <div class="box-body" >
        <div class="form-inline pull-right">
            <div class="checkbox">
                <label> <input type="checkbox" id="check_justificativa" name="check_justificativa" > Exibir Justificativa </label>
            </div>
        </div>
        <div id="result"></div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const Toast = Swal.mixin({
            toast: true,
            // position: 'bootom-center',
            showConfirmButton: false,
            timer: 3000
        });
        $(".exportar").on("click",function(){
            var url = siteurl + 'relatorio/exporta_relatorio_ocorrencia_motivo';	
            $("form").attr("action",url);
            $("form").submit();
        });
        $("#consultar").on("click",function(){
            buscaDadosMotivoOcorrencia();
        });
        $("#check_justificativa").on("change",function(){
            if($(this).is(':checked')){
                $('#input_justificativa').val('exibir');
            }else{
                $('#input_justificativa').val('');
                
            }
            buscaDadosMotivoOcorrencia();
        });
        $("#contrato").on("change",function(){
            var contrato = $(this).val();
            var url = siteurl + "relatorio/getMotivoRelOcMotivos";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend: function(){
                    $('#motivo').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].idMotivo+"' data-subtext='"+data[i].DescricaoMotBS+"'>"+data[i].Motivo+"</option>";
                    }
                    $("#motivo").html(option);
                    $('#motivo').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#motivo').selectpicker('refresh');
                }
            });
        });
        $('#dt-ini').datepicker({
            language:"pt-BR",
            view:"days",		
            // minView:"months",
            dateFormat: 'dd/mm/yyyy',
            autoClose: true,
            // minDate: new Date(currentYear, currentMonth-1, currentDate),       
            maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });
        $('.datepicker-my').datepicker({
            language:"pt-BR",
            view:"days",		
            // minView:"months",
            dateFormat: 'dd/mm/yyyy',
            autoClose: true,
            // minDate: new Date(currentYear, currentMonth-1, currentDate),       
            maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });
        function formValida(){   
            valid = true;
            // motivo
            if($("#motivo").val() =="" || $("#motivo").val() == null){
                valid = false;
                $("#motivo").css({'border-color': '#a94442'});
                $("#input_motivo_error").html("Selecione o(s) motivo(s)");
            }else{
                $("#motivo").css({'border-color': 'lightgrey'});
                $("#input_motivo_error").html('');
            }
                
             // data dt-fim
             if($("#dt-fim").val() =="" || $("#dt-fim").val() == null){
                valid = false;
                $("#fim_error").html("Selecione a data fim");
            }else{
                if(verificaDiferDatas()){
                    valid = false;
                    $("#dt-fim").css({'border-color': '#a94442'});
                    $("#fim_error").html("Data fim menor que a início"); 
                }else{
                    $("#dt-fim").css({'border-color': 'lightgrey'});
                    $("#fim_error").html('');
                }
            }
            if($("#dt-ini").val() =="" || $("#dt-ini").val() == null){
                valid = false;
                $("#ini_error").html("Selecione a data início");
            }else{
                $("#dt-ini").css({'border-color': 'lightgrey'});
                $("#ini_error").html('');
                
            }

            return valid;
        }
        function verificaDiferDatas(){
            var parts_ini = $("#dt-ini").val().split('/');
            var parts_fim = $("#dt-fim").val().split('/');

            data_ini = new Date(parts_ini[2], parts_ini[1] - 1, parts_ini[0]);
            data_fim = new Date(parts_fim[2], parts_fim[1] - 1, parts_fim[0]);

            if( Date.parse(data_fim) < Date.parse(data_ini)){
                return true;
            }else{
                return false;
            }
        }
        function buscaDadosMotivoOcorrencia(){
            var url = siteurl + "relatorio/result_ocorrencia_motivo";
            var motivo = $('#formOcorrencia').serialize();
            if(formValida()){
                $.ajax({
                    type: "post",
                    url: url,
                    data: motivo,
                    beforeSend: function(){
                        $('.overlay').show();
                    },
                    success: function (response) {
                        var mens = '';
                        if($('#resultado_detalhado').is(':visible')){
                            mens = 'Dados atualizados com sucesso.';
                        }else{
                            mens = 'Dados carregados com sucesso.';
                        }
                        Toast.fire({
                            type: 'success',
                            title: mens
                        });
                        $('#resultado_detalhado').show();
                        $('#result').html(response);
                        $('.overlay').hide();
                    }
                });
            }
            $(this).tooltip('hide'); 
        }

        $('#contrato').selectpicker({
            noneSelectedText: 'Selecione o contrato',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            selectAllText: 'Marcar',
            deselectAllText: 'Limpar',
            actionsBox: true,
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm',
            maxOptions: 1,
            // title: 'Selecione'
        });
        $('#motivo').selectpicker({
            noneSelectedText: 'Selecione o(s) motivo(s)',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            selectAllText: 'Marcar',
            deselectAllText: 'Limpar',
            actionsBox: true,
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm'
            // maxOptions: 1,
            // title: 'Selecione'
        });
        $('.dropdown-menu .inner').css('font-size','12px');
        $('.btn-default').addClass('btn-sm');
        // function mostraColuna(){
        //     var url = siteurl + "relatorio_colaborador/buscaColaborador";
        //     var sit = '';
        //     if($('#inp_sit').is(':checked')){
        //         sit = "exibir";
        //     }
        //     $.ajax({
        //         url : url, 
        //         type : "POST",
        //         data : {
        //             situacao: sit,
        //             fila: fila,
        //             funcao: funcao,
        //             supervisor: sup,
        //             superior: superior
        //             // funcao: 'e'
        //         },
        //         beforeSend : function(){
        //             $(".overlay").show();
        //         }
        //     }).done(function(data){
        //         $("#resultado").html(data);
        //         $(".overlay").hide();
        //         if(!$('#resultado_colaborador').is(':visible')){
        //             $('#resultado_colaborador').show();
        //         }
        //     });
        // }
        // $('#inp_sit').change(function(){
        //     mostraColuna();
        // });
        // $('#inp_fila').change(function(){
        //     mostraColuna();
        // });
        // $('#inp_funcao').change(function(){
        //     mostraColuna();
        // });
        // $('#inp_supervisor').change(function(){
        //     mostraColuna();
        // });
    });

</script>