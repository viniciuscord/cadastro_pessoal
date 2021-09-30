<style>
.pointer {
    cursor: pointer;
}

.align-tabela {
    text-align: center;
    /* text-transform: uppercase; */
}

.align-tabela-th {
    /* text-align: center; */
    font-size: 12px;
    text-transform: uppercase;
}

.align-tabela-td {
    /* text-align: center; */
    font-size: 12px;
    /* text-transform: uppercase; */
}
.overlay-new {
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    background-color: rgba(255, 255, 255, 0.8);
}
.info-box{
    cursor: pointer;
}

.overlay-new-content {
    position: absolute;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    top: 50%;
    left: 0;
    right: 0;
    text-align: center;
    color: #555;
}
.content-header > .breadcrumb > li + li::before {
    content: '\00a0' !important;
}
/* .swal2-question{
    display: block !important;
} */
.swal2-input {
    max-width: 15em !important;
}
</style>
<section class="content-header">
    <h1>Gerênciamento e Controle de Horas <small>Equipe Sistemas</small></h1>
    <ol class="breadcrumb">
      <li class="btn-mes-info"><button type="button" class="btn btn-box-tool btn-sm btn-default" data-toggle="popover" title="Mês de Apuração" data-placement="bottom" data-content="Todos os dados exibidos são do mês de <?=$mes;?> de <?= date('Y')?>."> <i class="fa fa-info-circle"></i> <?=$mes;?> de <?= date('Y')?></button></li>
      <li><button type="button" class="btn btn-box-tool btn-sm btn-default" data-toggle="modal" data-target="#modal-default"><i class="fa fa-calendar"></i> Meses</button></li>
      <li><button type="button" class="btn btn-box-tool btn-sm btn-default exportar" data-widget="collapse"><i class="glyphicon glyphicon-cloud-download"></i> Excel</button></li>
    </ol>
