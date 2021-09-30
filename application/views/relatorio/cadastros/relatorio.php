<!-- <div class="box box-primary">
    <div id="overlay-filtro" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Cadastros Ativos</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <?php //print_r($this->session->userdata("acesso")); ?> 
    <div class="box-body">
        <div class="col-sm-12">
            <div class="row">
                <form id="formRelatorio">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="cerat">CGC:</label><br>
                            <select class="form-control input-sm selectpicker" id="cerat" name="cerat[]" multiple>
                                <?php foreach($cgc as $unids): ?>
                                <option class="cgc_option" value="<?= $unids['CGC'] ?>"><?= $unids['SIGLA'] ?></option>
                                <?php endforeach; ?>
                            </select>          
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="periodo">Empresa:</label>
                            <select class="form-control input-sm selectpicker" id="empresa" name="empresa[]" multiple>
                              
                            </select>        
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="periodo">Contrato:</label>
                            <select class="form-control input-sm selectpicker" id="contrato" name="contrato[]" multiple>
                            </select>        
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="periodo">Superior:</label>
                            <select class="form-control input-sm selectpicker" id="superior" name="superior[]" multiple>
                               
                            </select>             
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="funcao">Função:</label>
                            <select class="form-control input-sm selectpicker" id="funcao" name="funcao[]" multiple>
                          
                            </select>               
                            <span id="periodo_error" class="text-danger"></span>              
                        </div>   
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="agrupador">Agrupado por:</label>
                            <select id="agrupador" class="form-control input-sm selectpicker" name="agrupador">
                                <option value='1' >EMPRESA</option>
                                <option value='2'>SUPERIOR</option>
                                <option value='3'>FUNÇÃO</option>
                            </select>               
                            <span id="periodo_error" class="text-danger"></span>              
                        </div>   
                    </div>
                </form>  
            </div>
            <div class='row'>
                <div class="col-sm-12">
                    <button class="btn btn-primary pull-right btn-sm" id="consultar_relatorio" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div>
        </div> 
    </div>
</div>
<div id="consult_result" style="margin-top:15px; display:none"></div>

<div  id="result_click" style="margin-top:15px; display:none;"></div>


<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_rel_detalhado"></div>	

