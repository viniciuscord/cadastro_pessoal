<div class="box box-primary">
    <div id="overlay-filtro" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Folha de Ponto</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body" >
        <div class="col-md-12"> 
            <div class="row">
                <form id="formPontoFolha" >
                <?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
                    <?php 
                    $modulo_acesso = array(	'modulo' => 'frequencia', 'submodulo' => 'controle_folha_ponto', 'type' => 'view', 'acao' => 'permitir', 'situacao' =>  1);
                    $perfil = Permissao_helper::validaAcessoFrequenciaFolhaPonto($modulo_acesso);
                    if($situacao == 1): ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="contrato">Contratos:</label>
                                <select class="form-control input-sm selectpicker" id="contrato" name="contrato[]" multiple>
                                    <!-- <option class="contrato_opt" value="" selected>Selecione</option> -->
                                    <?php foreach($contratos as $contrato): ?>
                                    <option class="contrato_opt" value="<?= $contrato['IdContrato']; ?>"><?= $contrato['Contrato']; ?></option>
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
                                    <!-- <option class="coordenador_opt" value="" selected>Selecione</option> -->
                                    <?php foreach($coordenadores as $coordenador): ?>
                                        <option class="coordenador_opt" value="<?= $coordenador['MatriculaSCP']; ?>"><?= $coordenador['Nome']; ?></option>
                                    <?php endforeach; ?>
                                </select>  
                                <span id="input_coordenador_error" class="text-danger"></span>              
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($situacao == 1 || $situacao == 2 || $situacao == 3 || $situacao == 4): ?>
                        <div class="<?=$class_padrao;?>">
                            <div class="form-group"> 
                                <label for="superior">Supervisor:</label>
                                <select id="superior" class="form-control input-sm selectpicker" multiple="multiple" name="superior[]" >
                                    <?php foreach($superiores as $superior): ?>
                                        <option value="<?= $superior['MatriculaSCP']; ?>"><?= $superior['Nome']; ?></option>
                                    <?php endforeach; ?>
                                </select>  
                                <span id="input_supervisor_error" class="text-danger"></span>              
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($perfil): ?>
                    <div class="<?=$class_padrao;?>">
                        <div class="form-group">
                            <label for="nome">Colaboradores:</label>
                            <select id="colaborador" class="form-control input-sm selectpicker" multiple="multiple" name="nome[]" >
                                <?php foreach($empregados as $empregado): ?>
                                <option value="<?= $empregado['MatriculaSCP']; ?>"><?= $empregado['Nome']; ?></option>
                                <?php endforeach; ?>
                            </select>  
                            <span id="input_colaborador_error" class="text-danger"></span>              
                        </div>
                    </div> 
                    <?php endif; ?>
                    <div class="col-md-2" style="margin-top: 2px;">
                        <div class="form-group">
                            <label for="periodo">Período:</label>
                            <input type="text" class="form-control input-sm datepicker-my" id="periodo" name="periodo" aria-describedby="emailHelp" placeholder="Clique e selecione o mês/ano" value="<?php echo date('m/Y'); ?>">
                            <span id="periodo_error" class="text-danger"></span>              
                        </div>   
                    </div>
                    </form>  

                    <div class="col-md-1">
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm" title="Imprimir Folha" id="consultarFolha" > <span class="fa fa-search"></span> Visualizar</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Ponto !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_ponto">
    <div class="modal-dialog modal-md" style="width: 890px;">
    <div class="modal-content">
        <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Folha de Ponto</h4>       
        </div>
        <div class="modal-body" style="overflow:scroll; height: 560px; width:880px;">
            
        </div>
        <div class="modal-footer">        
            <button type="button" class="btn btn-success" id="imprimir_via_modal" ><span class="fa fa-print"></span> Imprimir</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
    </div>
</div>	

