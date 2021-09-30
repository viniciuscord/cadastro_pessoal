<?php if($dados): ?>
<div class="box box-success">
    <div id="overlay-detalhado" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Relatório</h4>
        <div class="box-tools">
            <button class="btn btn-secondary btn-sm pull-right exportar" ><span class="fa fa-file"></span> Exportar</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-striped small">
            <thead>
                <th>Dia</th>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th data-toggle="tooltip" title="Entrada Prevista" style="cursor:pointer;">E.Prevista</th>
                <th data-toggle="tooltip" title="Entrada Fato" style="cursor:pointer;">E.Fato</th>
                <th data-toggle="tooltip" title="Entrada Autorizada" style="cursor:pointer;">E.Autorizada</th>
                <th data-toggle="tooltip" title="Matrícula Autorização Entrada" style="cursor:pointer;">Mat Aut. E</th>
                <th data-toggle="tooltip" title="Saída Prevista" style="cursor:pointer;">S.Prevista</th>
                <th data-toggle="tooltip" title="Saída Fato" style="cursor:pointer;">S.Fato</th>
                <th data-toggle="tooltip" title="Saída Autorizada" style="cursor:pointer;">S.Autorizada</th>
                <th data-toggle="tooltip" title="Matrícula Autorização Saída" style="cursor:pointer;">Mat Aut. S</th>
                <th>Débito</th>
                <th data-toggle="tooltip" title="Hora Extra" style="cursor:pointer">H.Extra</th>
            </thead>
           <tbody>
                <?php 
                    if(isset($dados)): 
                        foreach($dados as $row): ?>
                            <tr>
                                <td><?= $row['dia'] ?></td>
                                <td><?= $row['Matricula'] ?></td>
                                <td><?= utf8_encode($row['Nome']) ?></td>
                                <td><?= $row['Descricao'] ?></td>
                                <td><?= $row['EntradaPrevista'] ?></td>
                                <td><?= $row['EntradaFato'] ?></td>
                                <td><?= $row['EntradaAutorizada'] ?></td>
                                <td><?= $row['MatriculaAutorizacaoEntrada'] ?></td>
                                <td><?= $row['SaidaPrevista'] ?></td>
                                <td><?= $row['SaidaFato'] ?></td>
                                <td><?= $row['SaidaAutorizada'] ?></td>
                                <td><?= $row['MatriculaAutorizacaoSaida'] ?></td>
                                <td style="color:red;"><?= $row['Deb1'] != null ? '-'.$row['Deb1'] : '' ?></td>
                                <td style="color:green;"><?= $row['Cred'] != null ? '+'.$row['Cred'] : '' ?></td>
                            </tr>
            <?php       endforeach; 
                    endif;
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <div class="box box-success">
    <div id="overlay-detalhado" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Relatórios</h4>
    </div>
    <div class="box-body">
        Nenhum resultado encontrado.
    </div>
</div>
<?php endif; ?>


<script>

    $(document).ready(function(){
        $(".exportar").on("click",function(){
            var url = siteurl + 'relatorio/exportar_dados_frequencia';	
            $("form").attr("action",url);
            $("form").submit();
        });

    });


</script>
