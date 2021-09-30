<style>
    .hours-input{
        width : 53px !important;
       /* border : solid 1px black; */
    }
    /* td{
        border: solid 1px silver;
    }  */
    table{
        font-size: 13px;
        text-align: center;
        width : 100%;
    }
    th{
        text-align: center;
    }
    .odd{
        background-color: white;
    }
    .even{
        background-color: #f4f4f4;
    }
   
    .silver{
        background-color: silver;
    }

    .td-default{
        border: solid 1px silver;
        font-size: 12px;
    }
    .blue{
        background-color: lightblue;
    }

    .pausa2{
        background-color: #53C5FF;
    }

    .td-pausa{
        border: solid 1px lightblue;
    }

    .green{
        background-color: lightgreen;
    }

    .td-almoco{
        border: solid 1px lightgreen;
    }

    .orange{
        /* background-color: #f39c12; */
        background-color: #ffca6b;
    }

    .saida{
        background-color: #F28888
    }
    .tb-large{
        width: 1465px  !important;
    }
    .swal2-cancel{
        margin-right: 5px !important;
    }
    .swal2-content{
        font-size: 12px;
    }
    .swal2-title{
        font-size: 16px;

    }
    .indicador{
        background-color: #b8e1da;
    }
    .legenda{
        background-color: #b8e1da;
        padding: 3px;
        border-radius: 5px;
    }
</style>