<script>

    $(document).ready(function(){

         $('.datepicker-my').datepicker({
            language:"pt-BR",
            view:"months",		
            minView:"months",
            dateFormat: 'mm/yyyy',
            autoClose: true,
            maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });
        
        $("#consultarFolha").on("click",function(){
            if(validaForm()){
                var data = $("#formPontoFolha").serialize();
                var url = siteurl + "frequencia/getFolhaPontoPrint";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'html',
                    beforeSend: function(){
                        $("#overlay-filtro").show();
                    },
                    success: function (html) {
                        if(html != ''){
                            $(".modal-body").html(html);
                            $("#modal_ponto").modal("show");
                        }else{
                            $.toaster({
                                priority : "warning", 
                                title : ceacr+" - CP", 
                                message : "Não foi possível realizar a impressão, verifique se TODOS os filtros estão preenchidos",
                                settings: {'timeout': 5500 }
                            });
                        }
                        $("#overlay-filtro").hide();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $("#overlay-filtro").hide();
                    }
                });
            }
        });

        $("#imprimir_via_modal").on("click",function(){
            var data = $("#formPontoFolha").serialize();
            var url = siteurl + "frequencia/getFolhaPontoPrint";
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'html',
                beforeSend: function(){
                    //$("#overlay-filtro").show();
                },
                success: function (html) {
                    if(html != ''){
                        w = window.open(window.location.href,"_blank");
                        w.document.open();
                        w.document.write(html);
                        w.document.close();
                        w.focus();
                        w.window.print();
                        w.close();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    //$("#overlay-filtro").hide();
                }
            });
        });

         // carrega as opções do multiselect Colaboradores conforme o Supervisor selecionado 
         $("#superior").on("change",function(){
            var opt = $(this).val();
            var url = siteurl + 'frequencia/getEmpregadosFolhaControlePontoFPADM';		
            $.ajax({
                url : url,
                type : "POST",
                data : { superior : opt },
                dataType : "json",
                beforeSend : function(){
                    $('#colaborador').attr('disabled',true);
                    $('#colaborador').selectpicker('refresh');

                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#colaborador").html(option);
                    $('#colaborador').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#colaborador').selectpicker('refresh');
                }
            });
        });

        // carrega as opcoes do select coordenador conoforme o contrato selecionado 
        $("#contrato").on("change",function(){
            var opt = $(this).val();
            var url = siteurl + 'frequencia/consultaCoordFolhaPonta';
            $.ajax({
                url: url,
                type: "POST",
                data: { contrato: opt },
                dataType: "json",
                beforeSend: function(){
                    $('#coordenador').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#colaborador').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data){
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#coordenador").html(option);
                    $('#coordenador').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#coordenador').selectpicker('refresh');
                    $('#superior').html('').selectpicker('refresh');
                    $('#colaborador').html('').selectpicker('refresh');
                }
            });
        });

        // carrega as opcoes do select Supervisor conoforme o Coordenador selecionado 
        $("#coordenador").on("change",function(){
            var opt = $(this).val();
            var url = siteurl + 'frequencia/getSupervisoresFolhaControlePontoFP';
            $.ajax({
                url: url,
                type: "POST",
                data: { coordenador: opt },
                dataType: "json",
                beforeSend: function(){
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#colaborador').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data){
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#superior").html(option);
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#superior').selectpicker('refresh');
                }
            });
        });
        function validaForm(){
            var valid = true;
            if($('#contrato').is(':visible')){
                if($('#contrato').val() == '' || $('#contrato').val() == null){
                    valid = false;
                    $("#contrato").css({'border-color': '#a94442'});
                    $("#input_contrato_error").html('Selecione o contrato');
                
                }else{
                    $("#contrato").css({'border-color': 'lightgrey'});
                    $("#input_contrato_error").html('');
                }
            }
            if($('#coordenador').is(':visible')){ 
                if($('#coordenador').val() == '' || $('#coordenador').val() == null){
                    valid = false;
                    $("#coordenador").css({'border-color': '#a94442'});
                    $("#input_coordenador_error").html('Selecione o(a) coordenador(a)');
                
                }else{
                    $("#input_coordenador_error").html('');
                    $("#coordenador").css({'border-color': 'lightgrey'});
                }
            }
            if($('#superior').is(':visible')){ 

                if($('#superior').val() == '' || $('#superior').val() == null){
                    valid = false;
                    $("#superior").css({'border-color': '#a94442'});
                    $("#input_supervisor_error").html('Selecione o(a) supervisor(a)');
                
                }else{
                    $("#input_supervisor_error").html('');
                    $("#superior").css({'border-color': 'lightgrey'});
                }
            }


            if($('#periodo').val() == '' || $('#periodo').val() == null){
                valid = false;
                $("#periodo").css({'border-color': '#a94442'});
                $("#periodo_error").html('Selecione o período');
              
            }else{
                $("#periodo_error").html('');
                $("#periodo").css({'border-color': 'lightgrey'});
            }

            return valid;
        }
        $('#contrato').selectpicker({
            noneSelectedText: 'Selecione o contrato',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm',
            maxOptions: 1,
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
        });
        $('#colaborador').selectpicker({
            noneSelectedText: 'Selecione o(a) empregado(a)',
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