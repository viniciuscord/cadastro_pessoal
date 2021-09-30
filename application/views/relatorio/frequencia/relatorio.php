<?php 
    $modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_frequencia', 'type' => 'view', 'acao' => 'negar', 'situacao' => 1);
    $acesso = Permissao_helper::validaAcessoRelatorioColaborador($modulo_acesso);
    if($acesso):
        $title = 'Resultado';
        $estilo = 'style="display:none;"';
    else:
        $title = 'Lista de Operadores';
        $estilo = 'style="display:block;"';
    endif;
?>
<?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
<div class="box box-primary">
    <div id="overlay-filtro" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Frequência</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <?php //print_r($this->session->userdata("acesso")); ?> 
    <div class="box-body">
        <div class="col-sm-12">
            <div class="row">
            <form id="formRelatorio" method="POST">
            <?php if($situacao == 1): //print_r($coordenadores);?>
            <!--?php if($this->session->userdata("acesso") ==  "Administrador" || $this->session->userdata("acesso") == "Coordenador TI" || $this->session->userdata("acesso") == "Gerente Contrato" ): //print_r($coordenadores);?-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="supervisor">Contrato:</label><br>
                        <select id="contrato" class="form-control input-sm selectpicker" multiple="multiple" name="contrato[]">
                            <?php foreach($contratos as $contrato): ?>
                            <option class="contrato_opt" value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato'] ?></option>
                            <?php endforeach; ?>
                        </select>          
                    <span id="input_contrato_error" class="text-danger"></span>  
                    </div> 
                </div>
            <?php endif; ?>
            <?php if($situacao == 4 || $situacao == 1): ?>
                <div class="<?=$class_padrao;?>">
                    <div class="form-group">
                        <label for="supervisor">Coordenador:</label><br>
                        <select id="coordenador" class="form-control input-sm selectpicker" multiple="multiple" name="coordenador[]">
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
                        <label for="supervisor">Supervisor:</label><br>
                        <select id="supervisor" class="form-control input-sm selectpicker" multiple="multiple" name="supervisor[]">
                        <?php if(isset($superiores)):?>
                            <?php foreach($superiores as $superior): ?>
                                <option value="<?= $superior['MatriculaSCP'] ?>"><?= $superior['Nome']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </select>          
                    <span id="input_supervisor_error" class="text-danger"></span>  
                    </div>   
                </div>
                <?php endif;?>
                <div class="<?=$class_padrao;?>">
                    <div class="form-group">
                        <label for="colaborador">Colaborador:</label>
                        <select id="colaborador" class="form-control input-sm selectpicker" multiple="multiple" name="colaborador[]">
                        <?php if($colaboradores): ?>
                            <?php foreach($colaboradores as $colaborador): ?>
                                <option class="contrato_opt" value="<?= $colaborador['MatriculaSCP'] ?>"><?= $colaborador['Nome'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </select>        
                    <span id="input_colaborador_error" class="text-danger"></span>  
                    </div>   
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="data">Período:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right" id="data" name="data" value="<?php echo date('m/Y'); ?>" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">  
                        </div>
                    <span id="input_data_error" class="text-danger"></span>
                    </div>
                </div>
            </form>
                <div class="col-sm-1">
                    <div class="form-group">
                        <br><button class="btn btn-primary btn-sm" id="pesquisar"><span class="fa fa-search"></span> Pesquisar</button>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="consult_result" style="margin-top:15px; display:none;"></div>

<script>
    $(document).ready(function(){
          var date = new Date();
          var currentYear = date.getFullYear();

        $('#data').datepicker({
            language:"pt-BR",
            view:"months",		
            minView:"months",
            dateFormat: 'mm/yyyy',
            autoClose: true,
            maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });
 
        $("#pesquisar").on("click",function(){
            var url = siteurl + "relatorio/getRelatorioFrequencia";
            if(formValida()){
                    $.ajax({
                        url : url,
                        type : "POST",
                        dataType : "html",
                        data : $("#formRelatorio").serialize(),
                        beforeSend: function(){
                            $("#overlay-filtro").show();
                            $("#overlay-detalhado").show();
                        },
                        success: function(data){    
                            $("#consult_result").html(data);
                            $("#consult_result").find('table').dataTable({
                                "oLanguage": {
                                    "sLengthMenu": "_MENU_ por página",
                                    "sInfoEmpty": "Não foram encontrados registros",
                                    "sInfo": "(_START_ a _END_) registros",
                                    "sInfoFiltered": "(filtrado de _MAX_ registro(s))",
                                    "sZeroRecords": "Nenhum resultado",
                                    "sSearch": "Filtrar",
                                    "oPaginate":
                                            {
                                                "sNext": "<span class='glyphicon glyphicon-chevron-right'></span>",
                                                "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span> "
                                            }
                                },
                                "order": [],
                                "pageLength": 10,
                                "bPaginate": true
                            });
                        
                            $("#overlay-detalhado").hide();
                            $("#consult_result").show();
                            $("#overlay-filtro").hide();

                        }
                });
            }

        });

        $("#contrato").on("change",function(){
            contrato = [];
            $(".contrato_opt:checked").each(function(i,v){
                contrato[i] = $(v).val();
            });
            var url = siteurl + "relatorio/getColaboradoresRelFreq"; 
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend : function(){
                    $('#coordenador').attr('disabled',true).empty().selectpicker('refresh');
                    $('#supervisor').attr('disabled',true).empty().selectpicker('refresh');
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
                }

            });

        });
        $("#coordenador").on("change",function(){
            var coordenador = $(this).val();
            var url = siteurl + "relatorio/getCoordRelFreq"; 
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data : { coordenador : coordenador },
                beforeSend : function(){
                    $('#supervisor').attr('disabled',true).empty().selectpicker('refresh');
                    $('#colaborador').attr('disabled',true).empty().selectpicker('refresh');
                },
                success: function(data){
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#supervisor").html(option);
                    $('#supervisor').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#supervisor').selectpicker('refresh');
                }

            });

        });
        $("#supervisor").on("change",function(){
            var supervisor = $(this).val();
            var url = siteurl + "relatorio/getColaboradores"; 
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data : { supervisor : supervisor },
                beforeSend : function(){
                    $('#colaborador').attr('disabled',true);
                    $('#colaborador').selectpicker('refresh');
                },
                success: function(data){
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
        $('#supervisor').selectpicker({
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
        $('#colaborador').selectpicker({
            noneSelectedText: 'Selecione o(a) colaborador(a)',
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

        function formValida(){
            var retorno = true;
            if($('#contrato').is(':visible')){
                if($('#contrato').val() == "" ||$('#contrato').val() == null){
                    retorno = false;
                    $("#contrato").css({'border-color': '#a94442'});
                    $("#input_contrato_error").html("Selecione o contrato");
                }else{
                    $("#contrato").css({'border-color': 'lightgrey'});
                    $("#input_contrato_error").html('');
                } 

                if($('#coordenador').val() == "" ||$('#coordenador').val() == null){
                    retorno = false;
                    $("#coordenador").css({'border-color': '#a94442'});
                    $("#input_coordenador_error").html("Selecione o(a) coordenado(a)r");
                }else{
                    $("#coordenador").css({'border-color': 'lightgrey'});
                    $("#input_coordenador_error").html('');
                } 
                
                if($('#supervisor').val() == "" ||$('#supervisor').val() == null){
                    retorno = false;
                    $("#supervisor").css({'border-color': '#a94442'});
                    $("#input_supervisor_error").html("Selecione o(a) supervisor(a)");
                }else{
                    $("#supervisor").css({'border-color': 'lightgrey'});
                    $("#input_supervisor_error").html('');
                } 

            }

            if($('#colaborador').val() == "" ||$('#colaborador').val() == null){
                retorno = false;
                $("#colaborador").css({'border-color': '#a94442'});
                $("#input_colaborador_error").html("Selecione o(a) colaborador(a)");
            }else{
                $("#colaborador").css({'border-color': 'lightgrey'});
                $("#input_colaborador_error").html('');
            } 

            if($('#data').val() == "" ||$('#data').val() == null){
                retorno = false;
                $("#data").css({'border-color': '#a94442'});
                $("#input_data_error").html("Selecione o período");
            }else{
                $("#data").css({'border-color': 'lightgrey'});
                $("#input_data_error").html('');
            } 

            return retorno;
        }
    });

</script>