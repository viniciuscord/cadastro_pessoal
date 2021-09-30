<style>
    .loading-screen{
        position : relative !important; 
    }
    .swal2-title{
        font-size: 14px !important;
    }
    .swal2-content{
        font-size: 12px !important;

    }
    .input-g{
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
    }
</style>
<script type="text/javascript" src="<?php echo base_url('js/fixedColumns.js');?>"></script>
<?php if($situacao == 4): $class_padrao = 'col-sm-3';  elseif($situacao == 1): $class_padrao = 'col-sm-2'; elseif($situacao == 3 || $situacao == 2): $class_padrao = 'col-sm-4';  else: $class_padrao = 'col-sm-3'; endif;?>
<div class="box box-primary">
    <div class="overlay" style="display:none;" ><div class="overlay-content"><img src="images/loading.gif"></div></div>	
    <div class="box-header with-border">        
        <h4 class="box-title">Controle de Ponto</h4>
        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
    </div>
    <div class="box-body">
        <div class="col-sm-12">
            <div class="row">
            <input type="hidden" id="fecha" value="<?= date('d/m/Y')?>">
                <form id="pesqFolha">
                    <?php 
                    if($situacao == 1): ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="contrato">Contratos:</label>
                                    <select class="form-control input-sm item" id="contrato" name="contrato" multiple>
                                        <?php foreach($contratos as $contrato): ?>
                                            <option value="<?= $contrato['IdContrato'] ?>"><?= $contrato['Contrato']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="input_contrato_error" class="text-danger"></span>              
                                </div>
                            </div>
                    <?php endif; ?>
                    <?php if($situacao == 4 || $situacao == 1): ?>
                            <div class="<?=$class_padrao;?>">
                                <div class="form-group">
                                    <label for="coordenador">Coordenador:</label>
                                    <select class="form-control input-sm item" id="coordenador" name="coordenador" multiple>
                                    <?php if(isset($coordenadores)):?>
                                        <?php foreach($coordenadores as $coordenador): ?>
                                            <option value="<?= $coordenador['MatriculaSCP'] ?>"><?= $coordenador['Nome']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </select>
                                    <span id="input_coordenador_error" class="text-danger"></span>              
                                </div>
                            </div>
                    <?php endif; ?>
                    <?php if($situacao == 1 || $situacao == 2 || $situacao == 3 || $situacao == 4): ?>
                            <div class="<?=$class_padrao;?>">
                                <div class="form-group">
                                    <label for="superior">Superior:</label>
                                    <select class="form-control input-sm item" id="superior" name="superior" multiple>
                                    <?php if(isset($superiores)):?>
                                        <?php foreach($superiores as $superior): ?>
                                            <option value="<?= $superior['MatriculaSCP'] ?>"><?= $superior['Nome']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </select>
                                    <span id="input_superv_error" class="text-danger"></span>              
                                </div>
                            </div>
                    <?php endif; ?>

                    <div class="<?=$class_padrao;?>">
                        <div class="form-group">
                            <label for="nome">Colaborador:</label>
                            <select class="form-control input-sm item" id="nome" name="nome" >
                                <?php foreach($empregados as $empregado): ?>
                                <option value="<?= $empregado['MatriculaSCP']; ?>"><?= $empregado['Nome']; ?></option>
                                <?php endforeach; ?>
                            </select>  
                            <span id="input_nome_error" class="text-danger"></span>              
                        </div> 
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="data">Mês:</label>
                            <div class="input-group">
                                <div class="input-group-addon bg-purple">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" class="form-control input-sm pull-right datepicker-my mask input-g" id="data" name="data" value="<?php echo date("m/Y"); ?>" >  
                            </div>
                            <span id="input_data_error" class="text-danger"></span>
                        </div>
                    </div>
                </form>
                <div class="col-sm-1">
                    <div class="form-group">
                        <br>
                        <button class="btn btn-primary btn-sm" data-toggle="tooltip" style="cursor:pointer;" id="pesq_folha_func" title="Pesquisar"><span class="fa fa-search"></span> Pesquisar</button>&nbsp;&nbsp;      
                    </div>
                </div>
            </div>
            <!-- <br><div id="div_folha_func"></div> -->
        </div>
    </div>
</div>

<div id="div_folha_func">

</div>


