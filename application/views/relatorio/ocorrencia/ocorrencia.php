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
    $modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_ocorrencia', 'type' => 'view', 'acao' => 'negar', 'situacao' => 1);
    $acesso = Permissao_helper::validaAcessoRelatorioOcorrenciasLancadas($modulo_acesso);
    if($acesso):
        $title = 'Quantidade de Ocorrências por Colaborador';
        $estilo = 'style="display:none;"';
    else:
        $title = 'Ocorrências Lançadas';
        $estilo = 'style="display:none;"';
    endif;
?>
<div class="box box-primary" id="adm">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Ocorrências Lançadas</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body" >
        <div class="col-md-12">
            <div class="row">
                <form id="formOcorrencia">
                <?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
                <?php if($situacao == 1): //print_r($coordenadores);?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="coordenador">Contratos:</label>
                            <select class="form-control input-sm selectpicker" id="contrato" name="contrato[]" multiple>
                                <?php foreach($contratos as $contrato): ?>
                                    <option value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="input_contrato_error" class="text-danger"></span>              
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($situacao == 4 || $situacao == 1): ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="coordenador">Coordenador:</label>
                            <select class="form-control input-sm selectpicker" id="coordenador" name="coordenador[]" multiple>
                                <?php if(isset($coordenadores)):?>
                                    <?php foreach($coordenadores as $coordenador): ?>
                                        <option value="<?= $coordenador['MatriculaSCP'] ?>"><?= $coordenador['Nome']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span id="input_coordenador_error" class="text-danger"></span>              
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($situacao == 1 || $situacao == 2 || $situacao == 3 || $situacao == 4): ?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="superior">Supervisor:</label>
                            <select class="form-control input-sm selectpicker" id="superior" name="superior[]" multiple>
                            <?php if(isset($superiores)):?>
                                <?php foreach($superiores as $superior): ?>
                                    <option value="<?= $superior['MatriculaSCP'] ?>"><?= $superior['Nome']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </select>
                            <span id="input_superv_error" class="text-danger"></span>              
                        </div>
                    </div>
                <?php endif;?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="superior">Tipo de Ocorrência:</label>
                            <select class="form-control input-sm selectpicker" id="tipo_ocorrencia" name="tipo_ocorrencia[]" multiple>
                                <option value="1">PONTO</option>
                                <option value="2">ADMINISTRATIVA</option>
                            </select>
                            <span id="input_tp_ocorrencia_error" class="text-danger"></span>              
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

<!-- relatório consolidado -->
<div class="box box-warning" id="resultado_colaborador" <?php echo $estilo;?>>
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title"><?php echo $title;?></h4>
    </div>
    <div class="box-body" >
        <div id="resultado"></div>
    </div>
</div>
<!-- relatório detalhado -->
<div class="box box-success" id="resultado_detalhado" <?php echo $estilo;?>>
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Detalhe dos Lançamentos</h4>
         <form id="export" method="POST">
                    <input name="motivo" id="razao" type="text" value="" hidden>
                    <input name="inseridopor" id="registro" type="text" value="" hidden>
                    <input name="matricula" id="matricula" type="text" value="" hidden>  
                    <input name="tipo_ocorrencia" id="tipo-ocorrencia" type="text" value="" hidden>  
                    <input name="dtinicio" id="dt-inicio" type="text" value="" hidden>  
                    <input name="dtfim" id="dt-final" type="text" value="" hidden>  
            <button class="btn btn-secondary btn-sm pull-right exportar" ><span class="fa fa-file"></span> Exportar</button>
        </form>      
    </div>
    <div class="box-body" >
        <div id="result_detalhado"></div>
    </div>
</div>

