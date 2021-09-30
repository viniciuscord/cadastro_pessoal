<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Cadastrar Escala</h4>       
        </div>
        <?php if($this->session->userdata('acesso') != "Administrador"): $class = "col-sm-3"; $style = "padding-top: 0px";  else: $class = "col-sm-4"; $style = "padding-top: 5px"; endif; ?>
        <div class="modal-body">
            <form id="formModalEscala">
                <div class="row">
                <?php if($this->session->userdata('acesso') == "Administrador"):?>
                    <div class="col-sm-4">
                        <!-- <div class="form-group"> -->
                            <label for="nome">Função:</label>
                            <select class="form-control input-sm multiselect" id="funcao_modal" name="funcao_modal" multiple>
                                <?php foreach($funcao as $k): ?>
                                <option value="<?= $k['IdFuncao']; ?>"><?= $k['NomeFuncao']; ?></option>
                                <?php endforeach; ?>
                            </select>  
                            <span id="input_funcao_error" class="text-danger"></span>              
                        <!-- </div> -->
                    </div>
                    <div class="col-sm-4">
                        <!-- <div class="form-group"> -->
                            <label for="nome">Colaborador:</label>
                            <select class="form-control input-sm multiselect" id="superior_modal" name="superior_modal" multiple>
                            </select>  
                            <span id="input_colaborador_error" class="text-danger"></span>              
                        <!-- </div> -->
                    </div> 
                    <?php endif;?>
                    <?php if($this->session->userdata('acesso') == "Administrador"):?>
                    <div class="col-sm-4">
                        <!-- <div class="form-group"> -->
                            <label for="nome">Subordinado:</label>
                            <select class="form-control input-sm multiselect" id="colaborador_modal" name="colaborador_modal[]" multiple>
                            </select>  
                            <span id="input_subordinado_error" class="text-danger"></span>              
                        <!-- </div> -->
                    </div>
                    <?php else: ?>
                    <div class="<?php echo $class;?>">
                        <label for="nome">Subordinado:</label>
                        <select class="form-control input-sm multiselect" id="sup_modal" name="sup_modal[]" multiple>
                            <?php foreach($colaborador as $k): ?>
                            <option value="<?= $k['MatriculaSCP']; ?>"><?= $k['Nome']; ?></option>
                            <?php endforeach; ?>
                        </select>  
                        <span id="input_sup_error" class="text-danger"></span>              
                    </div>
                    <?php endif;?>
                    <div class="<?php echo $class;?>" style="<?php echo $style;?>">
                        <label for="input-data">Data:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control pull-right datetimepicker date-mask" id="input-data" name="input-data" value=""  style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">     
                        </div>
                        <span id="input_data_error" class="text-danger"></span>
                    </div>
                    <div class="<?php echo $class;?>" style="<?php echo $style;?>">
                        <label for="input-hr-ini">Horário(Entrada):</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <input type="text" class="form-control pull-right hours-input" id="input-hr-ini" name="input-hr-ini"  value="" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">     
                        </div>
                        <span id="input_hr_ini_error" class="text-danger"></span>
                    </div>
                    <div class="<?php echo $class;?>" style="<?php echo $style;?>">
                        <label for="input-hr-said">Horário(Saída):</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <input type="text" class="form-control pull-right hours-input" id="input-hr-said" name="input-hr-said"  value="" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;">     
                        </div>
                        <span id="input_hr_said_error" class="text-danger"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="just-text">Justificativa:</label>
                            <textarea class="form-control" cols="70" rows="2" maxlength='4000' name="justificativa" id="justificativa" required></textarea>       
                            <span id="justificativa_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div id="alert-info"></div> 
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="salvar_escala" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
    </div>
</div>

<script>
    <?php include "modal_cadastro_escala.js"; ?>
</script>