<!-- Modal Ponto !-->
<div class="modal fade modal-info" role="dialog" tabindex="1" id="modal_ponto"></div>	

<script>
    $(document).ready(function(){
        const Toast3 = Swal.mixin({
            customClass:{
                confirmButton: 'btn btn-sm btn-success',
                // cancelButton: 'btn btn-sm btn-danger'
            },buttonsStyling: true
        });
        var date = new Date();
    	var currentMonth = date.getMonth();
    	var currentDate = date.getDate();
	    var currentYear = date.getFullYear();
        $.ajax({
            type: "post",
            url: siteurl + "frequencia/validaDiaUtil",
            success: function (data) {
                var dia_util = 1;
                if(data == 'bloq'){
                    dia_util = 0;
                }
                $('.datepicker-my').datepicker({
                    language:"pt-BR",
                    view:"months",
                    minView:"months",
                    dateFormat: 'mm/yyyy',
                    autoClose: true,
                    minDate: new Date(currentYear, currentMonth-dia_util),       
                    maxDate: new Date(),
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
                });
            }
        });
        // $('.datepicker-my').datepicker({language:"pt-BR",view:"months",minView:"months",dateFormat: 'mm/yyyy',autoClose: true,maxDate:new Date(),monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']});
        $(".mask").mask('00/0000',{placeholder: "__/____"}, {'translation':{ 0: { pattern: /[0-9*]/}}});
        $("#pesq_folha_func").on("click", function(){
            // var data = $("#pesqFolha").serialize();
            // var url = siteurl + "frequencia/getFolhaFuncionario";
            if(formValida()){
                //console.log(data);
                $.ajax({
                    type: "post",
                    url: siteurl + "frequencia/validaDiaUtil",
                    data: {
                        data: '01/'+$('#data').val()
                    },
                    success: function (response) {
                        var mens = '';
                        var data = $("#pesqFolha").serialize();
                        if(response == 'bloq'){
                            $('#div_folha_func').empty();
                            mens = 'A folha do mês <b>'+$('#data').val()+'</b> encontra-se fechada.';
                            Toast3.fire(
                                'Data Inválida',
                                mens,
                                'error',
                                )
                            $("#data").val($("#fecha").val().substring(3));
                        }else{
                            $.ajax({
                                type : "POST",
                                data : data,
                                url : siteurl + "frequencia/getFolhaFuncionario",
                                dataType : 'html',
                                beforeSend : function(){
                                    $("#pesq_folha_func").attr('disabled',true);
                                    $(".overlay").show();
                                },
                                success: function (data){
                                    $("#div_folha_func").html(data);
                                    $("#pesq_folha_func").attr('disabled',false);
                                    $(".overlay").hide();
                                }
                            });
                        }
                    }
                });
            }
            $(this).tooltip('hide')
        });

        $("#ponto_dia_func").on("click", function(){
            var url = siteurl + "frequencia/viewModalPonto";
            $.ajax({
                type : "POST",
                url : url,
                dataType : 'html',
                beforeSend : function(){
                    $("#ponto_dia_func").attr('disabled',true);
                },
                success: function (data){
                    $("#modal_ponto").html(data);
                    $("#modal_ponto").modal("show");
                    $("#ponto_dia_func").attr('disabled',false);

                }
            });
            $(this).tooltip('hide')
        });

        $("#contrato").on("change",function(){
            var contrato = $(this).val();
            var url = siteurl + "frequencia/getConsultaCoordContPonto";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { contrato : contrato },
                beforeSend: function(){
                    $('#coordenador').attr('disabled',true).empty().selectpicker('refresh');
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#nome').attr('disabled',true).empty().selectpicker('refresh');
                    $('#div_folha_func').empty();
                },
                success: function(data) {
                    //console.log(data);
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#coordenador").html(option);
                    $('#coordenador').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#coordenador').selectpicker('refresh');
                }
            });
        });
        $("#coordenador").on("change",function(){
            var coordenador = $(this).val();
            var url = siteurl + "frequencia/getSupervisoresControlePonto";
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { coordenador : coordenador },
                beforeSend: function(){
                    $('#superior').attr('disabled',true).empty().selectpicker('refresh');
                    $('#nome').attr('disabled',true).empty().selectpicker('refresh');
                    $('#div_folha_func').empty();
                },
                success: function(data) {
                    //console.log(data);
                    var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                    for(var i=0; i < data.length; i++ ){
                        option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    }
                    $("#superior").html(option);
                    $('#superior').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#superior').selectpicker('refresh');
                }
            });
        });
    $("#superior").on("change",function(){
        var superior = $(this).val();
        var url = siteurl + "frequencia/getEmpregadosControleFolha"; 

        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { superior : superior },
            beforeSend: function(){
                $('#nome').attr('disabled',true).selectpicker('refresh');
                $('#div_folha_func').empty();
            },
            success: function(data) {
                //console.log(data);
                var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                }
                $("#nome").html(option);
                $('#nome').attr('disabled',false);
                $('.select_emp').remove();
                $('#nome').selectpicker('refresh');
            }
        });

    });
        // $('#data').on("change", function(){
        //     // var val = $(this).val();
        //     // var nome = 'data';
        //     // fechamentoFolha(val, nome);
        //     $('#div_folha_func').empty();
        // })
        // $('.bootstrap-select').selectpicker({
        //     noneSelectedText: 'Selecione o status',
        //     // liveSearch: true,
        //     selectedTextFormat: '',
        //     noneResultsText: 'Nenhum resultado para {0}',
        //     selectAllText: 'Marcar',
        //     deselectAllText: 'Limpar',
        //     actionsBox: true,
        //     liveSearchNormalize: true,
        //     // title: 'Selecione'
        // }); 

        $('#contrato').selectpicker({
        noneSelectedText: 'Selecione o contrato',
        liveSearch: true,
        styleBase: 'btn btn-sm',
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        maxOptions: 1,
        // title: 'Selecione'
    }); 

    $('#coordenador').selectpicker({
        noneSelectedText: 'Selecione o(a) coordenador(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        selectAllText: 'Marcar',
        deselectAllText: 'Limpar',
        actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm'
    });

        $('#superior').selectpicker({
        noneSelectedText: 'Selecione o(a) supervisor(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        selectAllText: 'Marcar',
        deselectAllText: 'Limpar',
        actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm'
    });

        $('#nome').selectpicker({
        noneSelectedText: 'Selecione o(a) colaborador(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm'
    });

    $('.dropdown-menu .inner').css('font-size','12px');
    $('.btn-default').addClass('btn-sm');
 
        function formValida(){
            valid = true;
            // validação do campo nome 
            if($("#nome").val()=="" || $("#nome").val()==null){
                valid = false;
                $("#nome").css({'border-color': '#a94442'});
                $("#input_nome_error").html("Selecione o(a) empregado(a)");
            }else{
                $("#nome").css({'border-color': 'lightgrey'});
                $("#input_nome_error").html('');
            } 
            if($('#coordenador').is(':visible')){
                if($("#coordenador").val()=="" || $("#coordenador").val()==null){
                    valid = false;
                    $("#coordenador").css({'border-color': '#a94442'});
                    $("#input_coordenador_error").html("Selecione o(a) empregado(a)");
                }else{
                    $("#coordenador").css({'border-color': 'lightgrey'});
                    $("#input_coordenador_error").html('');
                } 
            } 
            if($('#contrato').is(':visible')){
                if($("#contrato").val()=="" || $("#contrato").val()==null){
                    valid = false;
                    $("#contrato").css({'border-color': '#a94442'});
                    $("#input_contrato_error").html("Selecione o contrato");
                }else{
                    $("#contrato").css({'border-color': 'lightgrey'});
                    $("#input_contrato_error").html('');
                } 
            } 
            if($('#superior').is(':visible')){
                if($("#superior").val()=="" || $("#superior").val()==null){
                    valid = false;
                    $("#superior").css({'border-color': '#a94442'});
                    $("#input_superv_error").html("Selecione o(a) empregado(a)");
                }else{
                    $("#superior").css({'border-color': 'lightgrey'});
                    $("#input_superv_error").html('');
                } 
            }
            // validação campo data 
            if($("#data").val()==""){
                valid = false;
                $("#data").css({'border-color': '#a94442'});
                $("#input_data_error").html("Selecione o período");
            }else{
                $("#data").css({'border-color': 'lightgrey'});
                $("#input_data_error").html('');
            }

            return valid;
        }

    });
</script>