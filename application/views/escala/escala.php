<?php 
if($this->session->userdata('acesso') == "Administrador" || $this->session->userdata('acesso') == "Planejamento"):
    $class = "col-sm-2";
else:
    $class = "col-sm-3";
endif;
?>
<div class="box box-primary">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Controle de Escala</h4>
        <div class="box-tools">
        <?php if(!($this->session->userdata("acesso") == "Planejamento")):?>
            <button class="btn btn-sm btn-warning" title="Cadastrar nova escala" id="nova_escala" >Cadastrar Escala <span class="glyphicon glyphicon-plus"></span></button>
        <?php endif;?>
        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12">
            <!-- primeira linha de campos !-->
                <div class="row">
                    <form id="formEscala">
                    <?php if($this->session->userdata('acesso') == "Administrador" || $this->session->userdata('acesso') == "Planejamento"):?>
                        <div class="<?php echo $class;?>">
                            <div class="form-group">
                                <label for="nome">Função:</label>
                                <select class="form-control input-sm multiselect" id="funcao" name="funcao" multiple>
                                    <?php foreach($funcao as $k): ?>
                                    <option value="<?= $k['IdFuncao']; ?>"><?= $k['NomeFuncao']; ?></option>
                                    <?php endforeach; ?>
                                </select>  
                                <span id="input_funcao_error" class="text-danger"></span>              
                            </div>
                        </div> 
                        <div class="<?php echo $class;?>">
                            <div class="form-group">
                                <label for="nome">Colaborador:</label>
                                <select class="form-control input-sm multiselect" id="superior" name="superior" multiple>
                                </select>  
                                <span id="input_superior_error" class="text-danger"></span>              
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if($this->session->userdata('acesso') == "Administrador" || $this->session->userdata('acesso') == "Planejamento"):?>
                        <div class="<?php echo $class;?>">
                            <div class="form-group">
                                <label for="nome">Subordinado:</label>
                                <select class="form-control input-sm multiselect" id="colaborador" name="colaborador[]" multiple>
                                </select>  
                                <span id="input_colaborador_error" class="text-danger"></span>              
                            </div>
                        </div> 
                    <?php else: ?>
                        <div class="<?php echo $class;?>">
                            <div class="form-group">
                                <label for="nome">Subordinado:</label>
                                <select class="form-control input-sm multiselect" id="sup" name="sup[]" multiple>
                                    <?php foreach($colaborador as $k): ?>
                                    <option value="<?= $k['MatriculaSCP']; ?>"><?= $k['Nome']; ?></option>
                                    <?php endforeach; ?>
                                </select>  
                                <span id="input_sup_error" class="text-danger"></span>              
                            </div>
                        </div> 
                    <?php endif;?>
                        <div class="<?php echo $class;?>">
                            <div class="form-group">
                                <label for="nome">Status:</label>
                                <select class="form-control input-sm multiselect" id="status" name="status[]" multiple>
                                    <option value="0" selected>Aguardando aprovação</option>
                                    <option value="1">Aprovado</option>
                                    <option value="2">Recusado</option>
                                </select>  
                                <span id="input_status_error" class="text-danger"></span>              
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="periodo">Período:</label>
                                <input type="text" class="form-control datepicker-my" id="periodo" name="periodo" aria-describedby="emailHelp" placeholder="Clique e selecione o mês/ano" value="<?php echo date('m/Y')?>">
                                <span id="periodo_error" class="text-danger"></span>              
                            </div>   
                        </div>
                    </form>  
                    <div class="col-sm">
                    <br>
                        <div class="form-group pull-left">
                            <button class="btn btn-primary" title="Consultar escalas" id="consultar" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>
                </div>
            <!-- <div class="row" id="div_escala_consulta" ></div> -->
        </div>
    </div>
</div>
<div class="box box-primary detalhe-escala" style="display:none;">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Detalhes da escala</h4>
    </div>
    <div class="box-body" id="div_escala_consulta" >
            <!-- <div class="row" id="div_escala_consulta" ></div> -->
    </div>
</div>

<!-- Modal Cadastro !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalCadastro"></div>	


