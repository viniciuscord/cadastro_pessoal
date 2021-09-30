<style>
    .ui-autocomplete{
        z-index: 9999;
    }
    .ui-menu-item{
        text-transform: uppercase;
        font-size: 11px;
        font-family: calibri;
        /* font-style: italic; */
    }
    .dropdown-menu{
        font-size: 11px;
        
    }
</style>
<div class="box box-primary">
    <div class="box-header with-border">        
        <h4 class="box-title">Cadastro</h4>
        <div class="box-tools">
            <?php 
                $modulo_acesso = array('modulo' => 'cadastro', 'submodulo' => null, 'type' => 'view', 'nome_view' => 'cadastramento', 'acao' => 'negar', 'situacao' => 1);
                $acesso = Permissao_helper::validaAcessoCadastro($modulo_acesso);
                
                $exibe_new_cad = array('modulo' => 'cadastro', 'submodulo' => null, 'type' => 'view', 'nome_view' => 'cadastramento', 'acao' => 'negar', 'situacao' => 3);
                $acesso_2 = Permissao_helper::validaAcessoCadastro($exibe_new_cad);
                
                if(!$acesso): $classe = 'col-lg-3'; else:  $classe = 'col-lg-2';  endif;
            ?>
            <!--<button class="btn btn-success view-modal" title="Cadastrar novo funcionário" data-remote="<?php // echo site_url('cadastro/cadastro_novo'); ?>">Cadastrar Novo <span class="glyphicon glyphicon-plus"></span></button>!-->
            <!--?php if($this->session->userdata("acesso") == "Administrador" || $this->session->userdata("acesso") == "Coordenador TI"): ?-->
            <?php if($acesso_2): ?>
                <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cadastrar novo funcionário" id="cadastrarNovo" >Cadastrar Novo <span class="glyphicon glyphicon-plus"></span></button>
            <?php endif; ?>
            <!-- <button class="btn btn-sm btn-success" data-toggle="tooltip" title="Cadastrar em lote" id="cadastroLote" >Cadastro Planilha <span class="glyphicon glyphicon-file"></span></button> -->
        </div>
    </div>
    <div class="box-body" >
        <div class="col-lg-12">
            <!-- primeira linha de campos !-->
            <form method="post" accept-charset="utf-8" action="<?php echo site_url("cadastro"); ?>">
                <div class="row">
                    <?php if($acesso): ?>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-nome">Contrato:</label>
                            <?php if($this->input->post('contrato')):?>
                                <?php $post_contrato = $this->input->post('contrato'); ?>
                            <?php endif;?>
                            <select class="form-control input-sm select-picker" name="contrato[]" id="contrato" multiple>
                                <?php if($contratos):?>
                                    <?php $i = 0;
                                     foreach ($contratos as $contrato):?>
                                        <option value="<?= $contrato['IdContrato']?>" <?php if($this->input->post('contrato')) if($contrato['IdContrato'] == $post_contrato[$i]) echo "selected";?>><?= $contrato['Contrato']?></option>
                                    <?php
                                    if(count($post_contrato) > 1): $i++; endif;
                                    endforeach?>
                                <?php endif;?>
                            </select>
                            <!-- <input type="text" class="form-control input-sm" name="contrato" id="contrato" aria-describedby="emailHelp" placeholder="Digite o nome do funcionário" value="<?php echo $this->input->post('nome'); ?>" > -->
                            <span id="contrato_error" class="text-danger"></span>
                        </div>   
                    </div> 
                    <?php endif; ?>
                    <div class="<?= $classe?>">
                        <div class="form-group">
                            <label for="input-nome">Nome:</label>
                            <input type="text" class="form-control input-sm" name="nome" aria-describedby="emailHelp" placeholder="Digite o nome do funcionário" value="<?php echo $this->input->post('nome'); ?>" >
                            <span id="pesq_error" class="text-danger"></span>
                        </div>   
                    </div> 
                    <div class="<?= $classe?>">
                        <div class="form-group">
                            <label for="input-nome">CPF:</label>
                            <input type="text" class="form-control input-sm" name="cpf" aria-describedby="emailHelp" placeholder="Digite o cpf do funcionário" value="<?php echo $this->input->post('cpf'); ?>">
                        </div>   
                    </div>
                    <div class="<?= $classe?>">
                        <div class="form-group">
                            <label for="input-nome">Matrícula:</label>
                            <input type="text" class="form-control input-sm" name="matricula" aria-describedby="emailHelp" placeholder="Digite a matrícula do funcionário" value="<?php echo $this->input->post('matricula'); ?>">
                        </div>   
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-nome">Funcionário Inativo:</label>
                            <div class="has-error">
                                <div class="checkbox">
                                    <label>
                                    <?php
                                    if($this->input->post('inativo') == "0"){
                                        $marca = 'checked="checked"';
                                    }else{
                                        $marca = "";
                                    }
                                    ?>
                                    <input type="checkbox" id="inativo" name="inativo" value="0" <? echo $marca;?>>
                                        Ver Inativo(s)
                                    </label>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                        <br>
                        <!-- linha do botão de envio !-->
                        <button type="submit" id="pesquisar" data-toggle="tooltip" title="Pesquisar" class="btn btn-sm btn-primary pull-right" id="consultar" >Pesquisar <span class="glyphicon glyphicon-search"></span></button>
                        </div>   
                    </div>
                </div> 
            </form>
            <div id="alert-submit"></div>
        </div>
    </div>
</div>
<?php 
    if(isset($dados)): 
        if($dados != null): 
