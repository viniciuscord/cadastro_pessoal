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
    .label{
        font-size: 100% !important;
    }
</style>

<?php if($detalhe != null ): ?>
    <table class="table detalhado table-hover" >
        <thead>
            <th>#</th>
            <th>Nome</th>
            <th>Função</th>
            <th>Cadastrada Por</th>
            <th>Motivo</th>
            <th>Justificativa</th>
            <th>Data Início</th>
            <th>Data Fim</th>
        </thead>
        <tbody>
            <?php $count = 1; foreach($detalhe as $row): ?>
            <tr>
                <td><?= $count;?></td>
                <td><?= $row['Nome'];?></td>
                <td><?= $row['NomeFuncao'];?></td>
                <td><?= $row['InseridoPor'];?></td>
                <td><?= $row['Ocorrencia'];?></td>
                <td><?= $row['Justificativa'];?></td>
                <td><?= $row['DataInicio'];?></td>
                <td><?= $row['DataFim'];?></td>
            </tr>
            <?php $count++; endforeach; ?>
        </tbody>
    </table>
<?php else:   
            echo "Nenhum registro encontrado";
        endif;    
?>

<script>
$(document).ready(function(){
    $(".detalhado").dataTable({
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
