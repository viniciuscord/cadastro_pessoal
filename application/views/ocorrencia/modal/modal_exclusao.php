<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Exclusão Ocorrência</h4>       
        </div>
        <div class="modal-body">
            <form id="formExclOcorrencia"> 
                <input type="hidden" name="num_ocorrencia" value="<?= $dados['NumOcorrencia'] ?>">
                <input type="hidden" name="matricula" value="<?= $dados['Matricula'] ?>">
                <input type="hidden" name="id_motivo" value="<?= $dados['IdMotivo'] ?>">
                <input type="hidden" name="ocorrencia" value="<?= $dados['Ocorrencia'] ?>">
                <input type="hidden" name="data_ini" value="<?= date('d/m/Y',strtotime($dados['DataInicio']));?>">
                <input type="hidden" name="data_fim" value="<?= date('d/m/Y',strtotime($dados['DataFim']));?>">

                <div class="col-md-12">
                    <div class="row">
                        <h4>Deseja confirmar a exclusão da ocorrência Nº <?= $dados['NumOcorrencia'] ?> ? </h4>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <th>Nº Ocorrência</th>
                                <th>Matrícula</th>
                                <th>Motivo</th>
                                <th>Inserido por</th>
                                <th>Justificativa</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th>Data Atualização</th>
                            </thead>    
                            <tbody>
                                <tr>
                                    <td><?= $dados['NumOcorrencia']?></td>
                                    <td><?= $dados['Matricula']?></td>
                                    <td><?= $dados['Descricao']?></td>
                                    <td><?= $dados['InseridoPor']?></td>
                                    <td><?= $dados['Ocorrencia']?></td>
                                    <td><?= date("d/m/Y",strtotime($dados['DataInicio']))?></td>
                                    <td><?= date("d/m/Y",strtotime($dados['DataFim']))?></td>
                                    <td><?= date("d/m/Y",strtotime($dados['DataAtualizacao']))?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div id="alert-info"></div>        
                    </div>
                </div>
            </form>     
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger excluir-ocorr"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){
        $(".excluir-ocorr").on("click",function(){
            //alert("clicou");
            var url = siteurl + "ocorrencia/setExclusaoOcorrencia";
            $.ajax({
                url : url, 
                type : "POST",
                dataType: "json",
                data : $("#formExclOcorrencia").serialize(),
                beforeSend: function(){
                    $(".excluir-ocorr").attr('disabled',true);
                },
                error : function (){
                    msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a ocorrência, tente novamente.</center></div>';
                    $("#alert-info").html(msg);
                    window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 3000);
                    $(".excluir-ocorr").attr('disabled',false);

                },
                success: function(data){
                    if(data){
                        var msg = "Ocorrência excluída com sucesso!"; 
                        $.toaster({
                            priority : "success", 
                            title : ceacr+" - CP",
                            message : msg,
                            settings: {'timeout': 5000 }
                        });
                        $(".excluir-ocorr").attr('disabled',false);
                        $("#modalOcorrencia").modal("hide");
                        $("#consultar").trigger("click");
                    }else{
                        var msg = "Não foi possível completar a exclusão!"; 
                        $.toaster({
                            priority : "danger", 
                            title : ceacr+" - CP",
                            message : msg,
                            settings: {'timeout': 5000 }
                        });
                        $(".excluir-ocorr").attr('disabled',false);
                    }
                   
                }     
            });
        });
    });
</script>