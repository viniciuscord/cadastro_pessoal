<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <span class='glyphicon glyphicon-remove modal-close'></span>        			
        </button>
        <h4 class="modal-title">Cadastro Planilha</h4>       
    </div>
    <div class="modal-body">
        <ul>
            <b>Informações</b>
            <li>Efetue o download da planilha clicando no botão "Download Planilha"</li>
            <li>Preencher as informações cadastrais SEM alterar as colunas da planilha respeitando a ordem do modelo, caso o contrário, as validações serão feitas de forma incorreta.</li>
        </ul>
        <div class="form-group">
            <label for="file_array">Anexar Arquivo:</span>
            <input name="file_array" class="" type="file" required/>
        </div>        
    </div>

    <div class="modal-footer">
        <form action="<?php echo site_url("cadastro/download_planilha"); ?>" id="form_download_planilha" method="POST">        
            <button type="button" class="btn btn-success" id="salvar-planilha" ><span class="fa fa-check"></span> Validar</button>
            <button type="submit" class="btn btn-primary" id="planilha"><span class="fa fa-arrow-down"></span> Download Planilha</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </form>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        // download da planilha
        $("#planilha").on("click",function(e){
           
        });
        
    });

</script>