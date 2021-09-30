<style>
.input-radius{
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
}
</style>
<?php if($situacao == 4): $class_padrao = 'col-sm-4';  elseif($situacao == 1): $class_padrao = 'col-sm-6'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-6';  else: $class_padrao = 'col-sm-3'; endif;?>
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" ><?php if(!isset($dados)): echo "Cadastrar Ocorrência"; else: echo "Editar Ocorrência"; endif; ?></h4>       
        </div>
        <div class="modal-body">
            <form id="formCadastroOcorrencia">
                <?php if(isset($dados)): ?> 
                    <!-- edição ocorrência  !-->   
                    <input type="hidden" id="num_ocorrencia" name="num_ocorrencia" value="<?= $dados['NumOcorrencia']; ?>" >
                    <input type="hidden" id="contr_ocorr" name="contr_ocorr" value= "1">
                <?php else: ?>
                    <!-- nova ocorrência !-->
                    <input type="hidden" id="contr_ocorr" name="contr_ocorr" value= "0">
                <?php endif; ?>      
                    <div class="row">
                    <?php if($situacao == 1): //print_r($coordenadores);?>
                        <div class="<?=$class_padrao;?>">
                            <div class="form-group">
                                <label for="contrato_modal">Contratos:</label>
                                <select class="form-control input-sm selectpicker" id="contratos_modal" name="contratos_modal[]" multiple>
                                    <!-- <option value="" >Selecione o empregado</option> -->
                                    <?php foreach($contratos as $contrato): ?>
                                        <option value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="input_contrato_modal_error" class="text-danger"></span>              
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($situacao == 4 || $situacao == 1): ?>
                        <div class="<?=$class_padrao;?>">
                            <div class="form-group">
                                <label for="coordenador_modal">Coordenador:</label>
                                <select class="form-control input-sm selectpicker" id="coordenador_modal" name="coordenador_modal[]" multiple>
                                    <?php if(isset($coordenadores)):?>
                                        <?php foreach($coordenadores as $coordenador): ?>
                                            <option value="<?= $coordenador['MatriculaSCP'] ?>"><?= $coordenador['Nome']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span id="input_coordenador_modal_error" class="text-danger"></span>              
                            </div>
                        </div>
                    <!-- </div>
                    <div class="row"> -->
                <?php endif; ?>
                <?php if($situacao == 1 || $situacao == 2 || $situacao == 3 || $situacao == 4): ?>
                        <div class="<?=$class_padrao;?>">
                            <div class="form-group">
                                <label for="superior_modal">Supervisor:</label>
                                <select class="form-control input-sm selectpicker" id="superior_modal" name="superior_modal[]" multiple>
                                    <?php if(isset($superiores)):?>
                                        <?php foreach($superiores as $superior): ?>
                                            <option value="<?= $superior['MatriculaSCP'] ?>"><?= $superior['Nome']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span id="input_superv_modal_error" class="text-danger"></span>              
                            </div>
                        </div>
                <?php endif; ?>
                        <div class="<?=$class_padrao;?>">
                            <div class="form-group"> 
                                <label for="nome_modal">Colaborador:</label>
                                <select class="form-control input-sm selectpicker" id="nome_modal" name="nome_modal[]" multiple <?php if(isset($dados)) echo "readonly"; ?> >
                                    <!-- <option value="" >Selecione o empregado</option> -->
                                    <?php foreach($empregados as $empregado): ?>
                                        <option value="<?= $empregado['MATRICULA']; ?>" <?php if(isset($dados['Matricula'])) if(strtoupper($dados["Matricula"]) == strtoupper($empregado["MATRICULA"])) echo " selected" ;?>><?= $empregado['Nome']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="modal_nome_error" class="text-danger"></span>
                            </div>
                        </div>                                
                    </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="input-group">
                            <label for="tipo_ocorr">Tipo Ocorrência:</label>
                            <select class="form-control input-sm selectpicker" id="tipo_ocorr" name="tipo_ocorr[]" multiple <?php if(isset($dados)) echo "readonly"; ?> >
                                <option value="1" <?php if(isset($dados)) if($dados['IdTipoOcorrencia'] == '1') echo "selected"; ?>>PONTO</option>
                                <option value="2" <?php if(isset($dados)) if($dados['IdTipoOcorrencia'] == '2') echo "selected"; ?>>ADMINISTRATIVA</option>
                            </select>
                        </div>
                        <span id="modal_tipo_oc_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-3">
                        <!-- <div class="input-group"> -->
                        <div class="">
                            <label for="motivo_ocorr">Motivo:</label>
                            <select class="form-control input-sm selectpicker" id="motivo_ocorr" name="motivo_ocorr[]" multiple <?php if(isset($dados)) echo "readonly"; ?> >
                            </select>
                        </div>
                        <span id="modal_motivo_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <label for="input-data-ini">Data Início:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-radius input-sm datetimepicker date-mask" id="input-data-ini" name="input-data-ini" value="<?php if(isset($dados)) echo date('d/m/Y',strtotime($dados['DataInicio'])); ?>"   >     
                            </div>
                            <span id="input_data_ini_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <label for="input-data-fim">Data Fim:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-radius input-sm datetimepicker date-mask" id="input-data-fim" name="input-data-fim" value="<?php if(isset($dados)) echo date('d/m/Y',strtotime($dados['DataFim'])); ?>"   >     
                            </div>
                            <span id="input_data_fim_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="input-cid">CID:</label>
                            <input type="text" class="form-control input-sm input-cid ui-autocomplete-input" id="input-cid" name="input-cid" value="<?php if(isset($dados)) echo $dados['CID']; ?>" <?php if(isset($dados)) echo "readonly"; else echo "disabled"; ?> >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="just-text">Justificativa:</label>
                        <textarea class="form-control" cols="70" rows="2" maxlength='4000' name="justificativa" id="justificativa" required><?php if(isset($dados)) echo $dados['Justificativa']; ?></textarea>
                        <span id="justificativa_error" class="text-danger"></span>
                    </div>
                </div>
            </form>
            <div id="alert-info"></div> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="salvar_ocorr" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
    </div>
</div>

<script>
   <?php include "ocorrencia.js"; ?>
</script>