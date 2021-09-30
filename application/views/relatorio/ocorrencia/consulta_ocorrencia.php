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

<?php if($colaborador != null ): ?>
    <table class="table datatable table-hover" >
        <thead>
            <th>#</th>
            <th>Matrícula</th>
            <th style="text-align: left;">Nome</th>
            <th style="text-align: left;">Descrição</th>
            <th>Quantidade</th>
        </thead>
        <tbody>
            <?php $count = 1; foreach($colaborador as $row): ?>
            <tr>
                <td><?= $count;?></td>
                <td><?= strtoupper($row['Matricula']);?></td>
                <td style="text-align: left;"><?= $row['NOME'] ?></td>
                <td style="text-align: left;"><?= $row['Descricao']?></td>
                <td> <span style="color: rgb(0,92,169);font-weight:bold;cursor: pointer;" class="label label-success qt-oc" data-mat="<?= $row['Matricula']?>" data-motivo="<?= $row['idMotivo']?>" data-inserido="<?= $row['InseridoPor']?>"> <?= $row['QTD']?> ocorrência(s)</span></td>
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
    const Toast = Swal.mixin({
        toast: true,
        // position: 'bootom-center',
        showConfirmButton: false,
        timer: 3000
    });
    
    $('.qt-oc').click(function(){
        var url = siteurl + "relatorio/consulta_ocorrencia_detalhado";
        var dtini = $('#dt-ini').val();
        var dtfim = $('#dt-fim').val();
        var tipo_ocorrencia = $('#tipo_ocorrencia').val();
        var mat = $(this).data('mat');
        var inseridopor = $(this).data('inserido');
        var motivo = $(this).data('motivo');

        $('#dt-inicio').val(dtini);
        $('#dt-final').val(dtfim);
        $('#tipo-ocorrencia').val(tipo_ocorrencia);
        $('#registro').val(inseridopor);
        $('#matricula').val(mat);
        $('#razao').val(motivo);
       
        $.ajax({
            type: "post",
            url: url,
            data: {
                dtinicio: dtini,
                dtfim: dtfim,
                matricula: mat,
                inseridopor: inseridopor,
                motivo: motivo,
                tipo_ocorrencia: tipo_ocorrencia
            },error: function(xhr, ajaxOptions, thrownError){
                Toast.fire({
                    type: 'error',
                    title: 'Ops! não foi possível atualizar os dados.'
                });
                

            },
            success: function (response) {
                var mens = '';
                if($('#resultado_detalhado').is(':visible')){
                    mens = 'Dados atualizados com sucesso.';
                }else{
                    mens = 'Dados carregados com sucesso.';
                }
                Toast.fire({
                    type: 'success',
                    title: mens
                });
                $("#result_detalhado").html(response);
                $(".overlay").hide();
                $('#resultado_detalhado').show();
                setTimeout(function(){
                    $('html, body').animate({scrollTop : 720},1000);
                },500);
            }
        });
    });
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
