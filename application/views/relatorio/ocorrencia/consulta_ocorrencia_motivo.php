<style>
    th{
        text-align: left;
    }
    td{
        text-align: left;
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
<?php if($detalhe_motivos != null ): ?>
    <table class="table datatable table-hover" >
        <thead>
            <th>Data</th>
            <th>Matrícula Empresa</th>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>Função</th>
            <th>Inserido Por</th>
            <?php if($this->input->post('input_justificativa') == 'exibir'):?> <th>Ocorrência</th> <?php endif;?>
            <th>Motivo BS</th>
            <th>Descrição</th>
            <th>Cod BS</th>
        </thead>
        <tbody>
            <?php foreach ($detalhe_motivos as $key => $value): ?>
                <tr>
                    <td><?= $value['Data'];?></td>
                    <td><?= $value['MatriculaEmpresa']?></td>
                    <td><?= $value['Mat_CAIXA']?></td>
                    <td><?= $value['Mat_Nome']?></td>
                    <td><?= $value['NomeFuncao']?></td>
                    <td><?= $value['Inserido_Por']?></td>
                    <?php if($this->input->post('input_justificativa') == 'exibir'):?> <td><?= $value['Ocorrencia']?></td> <?php endif;?>
                    <td><?= $value['Descricao']?></td>
                    <td><?= $value['Motivo_BS']?></td>
                    <td><?= $value['Cod_BS']?></td>
                </tr>
            <?php endforeach;?>
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
