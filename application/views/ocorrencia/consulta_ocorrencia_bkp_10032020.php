<div class="col-sm-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <i class="fa fa-file-text-o"></i> Ocorrências 
        </div>
        <div class="panel-body">
            <?php if($dados != null ): ?>
                <table class="table striped table-striped" >
                    <thead>
                        <th>Nº Ocorrência</th>
                        <th>Matrícula</th>
                        <th>Empregado</th>
                        <th>Motivo</th>
                        <th>Inserido por</th>
                        <th>Justificativa</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Data Atualização</th>
                        <th>Status</th>
                        <th>Editar</th>
                    </thead>
                    <tbody>
                        <?php foreach($dados as $row): ?>
                        <tr>
                            <td><?= $row['NumOcorrencia']?></td>
                            <td><?= $row['Matricula']?></td>
                            <td><?= $row['Nome'] ?></td>
                            <td><?= $row['Descricao']?></td>
                            <td><?= $row['InseridoPor']?></td>
                            <td><?= $row['Ocorrencia']?></td>
                            <td><?= date("d/m/Y",strtotime($row['DataInicio']))?></td>
                            <td><?= date("d/m/Y",strtotime($row['DataFim']))?></td>
                            <td><?= date("d/m/Y",strtotime($row['DataAtualizacao']))?></td>
                            <td><?= $row['StatusOcorrencia']?></td>
                            <td>
                                <button class="btn btn-success btn-sm editar" data-toggle="tooltip" title="Editar"><span class="glyphicon glyphicon-pencil"></span></button>
                                <button class="btn btn-danger btn-sm excluir" data-toggle="tooltip" title="Excluir"><span class="glyphicon glyphicon-remove"></span></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else:   
                        echo "Nenhum registro encontrado";
                  endif;    
            ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        // editar ocorrência  
        $(".editar").on("click",function(){
            var num_ocorrencia = $(this).closest("tr").children("td:eq(0)").text();
            var matricula = $(this).closest("tr").children("td:eq(1)").text();
            var url = siteurl + "ocorrencia/modalEditDadosOcorrencia";
            $.ajax({
                url : url,
                data : { num_ocorrencia : num_ocorrencia , matricula : matricula },
                type : "POST",
                dataType: "html",
                beforeSend : function(){
                    $(".overlay").show();
                },
                success : function(data){
                    $("#modalOcorrencia").html(data);
                    $("#modalOcorrencia").modal("show");
                    $(".overlay").hide();
                } 
            });
        });
        // excluir ocorrência 
        $(".excluir").on("click",function(){
            var num_ocorrencia = $(this).closest("tr").children("td:eq(0)").text();
            var matricula = $(this).closest("tr").children("td:eq(1)").text();
            var url = siteurl + "ocorrencia/modalExcluirOcorrencia";

            $.ajax({
                url : url,
                data : { num_ocorrencia : num_ocorrencia, matricula : matricula },
                type : "POST",
                dataType: "html",
                beforeSend: function(){
                    $(".overlay").show();
                },
                success: function(data){
                    $("#modalOcorrencia").html(data);
                    $("#modalOcorrencia").modal("show");
                    $(".overlay").hide();
                } 
            });
        });
       
    });
</script>
