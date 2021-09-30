<!-- <div class="col-sm-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="fa fa-clock-o"></i> Escalas Solicitadas
        </div>
        <div class="panel-body"> -->
            <?php if($dados != null ): ?>
                <?php //print_r($dados); ?>
                <table class="table table-striped" >
                    <thead>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th data-toggle="tooltip" title="Horário Real de Entrada" style="cursor:pointer;">H.Real Entrada</th>
                        <th data-toggle="tooltip" title="Horário Escala de Entrada" style="cursor:pointer;">H.Escala Entrada</th>
                        <th data-toggle="tooltip" title="Horário Real de Saída" style="cursor:pointer;">H.Real Saída</th>
                        <th data-toggle="tooltip" title="Horário Escala de Saída" style="cursor:pointer;">H.Escala Saída</th>
                        <th>Inserido por</th>
                        <th>Nome Responsável</th>
                        <th>Justificativa</th>
                        <th>Status Escala</th>
                        <th>Editar</th>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $row): ?>
                        <tr>
                            <td><?= $row['Matricula'] ?></td>
                            <td><?= $row['Nome'] ?></td>
                            <td><?= date('d/m/Y',strtotime($row['Data'])) ?></td>
                            <td><?= $row['HorarioRealEntrada'] ?></td>
                            <td><?= $row['HorarioEscalaEntrada'] ?></td>
                            <td><?= $row['HorarioRealSaida'] ?></td>
                            <td><?= $row['HorarioEscalaSaida'] ?></td>
                            <td><?= $row['InseridoPor'] ?></td>
                            <td><?= $row['MatriculaNome']?></td>
                            <td><?= $row['Justificativa'] ?></td>
                            <td><?= $row['StatusEscala'] ?></td>
                            <td><?php if($row['StatusEscala'] == 'AGUARDANDO'): ?><button class="btn btn-success edt-solicitacao" data-toggle="tooltip" title="Editar"><span class="glyphicon glyphicon-pencil"></span></button><?php endif;?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: 
                        echo "Nenhum registro encontrado";
                  endif;    
            ?>
        <!-- </div>
    </div>
</div> -->

<!-- Modal edição escala !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_escala_edt"></div>	

<script>
    $(document).ready(function(){
        $(".edt-solicitacao").on("click", function(){
            var matricula = $(this).closest("tr").children("td:eq(0)").text();
            var data = $(this).closest("tr").children("td:eq(2)").text();
            var url = siteurl + "escala/modalEditarEscala";
            $.ajax({
                url : url, 
                type : "POST",
                data : { matricula : matricula , data : data },
                dataType: "html", 
                beforeSend : function(){
                    $(".overlay").show();
                }
            }).done(function(data){
                $("#modal_escala_edt").html(data);
                $("#modal_escala_edt").modal("show");
                $(".overlay").hide();
            });
        });
    });
</script>