<div class="box box-success">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title"><?php print_r($dados[0]['Matricula'].' - '.$dados[0]['Nome']);?></h4>     
        <?php if(!empty($dados)): $indicador = ''; foreach ($dados as $value): if($value['Indicador'] == 1): $indicador = 'exibir'; endif; endforeach; endif; ?>
        <?php if($indicador != ''):?>
        <div class="box-tools pull-right">
            <div data-toggle="tooltip" data-placement="top" title="Possível divergência no horário de pausas/almoço.">
                <div class="legenda"></div>
                <label class="btn btn-box-tool" style="cursor: default;">Horário Divergente</label>
            </div>
        </div>  
        <?php endif;?>
    </div>
    <div class="box-body">
        <?php if(!empty($dados)){ ?>
            <table id="table-result" class="table tb-large">
                <thead>
                    <tr>
                        <th colspan="2" class="silver">Folha de Ponto <i class="glyphicon glyphicon-time"></i></th>
                        <th colspan="3" class="blue">Entrada</th>
                        <th colspan="2" class="orange">Pausa 1 - Entrada </th>
                        <th colspan="2" class="orange">Pausa 1 - Saída</th>
                        <th colspan="2" class="green">Almoço - Entrada</th>
                        <th colspan="2" class="green">Almoço - Saída</th>
                        <th colspan="2" class="pausa2">Pausa 2 - Entrada</th>
                        <th colspan="2" class="pausa2">Pausa 2 - Saída</th>
                        <th colspan="3" class="saida">Saída</th>
                    </tr>

                    <tr>
                        <th class="silver" style="display:none;">Matrícula</th>
                        <th class="silver" style="display:none;">Nome</th>
                        <th class="silver">Ocorrência</th>
                        <th class="silver"> Data</th>
                        <th data-toggle="tooltip" title="Entrada Prevista" style="cursor:pointer;" class="blue">Prevista</th>
                        <th data-toggle="tooltip" title="Entrada Fato" style="cursor:pointer;" class="blue">Fato</th>
                        <th data-toggle="tooltip" title="Entrada Autorizada" style="cursor:pointer;" class="blue">Autorizada</th>
                        <th data-toggle="tooltip" title="Entrada Pausa 1" style="cursor:pointer;" class="orange">Fato</th>
                        <th data-toggle="tooltip" title="Entrada Autorizada Pausa 1" style="cursor:pointer;" class="orange" >Autorizada</th>
                        <th data-toggle="tooltip" title="Saída Pausa 1" style="cursor:pointer;" class="orange" >Fato</th>
                        <th data-toggle="tooltip" title="Saída Autorizada Pausa 1" style="cursor:pointer;" class="orange" >Autorizada</th>
                        <!-- <th data-toggle="tooltip" title="Entrada Prevista Almoço" style="cursor:pointer;" class="green" >Prevista</th> -->
                        <th data-toggle="tooltip" title="Entrada Fato Almoço" style="cursor:pointer;" class="green" >Fato</th>
                        <th data-toggle="tooltip" title="Entrada Autorizada Almoço" style="cursor:pointer;" class="green" >Autorizada</th>
                        <!-- <th data-toggle="tooltip" title="Saida Prevista Almoço" style="cursor:pointer;" class="orange" >Prevista</th> -->
                        <th data-toggle="tooltip" title="Saida Fato Almoço" style="cursor:pointer;" class="green" >Fato</th>
                        <th data-toggle="tooltip" title="Saida Autorizada Almoço" style="cursor:pointer;" class="green" >Autorizada</th>
                        <th data-toggle="tooltip" title="Entrada Pausa 2" style="cursor:pointer;" class="pausa2" >Fato</th>
                        <th data-toggle="tooltip" title="Entrada Autorizada Pausa 2" style="cursor:pointer;" class="pausa2" >Autorizada</th>
                        <th data-toggle="tooltip" title="Saída Pausa 2" style="cursor:pointer;" class="pausa2" >Fato</th>
                        <th data-toggle="tooltip" title="Saída Autorizada Pausa 2" style="cursor:pointer;" class="pausa2" >Autorizada</th>
                        <th data-toggle="tooltip" title="Saída Prevista" style="cursor:pointer;" class="saida" >Prevista</th>
                        <th data-toggle="tooltip" title="Saída Fato" style="cursor:pointer;" class="saida" >Fato</th>
                        <th data-toggle="tooltip" title="Saída Autorizada" style="cursor:pointer;" class="saida" >Autorizada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados as $row):
                            // verifica se o dia é futuro e desabilita os imputs da folha 
                            if( strtotime($row['dia']) > strtotime(date("Y-m-d")) ): $disabled = "disabled"; else: $disabled = null; endif; 
                    ?>
                    <?php if($row['Indicador'] == 1):  $class = 'indicador'; else:  $class = ''; endif; ?>
                        <tr class="<?= $class;?>">
                            <td class="td-default" style="display:none;"><?= $row['Matricula']; ?></td>
                            <td class="td-default" style="display:none;"><?= $row['Nome']; ?></td>
                            <td class="td-default"><?= $row['Descricao']; ?></td>

                            <td class="td-default"><?= date("d/m/Y",strtotime($row['dia'])); ?></td>
                            <td class="td-default"><?= $row['EntradaPrevista'] != null ? date("H:i", strtotime($row['EntradaPrevista'])) : "--:--";?></td>
                            <td class="td-default"><?= $row['EntradaFato'] != null ? date("H:i", strtotime($row['EntradaFato'])) : "--:--";?></td>
                            <td class="td-default"><input type="text" class="form-control input-sm hours-input timepicker" value="<?= $row['EntradaAutorizada'] != null ? date("H:i", strtotime($row['EntradaAutorizada'])) : "--:--";?>" <?= $disabled ?>></td>
                            <!-- <td><?= $row['MatriculaAutorizacaoEntrada'] ; ?></td> -->

                            <!-- pausa 1 !-->
                            <td class="td-default"><?= $row['EntradaPausa1'] != null ? date("H:i", strtotime($row['EntradaPausa1'])) : "--:--";?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['EntradaPausa1Autorizada'] != null ? date("H:i", strtotime($row['EntradaPausa1Autorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoEntradaPausa1']; ?></td> -->
                            <td class="td-default"><?= $row['SaidaPausa1'] != null ? date("H:i", strtotime($row['SaidaPausa1'])) : "--:--";?></td>
                            <td class="td-default"> 
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['SaidaPausa1Autorizada'] != null ? date("H:i", strtotime($row['SaidaPausa1Autorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoSaidaPausa1']; ?></td> -->


                            <!-- <td class="td-default"><?= $row['EntradaPrevistaAlmoco'] != null ? date("H:i", strtotime($row['EntradaPrevistaAlmoco'])) : "--:--"; ?></td> -->
                            <td class="td-default"><?= $row['EntradaAlmocoFato'] != null ? date("H:i", strtotime($row['EntradaAlmocoFato'])) : "--:--"; ?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['EntradaAlmocoAutorizada'] != null ? date("H:i", strtotime($row['EntradaAlmocoAutorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoEntradaAlmoco']; ?></td> -->
                            <!-- <td class="td-default"><?= $row['SaidaPrevistaAlmoco'] != null ? date("H:i", strtotime($row['SaidaPrevistaAlmoco'])) : "--:--"; ?></td> -->
                            <td class="td-default"><?= $row['SaidaAlmocoFato'] != null ? date("H:i", strtotime($row['SaidaAlmocoFato'])) : "--:--"; ?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['SaidaAlmocoAutorizada'] != null ? date("H:i", strtotime($row['SaidaAlmocoAutorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoSaidaAlmoco']; ?></td> -->
                             <!-- pausa 2 !-->
                             <td class="td-default"><?= $row['EntradaPausa2'] != null ? date("H:i", strtotime($row['EntradaPausa2'])) : "--:--";?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['EntradaPausa2Autorizada'] != null ? date("H:i", strtotime($row['EntradaPausa2Autorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoEntradaPausa2']; ?></td> -->
                            <td class="td-default"><?= $row['SaidaPausa2'] != null ? date("H:i", strtotime($row['SaidaPausa2'])) : "--:--";?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input" value="<?= $row['SaidaPausa2Autorizada'] != null ? date("H:i", strtotime($row['SaidaPausa2Autorizada'])) : "--:--"; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoSaidaPausa2']; ?></td> -->


                            <td class="td-default"><?= $row['SaidaPrevista'] != null ? date("H:i", strtotime($row['SaidaPrevista'])) : "--:--" ; ?></td>
                            <td class="td-default"><?= $row['SaidaFato'] != null ? date("H:i", strtotime($row['SaidaFato'])) : "--:--" ; ?></td>
                            <td class="td-default">
                                <input type="text" class="form-control input-sm hours-input saida_autorizada" value="<?= $row['SaidaAutorizada'] != null ? date("H:i", strtotime($row['SaidaAutorizada'])) : "--:--" ; ?>" <?= $disabled ?> >
                            </td>
                            <!-- <td><?= $row['MatriculaAutorizacaoSaida']; ?></td> -->
                          
                           

                            <!--<td><button class="btn btn-success btn-sm edit-ponto"><span class="glyphicon glyphicon-pencil"></span></button></td>!-->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <div class="pull-right" style="padding: 15px 0px 15px 0px;"><button class="btn btn-success" id="salvar" data-toggle="tooltip" style="cursor:pointer;" title="Salvar a folha do mês"><span class="fa fa-floppy-o"></span> Salvar Folha</button></div>
        <!-- modal de edição da folha !-->
        <div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_folha"></div>	
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
            "scrollY" : "450px",
            "scrollX" : true,
            // "fixedColumns": {
            //     "leftColumns": 4
            // },
            "ordering": false,
            "bPaginate": false,
            "bDestroy": true,
            "bFilter": false

        });


        $('#table-result_info').hide();
          
        $("#salvar").on("click",function(){
            var url = siteurl + "frequencia/setRegistroLoteFolha";
            var arr = new Array();
            $("#table-result tr:gt(0)").each(function(){
                var this_row = $(this);
                arr.push({
                    matricula: $.trim(this_row.find('td:eq(0)').text()),
                    data : $.trim(this_row.find('td:eq(3)').text()),
                    eAutorizada: $.trim(this_row.find('td:eq(6) input').val()),
                    eAutorizadaPausa1 : $.trim(this_row.find('td:eq(8) input').val()),
                    sAutorizadaPausa1 : $.trim(this_row.find('td:eq(10) input').val()),    
                    eAutorizadaAlmoco : $.trim(this_row.find('td:eq(12) input').val()),
                    sAutorizadaAlmoco : $.trim(this_row.find('td:eq(14) input').val()),
                    eAutorizadaPausa2 : $.trim(this_row.find('td:eq(16) input').val()),
                    sAutorizadaPausa2 : $.trim(this_row.find('td:eq(18) input').val()),
                    sAutorizada: $.trim(this_row.find('td:eq(21) input').val())
                });
            }); 
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
                        url : url, 
                        data : { arr } ,
                        dataType : "json", 
                        type : "POST",
                        beforeSend : function(){
                            $("#salvar").attr('disabled',true);
                        }
                    }).done(function(data){
                        if(data.tipo == true){
                            $("#salvar").attr('disabled',false);
                            $.toaster({
                                priority : "success", 
                                title : ceacr+" - CP", 
                                message : "Folha salva com sucesso",
                                settings: {'timeout': 5000 }
                            });   
                            $("#pesq_folha_func").trigger( "click" );
                        }else{
                            $("#salvar").attr('disabled',false);
                            $.toaster({
                                priority : "warning", 
                                title : ceacr+" - CP", 
                                message : "Ocorreu algum erro ao processar, tente novamente",
                                settings: {'timeout': 5000 }
                            });  
                        }
                    });
                    $(this).tooltip('hide');
                }/*else if(result.dismiss === Swal.DismissReason.cancel){/** resposta não
                    Toast2.fire(
                        'Operação Cancelada.',
                        'Não salvamos as alterações indicadas, assim você pode avaliar melhor o que precisa fazer!',
                        // '',
                        'error'
                    )
                }*/
            });
        });

    });
</script>