<script>
    $(document).ready(function(){
        $("#consultar_relatorio").on("click",function(){
            var url = siteurl + "relatorio/getRelatorioResult";
            $.ajax({
                url : url,
                type : "POST",
                dataType : "html",
                data : $("#formRelatorio").serialize(),
                beforeSend: function(){
                    $("#overlay-filtro").show();
                    $("#overlay-analitico").show();
                },
                success: function(data){    
                    $("#consult_result").html(data);
                    $("#overlay-analitico").hide();
                    $("#consult_result").show();
                    $("#overlay-filtro").hide();
                    $("#result_click").hide();

                }
           });
        });

        // carrega as opções do multiselect Empresa conforme a CERAT selecionada 
        $("#cerat").on("change",function(){
            cgc = [];
            $('.cgc_option:checked').each(function (i, v) {
                cgc[i] = $(v).val(); 
            });
            var url = siteurl + 'relatorio/getEmpresas';		
            $.ajax({
                url : url,
                type : "POST",
                data : { cgc : cgc },
                dataType : "json",
                beforeSend : function(){
                    $('#empresa').attr('disabled',true).empty().selectpicker('refresh');
                    $('#contrato').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#funcao').attr('disabled',true).empty().selectpicker('refresh');

                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].IdEmpresa+"'>"+data[i].NomeEmpresa+"</option>";
                    }
                    $("#empresa").html(option);
                    $('#empresa').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#empresa').selectpicker('refresh');
                }
            });
        });

        // carrega as opções do multiselect Contrato conforme a Empresa selecionada
        $("#empresa").on("change",function(){
            empresa = [];
            $('#empresa option:checked').each(function (i, v) {
                empresa[i] = $(v).val(); 
            });
            var url = siteurl + 'relatorio/getContrato';		
            $.ajax({
                url : url,
                type : "POST",
                data : { empresa : empresa },
                dataType : "json",
                beforeSend : function(){
                    $('#contrato').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#funcao').attr('disabled',true).empty().selectpicker('refresh');
                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].IdContrato+"'>"+data[i].Contrato+"</option>";
                    }
                    $("#contrato").html(option);
                    $('#contrato').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#contrato').selectpicker('refresh');
                }
            });
        });

        // carrega as opções do multiselect Superior conforme o Contrato selecionada
        $("#contrato").on("change",function(){
            empresa = [];
            cgc = [];
            contrato = [];
            $('#contrato option:checked').each(function (i, v) {
                contrato[i] = $(v).val(); 
            });
            $('.cgc_option:checked').each(function (i, v) {
                cgc[i] = $(v).val(); 
            });

            $('#empresa option:checked').each(function (i, v) {
                empresa[i] = $(v).val(); 
            });
            var url = siteurl + 'relatorio/getSuperior';		
            $.ajax({
                url : url,
                type : "POST",
                data : {
                        contrato : contrato,
                        cgc: cgc,
                        empresa: empresa
                },
                dataType : "json",
                beforeSend : function(){
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#funcao').attr('disabled',true).empty().selectpicker('refresh');
                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSuperior+"'>"+data[i].Nome+"</option>";
                    }
                    $("#superior").html(option);
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#superior').selectpicker('refresh');
                }
            });
        });

        // carrega as opções do multiselect Função conforme o Superior selecionado
        $("#superior").on("change",function(){
            empresa = [];
            cgc = [];
            contrato = [];
            $('#contrato option:checked').each(function (i, v) {
                contrato[i] = $(v).val(); 
            });
            $('.cgc_option:checked').each(function (i, v) {
                cgc[i] = $(v).val(); 
            });

            $('#empresa option:checked').each(function (i, v) {
                empresa[i] = $(v).val(); 
            });
            var url = siteurl + 'relatorio/getFuncao';		
            $.ajax({
                url : url,
                type : "POST",
                data : {
                        contrato : contrato,
                        cgc: cgc,
                        empresa: empresa
                },
                dataType : "json",
                beforeSend : function(){
                    $('#funcao').attr('disabled',true);
                    $('#funcao').selectpicker('refresh');

                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].IdFuncao+"' data-subtext=' | "+data[i].Contrato+"'>"+data[i].NomeFuncao+"</option>";
                    }
                    $("#funcao").html(option);
                    $('#funcao').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#funcao').selectpicker('refresh');
                }
            });


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
        $('#cerat').selectpicker({
            noneSelectedText: 'Selecione o CGC',
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
        $('#agrupador').selectpicker({
            noneSelectedText: 'Selecione a empresa',
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
        $('#empresa').selectpicker({
            noneSelectedText: 'Selecione a empresa',
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
        $('#funcao').selectpicker({
            noneSelectedText: 'Selecione a função',
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

</script> -->

<div class="box box-primary">
    <div id="overlay-filtro" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Cadastros Ativos</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <?php //print_r($this->session->userdata("acesso")); ?> 
    <div class="box-body">
        <div class="col-sm-12">
            <div class="row">
                <form id="formRelatorio">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="contrato">Contratos:</label><br>
                            <select class="form-control input-sm selectpicker" id="contrato" name="contrato[]" multiple>
                                <?php foreach($contratos as $contrato): ?>
                                <option class="contrato_option" value="<?= $contrato['IdContrato'] ?>" data-cgc="<?= $contrato['Central'] ?>" data-empresa="<?= $contrato['IdEmpresa'] ?>" data-subtext=" | <?= $contrato['NomeEmpresa'].' '.$contrato['Central'] ?>"><?= $contrato['Contrato'] ?></option>
                                <?php endforeach; ?>
                            </select>          
                        </div>   
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="periodo">Superior:</label>
                            <select class="form-control input-sm selectpicker" id="superior" name="superior[]" multiple>
                               
                            </select>             
                        </div>   
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="agrupador">Agrupado por:</label>
                            <select id="agrupador" class="form-control input-sm selectpicker" name="agrupador">
                                <option value='1' >EMPRESA</option>
                                <option value='2'>SUPERIOR</option>
                                <option value='3'>FUNÇÃO</option>
                            </select>               
                            <span id="periodo_error" class="text-danger"></span>              
                        </div>   
                    </div>
                </form>  
                <div class="col-sm-1">
                    <div class="form-group">
                        <br>
                        <button class="btn btn-primary pull-right btn-sm" id="consultar_relatorio" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                    </div>   
                </div>
            </div>
            <!-- <div class='row'>
                <div class="col-sm-12">
                    <button class="btn btn-primary pull-right btn-sm" id="consultar_relatorio" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                </div>
            </div> -->
        </div> 
    </div>
</div>
<div id="consult_result" style="margin-top:15px; display:none"></div>

<div  id="result_click" style="margin-top:15px; display:none;"></div>


<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_rel_detalhado"></div>	

<script>
    $(document).ready(function(){
        $("#consultar_relatorio").on("click",function(){
            empresa = [];
            cgc = [];
            var superior = $('#superior').val();
            var agrupador = $('#agrupador').val();

            $('.contrato_option:checked').each(function (i, v) {
                empresa[i] = $(v).data('empresa'); 
                cgc[i] = $(v).data('cgc'); 
            });
            var url = siteurl + "relatorio/getRelatorioResult";
            $.ajax({
                url : url,
                type : "POST",
                dataType : "html",
                // data : $("#formRelatorio").serialize(),
                data:{
                    cerat: cgc,
                    empresa: empresa,
                    superior: superior,
                    agrupador: agrupador

                },
                beforeSend: function(){
                    $("#overlay-filtro").show();
                    $("#overlay-analitico").show();
                },
                success: function(data){    
                    $("#consult_result").html(data);
                    $("#overlay-analitico").hide();
                    $("#consult_result").show();
                    $("#overlay-filtro").hide();
                    $("#result_click").hide();

                }
           });
        });

        // carrega as opções do multiselect Superior conforme o Contrato selecionada
        $("#contrato").on("change",function(){
            contrato = [];
            $('.contrato_option:checked').each(function (i, v) {
                contrato[i] = $(v).val(); 
            });
            var url = siteurl + 'relatorio/getSuperiorContratosRelAtivos';		
            $.ajax({
                url : url,
                type : "POST",
                data : {
                        contrato : contrato,
                },
                dataType : "json",
                beforeSend : function(){
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                },
                success : function(data) {
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSuperior+"'>"+data[i].Nome+"</option>";
                    }
                    $("#superior").html(option);
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#superior').selectpicker('refresh');
                }
            });
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
        $('#superior').selectpicker({
            noneSelectedText: 'Selecione o superior',
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
        $('#agrupador').selectpicker({
            noneSelectedText: 'Selecione a empresa',
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