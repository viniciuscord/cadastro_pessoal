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

</style>


<?php 
    $modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'relatorio_colaborador', 'type' => 'view', 'acao' => 'negar', 'situacao' => 1);
    $acesso = Permissao_helper::validaAcessoRelatorioColaborador($modulo_acesso);
    if($situacao == 4 || $situacao == 1 || $situacao == 2):
        $title = 'Resultado';
        $estilo = 'style="display:none;"';
    else:
        $title = 'Lista de Operadores';
        $estilo = 'style="display:block;"';
    endif;
?>
<?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
<?php if($situacao): //print_r($coordenadores);?>
<div class="box box-primary" id="adm">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Lista de Operadores</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body" >
        <div class="col-md-12">
            <div class="row">
                <form id="formOcorrencia" method="POST">
            <?php if($situacao == 1): //print_r($coordenadores);?>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="contrato">Contrato:</label>
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
                    <div class="col-sm-3">
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
                    <div class="col-sm-3">
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
<?php endif; ?>
<div class="box box-primary" id="resultado_colaborador" <?php echo $estilo;?>>
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title"><?php echo $title;?></h4>
        <button class="btn btn-secondary btn-sm pull-right exportar" ><span class="fa fa-file"></span> Exportar</button>
    </div>
    <div class="box-body" >
        <div class="form-inline pull-right">
            <div class="checkbox">
                <label> <input type="checkbox" id="inp_sit" name="inp_sit" > Exibir Situação </label>
            </div>
            <div class="checkbox">
                <label> <input type="checkbox" id="inp_fila" name="inp_fila" > Exibir Fila </label>
            </div>
            <div class="checkbox">
                <label> <input type="checkbox" id="inp_funcao" name="inp_funcao" > Exibir Função </label>
            </div>
            <div class="checkbox">
                <label> <input type="checkbox" id="inp_supervisor" name="inp_supervisor" > Exibir Supervisor </label>
            </div>
        </div>
        <br>
        <div id="resultado"></div>
    </div>
        
</div>

<!-- Modal Cadastro !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalOcorrencia"></div>	
<script>
    $(document).ready(function(){

        $(".exportar").on("click",function(){
            var url = siteurl + 'relatorio_colaborador/exportar_lista_operadores';

            $("form").attr("action", url);
            $("form").submit();
        });
        
        if(!$('#adm').is(':visible')){
            mostraColuna();
        }

        $("#consultar").on("click",function(){
            if(formValida()){
                buscaColaborador();
            }
            $(this).tooltip('hide');    
        });

        $("#contrato").on("change",function(){
            var contrato = $(this).val();
            var url = siteurl + "relatorio_colaborador/getConsultaContratoRelListaOperadores";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend: function(){
                    $('#coordenador').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#colaborador').attr('disabled',true).empty().selectpicker('refresh');
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
            var url = siteurl + "relatorio_colaborador/consultaSuperiorRelListaOperadores";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { coordenador : coordenador },
                beforeSend: function(){
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#colaborador').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data) {
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

        function formValida(){   
            valid = true;
            if($("#contrato").is(':visible')){
                if($("#contrato").val() =="" || $("#contrato").val() == null){
                    valid = false;
                    $("#coordenador").css({'border-color': '#a94442'});
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
                if($("#superior").val() =="" || $("#superior").val() == null){
                    valid = false;
                    $("#superior").css({'border-color': '#a94442'});
                    $("#input_superv_error").html("Selecione o(a) supervisor(a)");
                }else{
                    $("#superior").css({'border-color': 'lightgrey'});
                    $("#input_superv_error").html('');
                }
            }

            return valid;
        }
        function buscaColaborador(){
            var url = siteurl + "relatorio_colaborador/buscaColaborador";
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
                    if(!$('#resultado_colaborador').is(':visible')){
                        $('#resultado_colaborador').show();
                    }
                    $("input:checked").attr('checked',false)
                });
        }
        function mostraColuna(){
            var url = siteurl + "relatorio_colaborador/buscaColaborador";
            var sit = '';
            var fila = '';
            var funcao = '';
            var sup = '';
            var superior = ''
            if($('#inp_sit').is(':checked')){
                sit = "exibir";
            }
            if($('#inp_fila').is(':checked')){
                fila = "exibir";
            }
            if($('#inp_funcao').is(':checked')){
                funcao = "exibir";
            }
            if($('#inp_supervisor').is(':checked')){
                sup = "exibir";
            }
            if($('#adm').is(':visible')){
                superior = $("#superior").val();
            }
            $.ajax({
                url : url, 
                type : "POST",
                data : {
                    situacao: sit,
                    fila: fila,
                    funcao: funcao,
                    supervisor: sup,
                    superior: superior
                    // funcao: 'e'
                },
                beforeSend : function(){
                    $(".overlay").show();
                }
            }).done(function(data){
                $("#resultado").html(data);
                $(".overlay").hide();
                if(!$('#resultado_colaborador').is(':visible')){
                    $('#resultado_colaborador').show();
                }
            });
        }
        $('#inp_sit').change(function(){
            mostraColuna();
        });
        $('#inp_fila').change(function(){
            mostraColuna();
        });
        $('#inp_funcao').change(function(){
            mostraColuna();
        });
        $('#inp_supervisor').change(function(){
            mostraColuna();
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
        $('.dropdown-menu .inner').css('font-size','12px');
        $('.btn-default').addClass('btn-sm');
    });

</script>