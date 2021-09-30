<style>
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
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <span class='glyphicon glyphicon-remove modal-close'></span>        			
    </button>
    <h4 class="modal-title">Formulário de Cadastro</h4>       
</div>
<form id="form-formulario">
<?php $readonly = null; if($this->session->userdata("acesso") != "Administrador" ): $readonly = 'readonly'; endif; ?>
<div class="modal-body">
    <?php if(isset($dados[0])): $dados = $dados[0]; //print_r($dados); echo "<br><br>"; print_r($ufs); ?>
        <!-- edição !-->
        <input type='hidden' id='input-contr-cadastro' name="input-contr-cadastro" value="1" >
    <?php else: ?> 
        <!-- inserção !-->
        <input type='hidden' id='input-contr-cadastro' name="input-contr-cadastro" value="0" >
    <?php endif;?>
    <?php //echo $uf; ?>
    <div class="panel panel-info" style="margin-bottom:0px;">
        <div class="panel-heading">
            <i class="fa fa-user"></i> Informações Pessoais
        </div>
        <div class="panel-body">
            <div class="col-lg-12">
                <!-- primeira linha de campos !-->
                <div class="row">
                    <input type="hidden" class="form-control input-sm" id="input-matricula" name="MatriculaSCP" value="<?php if(isset($dados['MatriculaSCP'])) echo $dados['MatriculaSCP']; ?>">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-name">Matricula:</label>
                            <input type="text" class="form-control input-sm" id="mat" name="mat"  value="<?php if(isset($dados['MatriculaSCP'])) echo $dados['MatriculaSCP']; ?>" <?= $readonly ?>>
                            <span id="matricula_error" class="text-danger"></span>
                        </div>   
                    </div> 
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-name">Nome:</label>
                            <input type="text" class="form-control input-sm" id="input-name" name="Nome"  value="<?php if(isset($dados['Nome'])) echo $dados['Nome']; ?>" <?= $readonly ?>>
                            <span id="name_error" class="text-danger"></span>
                        </div>   
                    </div> 
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-dt-nascim">Data de Nascimento:</label>
                            <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-dt-nascim" name="DataNascimento" value="<?php if(isset($dados['DataNascimento'])) echo date('d/m/Y',strtotime($dados['DataNascimento'])); ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="">Sexo:</label>
                            <select class="form-control input-sm" id="input-sx" name="IdSexo" <?= $readonly ?> >
                                <option value="">Selecione</option>
                                <?php foreach($sexo as $s): ?>
                                <option value="<?= $s['IdSexo']; ?>" <?php if(isset($dados['IdSexo'])) if($dados['IdSexo']== $s['IdSexo']) echo "selected";  ?> ><?= $s['Sexo']; ?></option>
                                <?php endforeach ; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-name-mae">Nome da Mãe:</label>
                            <input type="text" class="form-control input-sm" id="input-name-mae" name="MaeFuncionario"  value="<?php if(isset($dados['MaeFuncionario'])) echo $dados['MaeFuncionario']; ?>" <?= $readonly ?>>
                        </div>   
                    </div> 
                </div>
                <!-- segunda linha de campos !-->
                <div class="row">
                     <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-estad-civil">Estado Civil:</label>
                            <select class="form-control input-sm" id="input-estad-civil" name="IdEstadoCivil" <?= $readonly ?>>
                                <option value="" selected>Selecione</option>
                                <?php foreach($statusCivil as $status): ?>
                                <option value="<?= $status['IdEstadoCivil']; ?>" <?php if(isset($dados['IdEstadoCivil'])) if($dados['IdEstadoCivil'] == $status['IdEstadoCivil']) echo "selected"; ?> ><?= $status['EstadoCivil'];?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-escolar">Escolaridade:</label>
                            <select class="form-control input-sm" id="input-escolar" name="IdGrauInstrucao" <?= $readonly ?> >
                                <option value="" selected>Selecione</option>
                                <?php foreach($escolaridade as $grau): ?>
                                <option value="<?= $grau['IdGrauInstrucao']; ?>" <?php if(isset($dados['IdGrauInstrucao'])) if($dados['IdGrauInstrucao'] == $grau['IdGrauInstrucao']) echo "selected"; ?> ><?= $grau['GrauInstrucao'];?></option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-email">Email:</label>
                            <input type="text" class="form-control input-sm" id="input-email" name="Email" value="<?php if(isset($dados['Email'])) echo $dados['Email']; ?>" <?= $readonly ?> >
                        </div>   
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-tel">Telefone (1ª opção):</label>
                            <input type="text" class="form-control input-sm" id="input-tel" name="Telefone1" value="<?php if(isset($dados['Telefone1'])) echo $dados['Telefone1']; ?>" <?= $readonly ?> >
                        </div> 
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-tel-op">Telefone (2ª opção):</label>
                            <input type="text" class="form-control input-sm" id="input-tel-op" name="Telefone2" value="<?php if(isset($dados['Telefone2'])) echo $dados["Telefone2"]; ?>" <?= $readonly ?> >
                        </div> 
                    </div> 
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-cep">CEP:</label>
                            <input type="text" class="form-control input-sm" id="input-cep" name="CEP" value="<?php if(isset($dados['CEP'])) echo $dados['CEP']; ?>" <?= $readonly ?> >
                        </div>   
                    </div>
                </div>
                <!-- terceira linha de campos !-->
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-endereco">Endereço:</label>
                            <input type="text" class="form-control input-sm" id="input-endereco" name="Endereco" value="<?php if(isset($dados['Endereco'])) echo $dados['Endereco']; ?>" <?= $readonly ?> >
                        </div>   
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-complemento">Complemento(Endereço):</label>
                            <input type="text" class="form-control input-sm" id="input-complemento" name="ComplementoEndereco" value="<?php if(isset($dados['ComplementoEndereco'])) echo $dados['ComplementoEndereco']; ?>" <?= $readonly ?> >
                        </div>   
                    </div> 
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="input-uf">UF:</label>
                            <select class="form-control input-sm" id="input-uf" name="UF" <?= $readonly ?>>
                                <option value="" selected>--</option>
                                <?php foreach($ufs as $uf ): ?>
                                <option value="<?= $uf['UF'] ?>" <?php if(isset($dados['UF'])) if($dados['UF'] == $uf['UF']) echo "selected"; ?>><?= $uf['UF'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                    </div> 
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-cidade">Cidade:</label>
                            <input type="text" class="form-control input-sm" id="input-cidade" name="Cidade" value="<?php if(isset($dados['Cidade'])) echo $dados['Cidade']; ?>" <?= $readonly ?>>
                        </div>   
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-bairro">Bairro:</label>
                            <input type="text" class="form-control input-sm" id="input-bairro" name="Bairro" value="<?php if(isset($dados['Bairro'])) echo $dados['Bairro']; ?>"  <?= $readonly ?>>
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-filhos">Possui filhos?</label>
                            <select class="form-control input-sm" id="input-filhos" name="Filhos" <?= $readonly ?> >
                                <option value="" selected>Selecione</option>
                                <?php foreach($filhos as $opt): ?>
                                <option value="<?= $opt['IdFilho']; ?>" <?php if(isset($dados['IdFilho'])) if($dados['IdFilho'] == $opt['IdFilho']) echo "selected"; ?> ><?= $opt['PossuiFilho'];?></option>
                                <?php endforeach; ?> 
                            </select>                        
                        </div>
                    </div>
                    <?php if(!isset($dados['IdFilho'])): ?>
                    <div class="col-lg-1" style="display:none" id="div_qtd_filhos">
                        <div class="form-group">
                            <label for="input-filhos">Qtd. Filhos:</label>
                            <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="" >                                         
                        </div>
                    </div>
                    <?php elseif($dados['IdFilho'] == 1 ): ?>
                    <div class="col-lg-1" id="div_qtd_filhos">
                        <div class="form-group">
                            <label for="input-filhos">Qtd. Filhos:</label>
                            <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="<?php if(isset($dados['QuantidadeFilhos'])) echo $dados['QuantidadeFilhos']; ?>" >                                         
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="col-lg-1" style="display:none" id="div_qtd_filhos">
                        <div class="form-group">
                            <label for="input-filhos">Qtd. Filhos:</label>
                            <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="" >                                         
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>        
        </div>  
    </div>
    <div class="panel panel-success" style="margin-bottom:0px;">
        <div class="panel-heading">
            <i class="fa fa-file"></i> Documentos Pessoais
        </div>
        <div class="panel-body">
            <div class="col-lg-12">
                <!-- primeira linha de campos !-->
                <div class="row"> 
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-cpf">CPF:</label>
                            <input type="text" class="form-control input-sm" id="input-cpf" name="CPF"  maxlenght="11" value="<?php if(isset($dados['CPF'])) echo $dados['CPF']; ?>" <?php if(isset($dados['CPF'])) echo "readonly"; ?> <?= $readonly ?> >
                            <span id="cpf_error" class="text-danger"></span>
                        </div>   
                    </div>   
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-rg">RG:</label>
                            <input type="text" class="form-control input-sm" id="input-rg" name="RGFuncionario" value="<?php if(isset($dados['RGFuncionario'])) echo $dados['RGFuncionario']; ?>" <?= $readonly ?>>
                        </div>   
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-rg-org-ex">Órgão Expedidor:</label>
                            <input type="text" class="form-control input-sm" id="input-rg-org-ex" name="RGOrgaoExpedidor" value="<?php if(isset($dados['RGOrgaoExpedidor'])) echo $dados['RGOrgaoExpedidor']; ?>" <?= $readonly ?>>
                        </div>   
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="input-uf-rg">UF(RG):</label>
                            <input type="text" class="form-control input-sm" id="input-uf-rg" name="RGUF" value="<?php if(isset($dados['RGUF'])) echo $dados['RGUF']; ?>" <?= $readonly ?> >
                        </div>  
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-dt-exp-rg">Data de Expedição(RG):</label>
                            <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-dt-exp-rg" name="RGDataExpedicao" value="<?php if(isset($dados['RGDataExpedicao'])) echo date('d/m/Y',strtotime($dados['RGDataExpedicao'])); ?>" <?= $readonly ?> >
                        </div>
                    </div>
                </div>
                <!-- segunda linha de campos !-->
                <div class="row">  
                     <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-pis">PIS:</label>
                            <input type="text" class="form-control input-sm" id="input-pis" name="PIS" value="<?php if(isset($dados['PIS'])) echo $dados['PIS']; ?>" <?= $readonly ?>>
                        </div>  
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-ctps">CTPS(Número):</label>
                            <input type="text" class="form-control input-sm" id="input-ctps" name="CTPS" value="<?php if(isset($dados['CTPS'])) echo $dados['CTPS']; ?>" <?= $readonly ?>>
                        </div>  
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-ctps-sr">CTPS(Série):</label>
                            <input type="text" class="form-control input-sm" id="input-ctps-sr" name="CTPSSerie" value="<?php if(isset($dados['CTPSSerie'])) echo $dados['CTPSSerie']; ?>" <?= $readonly ?>>
                        </div>  
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-ctps-dt-exp">Data de Expedição(CTPS):</label>
                            <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-ctps-dt-exp" name="CTPSDataExpedicao" value="<?php if(isset($dados['CTPSDataExpedicao'])) echo date('d/m/Y',strtotime($dados['CTPSDataExpedicao'])); ?>" <?= $readonly ?>>
                        </div> 
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-banco-nome">Banco:</label>
                            <input type="text" class="form-control input-sm input-banco-nome ui-autocomplete-input" id="input-banco-nome" name="IdBancoFuncionario" value="<?php if(isset($dados['NomeBanco'])) echo $dados['NomeBanco']; ?>" <?= $readonly ?>>
                            <span id="banco_nome_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <!-- terceira linha de campos !-->
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-ag">Agência:</label>
                            <input type="text" class="form-control input-sm" id="input-ag" name="Agencia" value="<?php if(isset($dados['Agencia'])) echo $dados['Agencia']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="input-ag-dig">Digito:</label>
                            <input type="text" class="form-control input-sm" id="input-ag-dig" name="DigitoAgencia" value="<?php if(isset($dados['DigitoAgencia'])) echo $dados['DigitoAgencia']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-ag-conta">Conta:</label>
                            <input type="text" class="form-control input-sm" id="input-ag-conta" name="Conta" value="<?php if(isset($dados['Conta'])) echo $dados['Conta']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="input-conta-dig">Digito:</label>
                            <input type="text" class="form-control input-sm" id="input-conta-dig" name="DigitoConta" value="<?php if(isset($dados['DigitoConta'])) echo $dados['DigitoConta']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-tipo-conta">Tipo da Conta:</label>
                            <input type="text" class="form-control input-sm" id="input-tipo-conta" name="TipoConta" value="<?php if(isset($dados['TipoConta'])) echo $dados['TipoConta']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label for="input-operacao">Operação:</label>
                            <input type="text" class="form-control input-sm" id="input-operacao" name="OperacaoConta" value="<?php if(isset($dados['OperacaoConta'])) echo $dados['OperacaoConta']; ?>" <?= $readonly ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-warning" style="margin-bottom:0px;">
        <div class="panel-heading">
            <i class="fa fa-building"></i> Empresa
        </div>
        <div class="panel-body">
            <div class="col-lg-12">
                <!-- quinta linha de campos !-->
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-empresa">Empresa:</label>
                            <select class="form-control input-sm" id="input-empresa" name="IdEmpresa" >
                                <option value="" >Selecione</option>
                                <?php foreach($empresas as $empresa): ?>
                                <option value="<?= $empresa['IdEmpresa']; ?>" <?php if(isset($dados['IdEmpresa'])) if($dados['IdEmpresa'] == $empresa['IdEmpresa']) echo "selected"; ?>><?= $empresa['NomeEmpresa']; ?></option>
                                <?php endforeach; ?>
                            </select>                
                        </div> 
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-matri-emp">Matricula Empresa:</label>
                            <input type="text" class="form-control input-sm" id="input-matri-emp" name="MatriculaEmpresa" value="<?php if(isset($dados['MatriculaEmpresa'])) echo $dados['MatriculaEmpresa']; ?>" >
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-unidade">Unidade (Sigla):</label>
                            <input type="text" class="form-control input-sm input-unidade-nome ui-autocomplete-input" placeholder="Ex: CEACR" id="input-unidade" name="CGC" value="<?php if(isset($dados['NomeLotacao'])) echo $dados['NomeLotacao']; ?>">
                            <span id="unidade_error" class="text-danger"></span>
                        </div> 
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-func-empregado">Função:</label>
                            <select class="form-control input-sm" id="input-func-empregado" name="IdFuncao" >
                                <option value="" >Selecione</option>
                                <?php foreach($funcoes as $funcao): ?>
                                <option value="<?= $funcao['IdFuncao']; ?>" <?php if(isset($dados['IdFuncao'])) if($dados['IdFuncao'] == $funcao['IdFuncao']) echo "selected"; ?> ><?= $funcao['NomeFuncao']; ?></option>
                                <?php endforeach; ?>
                            </select>                
                        </div> 
                    </div>
                    <div class="col-lg-2">
                        <label for="input-data-adm">Data Admissão:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right datetimepicker date-mask" id="input-data-adm" name="DataAdmissao" value="<?php if(isset($dados['DataAdmissao'])) echo date('d/m/Y',strtotime($dados['DataAdmissao'])); ?>" >     
                        </div>
                        <span id="data_adm_error" class="text-danger"></span>

                    </div>
                    <div class="col-lg-2">
                        <label for="input-data-dem">Data Demissão:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right datetimepicker date-mask" id="input-data-dem" name="DataDemissao" value="<?php if(isset($dados['DataDemissao'])) echo date('d/m/Y',strtotime($dados['DataDemissao'])); ?>" >     
                        </div>
                    </div>
                </div>
                <!-- sexta linha de campos !-->
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                        <label for="input-matri-super">Matrícula Superior:</label>
                            <select name="MatriculaSuperior"  id="input-matri-super" class="form-control" multiple required="required">
                                <?php
                                foreach ($supervisor as $key => $value) {?>
                                    <?php 
                                    if(isset($dados['MatriculaSuperior'])){?>
                                        <option value="<?=$value['Matricula']?>" <?php if($value['Matricula'] == strtoupper($dados['MatriculaSuperior'])): echo 'selected'; endif;?>><?=$value['SUPERVISOR']?></option>
                                    <?}else{?>
                                        <option value="<?=$value['Matricula']?>"><?=$value['SUPERVISOR']?></option>
                                    <?}?>
                                <?}?>
                            </select>
                            <!-- <input type="text" class="form-control input-sm" id="input-matri-super" name="MatriculaSuperior" value="<?php if(isset($dados['MatriculaSuperior'])) echo $dados['MatriculaSuperior']; ?>"> -->
                        </div>
                    </div>            
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-ini">Horário Início:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="input-hr-ini" name="HorarioInicio" aria-describedby="emailHelp" value="<?php if(isset($dados['HorarioInicio'])) echo date('H:i',strtotime($dados['HorarioInicio'])); ?>">     
                            </div>
                            <span id="hr_ini_error" class="text-danger"></span>
                        </div>    
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-fim">Horário Fim:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="input-hr-fim" name="HorarioFim" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioFim'])) echo date('H:i',strtotime($dados['HorarioFim'])); ?>">     
                            </div>
                            <span id="hr_fim_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-alm-ini">Horário Almoço(início):</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="input-hr-alm-ini" name="HorarioAlmocoInicio" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioAlmocoInicio'])) echo date('H:i',strtotime($dados['HorarioAlmocoInicio'])); ?>">     
                            </div>
                            <span id="hr_al_ini_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-alm-fim">Horário Almoço(fim):</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="input-hr-alm-fim" name="HorarioAlmocoFim" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioAlmocoFim'])) echo date('H:i',strtotime($dados['HorarioAlmocoFim'])); ?>">     
                            </div>
                            <span id="hr_al_fim_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-situacao">Situação:</label>
                            <select class="form-control input-sm" id="input-situacao" name="IdSituacao">
                                <option value="">Selecione</option>
                                <?php foreach($situacao as $sit): ?>
                                <option value="<?= $sit['IdSituacao']; ?>" <?php if(isset($dados['IdSituacao'])) if($dados['IdSituacao'] == $sit['IdSituacao']) echo "selected"; ?> ><?= $sit['Situacao']; ?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-contrato">Contrato:</label>
                            <select class="form-control input-sm" id="input-contrato" name="IdContrato">
                                <option value="">Selecione</option>
                                <?php foreach($contratos as $contrato): ?>
                                <option value="<?= $contrato['IdContrato']; ?>" <?php if(isset($dados['IdContrato'])) if($dados['IdContrato'] == $contrato['IdContrato']) echo "selected"; ?> ><?= $contrato['Contrato']; ?></option>
                                <?php endforeach; ?>
                            </select> 
                        </div>
                    </div>
                    <!--<div class="col-lg-3">
                        <div class="form-group">
                            <label for="input-cid">CID:</label>
                            <input type="text" class="form-control input-sm input-cid ui-autocomplete-input" id="input-cid" name="input-cid" value="<?php if(isset($dados['Cid'])) echo $dados['Cid']; ?>">
                        </div>
                    </div>!-->
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-estabilidade">Estabilidade:</label>
                            <select class="form-control input-sm" id="input-estabilidade" name="Estabilidade">
                                <option value="">Selecione</option>
                                <?php foreach($estabilidades as $estab): ?>
                                <option value="<?= $estab['IdEstabilidade']; ?>" <?php if(isset($dados['IdEstabilidade'])) if($dados['IdEstabilidade'] == $estab['IdEstabilidade']) echo "selected"; ?> ><?= $estab['Estabilidade']; ?></option>
                                <?php endforeach; ?>
                     
                            </select> 
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-fila">Fila:</label>
                            <input type="text" class="form-control input-sm input-fila ui-autocomplete-input" id="input-fila" name="IdFila" value="<?php if(isset($dados['Fila'])) echo $dados['Fila']; ?>">
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">        
    <button type="button" class="btn btn-success" id="salvar"><span class="fa fa-floppy-o"></span> Salvar</button>
	<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
</div>
</form>

<script>
    <?php include "cadastro.js"; ?>
</script>