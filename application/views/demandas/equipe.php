<form action="<?php echo site_url("demandas/export_dados_excel"); ?>" method="POST" id="form-excel">
            <input type="hidden" value="<?= $mes_padrao;?>" id="mes_param" name="mes_param">
            <input type="hidden" value="<?= $ano_padrao;?>" id="ano_param" name="ano_param">
        </form>
<div class="overlay-new" style="display: none;margin: 0px 15px 20px 15px;"><div class="overlay-new-content"><img src="images/loading.gif"></div></div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Membros de Equipe</h3>
        <span class="label label-danger tot-member">Qtde Membros: <?= $tot_func;?></span>

        <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
            </button> -->
            <div class="btn-group">
                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                    <li class="pointer"><a id="alternar">Alternar Visão</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <div id='v_1_members'>
            <ul class="users-list clearfix">
                <?php 
                    $imgs = array(
                        'P534499','P541903','P551097',
                        'P566774','P608549','p608558',
                        'P608614','p614939','P616003',
                        'P629450','P639738',
                        'P723102','P773778','P785446',
                        'P950635','P981551','P981809',
                        'P536249','P586836','P980648',
                        'P951670','P616339',
                        'P616204','P980705',
                    );
        if($demandas_por_funcionario): 
            foreach ($demandas_por_funcionario as $key => $value) {
            $tipo_funcao = explode(' ',$value['FUNCAO']);
            $nome = explode(' ',$value['NOME']);
            $qtd_nome = intval(count($nome));
            $tot_horas_mes_2 = explode('.',$value['TOTALHORASMES']); $tot_horas_mes_2 = intval($tot_horas_mes_2[0]);
            $tot_horas_mes_func_2 = explode(':',$value['TOTAL']); $tot_horas_mes_func_2 = intval($tot_horas_mes_func_2[0]);
            if($tot_horas_mes_func_2 < $tot_horas_mes_2): $status_2 = 1; else: $status_2 = 2; endif;
            ?>
                <li class="<?= substr($tipo_funcao[3],0,-1);?>">
                <?php 
                    $fotos = in_array($value['MATRICULA'], $imgs);
                    if($fotos): $data_foto = 's';?>
                        <img src="<?php echo base_url('images/FotosEquipe/Novas_Imagens/'.$value['MATRICULA'].'.png');?>" alt="User Image" width="50" height="50">
                    <?php else: $data_foto = 'n';?>
                        <img src="<?php echo base_url('images/no_image_user.png');?>" alt="User Image" width="50" height="50">
                    <?php endif;?>
                    <a class="users-list-name pointer nome_func" data-foto="<?=$data_foto;?>"
                        data-mat="<?= $value['MATRICULA']?>" data-status="<?= $status_2;?>"><?=$nome[0].' '.$nome[$qtd_nome-1];?></a>
                    <span class="users-list-date"><?=$value['FUNCAO'];?></span>
                </li>
                <?}
        endif;
        ?>
            </ul>
        </div>
        <div class="col-md-12" id='v_2_members' style="display:none;">

            <table class="table table-hover table-striped datatable">
                <thead>
                    <tr>
                        <th class="align-tabela-th align-tabela">#</th>
                        <th class="align-tabela-th align-tabela">Matrícula</th>
                        <th class="align-tabela-th">Nome</th>
                        <th class="align-tabela-th align-tabela">Função</th>
                        <th class="align-tabela-th align-tabela">Total Horas Mês</th>
                        <th class="align-tabela-th align-tabela">Total</th>
                        <th class="align-tabela-th align-tabela">Hora Extra</th>
                        <th class="align-tabela-th align-tabela">Hora Negativa</th>
                        <th class="align-tabela-th align-tabela">Status Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
        if($demandas_por_funcionario): 
            $item = 1;
            foreach ($demandas_por_funcionario as $key => $value) {
            $tot_horas_mes = explode('.',$value['TOTALHORASMES']); $tot_horas_mes = intval($tot_horas_mes[0]);
            
            $tot_horas_mes_func = explode(':',$value['TOTAL']); $tot_horas_mes_func = intval($tot_horas_mes_func[0]);
            

            $nome = explode(' ',$value['NOME']);
            $qtd_nome = intval(count($nome));
            ?>
                    <!-- <tr <?= $class_menor_tempo;?>> -->
                    <tr>
                        <td class="align-tabela-td align-tabela"><?= $item?></td>
                        <td class="align-tabela-td align-tabela"><?= $value['MATRICULA']?></td>
                        <td class="align-tabela-td"><?= $value['NOME']?></td>
                        <td class="align-tabela-td align-tabela"><?= $value['FUNCAO']?></td>
                        <td class="align-tabela-td align-tabela" data-sort="<?php $horaM = explode(':',$value['TOTALHORASMES']); echo $horaM[0];?>"><?= $value['TOTALHORASMES']?></td>
                                    <td class="align-tabela-td align-tabela" data-sort="<?php $horaT = explode(':',$value['TOTAL']); echo $horaT[0];?>"><?= $value['TOTAL']?></td>
                                    <td class="align-tabela-td align-tabela" data-sort="<?php $horaE = explode(':',$value['HEXTRA']); echo $horaE[0];?>"><?= $value['HEXTRA']?></td>
                                    <td class="align-tabela-td align-tabela" data-sort="<?php $horaN = explode(':',$value['HNEGATIVA']); echo $horaN[0];?>"><?= $value['HNEGATIVA']?></td>
                        <?php if($tot_horas_mes_func < $tot_horas_mes):?>
                            <td class="align-tabela-td align-tabela"><span class="label bg-red item-status-hora">Negativo</span></td>
                            <?php else: ?>
                            <td class="align-tabela-td align-tabela"><span class="label bg-green item-status-hora">Positivo</span></td>
                        <?php endif;?>
                    </tr>
                    <? $item++;}
        endif;
        ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
