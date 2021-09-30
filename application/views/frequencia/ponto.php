<style>
        .base {
            width: 185px;
            height: 185px;
            border-radius: 180px;
            position: relative;
            background-image: url("https://1.bp.blogspot.com/-yEovcKTuoC0/U5TrBtVCNyI/AAAAAAAA1pw/L1_u1P-GTNg/s1600/8.png");
            box-shadow: 5px 5px 20px #555;
            background-size:100%
        }

        .base .base-ponteiro {
            width: 185px;
            position: absolute;
            top: 50%;
            height: 2px;
            margin-top: -1px;
            transition: transform 1s;
            -webkit-transition: transform 1s;
        }
        .base .ponteiro-segundos > div {
            background-image:url("images/p_segundos.png");
            background-repeat:no-repeat;
            height: 7px;
            width: 88px;
            margin-right: 8px;/*sai do centro*/
            margin-left: 8px;/*sai do centro*/
            margin-top: -2px; /*posição pra idreita*/
            border-radius: 8px;
            box-shadow: 1px 1px 15px #333 ;
        }
        .base .ponteiro-minutos > div {
            background-image:url("images/p_minutos.png");
            background-repeat: no-repeat;
            height:8px;
            width: 88px;
            margin-left: 20px;
            margin-top: -2px;
            border-radius: 6px;
        }
        .base .ponteiro-horas > div {
            background-image:url("images/p_horas.png");
            background-repeat: no-repeat;
            height: 8px;
            width: 88px;
            margin-left: 30px;
            margin-top: -2px;
            border-radius: 6px;
        }

</style>

<div class="box box-primary">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <ul class="nav nav-tabs">
            <li class="active"><a href="#menu_ponto" data-toggle="tab" title="Registro de Ponto"><i class="fa fa-clock-o"></i></a></li>
            <li><a href="#menu_folha" data-toggle="tab" title="Folha de Ponto"><i class="fa fa-list"></i></a></li>
        </ul>
    </div>
    <div class="box-body" >
        <div class="tab-content">
            <input name="entradaFato" id="entradaFato" type="hidden" value="<?php if(isset($dados['EntradaFato'])) echo $dados['EntradaFato']; else echo ""; ?>" >
            <!-- aba de registro de ponto !-->
            <div id="menu_ponto" class="tab-pane fade in active">    
                <div class="panel panel-info">
                    <div class="panel-heading"><span class="fa fa-clock-o"></span> Registro de Ponto</div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <figure class="relogio">
                                        <div class="base">
                                            <div id="ph" class="base-ponteiro ponteiro-horas">
                                            <div></div>
                                            </div>
                                            <div id="pm" class="base-ponteiro ponteiro-minutos">
                                            <div></div>
                                            </div>
                                            <div id="ps" class="base-ponteiro ponteiro-segundos">
                                            <div></div>
                                            </div>
                                            <div class="decorador"></div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="col-lg-2">
                                    <h4>Horas: <span id="time_relogio"></span></h4>
                                    <?php if($dados['EntradaFato'] != null  && $dados['SaidaFato'] == null): ?>
                                        <h4>Horas trabalhadas: <span id="time_trabalhado"></span></h4>
                                    <?php endif; ?>
                                </div>
                                <?php //print_r($dados); ?>
                                <div class="col-lg-4">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item"><b>Nome:</b> <?= $dados['Nome']; ?></li>   
                                        <li class="list-group-item list-group-item"><b>Função:</b> <?= $dados['NomeFuncao']; ?></li>
                                        <li class="list-group-item list-group-item"><b>Superior:</b> <?= $dados['NomeSuperior']; ?></li>
                                    </ul>
                                </div>
                                <div class="col-lg-4">
                                    <ul class="list-group">   
                                        <li class="list-group-item"><b>Horário:</b> <?= date('H:i',strtotime($dados['HorarioInicio'])); ?> às <?php echo date('H:i',strtotime($dados['HorarioFim'])); ?></li>
                                        <li class="list-group-item"><b>Data:</b> <?= date('d/m/Y'); ?></li>
                                        <li class="list-group-item">
                                            <b>Entrada efetuada:</b>
                                            <?php if($dados['EntradaFato'] != null ): ?>
                                                <?= date("H:i",strtotime($dados['EntradaFato'])); ?>
                                            <?php endif; ?>
                                            <?php if($dados['SaidaFato'] != null ): $verificaPonto = 2;  ?>
                                                &nbsp;<b>Saída efetuada:</b> <?= date("H:i", strtotime($dados['SaidaFato'])); ?>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                    <?php if(!in_array($dados['IdFuncao'],$funcoes_bloqueadas)): ?>
                                        <?php if($verificaPonto == null ): ?>
                                                <button class="btn btn-success regponto pull-right" data-toggle="tooltip" id="1" title="Registrar Entrada">Registrar Entrada <span class="fa fa-hand-o-up"></span></button>
                                        <?php elseif($verificaPonto['VERIFICADOR'] == '1' ): ?>
                                                <button class="btn btn-danger regponto pull-right" id="2" data-toggle="tooltip" title="Registrar Saída">Registrar Saída <span class="fa fa-hand-o-down"></span></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- aba folha de ponto !-->
            <div id="menu_folha" class="tab-pane fade">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                        <label for="data">Período:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right datepicker-my" id="data" name="data" value="<?php echo date('m/Y'); ?>" >  
                            </div>
                            <span id="input_data_error" class="text-danger"></span>
                            <?php //print_r($total_parc); ?>
                        </div>
                        <div class="col-md-2"><br>
                            <button class="btn btn-success btn-sm" id="filtro_folha" data-toggle="tooltip" style="cursor:pointer; margin-left:-20px;" title="Pesquisar" style="margin-left:-20px;" ><span class="fa fa-search"></span></button>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="panel-heading"><span class="fa fa-list"></span> Folha de Frequência</div>
                                <div class="panel-body" id="tab_folha">
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
                                                    <td style="color:red;"><?= $row['Deb1'] != null &&   !in_array($dados['IdFuncao'],$funcoes_bloqueadas) ? '-'.$row['Deb1'] : '' ?></td>
                                                    <td style="color:green;"><?= $row['Cred'] != null && !in_array($dados['IdFuncao'],$funcoes_bloqueadas)  ? '+'.$row['Cred'] : '' ?></td>
                                                    <td><?= $row['MatriculaAutorizacaoSaida']; ?></td>
                                                    <td><?= $row['Descricao']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php if(!in_array($dados['IdFuncao'],$funcoes_bloqueadas)): ?>
                                    <div class="col-md-2 pull-right">
                                        <h4>Total do Mês: <?php if($total_parc['saldo'] == 'P') echo "<span style='color:green'>+"; else echo "<span style='color:red'>-"; echo $total_parc['total']; ?></span></h4>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- tab teste !-->
            <div class="tab-pane fade">
                
            </div>
        </div>
    </div>
