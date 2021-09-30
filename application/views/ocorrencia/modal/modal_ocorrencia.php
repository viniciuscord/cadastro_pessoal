
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
                <?php if(isset($dados)): //print_r($dados);  ?> 
                    <!-- edição ocorrência  !-->   
                    <input type="hidden" id="num_ocorrencia" name="num_ocorrencia" value="<?= $dados['NumOcorrencia']; ?>" >
                    <input type="hidden" id="contr_ocorr" name="contr_ocorr" value= "1">
                <?php else: ?>
                    <!-- nova ocorrência !-->
                    <input type="hidden" id="contr_ocorr" name="contr_ocorr" value= "0">
                <?php endif; ?>       
                <div class="row">
                    <div class="col-sm-6">
                        <div class=""> 
                            <label for="nome_modal">Colaborador:</label>
                            <select class="form-control input-sm selectpicker" id="nome_modal" name="nome_modal[]" <?php if(isset($dados)) echo "readonly"; ?> multiple>
                                <?php if(isset($dados)): ?>
                                        <option value="<?= $dados['Matricula']; ?>" selected ><?= $dados['Nome']; ?></option>
                                <?php else: 
                                        foreach($empregados as $empregado): ?>
                                    <option value="<?= $empregado['MATRICULA']; ?>" <?php if(isset($dados['Matricula'])) if(strtoupper($dados["Matricula"]) == strtoupper($empregado["MATRICULA"])) echo " selected" ;?>><?= $empregado['Nome']; ?></option>
                                <?php   endforeach; 
                                      endif;
                                ?>
                            </select>
                        </div>
                        <span id="modal_nome_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <label for="tipo_ocorr">Tipo Ocorrência:</label>
                            <?php if(isset($dados)): ?>
                                <select class="form-control input-sm selectpicker" id="tipo_ocorr" name="tipo_ocorr[]" <?php if(isset($dados)) echo "readonly"; ?> multiple>
                                    <option value="<?= $dados['IdTipoOcorrencia'];?>" selected><?php if($dados['IdTipoOcorrencia'] == 1) echo "PONTO"; else echo "ADMINISTRATIVA" ?></option>
                                </select>
                            <?php else: ?>
                            <select class="form-control input-sm selectpicker" id="tipo_ocorr" name="tipo_ocorr[]" multiple>
                                <option value="1" <?php if(isset($dados)) if($dados['IdTipoOcorrencia'] == '1') echo "selected"; ?>>PONTO</option>
                                <option value="2" <?php if(isset($dados)) if($dados['IdTipoOcorrencia'] == '2') echo "selected"; ?>>ADMINISTRATIVA</option>
                            </select>
                            <?php endif; ?>
                        </div>
                        <span id="modal_tipo_oc_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-3">
                        <!-- <div class="input-group"> -->
                        <div class="">
                            <label for="motivo_ocorr">Motivo:</label>
                            <select class="form-control input-sm selectpicker" id="motivo_ocorr" name="motivo_ocorr[]" <?php if(isset($dados)) echo "readonly"; ?> multiple>
                                <?php if(!isset($dados)): ?>
                                    <!-- <option value="">Selecione o motivo</option> -->
                                    <?php foreach($motivos as $motivo): ?>
                                        <!-- <option value="<?= $motivo['IdMotivo'];?>" <?php if(isset($dados)) if($motivo['IdMotivo'] == $dados['IdMotivo']) echo "selected"; ?>><?= $motivo['Descricao']; ?></option> -->
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="<?= $dados['IdMotivo']; ?>" selected ><?= $dados['Descricao']; ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <span id="modal_motivo_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="input-cid">CID:</label>
                            <input type="text" class="form-control input-sm input-cid ui-autocomplete-input" id="input-cid" name="input-cid" value="<?php if(isset($dados)) echo $dados['CID']; ?>" <?php if(isset($dados)) echo "readonly"; else echo "disabled"; ?> >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="input-data-ini">Data Início:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-data-ini" name="input-data-ini" value="<?php if(isset($dados)) echo date('d/m/Y',strtotime($dados['DataInicio'])); ?>"  style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">     
                            </div>
                            <span id="input_data_ini_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="input-data-fim">Data Fim:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-sm datetimepicker date-mask" id="input-data-fim" name="input-data-fim" value="<?php if(isset($dados)) echo date('d/m/Y',strtotime($dados['DataFim'])); ?>"   style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">     
                            </div>
                            <span id="input_data_fim_error" class="text-danger"></span>
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
        <?php 
            if(!isset($dados)): ?>
                <button type="button" class="btn btn-success" id="salvar_ocorr" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <?else:?> 
                <button type="button" class="btn btn-success" id="editar_ocorr" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <?endif; ?>  
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
    </div>
</div>

<script>
   <?php include "ocorrencia.js"; ?>
</script>