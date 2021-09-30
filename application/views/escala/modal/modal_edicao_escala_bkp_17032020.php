<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <span class='glyphicon glyphicon-remove modal-close'></span>        			
            </button>
            <h4 class="modal-title" >Editar Solicitação</h4>       
        </div>
        <?php //print_r($dados); ?>
        <div class="modal-body">
            <?php if($this->session->userdata("acesso") == 'Planejamento'): ?>
                <table class="table striped" >
                    <thead>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>H.Escala Entrada</th>
                        <th>H.Escala Saída</th>
                        <th>Inserido por</th>
                        <th>Justificativa</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $dados['Matricula'] ;?></td>
                            <td><?= $dados['Nome']; ?></td>
                            <td><?= date("d/m/Y",strtotime($dados['Data'])); ?></td>
                            <td><?= $dados['HorarioEscalaEntrada']; ?></td>
                            <td><?= $dados['HorarioEscalaSaida']; ?></td>
                            <td><?= $dados['InseridoPor']; ?></td>
                            <td><?= $dados['Justificativa']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <form id="formEdtEscala">
                    <input type="hidden" name="matricula" value="<?= $dados['Matricula']; ?>" >
                    <input type="hidden" name="data" value="<?= $dados['Data']; ?>" >
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="just-text">Justificativa (Planejamento):</label>
                            <textarea class="form-control" cols="70" rows="2" maxlength='4000' name="justificativa" id="justificativa" required></textarea>
                            <span id="justificativa_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div>
                                <label>A solicitação está:</label>&nbsp;&nbsp;
                                <input type="radio" id="aprovada" name="solicitacao" value="1" checked>
                                <label for="aprovada">Aprovada <span class=""></span></label>&nbsp;&nbsp;
                                <input type="radio" id="recusada" name="solicitacao" value="2">
                                <label for="recusada">Recusada</label>
                            </div>
                        </div> 
                    </div>
                </form>
                <div id="alert-info"></div> 
            <?php else: ?>
                    <form id="formEdtEscala">
                        <input type="hidden" name="matricula" value="<?= $dados['Matricula']; ?>" >
                        <input type="hidden" name="data" value="<?= $dados['Data']; ?>" >
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="input-group"> 
                                    <label for="nome_modal">Nome:</label>
                                    <input type="text" class="form-control input-sm" value="<?= $dados['Nome']; ?>" disabled style="width:300px;" >
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="input-data">Data:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                    <input type="text" class="form-control input-sm" value="<?= date("d/m/Y",strtotime($dados['Data'])); ?>"  disabled >     
                                </div>
                                <span id="input_data_error" class="text-danger"></span>
                            </div>
                            <div class="col-sm-2">
                                <label for="input-hr-ini">Horário(Entrada):</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </div>
                                    <input type="text" name="input-hr-ini" class="form-control input-sm hours-input"  value="<?= $dados['HorarioEscalaEntrada']; ?>">     
                                </div>
                                <span id="input_hr_ini_error" class="text-danger"></span>
                            </div>
                            <div class="col-sm-2">
                                <label for="input-hr-said">Horário(Saída):</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </div>
                                    <input type="text" name="input-hr-said" class="form-control input-sm hours-input"  value="<?= $dados['HorarioEscalaSaida']; ?>">     
                                </div>
                                <span id="input_hr_said_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="just-text">Justificativa:</label>
                                <textarea class="form-control" cols="70" rows="2" maxlength='4000' name="justificativa" id="justificativa" required><?= $dados['Justificativa'] ?></textarea>
                                <span id="justificativa_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div id="alert-info"></div> 
                    </form> 
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="save_edt_escala" ><span class="fa fa-floppy-o"></span> Salvar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Voltar</button>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        var perfil = "<?php echo $this->session->userdata('acesso'); ?>";
        $("#save_edt_escala").on("click",function(){
            var controller = perfil == "Supervisor" ? "escala/alterarEscalaSupervisor" : "escala/alterarEscalaPlanejamento";
            var url = siteurl + controller;
            if($("#justificativa").val().trim() == ""){
                $("#justificativa").css({'border-color': '#a94442'});
                $("#justificativa_error").html("Justificativa obrigatória");
            }else{
                $("#justificativa").css({'border-color': 'lightgrey'});
                $("#justificativa_error").html('');

                $.ajax({
                    url: url,
                    data : $("#formEdtEscala").serialize(),
                    type : "POST",
                    dataType: "json",
                    beforeSend : function(){
                        $("#save_edt_escala").attr("disabled",true);
                    }, 
                    error : function(){
                        msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a escala, tente novamente.</center></div>';
                        $("#alert-info").html(msg);
                        window.setTimeout(function () {//remove o alert do erro
                            $(".result").fadeTo(500, 0).slideUp(500, function () {
                                $(this).remove();
                            });
                            }, 3000);
                        $("#save_edt_escala").attr("disabled",false);
                    }
                }).done(function(data){
                    //console.log(data);
                    if(data == null ){
                        /*msg = '<br><div class="alert result alert-success animated bounceIn col-md-auto btn-xs"><center>Escala registrada com sucesso.</center></div>';
                        $("#alert-info").html(msg);
                        window.setTimeout(function () {//remove o alert do erro
                            $(".result").fadeTo(500, 0).slideUp(500, function () {
                                $(this).remove();
                            });
                        }, 3000);
                        */
                        var msg = "Escala registrada com sucesso."; 
                        $.toaster({
                            priority : "success", 
                            title : "CEACR/BR - CP:", 
                            message : msg,
                            settings: {'timeout': 5000 }
                        });
                        $("#modal_escala_edt").modal("hide");
                        $("#consultar").trigger("click");
                    }
                });
            }
        });
    });

</script>

