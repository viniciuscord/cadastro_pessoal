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
    .swal2-cancel{
        margin-right: 5px !important;
    }
    .swal2-content{
        font-size: 12px;
    }
    .swal2-title{
        font-size: 16px;

    }

</style>

<?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
<div class="box box-primary">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Ocorrências</h4>
        <div class="box-tools">
            <!--<button class="btn btn-success view-modal" title="Cadastrar novo funcionário" data-remote="<?php // echo site_url('cadastro/cadastro_novo'); ?>">Cadastrar Novo <span class="glyphicon glyphicon-plus"></span></button>!-->
            <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cadastrar nova ocorrência" id="cadastrarNovo" >Cadastrar Ocorrência <span class="glyphicon glyphicon-plus"></span></button>
        </div>
    </div>
    <div class="box-body" >
        <div class="col-md-12">
            <div class="row">
            <input type="hidden" id="fecha" value="<?= date('d/m/Y')?>">
                <form id="formOcorrencia">
                <?php if($situacao == 1): //print_r($coordenadores);?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="coordenador">Contratos:</label>
                            <select class="form-control input-sm selectpicker" id="contratos" name="contratos[]" multiple>
                                <!-- <option value="" >Selecione o empregado</option> -->
                                <?php foreach($contratos as $contrato): ?>
                                    <option value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span id="input_contrato_error" class="text-danger"></span>              
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($situacao == 4 || $situacao == 1): ?>
                    <div class="<?=$class_padrao;?>">
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
                    <div class="<?=$class_padrao;?>">
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
                <?php endif; ?>
                <div class="<?=$class_padrao;?>">
                    <div class="form-group">      
                        <label for="nome">Colaborador:</label>
                        <select class="form-control input-sm selectpicker" id="nome" name="nome[]" multiple>
                            <!-- <option value="" >Selecione o empregado</option> -->
                            <?php foreach($empregados as $empregado): ?>
                                <option value="<?= $empregado['MatriculaSCP']; ?>"><?= $empregado['Nome']; ?></option>
                            <?php endforeach; ?>
                        </select>  
                        <span id="input_nome_error" class="text-danger"></span>              
                    </div>
                </div> 
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="periodo">Mês:</label>
                        <input type="text" class="form-control input-sm datepicker-my mask" id="periodo" name="periodo" aria-describedby="emailHelp" placeholder="Clique e selecione o mês/ano" value="<?= date('m/Y');?>">
                        <span id="periodo_error" class="text-danger"></span>              
                    </div>   
                </div>
                </form>
                <div class="col-md-1">
                    <br>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Consultar Ocorrências" id="consultar" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="div_ocorrencia_consulta" ></div>

<!-- Modal Cadastro !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalOcorrencia"></div>	


