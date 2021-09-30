<?php if($dados):?>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalhes da Prospecção</h3>
                </div>
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                        src="<?php echo base_url('images/no_image_user.png');?>" alt="User Image" width="50"
                        height="50">

                    <h3 class="profile-username text-center">Equipe com <?= $dados[0]['QTDANALISTAS'];?> analistas</h3>

                    <!-- <p class="text-muted text-center">Obs: As informações apresentadas são apenas ilustrativas, utilizadas apenas para montar uma prospecção com base nos dados informados.</p> -->
                    <p class="text-muted text-center">Resumo da Prospecção</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Período de Prospecção</b> <a class="pull-right"><?= $mes?> de <?= $ano?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Horas por Analista</b> <a class="pull-right"><?= $dados[0]['QTDHORASANALISTAS'];?></a>
                        </li>
                        <!-- <li class="list-group-item">
                            <b>Horas Contrato</b> <a class="pull-right"><?= $dados[0]['HORASCONTRATO'];?></a>
                        </li> -->
                    </ul>

                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Horas da Prospecção</h3>
                </div>
                <div class="box-body box-profile" style="padding-bottom: 105px;">
                    <!-- ./col -->
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= $dados[0]['HORASCONTRATO'];?><sup style="font-size: 20px"></sup></h3>

                                <p>Horas Contrato</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a> -->
                        </div>
                    </div>
                    <!-- ./col -->
                  
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3><?= $dados[0]['QTDHORASMES'];?></h3>

                                <p>Quantidade de Horas Projetadas</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a> -->
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?= $dados[0]['CREDITO/DEBITO'];?></h3>

                                <p>Crédito / Débito</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <!-- <a href="#" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a> -->
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
                <div class="box-footer with-border">
                    <p class="text-muted text-left">Obs: As informações apresentadas são apenas ilustrativas, utilizadas apenas para montar uma prospecção com base nos dados informados.</p>
                    <!-- <h3 class="box-title">Horas da Prospecção</h3> -->
                </div>
            </div>
        </div>
    </div>
    <?php else:?>
    <div class="alert alert-warning animated bounceIn col-sm-auto">Nenhum cadastro encontrado com os parâmetros
        informados.</div>
    <?php endif;?>
</section>
<script>

</script>