<script>
    $(document).ready(function(){

        $("#consultar").on("click",function(){
            if(formValida()){
                var url = siteurl + "escala/getDadosEscala";
                $.ajax({
                    url : url, 
                    type : "POST",
                    dataType: "html",
                    data : $("#formEscala").serialize(),
                    beforeSend : function(){
                        $(".overlay").show();
                    }
                }).done(function(data){
                    $("#div_escala_consulta").html(data);
                    $(".overlay").hide();
                    $('.detalhe-escala').show();
                });
            }       
        });
        // carrega as opções do multiselect COLOABORADORES conforme a FUNÇÃO selecionada 
        $("#funcao").on("change",function(){
            var opt = $(this).val();
            var url = siteurl + 'escala/consultaSuperiorFuncao';		
            $.ajax({
                url : url,
                type : "POST",
                data : { funcao : opt },
                dataType : "json",
                beforeSend : function(){
                    var data = [{ label: "Carregando", value: '1'}];
                    $("#superior.multiselect").multiselect('dataprovider',data);
                    $("#superior.multiselect").multiselect('select','1');
                    $("#superior.multiselect").multiselect('disable');

                },
                success : function(data) {
                    if(data != ''){
                        $("#superior.multiselect").multiselect('dataprovider',data);
                    }else{
                        var data = [{ label: "Nenhum resultado encontrado", value: '1'}];
                        $("#superior.multiselect").multiselect('dataprovider',data);
                        $("#superior.multiselect").multiselect('select','1');
                    }
                }
            });
        });
        $("#superior").on("change",function(){
            var sup = $(this).val();
            var url = siteurl + 'escala/consultaColaboradorEscala';		
            $.ajax({
                url : url,
                type : "POST",
                data : { superior : sup },
                dataType : "json",
                beforeSend : function(){
                    var data = [{ label: "Carregando", value: '1'}];
                    $("#colaborador.multiselect").multiselect('dataprovider',data);
                    $("#colaborador.multiselect").multiselect('select','1');
                    $("#colaborador.multiselect").multiselect('disable');

                },
                success : function(data) {
                    if(data != ''){
                        $("#colaborador.multiselect").multiselect('dataprovider',data);
                    }else{
                        var data = [{ label: "Nenhum resultado encontrado", value: '1'}];
                        $("#colaborador.multiselect").multiselect('dataprovider',data);
                        $("#colaborador.multiselect").multiselect('select','1');
                    }
                }
            });
        });
        $("#nova_escala").on("click",function(){
            var url = siteurl + "escala/modalCadastroEscala";
            $.ajax({
                    url : url, 
                    type : "POST",
                    dataType: "html",
                    data : $("#formEscala").serialize(),
                    beforeSend : function(){
                        $(".overlay").show();
                    }
            }).done(function(data){
                $("#modalCadastro").html(data);
                $("#modalCadastro").modal("show");
                $(".overlay").hide();
            });
        });
        
        var date = new Date();
    	var currentMonth = date.getMonth();
    	var currentDate = date.getDate();
	    var currentYear = date.getFullYear();

        $('.datepicker-my').datepicker({
            language:"pt-BR",
            view:"months",		
            minView:"months",
            dateFormat: 'mm/yyyy',
            autoClose: true,
            minDate: new Date(currentYear, currentMonth-1, currentDate),       
            maxDate:new Date(),
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez']
        });


        function formValida(){   
            valid = true;
            // validação do campo de FUNÇÃO/COLABORADOR
            if($('#funcao').is(':visible')){
                if($("#funcao").val()=="" || $("#funcao").val()==null){/** FUNÇÃO */
                    valid = false;
                    $("#funcao").css({'border-color': '#a94442'});
                    $("#input_funcao_error").html("Informe a função.");
                }else{
                    $("#funcao").css({'border-color': 'lightgrey'});
                    $("#input_funcao_error").html('');
                }

                if($("#superior").val()=="" || $("#superior").val()==null){ /** COLABORADOR */
                    valid = false;
                    $("#superior").css({'border-color': '#a94442'});
                    $("#input_superior_error").html("Selecione o(a) colaborador(a).");
                }else{
                    $("#superior").css({'border-color': 'lightgrey'});
                    $("#input_superior_error").html('');
                }
                if($("#colaborador").val()=="" || $("#colaborador").val()==null){ /** SUBORDINADO */
                    valid = false;
                    $("#colaborador").css({'border-color': '#a94442'});
                    $("#input_colaborador_error").html("Selecione o(a) subordinado(a).");
                }else{
                    $("#colaborador").css({'border-color': 'lightgrey'});
                    $("#input_colaborador_error").html('');
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
        
    });
   
</script>