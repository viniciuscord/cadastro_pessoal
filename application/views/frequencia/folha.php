<?php if($folha != null): ?>
    <table class="table table-striped" >
        <thead>
            <th>Matrícula</th>
            <th>Data</th>
            <th data-toggle="tooltip" title="Entrada Prevista" style="cursor:pointer;">E.Prevista</th>
            <th data-toggle="tooltip" title="Entrada Fato" style="cursor:pointer;">E.Fato</th>
            <th data-toggle="tooltip" title="Entrada Autorizada" style="cursor:pointer;">E.Autorizada</th>
            <th data-toggle="tooltip" title="Matrícula Autorização Entrada" style="cursor:pointer;">Mat Aut. E</th>
            <th data-toggle="tooltip" title="Saída Prevista" style="cursor:pointer;">S.Prevista</th>
            <th data-toggle="tooltip" title="Saída Fato" style="cursor:pointer;">S.Fato</th>
            <th data-toggle="tooltip" title="Saída Autorizada" style="cursor:pointer;">S.Autorizada</th>
            <th>Débito</th>
            <th data-toggle="tooltip" title="Hora Extra" style="cursor:pointer">H.Extra</th>
            <th data-toggle="tooltip" title="Matrícula Autorização Saída" style="cursor:pointer;">Mat Aut. S</th>
            <th>Ocorrência</th>
        </thead>
        <tbody>
            <?php foreach($folha as $row):  ?>
                <tr>
                    <td><?= $row['Matricula']; ?></td>
                    <td><?= date("d/m/Y",strtotime($row['dia'])); ?></td>
                    <td><?= $row['EntradaPrevista'] != null ? date("H:i", strtotime($row['EntradaPrevista'])) : "--:--";?></td>
                    <td><?= $row['EntradaFato'] != null ? date("H:i", strtotime($row['EntradaFato'])) : "--:--";?></td>
                    <td><?= $row['EntradaAutorizada'] != null ? date("H:i", strtotime($row['EntradaAutorizada'])) : "--:--";?></td>
                    <td><?= $row['MatriculaAutorizacaoEntrada']; ?></td>
                    <td><?= $row['SaidaPrevista'] != null ? date("H:i", strtotime($row['SaidaPrevista'])) : "--:--" ; ?></td>
                    <td><?= $row['SaidaFato'] != null ? date("H:i", strtotime($row['SaidaFato'])) : "--:--" ; ?></td>
                    <td><?= $row['SaidaAutorizada'] != null ? date("H:i", strtotime($row['SaidaAutorizada'])) : "--:--" ; ?></td>
                    <td style="color:red;"><?= $row['Deb1'] != null && $dados['IdFuncao'] != 8 ? '-'.$row['Deb1'] : '' ?></td>
                    <td style="color:green;"><?= $row['Cred'] != null && $dados['IdFuncao'] != 8  ? '+'.$row['Cred'] : '' ?></td>
                    <td><?= $row['MatriculaAutorizacaoSaida']; ?></td>
                    <td><?= $row['Descricao']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if($dados['IdFuncao'] !=  8 ): ?>
    <div class="col-md-2 pull-right">
        <h4>Total do Mês: <?php if($total_parc['saldo'] == 'P') echo "<span style='color:green'>+"; else echo "<span style='color:red'>-"; echo $total_parc['total']; ?></span></h4>
    </div>
    <?php endif; ?>
<?php else: echo "Não foi possível localizar informações da folha para o período selecionado."; endif;?>
