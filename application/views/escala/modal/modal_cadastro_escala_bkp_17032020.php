<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Cadastrar Escala</h4>       
        </div>
        <?php //print_r($empregados); ?>
        <div class="modal-body">
            <form id="formModalEscala">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="input-group"> 
                            <label for="nome_modal">Nome:</label>
                            <select class="form-control input-sm" id="nome_modal" name="nome_modal" >
                                <option value="" >Selecione o empregado</option>
                                <?php foreach($empregados as $empregado): ?>
                                    <option value="<?= $empregado['MATRICULA']; ?>"><?= $empregado['Nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <span id="modal_nome_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-3">
                        <label for="input-data">Data:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right datetimepicker date-mask" id="input-data" name="input-data" value="" >     
                        </div>
                        <span id="input_data_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-2">
                        <label for="input-hr-ini">Horário(Entrada):</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right hours-input" id="input-hr-ini" name="input-hr-ini"  value="">     
                        </div>
                        <span id="input_hr_ini_error" class="text-danger"></span>
                    </div>
                    <div class="col-sm-2">
                        <label for="input-hr-said">Horário(Saída):</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <input type="text" class="form-control input-sm pull-right hours-input" id="input-hr-said" name="input-hr-said"  value="">     
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