$(function(){
    $('#alternar').click(function() {
        if ($('#v_2_members').is(':visible')) {
            $('#v_2_members').fadeOut();
            $('#v_1_members').fadeIn();
        } else {
            $('#v_2_members').fadeIn();
            $('#v_1_members').fadeOut();
            $('#detalhe-invidual').slideUp();
        }
    });
    $('.nome_func').on('click', function(){
        var mat = $(this).data('mat');
        var status_hora = $(this).data('status');
        var mes_padrao = $('#mes_param').val();
        var ano_padrao = $('#ano_param').val();
        var tem_foto = $(this).data('foto');
        $.ajax({
            type: "post",
            url: siteurl + "demandas/buscaHorasPorFuncionarioIndividual",
            data: {
                matricula: mat,
                status: status_hora,
                mes_padrao: mes_padrao,
                ano_padrao: ano_padrao
                
            },
            dataType: "json",
            beforeSend: function(){
                $('.overlay-new').show();
            },
            success: function (data) {
            //   console.log(data.status);
                var nome = data.reg.NOME.split(" ");
                var ultimo_nome = nome.length-1;
                var primeiro_nome = nome[0];
                var ultimo_nome = nome[ultimo_nome];
                var nome_compl = primeiro_nome+' '+ultimo_nome;
                $('.overlay-new').hide();
                $('.nome-func-ind').text(nome_compl);
                $('.nome-funcao-ind').text(data.reg.FUNCAO);
                $('.hor-previsto').text(data.reg.TOTALHORASMES);
                $('.hor-realizada').text(data.reg.TOTAL);
                if(tem_foto == 's'){
                    $('.img-analista').html('<img class="img-circle" src="'+base_url+'images/FotosEquipe/Novas_Imagens/'+mat+'.png" alt="User Avatar">');
                }else{
                    $('.img-analista').html('<img class="img-circle" src="'+base_url+'images/no_image_user.png" alt="User Avatar">');
                }
                $('#detalhe-invidual').slideDown();
                // alert(status_hora);
                if(data.reg.FUNCAO == 'ANALISTA DE SISTEMAS JR.'){
                    $('.widget-user-header').addClass('bg-aqua-active').removeClass('bg-red-active').removeClass('bg-green-active');
                }else if(data.reg.FUNCAO == 'ANALISTA DE SISTEMAS PL.'){
                    $('.widget-user-header').addClass('bg-red-active').removeClass('bg-aqua-active').removeClass('bg-green-active');
                }else{
                    $('.widget-user-header').addClass('bg-green-active').removeClass('bg-aqua-active').removeClass('bg-red-active');
                }
                
                if(data.status == 1){
                    $('.hor-negativo').text(data.reg.HNEGATIVA).addClass('text-red');
                    $('.hor-positivo').text(data.reg.HEXTRA).removeClass('text-green');
                }else{
                    $('.hor-positivo').text(data.reg.HEXTRA).addClass('text-green');
                    $('.hor-negativo').text(data.reg.HNEGATIVA).removeClass('text-red');
                }
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