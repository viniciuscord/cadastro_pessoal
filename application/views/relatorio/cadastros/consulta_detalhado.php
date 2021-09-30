<div class="box box-success">
    <div id="overlay-detalhado" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
    <h4 class="box-title">Relatório Simplificado/Detalhado</h4>
        <div class="box-tools">
            <form action="<?php echo site_url("relatorio/export_dados_cadastro"); ?>" method="POST">
                <input type="hidden" name="idFuncao" value="<?php echo $this->input->post('idFuncao'); ?>" >
                <input type="hidden" name="idEmpresa" value="<?php echo $this->input->post('idEmpresa'); ?>" >
                <input type="hidden" name="cgc" value="<?php echo $this->input->post('cgc'); ?>" >
                <input type="hidden" name="codSuperior" value="<?php echo $this->input->post('codSuperior'); ?>" >
                <button class="btn btn-secondary btn-sm pull-right exportar" ><span class="fa fa-file"></span> Exportar</button>
            </form>
        </div>
        <div class="box-body" >
        <div class="form-inline pull-right">
            <div class="checkbox" style="margin-right:15px;">
                <label> <input type="checkbox" id="rel-simplificado" name="rel-simplificado" checked=""> Relatório Simplificado </label>
    </div>
    <div class="checkbox">
                <label> <input type="checkbox" id="rel-detalhado" name="rel-detalhado" > Relatório Detalhado </label>
            </div>
        </div>
        <br>
        <div id="resultado"></div>
        </div>
    </div>
    <?php //print_r($this->session->userdata("acesso")); ?> 
    <div class="box-body" id='tabela-rel-simplificado'>
        <table class="table table-striped small rel-simplificado">
            <thead>
                <th>Matricula</th>
                <th>Nome</th>
                <th>Matrícula Superior</th>
                <th>Data de Admissão</th>
                <th>Nome Empresa</th>
                <th>Contrato</th>
                <th>Função</th>
                <th>Status</th>
            </thead>   
            <tbody>
                <?php foreach($dados as $row): ?>
                    <tr>
                        <td><?= $row['MatriculaSCP'] ?></td>
                        <td><?= $row['Nome'] ?></td>
                        <td><?= $row['MatriculaSuperior'] ?></td>
                        <td><?= $row['DataAdmissao'] ?></td>
                        <td><?= $row['NomeEmpresa'] ?></td>
                        <td><?= $row['Contrato'] ?></td>
                        <td><?= $row['NomeFuncao'] ?></td>
                        <td><?= $row['Situacao'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="box-body" id='tabela-rel-detalhado' style='display:none'>             
        <table class="table table-striped small rel-detalhado">
            <thead>
                <th>Matricula</th>
                <th>Nome</th>
                <th>Data Nascimento</th>
                <th>Sexo</th>
                <th>Mãe Func.</th>
                <th>Estado Civil</th>
                <th>Grau Instrução</th>
                <th>Email</th>
                <th>Quantidade Filhos</th>
                <th>Telefone 1</th>
                <th>Telefone 2</th>
                <th>CEP</th>
                <th>Endereço</th>
                <th>Complemento</th>
                <th>UF</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th>CPF</th>
                <th>RG</th>
                <th>RG Orgão Exp.</th>
                <th>RG UF</th>
                <th>RG Data Exp.</th>
                <th>PIS</th>
                <th>CTPS</th>
                <th>CTPS Serie</th>
                <th>CTPS Dt. Exp.</th>
                <th>Id. Banco</th>
                <th>Banco</th>
                <th>Agência</th>
                <th>Dig. Agência</th>
                <th>Conta</th>
                <th>Dig. Conta</th>
                <th>Tipo de Conta</th>
                <th>Operação</th>
                <th>Nome Empresa</th>
                <th>Matrícula Emp.</th>
                <th>CGC</th>
                <th>Nome Lotação</th>
                <th>Nome Função</th>
                <th>Data Admissão</th>
                <th>Matricula Superior</th>
                <th>Horário Início</th>
                <th>Horário Fim</th>
                <th>Contrato</th>
                <th>Fila</th>
                <th>Id Fila</th>    
                <th>Situação</th>
            </thead>   
            <tbody>
                <?php foreach($dados as $row): ?>
                    <tr>
                        <td><?= $row['MatriculaSCP'] ?></td>
                        <td><?= $row['Nome'] ?></td>
                        <td><?= $row['DataNascimento'] ?></td>
                        <td><?= $row['Sexo'] ?></td>
                        <td><?= $row['MaeFuncionario'] ?></td>
                        <td><?= $row['EstadoCivil'] ?></td>
                        <td><?= $row['GrauInstrucao'] ?></td>
                        <td><?= $row['Email'] ?></td>
                        <td><?= $row['QuantidadeFilhos'] ?></td>
                        <td><?= $row['Telefone1'] ?></td>
                        <td><?= $row['Telefone2'] ?></td>
                        <td><?= $row['CEP'] ?></td>
                        <td><?= $row['Endereco'] ?></td>
                        <td><?= $row['ComplementoEndereco'] ?></td>
                        <td><?= $row['UF'] ?></td>
                        <td><?= $row['Cidade'] ?></td>
                        <td><?= $row['Bairro'] ?></td>
                        <td><?= $row['CPF'] ?></td>
                        <td><?= $row['RGFuncionario'] ?></td>
                        <td><?= $row['RGOrgaoExpedidor'] ?></td>
                        <td><?= $row['RGUF'] ?></td>
                        <td><?= $row['RGDataExpedicao'] ?></td>
                        <td><?= $row['PIS'] ?></td>
                        <td><?= $row['CTPS'] ?></td>
                        <td><?= $row['CTPSSerie'] ?></td>
                        <td><?= $row['CTPSDataExpedicao'] ?></td>
                        <td><?= $row['IdBancoFuncionario'] ?></td>
                        <td><?= $row['NomeBanco'] ?></td>
                        <td><?= $row['Agencia'] ?></td>
                        <td><?= $row['DigitoAgencia'] ?></td>
                        <td><?= $row['Conta'] ?></td>
                        <td><?= $row['DigitoConta'] ?></td>
                        <td><?= $row['TipoConta'] ?></td>
                        <td><?= $row['OperacaoConta'] ?></td>
                        <td><?= $row['NomeEmpresa'] ?></td>
                        <td><?= $row['MatriculaEmpresa'] ?></td>
                        <td><?= $row['CGC'] ?></td>
                        <td><?= $row['NomeLotacao'] ?></td>
                        <td><?= $row['NomeFuncao'] ?></td>
                        <td><?= $row['DataAdmissao'] ?></td>
                        <td><?= $row['MatriculaSuperior'] ?></td> 
                        <td><?= $row['HorarioInicio'] ?></td>
                        <td><?= $row['HorarioFim'] ?></td>
                        <td><?= $row['Contrato'] ?></td>
                        <td><?= $row['Fila'] ?></td>
                        <td><?= $row['IdFila'] ?></td>
                        <td><?= $row['Situacao'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".rel-detalhado").dataTable({
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
            "pageLength": 25,
            "bPaginate": true,
            "scrollY": "500px",
            "scrollX": "100%",
            
        });
        $(".rel-simplificado").dataTable({
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
            "bPaginate": true,
            // "scrollY": "500px",
            // "scrollX": "100%",
            // "fixedHeader": true,
        });
    
        $(".exportar").on("click",function(){
            $("form").submit();
        });
        
        setTimeout(function(){ $(window).trigger('resize') }, 1000);
        // setTimeout(function(){ alert("Teste"); }, 1000);
    
    $('#rel-simplificado').change(function(){
            tipoRelatorio();
    });
    $('#rel-detalhado').change(function(){
            tipoRelatorio();
    });

    $('#rel-simplificado').click(function(){
        $('#rel-detalhado').removeAttr("checked",false);
        setTimeout(function(){ $(window).trigger('resize') }, 1000);
        // setTimeout(function(){ alert("Hello"); }, 3000);
    });

    $('#rel-detalhado').click(function(){
        $('#rel-simplificado').removeAttr("checked",false);
        setTimeout(function(){ $(window).trigger('resize') }, 1000);
        // setTimeout(function(){ alert("Hello"); }, 3000);
    });

    function tipoRelatorio(){
        if($("#rel-simplificado").is(':checked')){
                $('#tabela-rel-simplificado').show(1000);
                $('#tabela-rel-detalhado').hide(1000);
            }
        if($("#rel-detalhado").is(':checked')){
                $('#tabela-rel-detalhado').show(1000);
                $('#tabela-rel-simplificado').hide(1000);
            }
    } 

    });

</script>