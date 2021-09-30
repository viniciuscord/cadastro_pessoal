<style>
th{
    text-align: center;
}
td{
    text-align: center;
}
.swal2-cancel{
    margin-right: 5px !important;
}
.swal2-content{
    font-size: 14px !important;
}
.swal2-title{
    font-size: 16px !important;
}
</style>
<div class="box box-success">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Alterar Fechamento de Folha</h4>       
    </div>
    <div class="box-body">
        <?php if(!empty($dados)){ ?>
            <table id="table-results" class="table table-striped tb-large">
                <thead>
                    <tr>
                        <th style="text-align: left;">Mês</th>
                        <th>Fechamento Automático</th>
                        <th>Status</th>
                        <th>Alterar Folha</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach ($dados as $key => $value):?>
                    <tr>
                        <td style="text-align: left;"><?=$value['mes'];?></td>
                        <td><?=$value['dtatualizacao'];?></td>
                        <td>
                            <?php if($value['Status'] == 0): ?>
                            <p class="label bg-red">Fechado</p>
                            <?php else: ?>
                            <p class="label bg-green">&nbsp;Aberto&nbsp;</p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            if($value['Valida'] == 1 and $value['Status'] == 1):?>
                                <button type="button" class="btn btn-xs btn-danger folha" data-id="<?php echo $value['IdFolha'];?>" data-opcao="2">fechar Folha</button>
                            <?php endif; ?>
                            <?php if($value['Valida'] == 1 and $value['Status'] == 0):?>
                                <button type="button" class="btn btn-xs btn-success folha" data-id="<?php echo $value['IdFolha'];?>" data-opcao="1">Abrir Folha</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        <?php }else{ 
            echo "Nenhum registro encontrado";
        }?>
    </div>
</div>
<script>
    $(document).ready(function(){
        const Toast2 = Swal.mixin({
            customClass:{
                confirmButton: 'btn btn-sm btn-success',
                cancelButton: 'btn btn-sm btn-danger'
            },buttonsStyling: false
        });

        $('#table-result').dataTable({
            "oLanguage": {
                "sLengthMenu": "_MENU_ por página",
                "sInfoEmpty": "Não foram encontrados registros",
                "sInfo": "(_START_ a _END_) registros",
                "sInfoFiltered": "(filtrado de _MAX_ registro(s))",
                "sZeroRecords": "Nenhum resultado",
                "sSearch": "Filtrar",
                "oPaginate": {
                    "sNext": "<span class='glyphicon glyphicon-chevron-right'></span>",
                    "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span> "
                }
            },
            "columnDefs": [
                   { "width" : "50px", "targets": 1 }
            ],
            "scrollY" : "300px",
            "scrollX" : true,
            "ordering": false,
            "bPaginate": false,
            "bDestroy": true,
            "bFilter": true

        });

        $(".folha").on("click",function(){
            var tipo_acao = $(this).data('opcao');
            var id_folha = $(this).data('id');
            
            var url = siteurl + "fechar_folha/alterarFolha";
            Toast2.fire({
                title: 'Atenção!',
                text: 'Tem certeza que deseja alterar?',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true,
            }).then((result) => {
                if(result.value){/* resposta sim*/
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        id_folha: id_folha,
                        opcao: tipo_acao
                    },
                    dataType: "json",
                    success: function (response) {
                        if(response.tipo == true){
                            $('#ano').trigger('click');
                            var tipo_alerta = 'success';
                        }else{
                            var tipo_alerta = 'danger';

                        }
                        $.toaster({
                            priority : tipo_alerta, 
                            title : ceacr+" - CP", 
                            message : response.mensagem,
                            settings: {'timeout': 5000 }
                        });
                    }
                });
                   
                }
            });
        });

    });
</script>