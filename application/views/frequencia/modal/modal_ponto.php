<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Ponto do dia <?= date('d/m/Y'); ?></h4>       
        </div>
        <div class="modal-body">
            <form id="form-alt-ponto-dia" >
            <div class="row">
                <div class="col-sm-5">
                    <div class="input-group">
                    <label for="nome">Nome:</label>
                    <select class="form-control input-sm" id="nome_modal" name="nome_modal" >
                        <option value="" >Selecione o empregado</option>
                        <?php foreach($empregados as $empregado): ?>
                            <option value="<?= $empregado['MATRICULA']; ?>"><?= $empregado['Nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <span id="nome_modal_error" class="text-danger"></span>
                </div>
                <div class="col-sm-3">
                    <label for="input-hr-ini">Data:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control input-sm pull-right" value="<?= date("d/m/Y");?>" disabled >     
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="input-hr-ini">Opção:</label>
                    <select class="form-control input-sm" id="opcao" name="opcao" >
                        <option value="1" selected>Entrada</option>
                        <option value="2">Saída</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="input-hr">Horário:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-clock-o"></span>
                        </div>
                        <input type="text" class="form-control input-sm pull-right hours-input" id="input-hr" name="input-hr"  value="">     
                    </div>
                    <span id="input_hr_error" class="text-danger"></span>
                </div>
            </div>   
            <div id="alert-info"></div> 
            </form>   
        </div>
        <div class="modal-footer">        
            <button type="button" class="btn btn-success" id="salvar_dia" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
	</div>
</div>

<script><?php include "modal_ponto.js"; ?></script>