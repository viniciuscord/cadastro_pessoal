<div class="box box-warning">
    <div id="overlay-analitico" class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Relatório - Consolidado</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <?php 
        if($this->input->post("superior"))
            $superior = implode(";",$this->input->post("superior")); 
        else
            $superior = null;
        if($this->input->post("funcao"))
            $funcao = implode(";",$this->input->post("funcao"));
        else    
            $funcao = null;
        
    ?> 
    <div class="box-body">
        <?php if($this->input->post("agrupador") == '1'): ?>
            <?php if($dados != null ): ?>
            <table class="table striped table-striped result_rel" >
                <thead>
                    <th>Empresa</th>
                    <th>Contrato</th>
                    <th>CGC</th>
                    <th>SIGLA</th>
                    <th>Quantidade</th>                        
                </thead>
                <tbody>
                   <?php foreach ($dados as $row): ?>          
                    <tr>
                        <td><?= $row['NomeEmpresa'] ?></td>
                        <td><?= $row['Contrato'] ?></td>
                        <td><?= $row['CGC'] ?></td>
                        <td><?= $row['SIGLA'] ?></td>
                        <td><a class="qtd_result" href="javascript:enviaDadosModel('<?=$row['IdEmpresa']?>','<?=$row['CGC']?>','<?=$superior?>','<?=$funcao?>')"><?= $row['Qtd'] ?></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: echo "Nenhum registro encontrado."; endif;?>
        <?php elseif($this->input->post("agrupador") == '2'): ?>
            <?php if($dados != null ): ?>
                <?php //print_r($dados); ?>
                <table class="table striped table-striped result_rel">
                    <thead>
                        <th>Empresa</th>
                        <th>Contrato</th>
                        <th>CGC</th>
                        <th>SIGLA</th>
                        <th>Nome</th>
                        <th>Matrícula Sup.</th>
                        <th>Quantidade</th>
                    </thead> 
                    <tbody>
                    <?php foreach ($dados as $row): ?>
                        <tr>
                            <td><?= $row['NomeEmpresa'] ?></td>
                            <td><?= $row['Contrato'] ?></td>
                            <td><?= $row['CGC'] ?></td>
                            <td><?= $row['SIGLA'] ?></td>
                            <td><?= $row['Nome'] ?></td>
                            <td><?= $row['MatriculaSuperior'] ?></td>
                            <td><a class="qtd_result" href="javascript:enviaDadosModel('<?=$row['IdEmpresa']?>','<?=$row['CGC']?>','<?= $row['MatriculaSuperior']?>','<?=$funcao?>')"><?= $row['Qtd'] ?></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: echo "Nenhum registro encontrado."; endif;?>
        <?php elseif($this->input->post("agrupador") == '3'): ?>
            <?php if($dados != null ): ?>
                <table class="table striped table-striped result_rel">
                    <thead>
                        <th>Empresa</th>
                        <th>Contrato</th>
                        <th>CGC</th>
                        <th>SIGLA</th>
                        <th>Função</th>
                        <th>Quantidade</th>
                    </thead>
                    <tbody>
                    <?php foreach ($dados as $row): ?>
                        <tr>
                            <td><?= $row['NomeEmpresa'] ?></td>
                            <td><?= $row['Contrato'] ?></td>
                            <td><?= $row['CGC'] ?></td> 
                            <td><?= $row['SIGLA'] ?></td>
                            <td><?= $row['NomeFuncao'] ?></td>
                            <td>
                                <a class="qtd_result" 
                                href="javascript:enviaDadosModel('<?=$row['IdEmpresa']?>','<?=$row['CGC']?>','','<?=$row['IdFuncao'] ?>');"
                                ><?= $row['Qtd'] ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: echo "Nenhum registro encontrado."; endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>

    $(document).ready(function(){

        $(".result_rel").dataTable({
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
            // "pageLength": 5,
            "bPaginate": true,
            "fixedHeader": true
        });

    });

    function enviaDadosModel(idEmpresa,cgc,codSuperior,idFuncao){
        var url = siteurl + "relatorio/modalRelatorioDetalhado";
        $.ajax({
            url : url,
            type : "POST",
            dataType : "html",
            data : { idFuncao : idFuncao , idEmpresa : idEmpresa, cgc : cgc , codSuperior : codSuperior },
            beforeSend : function (){
                $("#overlay-analitico").show();
                $("#overlay-detalhado").show();

            },
            success : function (data){
                $("#result_click").html(data);
                $("#result_click").show()
                //$("#modal_rel_detalhado").modal("show");
                $("#overlay-analitico").hide();
                $("#overlay-detalhado").hide();

            }
        });

    }                        

</script>