<script>
    $(document).ready(function(){
        const Toast3 = Swal.mixin({
            customClass:{
                confirmButton: 'btn btn-sm btn-success',
                // cancelButton: 'btn btn-sm btn-danger'
            },buttonsStyling: true
        });
        var date = new Date();
    	var currentMonth = date.getMonth();
    	var currentDate = date.getDate();
	    var currentYear = date.getFullYear();

        $.ajax({
            type: "post",
            url: siteurl + "frequencia/validaDiaUtil",
            success: function (data) {
                var dia_util = 1;
                if(data == 'bloq'){
                    dia_util = 0;
                }
                $('.datepicker-my').datepicker({
                    language:"pt-BR",
                    view:"months",
                    minView:"months",
                    dateFormat: 'mm/yyyy',
                    autoClose: true,
                    minDate: new Date(currentYear, currentMonth-dia_util),       
                    maxDate: new Date(),
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
                });
            }
        });

        $(".mask").mask('00/0000',{placeholder: "__/____"}, {'translation':{ 0: { pattern: /[0-9*]/}}});
        $("#consultar").on("click",function(){
            if(formValida()){
                var url = siteurl + "ocorrencia/getDadosOcorrencia";
                $.ajax({
                    type: "post",
                    url: siteurl + "frequencia/validaDiaUtil",
                    data: {
                        data: '01/'+$('#periodo').val()
                    },
                    success: function (response) {
                        var mens = '';
                        var data = $("#pesqFolha").serialize();
                        if(response == 'bloq'){
                            $('#div_ocorrencia_consulta').empty();
                            mens = 'A folha do mês <b>'+$('#periodo').val()+'</b> encontra-se fechada.';
                            Toast3.fire(
                                'Data Inválida',
                                mens,
                                'error',
                                )
                            $("#periodo").val($("#fecha").val().substring(3));
                        }else{
                            $.ajax({
                                url : url, 
                                type : "POST",
                                dataType: "html",
                                data : $("#formOcorrencia").serialize(),
                                beforeSend : function(){
                                    $(".overlay").show();
                                }
                            }).done(function(data){
                                $("#div_ocorrencia_consulta").html(data);
                                $(".overlay").hide();
                            });
                        }
                    }
                });
            }
            $(this).tooltip('hide');    
        });

        $("#cadastrarNovo").on("click",function(){
            var url = siteurl + "ocorrencia/modalCadastroOcorrencia";
            $.ajax({
                url : url, 
                type : "POST",
                dataType: "html",
                beforeSend : function(){
                    $(".overlay").show();
                }
            }).done(function(data){
                $("#modalOcorrencia").html(data);
                $("#modalOcorrencia").modal("show");
                $(".overlay").hide();
            });
            $(this).tooltip('hide');    
        });

        $("#contratos").on("change",function(){
            var contrato = $(this).val();
            var url = siteurl + "ocorrencia/getCoordenadoresOcorrencia";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend: function(){
                    $('#coordenador').attr('disabled',true).selectpicker('refresh');
                    $("#nome").attr('disabled',true).selectpicker('refresh');
                    $("#superior").attr('disabled',true).selectpicker('refresh');
                },
                success: function(data) {
                    var option = "";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#coordenador").html(option).attr('disabled',false).selectpicker('refresh');
                    $("#nome").html('').attr('disabled',false).selectpicker('refresh');
                    $("#superior").html('').attr('disabled',false).selectpicker('refresh');
                }
            });
        });
        $("#coordenador").on("change",function(){
            var coordenador = $(this).val();
            var url = siteurl + "ocorrencia/getSupervisoresFolhaSelect";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { coordenador : coordenador },
                beforeSend: function(){
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
                    $("#nome").html('');
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    // $("#superior").removeClass("loading-screen");
                    $('#superior').selectpicker('refresh');
                    $('#nome').selectpicker('refresh');
                }
            });
        });

        $("#superior").on("change",function(){
            var superior = $(this).val();
            var url = siteurl + "ocorrencia/getEmpregadosFolhaSelect";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { superior : superior },
                beforeSend: function(){
                    $('#nome').attr('disabled',true);
                    $('#nome').selectpicker('refresh');
                },
                success: function(data) {
                    //console.log(data);
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        //console.log(data[i].IdMotivo);
                        option = option + "<option value='"+data[i].MATRICULA+"'>"+data[i].Nome+"</option>";
                        //console.log(option);   
                    }
                    $("#nome").html(option);
                    $('#nome').attr('disabled',false);
                    $('.select_emp').remove();
                    // $("#superior").removeClass("loading-screen");
                    $('#nome').selectpicker('refresh');
                }
            });

        });


        function formValida(){   
            valid = true;

            if($('#contratos').is(':visible')){
                if($("#contratos").val() =="" || $("#contratos").val() == null){
                    valid = false;
                    $("#contratos").css({'border-color': '#a94442'});
                    $("#input_contrato_error").html("Selecione um contrato");
                }else{
                    $("#contratos").css({'border-color': 'lightgrey'});
                    $("#input_contrato_error").html('');
                }
            }
            if($('#coordenador').is(':visible')){
                if($("#coordenador").val() =="" || $("#coordenador").val() == null){
                    valid = false;
                    $("#coordenador").css({'border-color': '#a94442'});
                    $("#input_coordenador_error").html("Selecione um coordenador");
                }else{
                    $("#coordenador").css({'border-color': 'lightgrey'});
                    $("#input_coordenador_error").html('');
                }
            }

            // validação campo data 
            if($("#periodo").val() ==""){
                valid = false;
                $("#periodo").css({'border-color': '#a94442'});
                $("#periodo_error").html("Selecione o período");
            }else{
                $("#periodo").css({'border-color': 'lightgrey'});
                $("#periodo_error").html('');
            }

            return valid;
        }

        $('#contratos').selectpicker({
            noneSelectedText: 'Selecione o(s) contrato(s)',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            // selectAllText: 'Marcar',
            // deselectAllText: 'Limpar',
            // actionsBox: true,
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm',
            maxOptions: 1,
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
            styleBase: 'btn btn-sm',
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
            styleBase: 'btn btn-sm',
            // maxOptions: 1,
            // title: 'Selecione'
        });
        $('#nome').selectpicker({
            noneSelectedText: 'Selecione o(a) empregado(a)',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            selectAllText: 'Marcar',
            deselectAllText: 'Limpar',
            actionsBox: true,
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm',
            // maxOptions: 1,
            // title: 'Selecione'
        });
        $('.dropdown-menu .inner').css('font-size','12px');
        $('.btn-default').addClass('btn-sm');
    });
    

</script>