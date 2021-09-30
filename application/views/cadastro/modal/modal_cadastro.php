<style> 
    <?php include "modal_cadastro.css"; ?>
</style> 
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        <span class='glyphicon glyphicon-remove modal-close'></span>        			
    </button>
    <h4 class="modal-title">Formulário de Cadastro</h4>       
</div>
<form id="form-formulario">
<?php $modulo_acesso = array('modulo' => 'cadastro', 'submodulo' => null, 'type' => 'view', 'nome_view' => 'modal_cadastro', 'acao' => 'negar', 'situacao' => 1);
      $perfil = Permissao_helper::validaAcessoCadastro($modulo_acesso);
?>
<?php $readonly = null; if(!$perfil): $readonly = 'readonly'; endif; ?>
<div class="modal-body" style="background: #d2d6de99; padding: 10px; min-height: 550px;">
    <?php if(isset($dados[0])): $dados = $dados[0]; //print_r($dados); echo "<br><br>"; print_r($ufs); ?>
        <!-- edição !-->
        <input type='hidden' id='input-contr-cadastro' name="input-contr-cadastro" value="1" >
    <?php else: ?> 
        <!-- inserção !-->
        <input type='hidden' id='input-contr-cadastro' name="input-contr-cadastro" value="0" >
    <?php endif;?>
    <?php //echo $uf; ?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs guia">
            <li class="tabs  tb1 active" data-type="blue" style="text-align: center;"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-user ico-tabs"></i> <br> Informações Pessoais</a></li>
            <li class="tabs tb2" data-type="green" style="text-align: center;"><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-file ico-tabs"></i> <br> Documentos Pessoais</a></li>
            <li class="tabs tb3" data-type="orange" style="text-align: center;"><a href="#tab_3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-building ico-tabs"></i> <br> Empresa</a></li>
        </ul>
        <div class="tab-content" style="padding: 10px 25px 0px 25px;">
            <div class="tab-pane active" id="tab_1">
                <div class="row">
                    <div class="panel panel-default panel-detalhe">
                          <div class="panel-heading detalhes">
                                <h3 class="panel-title">Colaborador</h3>
                          </div>
                          <div class="panel-body" style="0px 15px 0px 15px">
                            <div class="row">
                                <input type="hidden" class="form-control input-sm" id="input-matricula" name="MatriculaSCP" value="<?php if(isset($dados['MatriculaSCP'])) echo $dados['MatriculaSCP']; ?>">
                                <div class="col-lg-2">
                                <?php if(!$dados):?>
                                    <div class="form-group">
                                        <label for="input-name">Matricula:</label>
                                        <input type="text" class="form-control input-sm" id="mat" name="mat" placeholder="Ex: P010101" value="<?php if(isset($dados['MatriculaSCP'])) echo $dados['MatriculaSCP']; ?>" readonly>
                                        <span id="matricula_error" class="text-danger"></span>
                                    </div> 
                                <?php else:?>
                                    <div class="form-group">
                                        <label for="input-name">Matricula:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-sm" id="mat" name="mat" readonly placeholder="Ex: P010101" value="<?php if(isset($dados['MatriculaSCP'])) echo $dados['MatriculaSCP']; ?>" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px">
                                            <span class="input-group-btn btn-copy">
                                                <button type="button" class="btn btn-info btn-flat btn-sm" data-toggle="tooltip" data-placement="top" title="Copiar Matrícula" ><i class="fa fa-copy"></i></button>
                                            </span>
                                            <span id="matricula_error" class="text-danger"></span>
                                        </div>
                                    </div> 
                                <?php endif;?> 
                                </div> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="input-name">Nome:</label>
                                        <input type="text" class="form-control input-sm" id="input-name" name="Nome"  value="<?php if(isset($dados['Nome'])) echo $dados['Nome']; ?>" <?= $readonly ?>>
                                        <span id="name_error" class="text-danger"></span>
                                    </div>   
                                </div> 
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Sexo:</label>
                                        <select class="form-control input-sm select-pk bloq-campos" id="input-sx" name="IdSexo" <?= $readonly ?> >
                                            <option value="">Selecione</option>
                                            <?php foreach($sexo as $s): ?>
                                            <option value="<?= $s['IdSexo']; ?>" <?php if(isset($dados['IdSexo'])) if($dados['IdSexo']== $s['IdSexo']) echo "selected";  ?> ><?= $s['Sexo']; ?></option>
                                            <?php endforeach ; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="input-estad-civil">Estado Civil:</label>
                                        <select class="form-control input-sm select-pk bloq-campos" id="input-estad-civil" name="IdEstadoCivil" <?= $readonly ?>>
                                            <option value="" selected>Selecione</option>
                                            <?php foreach($statusCivil as $status): ?>
                                            <option value="<?= $status['IdEstadoCivil']; ?>" <?php if(isset($dados['IdEstadoCivil'])) if($dados['IdEstadoCivil'] == $status['IdEstadoCivil']) echo "selected"; ?> ><?= $status['EstadoCivil'];?></option>
                                            <?php endforeach; ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="input-dt-nascim">Data Nasc.:</label>
                                        <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-dt-nascim" name="DataNascimento" value="<?php if(isset($dados['DataNascimento'])) echo date('d/m/Y',strtotime($dados['DataNascimento'])); ?>" <?= $readonly ?>>
                                        <span id="dt_nasc_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="input-name-mae">Nome da Mãe:</label>
                                        <input type="text" class="form-control input-sm" id="input-name-mae" name="MaeFuncionario"  value="<?php if(isset($dados['MaeFuncionario'])) echo $dados['MaeFuncionario']; ?>" <?= $readonly ?>>
                                    </div>   
                                </div> 
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="input-escolar">Escolaridade:</label>
                                        <select class="form-control input-sm select-pk bloq-campos" id="input-escolar" name="IdGrauInstrucao" <?= $readonly ?> >
                                            <option value="" selected>Selecione</option>
                                            <?php foreach($escolaridade as $grau): ?>
                                            <option value="<?= $grau['IdGrauInstrucao']; ?>" <?php if(isset($dados['IdGrauInstrucao'])) if($dados['IdGrauInstrucao'] == $grau['IdGrauInstrucao']) echo "selected"; ?> ><?= $grau['GrauInstrucao'];?></option>
                                            <?php endforeach; ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="input-filhos">Possui filhos?</label>
                                        <select class="form-control input-sm select-pk bloq-campos" id="input-filhos" name="Filhos" <?= $readonly ?> >
                                            <option value="" selected>Selecione</option>
                                            <?php foreach($filhos as $opt): ?>
                                            <option value="<?= $opt['IdFilho']; ?>" <?php if(isset($dados['IdFilho'])) if($dados['IdFilho'] == $opt['IdFilho']) echo "selected"; ?> ><?= $opt['PossuiFilho'];?></option>
                                            <?php endforeach; ?> 
                                        </select>                        
                                    </div>
                                </div>
                                <?php
                                if(!isset($dados['IdFilho'])): ?>
                                <div class="col-sm-2" style="display:none" id="div_qtd_filhos">
                                    <div class="form-group">
                                        <label for="input-filhos">Qtd. Filhos:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                                                <button type="button" class="btn btn-box-tool btn-menos" style="padding: 4px"><i class="fa fa-minus"></i></button>
                                            </div>
                                                <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="" style="border-radius: 0px;">  
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                <button type="button" class="btn btn-box-tool btn-mais" style="padding: 4px"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php elseif($dados['IdFilho'] == 1 ): ?>
                                <div class="col-lg-2" id="div_qtd_filhos">
                                    <div class="form-group">
                                        <label for="input-filhos">Qtd. Filhos:</label>
                                        <div class="input-group">
                                        <?php $readonly != null ? $plus_minus = 'display: none;': '';?>
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-left-radius: 5px; border-bottom-left-radius: 5px;<?= $plus_minus;?>">
                                                <button type="button" class="btn btn-box-tool btn-menos" style="padding: 4px"><i class="fa fa-minus"></i></button>
                                            </div>
                                                <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="<?php if(isset($dados['QuantidadeFilhos'])) echo $dados['QuantidadeFilhos']; ?>" <?= $readonly;?> style="border-radius: 0px;">  
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-right-radius: 5px; border-bottom-right-radius: 5px;<?= $plus_minus;?>">
                                                <button type="button" class="btn btn-box-tool btn-mais" style="padding: 4px"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="col-sm-2" style="display:none" id="div_qtd_filhos">
                                    <div class="form-group">
                                        <label for="input-filhos">Qtd. Filhos:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
                                                <button type="button" class="btn btn-box-tool btn-menos" style="padding: 4px"><i class="fa fa-minus"></i></button>
                                            </div>
                                                <input type="text" class="form-control input-sm" id="input-qtd-filhos" name="QuantidadeFilhos" value="" style="border-radius: 0px;">  
                                            <div class="input-group-addon" style="padding: 0px 5px;border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                                <button type="button" class="btn btn-box-tool btn-mais" style="padding: 4px"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                          </div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="panel panel-default panel-detalhe">
                        <div class="panel-heading detalhes">
                            <h3 class="panel-title">Contato</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="input-email">Email:</label>
                                    <input type="text" class="form-control input-sm" id="input-email" name="Email" value="<?php if(isset($dados['Email'])) echo $dados['Email']; ?>"<?php if(!isset($dados['Email'])) echo 'readonly'; ?> <?= $readonly ?> >
                                    <div class="input-group">
                                    <!--?php if($this->session->userdata("acesso") == "Administrador" || $this->session->userdata("acesso") == "Coordenador TI" ):?> -->
                                    <?php if($perfil):?>
                                         <input type="checkbox" id="checkbox_email" <?php if(!isset($dados['Email'])) echo 'checked'; ?>> Não possui email
                                    <?php endif;?>
                                    </div>
                                </div>   
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-tel">Telefone (1ª opção):</label>
                                    <input type="text" class="form-control input-sm" id="input-tel" name="Telefone1" value="<?php if(isset($dados['Telefone1'])) echo $dados['Telefone1']; ?>" <?= $readonly ?> >
                                </div> 
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-tel-op">Telefone (2ª opção):</label>
                                    <input type="text" class="form-control input-sm" id="input-tel-op" name="Telefone2" value="<?php if(isset($dados['Telefone2'])) echo $dados["Telefone2"]; ?>" <?= $readonly ?> >
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-default panel-detalhe">
                        <div class="panel-heading detalhes">
                            <h3 class="panel-title">Endereço</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="input-cep">CEP:</label>
                                    <input type="text" class="form-control input-sm" id="input-cep" name="CEP" value="<?php if(isset($dados['CEP'])) echo $dados['CEP']; ?>" <?= $readonly ?> >
                                </div>   
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-endereco">Endereço:</label>
                                    <input type="text" class="form-control input-sm" id="input-endereco" name="Endereco" value="<?php if(isset($dados['Endereco'])) echo $dados['Endereco']; ?>" <?= $readonly ?> >
                                </div>   
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="input-complemento">Complemento:</label>
                                    <input type="text" class="form-control input-sm" id="input-complemento" name="ComplementoEndereco" value="<?php if(isset($dados['ComplementoEndereco'])) echo $dados['ComplementoEndereco']; ?>" <?= $readonly ?> >
                                </div>   
                            </div> 
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="input-uf">UF:</label>
                                    <select class="form-control input-sm select-pk bloq-campos" id="input-uf" name="UF" <?= $readonly ?>>
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
                    </div>
                </div>
                
            </div>
            <div class="tab-pane" id="tab_2">
                <div class="row"> 
                    <div class="panel panel-default panel-detalhe">
                        <div class="panel-heading detalhes">
                            <h3 class="panel-title">CPF/RG</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-cpf">CPF:</label>
                                    <input type="text" class="form-control input-sm" id="input-cpf" name="CPF"  maxlenght="11" value="<?php if(isset($dados['CPF'])) echo $dados['CPF']; ?>" <?php if(isset($dados['CPF'])) echo "readonly"; ?> <?= $readonly ?> >
                                    <span id="cpf_error" class="text-danger"></span>
                                </div>   
                            </div>   
                            <div class="col-lg-2">
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
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="input-uf-rg">UF(RG):</label>
                                    <!-- <input type="text" class="form-control input-sm" id="input-uf-rg" name="RGUF" value="<?php if(isset($dados['RGUF'])) echo $dados['RGUF']; ?>" <?= $readonly ?> > -->
                                    <select class="form-control input-sm select-pk bloq-campos" id="input-uf-rg" name="RGUF" <?= $readonly ?>>
                                        <option value="" selected>--</option>
                                        <?php foreach($ufs as $uf ): ?>
                                        <option value="<?= $uf['UF'] ?>" <?php if(isset($dados['RGUF'])) if($dados['RGUF'] == $uf['UF']) echo "selected"; ?>><?= $uf['UF'] ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div> 
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-dt-exp-rg">Data de Expedição(RG):</label>
                                    <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-dt-exp-rg" name="RGDataExpedicao" value="<?php if(isset($dados['RGDataExpedicao'])) echo date('d/m/Y',strtotime($dados['RGDataExpedicao'])); ?>" <?= $readonly ?> >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="panel panel-default panel-detalhe">
                        <div class="panel-heading detalhes">
                            <h3 class="panel-title">Carteira de Trabalho e Previdência Social (CTPS)</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-pis">PIS:</label>
                                    <input type="text" class="form-control input-sm" id="input-pis" name="PIS" value="<?php if(isset($dados['PIS'])) echo $dados['PIS']; ?>" <?= $readonly ?>>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-ctps">CTPS(Número):</label>
                                    <input type="text" class="form-control input-sm" id="input-ctps" name="CTPS" value="<?php if(isset($dados['CTPS'])) echo $dados['CTPS']; ?>" <?= $readonly ?>>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-ctps-sr">CTPS(Série):</label>
                                    <input type="text" class="form-control input-sm" id="input-ctps-sr" name="CTPSSerie" value="<?php if(isset($dados['CTPSSerie'])) echo $dados['CTPSSerie']; ?>" <?= $readonly ?>>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="input-ctps-dt-exp">Data de Expedição(CTPS):</label>
                                    <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-ctps-dt-exp" name="CTPSDataExpedicao" value="<?php if(isset($dados['CTPSDataExpedicao'])) echo date('d/m/Y',strtotime($dados['CTPSDataExpedicao'])); ?>" <?= $readonly ?>>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="panel panel-default panel-detalhe">
                        <div class="panel-heading detalhes">
                            <h3 class="panel-title">Informações Bancárias</h3>
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="input-banco-nome">Banco:</label>
                                    <!-- <input type="text" class="form-control input-sm input-banco-nome ui-autocomplete-input" id="input-banco-nome" name="IdBancoFuncionario" value="<?php if(isset($dados['NomeBanco'])) echo $dados['NomeBanco']; ?>" <?= $readonly ?>> -->
                                    <select class="form-control input-sm select-pk bloq-campos input-banco-nome ui-autocomplete-input" id="input-banco-nome" name="IdBancoFuncionario" <?= $readonly ?>>
                                        <option value="" selected>Selecione</option>
                                        <?php foreach($bancos as $banco ): ?>
                                            <option value="<?= $banco['IdBancoFuncionario'] ?>" <?php if(isset($dados['IdBancoFuncionario'])) if($dados['IdBancoFuncionario'] == $banco['IdBancoFuncionario']) echo "selected"; ?>><?= $banco['Nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                    <span id="banco_nome_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="input-ag">Agência:</label>
                                    <input type="text" class="form-control input-sm" id="input-ag" name="Agencia" value="<?php if(isset($dados['Agencia'])) echo $dados['Agencia']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="input-ag-dig">Digito:</label>
                                    <input type="text" class="form-control input-sm" id="input-ag-dig" name="DigitoAgencia" value="<?php if(isset($dados['DigitoAgencia'])) echo $dados['DigitoAgencia']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="input-ag-conta">Conta:</label>
                                    <input type="text" class="form-control input-sm" id="input-ag-conta" name="Conta" value="<?php if(isset($dados['Conta'])) echo $dados['Conta']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="input-conta-dig">Digito:</label>
                                    <input type="text" class="form-control input-sm" id="input-conta-dig" name="DigitoConta" value="<?php if(isset($dados['DigitoConta'])) echo $dados['DigitoConta']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="input-tipo-conta">Tipo da Conta:</label>
                                    <input type="text" class="form-control input-sm" id="input-tipo-conta" name="TipoConta" value="<?php if(isset($dados['TipoConta'])) echo $dados['TipoConta']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="input-operacao">Operação:</label>
                                    <input type="text" class="form-control input-sm" id="input-operacao" name="OperacaoConta" value="<?php if(isset($dados['OperacaoConta'])) echo $dados['OperacaoConta']; ?>" <?= $readonly ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_3">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="input-empresa">Empresa:</label>
                            <select class="form-control input-sm select-empresa-funcao" id="input-empresa" name="IdEmpresa[]" multiple>
                                <?php foreach($empresas as $empresa): ?>
                                    <option value="<?= $empresa['IdEmpresa']; ?>" <?php if(isset($dados['IdEmpresa'])) if($dados['IdEmpresa'] == $empresa['IdEmpresa']) echo "selected"; ?>><?= $empresa['NomeEmpresa']; ?></option>
                                <?php endforeach; ?>
                            </select>                
                        <span id="empresa_error" class="text-danger"></span> 
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="input-contrato">Contrato:</label>
                            <select class="form-control input-sm select-empresa-funcao" id="input-contrato" name="IdContrato[]" multiple>
                                <?php
                                foreach($contratos as $contrato) {?>
                                    <?php if(isset($dados['IdContrato'])){?>
                                        <option value="<?= $contrato['IdContrato']; ?>" <?php if(isset($dados['IdContrato'])) if($dados['IdContrato'] == $contrato['IdContrato']) echo "selected"; ?> ><?= $contrato['Contrato']; ?></option>
                                    <?}?>
                                <?}?>
                            </select>  
                            <span id="contrato_error" class="text-danger contrato_error"></span> 
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="input-func-empregado">Função:</label>
                            <select class="form-control input-sm select-empresa-funcao" id="input-func-empregado" name="IdFuncao[]" multiple>
                                <?php
                                foreach($funcoes as $funcao) {?>
                                    <?php if(isset($dados['IdFuncao'])){?>
                                        <option value="<?= $funcao['IdFuncao']; ?>" <?php if(isset($dados['IdFuncao'])) if($dados['IdFuncao'] == $funcao['IdFuncao']) echo "selected"; ?> ><?= $funcao['NomeFuncao']; ?></option>
                                    <?}?>
                                <?}?>
                            </select>        
                            <span id="funcao_error" class="text-danger"></span> 
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <label for="input-data-adm">Data Admissão:</label>
                        <div class="input-group">
                            <div class="input-group-addon bg-purple">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control radius input-sm pull-right datetimepicker date-mask" id="input-data-adm" name="DataAdmissao" value="<?php if(isset($dados['DataAdmissao'])) echo date('d/m/Y',strtotime($dados['DataAdmissao'])); ?>" >     
                        </div>
                        <span id="data_adm_error" class="text-danger"></span>
                    </div>
                    <div class="col-lg-2">
                        <label for="input-data-dem">Data Demissão:</label>
                        <div class="input-group">
                            <div class="input-group-addon bg-purple">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control radius input-sm pull-right datetimepicker date-mask" id="input-data-dem" name="DataDemissao" value="<?php if(isset($dados['DataDemissao'])) echo date('d/m/Y',strtotime($dados['DataDemissao'])); ?>" >     
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- <div class="form-group"> -->
                        <label for="input-matri-super">Matrícula Superior:</label>
                            <select name="MatriculaSuperior"  id="input-matri-super" class="form-control" multiple required="required">
                                <?php
                                foreach ($supervisor as $key => $value) {?>
                                    <?php if(isset($dados)){?>
                                        <?php if($dados['MatriculaSuperior'] == null || $dados['MatriculaSuperior'] == ""):?>
                                            <option value="<?=$value['MatriculaSuperior']?>" ><?=$value['MatriculaSuperior'].' - '.$value['Nome'];?></option>
                                        <?php else:?>
                                            <option value="<?=$value['MatriculaSuperior']?>" <?php if($value['MatriculaSuperior'] == strtoupper($dados['MatriculaSuperior'])): echo 'selected'; endif;?>><?=$value['MatriculaSuperior'].' - '.$value['Nome'];?></option>
                                        <?php endif;?>
                                    <?}?>
                                <?}?>
                            </select>
                    </div>   
                    <div class="col-lg-4">
                        <!-- <div class="form-group"> -->
                            <label for="input-situacao">Situação:</label>
                            <select class="form-control input-sm select-pk" id="input-situacao" name="IdSituacao">
                                <option value="">Selecione</option>
                                <?php foreach($situacao as $sit): ?>
                                <option value="<?= $sit['IdSituacao']; ?>" <?php if(isset($dados['IdSituacao'])) if($dados['IdSituacao'] == $sit['IdSituacao']) echo "selected"; ?> ><?= $sit['Situacao']; ?></option>
                                <?php endforeach; ?>
                            </select> 
                        <!-- </div> -->
                    </div>         
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-ini">Horário Início:</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-orange">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm radius pull-right" id="input-hr-ini" name="HorarioInicio" aria-describedby="emailHelp" value="<?php if(isset($dados['HorarioInicio'])) echo date('H:i',strtotime($dados['HorarioInicio'])); ?>">     
                            </div>
                            <span id="hr_ini_error" class="text-danger"></span>
                        </div>    
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-fim">Horário Fim:</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-orange">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm radius pull-right" id="input-hr-fim" name="HorarioFim" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioFim'])) echo date('H:i',strtotime($dados['HorarioFim'])); ?>">     
                            </div>
                            <span id="hr_fim_error" class="text-danger"></span>
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
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="input-estabilidade">Estabilidade:</label>
                            <select class="form-control input-sm select-pk" id="input-estabilidade" name="Estabilidade">
                                <option value="">Selecione</option>
                                <?php foreach($estabilidades as $estab): ?>
                                <option value="<?= $estab['IdEstabilidade']; ?>" <?php if(isset($dados['IdEstabilidade'])) if($dados['IdEstabilidade'] == $estab['IdEstabilidade']) echo "selected"; ?> ><?= $estab['Estabilidade']; ?></option>
                                <?php endforeach; ?>
                     
                            </select> 
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-alm-ini">Almoço(início):</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-orange">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm radius pull-right" id="input-hr-alm-ini" name="HorarioAlmocoInicio" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioAlmocoInicio'])) echo date('H:i',strtotime($dados['HorarioAlmocoInicio'])); ?>">     
                            </div>
                            <span id="hr_al_ini_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="input-hr-alm-fim">Almoço(fim):</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-orange">
                                    <span class="fa fa-clock-o"></span>
                                </div>
                                <input type="text" class="form-control input-sm radius pull-right" id="input-hr-alm-fim" name="HorarioAlmocoFim" aria-describedby="emailHelp"  value="<?php if(isset($dados['HorarioAlmocoFim'])) echo date('H:i',strtotime($dados['HorarioAlmocoFim'])); ?>">     
                            </div>
                            <span id="hr_al_fim_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-lg-2" style="display: none;" >
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
<div class="modal-footer" style="margin-top: 0px;">        
    <button type="button" class="btn btn-success" id="salvar"><span class="fa fa-floppy-o"></span> Salvar</button>
	<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
</div>
</form>
<script>
    <?php include "cadastro.js"; ?>
    function desabilitaCampos(){
        var val = '';
        <?php if($readonly != null):?>
            val = '1';
        <?php else:?>
            val = '2';
        <?php endif;?>
        if(val == '1'){
            $('.bloq-campos').attr('disabled',true).selectpicker('refresh');
        }
    }
</script>