</section>
<div id="demandas">
<section class="content">
    <div class="row">
        <?php
        // print_r($demandas_por_funcao);
      if($demandas_por_funcao):
        $i = 0;
        foreach ($demandas_por_funcao as $key => $value):
        if($i == 0):
          $class_color = 'bg-aqua';
        elseif($i == 1):
          $class_color = 'bg-red';
        elseif($i == 2):
          $class_color = 'bg-green';
        elseif($i == 3):
          $class_color = 'bg-orange';
        else: 
          $class_color = 'bg-purple';
        endif;
        $total = explode(':',$value['Total']);
        $info_box_func = explode(' ',$value['Funcao']);
        
        if($i < 3):
            $info_box_func = explode(' ',$value['Funcao']);
            $info_box_func = substr(strtolower($info_box_func[3]),0,-1);
        else:
            $info_box_func = 'total';

        endif;
        // print_r($info_box_func);
        ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="overlay-new" style="display: none;margin: 0px 15px 15px 15px;"><div class="overlay-new-content"><img src="images/loading.gif"></div></div>
            <div class="info-box info-box-function" data-type="<?=$info_box_func;?>">
                <span class="info-box-icon <?= $class_color;?>"><i class="glyphicon glyphicon-time"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= $value['Funcao']?></span>
                    <span class="info-box-number number-info-box-<?=$i;?>"><?= $total[0].' Horas e '.$total[1].' Minutos'?><small></small></span>
                </div>
            </div>
        </div>

        <?php $i++; endforeach;
      endif;
      ?>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-8 equipe">
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
                                            'P629450','P639738','P646124',
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
                                            <img src="<?php echo base_url('images/FotosEquipe/Novas_Imagens/'.$value['MATRICULA'].'.png');?>" alt="User Image" width="60" height="60">
                                        <?php else: $data_foto = 'n';?>
                                            <img src="<?php echo base_url('images/no_image_user.png');?>" alt="User Image" width="60" height="60">
                                        <?php endif;?>
                                            <a class="users-list-name pointer nome_func "
                                                data-mat="<?= $value['MATRICULA']?>" data-foto="<?=$data_foto;?>" data-status="<?= $status_2;?>"><?=$nome[0].' '.$nome[$qtd_nome-1];?></a>
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
        </div>
        <div class="col-md-4" style="display: none;" id="detalhe-invidual">
          <div class="overlay-new" style="margin: 0px 15px 20px 15px;"><div class="overlay-new-content"><img src="images/loading.gif"></div></div>
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username nome-func-ind">-</h3>
                    <h5 class="widget-user-desc nome-funcao-ind">-</h5>
                </div>
                <div class="widget-user-image img-analista">
                    <img class="img-circle" src="<?php echo base_url('images/no_image_user.png');?>" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header hor-previsto">-</h5>
                                <span class="description-text">Previsto</span>
                            </div>
                        </div>
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header hor-realizada">-</h5>
                                <span class="description-text">Realizado</span>
                            </div>
                        </div>
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header hor-positivo">-</h5>
                                <span class="description-text">Positivo</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header hor-negativo">-</h5>
                                <span class="description-text">Negativo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 pull-right">
            <div class="overlay-new" style="display: none;margin: 0px 15px 20px 15px;"><div class="overlay-new-content"><img src="images/loading.gif"></div></div>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Relatório mensal de recapitulação</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center">
                                <strong>Evolução de Horas</strong>
                            </p>

                            <?php
                  if($demandas_por_funcao):
                    $i = 0;
                    foreach ($demandas_por_funcao as $key => $value):
                    if($i == 0):
                      $class_color_bar = 'aqua';
                    elseif($i == 1):
                      $class_color_bar = 'red';
                    elseif($i == 2):
                      $class_color_bar = 'green';
                    elseif($i == 3):
                      $class_color_bar = 'yellow';
                    else: 
                      $class_color_bar = 'aqua';
                    endif;
                    $total = explode(':',$value['Total']);
                    $totalFuncao = explode(':',$value['TotalPorFuncao']);

                    $tipo_funcao_bar = explode(' ',$value['Funcao']);
                    if($i < 3):
                        $tipo_funcao_bar = substr($tipo_funcao_bar[3],0,-1);
                    else:
                        $tipo_funcao_bar = 'total';
                    endif;
                    ?>
                            <div class="progress-group <?= $tipo_funcao_bar;?>">
                                <span class="progress-text"><?= strtoupper($value['Funcao'])?></span>
                                <span class="progress-number number-progress-<?=$i;?>"><b><?= $total[0].':'.$total[1];?></b>/<?= $totalFuncao[0].':'.$totalFuncao[1];?></span>

                                <div class="progress sm new-progress-bar<?=$i;?>" data-toggle="tooltip" data-placement="top" title="<?= $value['Percentual'].' Concluído'?>">
                                    <div class="progress-bar progress-bar-<?= $class_color_bar;?>" style="width: <?= $value['Percentual']?>"></div>
                                </div>
                            </div>
                            <?php $i++; endforeach;
                        endif;
                        ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<div class="overlay" style="display: none;margin: 0px 15px 15px 15px;"><div class="overlay-content"><img src="images/loading.gif"></div></div>
<div id="prospeccao" style="display: none;"></div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button> <h4 class="modal-title">Mês de Apuração</h4>
            </div>
            <div class="modal-header">
                <input type="text" class="form-control input-sm datepicker-my" style="text-align: center; font-size: 16px;" id="input_ano" name="input_ano" placeholder="Clique e selecione o ano" value="<?= date('Y');?>">
            </div>
            <div class="modal-body">
            <div class="overlay-new" style="display: none;margin: 0px 15px 20px 15px;"><div class="overlay-new-content"><img src="images/loading.gif"></div></div>
            <form>
                <div class="row pai-mes-apuracao">
                <?php
                $i = 1;
                foreach ($meses as $v) { $mes_atual = date('n'); if($mes_atual == $i): $marca_mes = 'bg-purple'; else: $marca_mes = ''; endif; ?>
                    <a class="btn btn-app mes-apuracao <?= $marca_mes;?>" data-mes="<?= $i;?>"> <i class="fa fa-calendar"></i> <?= $v;?> </a>
                <? $i++; } ?>
                </div>
                </div>
            </form>
            </div>
        </div>
        </div>
    <!-- </div> -->
<script>
    <?php include "demandas_ti.js"; ?>
</script>