?>
<div class="box box-primary">
    <div class="box-header with-border">        
        <h4 class="box-title">Usuários Cadastrados</h4>
    </div>
    <div class="box-body" >
        <div class="col-lg-12">
            <table class='table table-hover datatable no-footer' >
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Função</th>
                        <th>Editar</th>
                    </tr>
                <thead>
                <tbody class="body">
                    <?php foreach ($dados as $dado): ?>
                        <tr>
                            <td><?php echo $dado['MatriculaSCP']; ?></td>
                            <td><?php echo $dado['Nome']; ?></td>
                            <td><?php echo $dado['CPF']; ?></td>
                            <td><?php echo $dado['NomeFuncao']; ?></td>
                            <td><button class="btn btn-success btn-sm edt-cadastro" data-toggle="tooltip" title="Editar" ><span class="glyphicon glyphicon-pencil"></span></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="box box-primary">
        <div class="box-header with-border">        
            <h4 class="box-title">Usuários Cadastrados</h4>
        </div>
        <div class="box-body" >
            <div class="col-lg-12">
                <br><div class='alert alert-warning animated bounceIn col-sm-auto'>Nenhum cadastro encontrado com os parâmetros informados.</div>
            </div>
        </div>
    </div>
<?php endif;
endif; ?>

<!-- Modal Cadastro !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalCadastro">
	<div class="modal-dialog modal-md" style="width: 65%">
		<div class="modal-content" id="modalCadastroContent"></div>
	</div>
</div>	

<!-- Modal Cadastro Planilha !--> 
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modalCadastroPlanilha">
	<div class="modal-dialog modal-md">
	</div>
</div>	


<script>
    $(document).on("click",".edt-cadastro", function(){
        var cpf = $(this).closest("tr").children("td").eq(2).text();
        var url = siteurl + 'cadastro/editar_cadastro';
        $.ajax({
            url : url,
            dataType: "html",
            type : "POST",
            data : { cpf: cpf}
        }).done(function(data){
            $("#modalCadastroContent").html(data);
            $("#modalCadastro").modal("show");

        });
    });
       
    $(document).ready(function(){
        $("input[name='cpf']").mask("000.000.000-00", { 'translation':{ 0: { pattern: /[0-9*]/ }}});
        $("input[name='nome']").mask("Z", { 'translation': { "Z": {pattern: /[áÁãÃéÉíÍóÓõÕúÚñüÜàèaçÇA-Za-z ]/, recursive: true }}});

        $("form").submit(function(event){            
            event.preventDefault();
            if($('#contrato').is(':visible')){
                if($('#contrato').val() == '' || $('#contrato').val() == null){
                    $('#contrato').css({'border-color': '#a94442'});
                    $('#contrato_error').html('Selecione o contrato');
                }else{
                    $('#contrato').css({'border-color': 'lightgrey'});
                    $('#contrato_error').html('');
                    var datastring = $("form").serializeArray();
                    var valida = validateFormConsulta(datastring);
                    if(valida == ''){
                        this.submit();
                    }
                    $("#pesquisar").tooltip('hide');
                }

            }else{
                var datastring = $("form").serializeArray();
                var valida = validateFormConsulta(datastring);
                if(valida == ''){
                    this.submit();
                }

            }
        });

        function validateFormConsulta(data){
            var url = siteurl + "validacao/validaConsultaCadastro";
            var valid = '';
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                async : false,
                dataType: 'json',
                beforeSend: function (){
                    $("#consultar").attr('disabled',true);
                },
                success: function (data){
                    // console.log(data);
                    if(data.error){
                        // Validação do CPF
                        if(data.error){
                            $("#pesq_error").html(data.pesq_error);
                            $("input[name='cpf']").css({'border-color': '#a94442'});
                            $("input[name='nome']").css({'border-color': '#a94442'});
                            $("input[name='matricula']").css({'border-color': '#a94442'});
                            valid = 'error';
                        }else{
                            $("input[name='cpf']").css({'border-color': 'lightgrey'});
                            $("input[name='nome']").css({'border-color': 'lightgrey'});
                            $("input[name='matricula']").css({'border-color': 'lightgrey'});
                        }
                    }else{
                        $("#pesq_error").html('');
                    }
                    $("#consultar").attr('disabled',false);
                }
            });
            return valid;
        }

        $("#cadastrarNovo").on("click",function(){
            var url = siteurl + 'cadastro/cadastro_novo';   
            $.ajax({
                url : url,
                dataType: "html",
                type : "POST",
                beforeSend: function(){
                    $("#cadastrarNovo").attr("disabled",true);
                    $("#cadastrarNovo").tooltip('hide');
                }
            }).done(function(data){
                $("#cadastrarNovo").attr("disabled",false);
                $("#modalCadastroContent").html(data);
                $("#modalCadastro").modal("show");

            });
        });

        $("#cadastroLote").on("click",function(){
            var url = siteurl + 'cadastro/cadastro_planilha';
            $.ajax({
                url : url,
                dataType: "html",
                type : "POST",
                beforeSend: function(){
                    $("#cadastroLote").attr("disabled",true);
                    $("#cadastroLote").tooltip('hide');
                }
            }).done(function(data){
                $("#cadastroLote").attr("disabled",false);
                $(".modal-md").html(data);
                $("#modalCadastroPlanilha").modal("show");
            });

        });
        $( ".select-picker").selectpicker({
            noneSelectedText: 'Selecione',
            liveSearch: true,
            selectedTextFormat: '',
            noneResultsText: 'Nenhum resultado para {0}',
            selectAllText: 'Marcar',
            deselectAllText: 'Limpar',
            actionsBox: true,
            liveSearchNormalize: true,
            styleBase: 'btn btn-sm',
            // maxOptions: 1
            // title: 'Selecione'
        });

    });


</script>