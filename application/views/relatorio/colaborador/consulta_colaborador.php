<style>
    th{
        text-align: center;
    }
    td{
        text-align: center;
        font-size: 12px;
    }
    .checkbox{
        padding-right: 15px;
        padding-bottom: 10px;
    }
</style>

<?php if($colaborador != null ): ?>
    <table class="table datatable table-hover" >
        <thead>
            <!-- <th>Nº Ocorrência</th> -->
            <th>Matrícula</th>
            <th style="text-align: left;">Nome</th>
            <th>Sexo</th>
            <th>Admissão</th>
            <th>Horário</th>
            <th>Carga Horária</th>
            <?php if($this->input->post('supervisor') == 'exibir'):?>  <th>Supervisor</th> <?php endif;?>
            <?php if($this->input->post('funcao') == 'exibir'):?> <th>Função</th> <?php endif;?>
            <?php if($this->input->post('fila') == 'exibir'):?> <th>Fila</th> <?php endif;?>
            <?php if($this->input->post('situacao') == 'exibir'):?> <th>Situação</th> <?php endif;?>

        </thead>
        <tbody>
            <?php foreach($colaborador as $row): ?>
            <tr>
                <td><?= $row['Matricula']?></td>
                <td style="text-align: left;"><?= $row['Login/Nome'] ?></td>
                <td><?= $row['Sexo']?></td>
                <td><?= $row['Admissao']?></td>
                <td><?= $row['Horario']?></td>
                <td><?= $row['Carga Horaria']?></td>
                <?php if($this->input->post('supervisor') == 'exibir'):?> <td><?= $row['Supervisor']?></td> <?php endif;?>
                <?php if($this->input->post('funcao') == 'exibir'):?> <td><?= $row['NomeFuncao']?></td> <?php endif;?>
                <?php if($this->input->post('fila') == 'exibir'):?> <td><?= $row['Fila']?></td> <?php endif;?>
                <?php if($this->input->post('situacao') == 'exibir'):?>  <td><?= $row['Situacao']?></td> <?php endif;?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else:   
            echo "Nenhum registro encontrado";
        endif;    
?>

<script>
$(document).ready(function(){
    $(".datatable").dataTable({
        "oLanguage": {
            "sLengthMenu": "_MENU_ por página",
            "sInfoEmpty": "Não foram encontrados registros",
            "sInfo": "(_START_ a _END_) registros",
            "sInfoFiltered": "(filtrado de _MAX_ registro(s))",
            "sZeroRecords": "Nenhum resultado",
            "sSearch": "Filtrar",
            "oPaginate":
                    {
                        "sNext": "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span> "
                    }
        },
        "order": [],
        "bPaginate": true,
    });
    
});
</script>