</div>

<!-- Modal Ponto !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_ponto"></div>	


<script>

$(document).ready(function(){

	$("#data").mask("00/0000", { 'translation':{ 0: { pattern: /[0-9*]/ }}});

    var horaEntrada = $("input[name='entradaFato']").val();
    var f = new Date();    

    // função de eventos do relógio
    setInterval(function(){
        var d = new Date();    
        var time = moment(d).format('HH:mm:ss');

        var co = 360 / 60;
        var graus_seconds = co * d.getSeconds() + (co * 15);
        $(".ponteiro-segundos").css({
        "transform": "rotate(" +graus_seconds+ "deg)"
        });
        
        var co = 360 / 60;
        var graus_seconds = co * (m = d.getMinutes()) + (co * 15);
        
        $(".ponteiro-minutos").css({
        "transform": "rotate(" +graus_seconds+ "deg)"
        });    

        var co = 360 / 12;
        var graus_seconds = co * ( h = d.getHours()) + (co * 3);
        
        $(".ponteiro-horas").css({
        "transform": "rotate(" +graus_seconds+ "deg)"
        });    
        $("#time_relogio").html(time);
        if(horaEntrada != ""){
            // console.log(moment.utc(moment(d).diff(horaEntrada)));
            var time = moment.utc(moment(d).diff(horaEntrada)).format("HH:mm:ss");
            $("#time_trabalhado").html(time);
        }
    }, 500); // um pouco menos de um segundo
    
    $(".regponto").on("click",function(){
        var id = $(this).attr("id");
        var url = siteurl + "frequencia/setRegistroPonto";
        $.ajax({
            type: "POST",
            url: url,
            data: { id : id },
            async : false ,
            dataType: 'json',
            beforeSend: function (){
            },
            success: function (data){
                if(data.Verificador == '0' ){         
                    $.toaster({
                        priority : "success", 
                        title : ceacr+" - CP",  
                        message : "Registro efetuado com sucesso!",
                        settings: {'timeout': 5000 }
                    });
                    window.location.reload();
                }else{
                    window.location.reload();
                }
	       }
        });
    });

    $('.datepicker-my').datepicker({
        language:"pt-BR",
        view:"months",		
        minView:"months",
        dateFormat: 'mm/yyyy',
        autoClose: true,
        maxDate:new Date(),
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
    });

    $("#filtro_folha").on("click",function(){
        var periodo = $("#data").val();
        var url = siteurl + "frequencia/consultaFiltroFolha";
        $.ajax({
            type: "POST",
            url : url,
            dataType : "html",
            data : { periodo : periodo},
            beforeSend : function(){
                $("#filtro_folha").attr('disabled',true);
                $(".overlay").show();
            },
            success : function (data){
                $("#tab_folha").html(data);
                $("#filtro_folha").attr('disabled',false);
                $(".overlay").hide();

            }
        });

    });


});

</script>