<!-- Modal Cadastro !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalOcorrencia"></div>	
<script>
    $(document).ready(function(){

        $(".exportar").on("click",function(){
           var url = siteurl + 'relatorio/exportar_ocorrencia_detalhado';	
            $("#export").attr("action", url);
            $("#export").submit();
        });

        $("#consultar").on("click",function(){
            if(formValida()){
                buscaColaborador();
            }
            $(this).tooltip('hide');    
        });

        $("#contrato").on("change",function(){
            var contrato = $(this).val();
            var url = siteurl + "relatorio/getCoordRelOcLancadas";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend: function(){
                    // $("#superior").addClass("loading-screen");
                    $('#coordenador').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#coordenador").html(option);
                    $('#coordenador').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#coordenador').selectpicker('refresh');
                }
            });
        });
        $("#coordenador").on("change",function(){
            var coordenador = $(this).val();
            var url = siteurl + "relatorio/consultaColaboradorRelOcLancadas";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { coordenador : coordenador },
                beforeSend: function(){
                    // $("#superior").addClass("loading-screen");
                    $('#superior').attr('disabled',true);
                    $('#superior').selectpicker('refresh');
                },
                success: function(data) {
                    //console.log(data);
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        //console.log(data[i].IdMotivo);
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                        //console.log(option);   
                    }
                    $("#superior").html(option);
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    // $("#superior").removeClass("loading-screen");
                    $('#superior').selectpicker('refresh');
                }
            });
        });
        var date = new Date();
    	var currentMonth = date.getMonth();
    	var currentDate = date.getDate();
	    var currentYear = date.getFullYear();

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
            // maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });

        function formValida(){   
            valid = true;
            if($("#contrato").is(':visible')){
                // coordenador
                if($("#contrato").val() =="" || $("#contrato").val() == null){
                    valid = false;
                    $("#contrato").css({'border-color': '#a94442'});
                    $("#input_contrato_error").html("Selecione o contrato");
                }else{
                    $("#contrato").css({'border-color': 'lightgrey'});
                    $("#input_contrato_error").html('');
                }
            }
            if($("#coordenador").is(':visible')){
                if($("#coordenador").val() =="" || $("#coordenador").val() == null){
                    valid = false;
                    $("#coordenador").css({'border-color': '#a94442'});
                    $("#input_coordenador_error").html("Selecione o(a) coordenador(a)");
                }else{
                    $("#coordenador").css({'border-color': 'lightgrey'});
                    $("#input_coordenador_error").html('');
                }
            }
            if($("#superior").is(':visible')){
                // supervisor
                if($("#superior").val() =="" || $("#superior").val() == null){
                    valid = false;
                    $("#superior").css({'border-color': '#a94442'});
                    $("#input_superv_error").html("Selecione o(a) superior(a)");
                }else{
                    $("#superior").css({'border-color': 'lightgrey'});
                    $("#input_superv_error").html('');
                }

            }
            // ocorrencias
            if($("#tipo_ocorrencia").val() =="" || $("#tipo_ocorrencia").val() == null){
                valid = false;
                $("#tipo_ocorrencia").css({'border-color': '#a94442'});
                $("#input_tp_ocorrencia_error").html("Selecione o tipo de ocorrência");
            }else{
                $("#tipo_ocorrencia").css({'border-color': 'lightgrey'});
                $("#input_tp_ocorrencia_error").html('');
            }
            // data dt-ini
            if($("#dt-ini").val() =="" || $("#dt-ini").val() == null){
                valid = false;
                $("#ini_error").html("Selecione a data de início");
            }else{
                $("#ini_error").html('');
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

            return valid;
        }
        function buscaColaborador(){
            var url = siteurl + "relatorio/consulta_ocorrencia";
            $.ajax({
                    url : url, 
                    type : "POST",
                    dataType: "html",
                    data : $("#formOcorrencia").serialize(),
                    beforeSend : function(){
                        $(".overlay").show();
                    }
                }).done(function(data){
                    $("#resultado").html(data);
                    $(".overlay").hide();
                    $('#resultado_colaborador').show();
                    if($('#resultado_detalhado').is(':visible')){
                       $('#resultado_detalhado').hide();
                    }
                });
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

        $('#contrato').selectpicker({
            noneSelectedText: 'Selecione o contrato',
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
        $('#superior').selectpicker({
            noneSelectedText: 'Selecione o(a) supervisor(a)',
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
        $('#coordenador').selectpicker({
            noneSelectedText: 'Selecione o(a) coordenador(a)',
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
        $('#tipo_ocorrencia').selectpicker({
            noneSelectedText: 'Selecione o tipo de ocorrência',
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
    });

</script>