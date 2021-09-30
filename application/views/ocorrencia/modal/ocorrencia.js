$(document).ready(function(){
    const Toast2 = Swal.mixin({
		customClass:{
			confirmButton: 'btn btn-sm btn-success',
			cancelButton: 'btn btn-sm btn-danger'
		},buttonsStyling: false
    });
    $("#tipo_ocorr").on("change",function(){
        var tipo = $(this).val();
        var contrato = '';
        if($('#contratos_modal').is(':visible')){
            contrato = $('#contratos_modal').val();
        }
        var url = siteurl + "ocorrencia/getMotivos";
        if(verificaTipoOcorrencia()){
            $.ajax({
                url : url, 
                type: "POST",
                dataType: "json",
                data : { 
                    tipo : tipo,
                    contrato : contrato
                },
                beforeSend: function(){
                    $('#motivo_ocorr').attr('disabled',true);
                    $('#motivo_ocorr').selectpicker('refresh');
                },
                success: function(data) {
                    //console.log(data);
                    var option = "<option value='' class='select_emp'>Selecione o motivo</option>";
                    for(var i=0; i < data.length; i++ ){
                        //console.log(data[i].IdMotivo);
                        option = option + "<option value='"+data[i].IdMotivo+"'>"+data[i].Descricao+"</option>";
                        //console.log(option);   
                    }
                    $("#motivo_ocorr").html(option);
                    $('#motivo_ocorr').attr('disabled',false);
                    $('.select_emp').remove();
                    $('#motivo_ocorr').selectpicker('refresh');
                }
            });
        }else{
            $(this).selectpicker('deselectAll');
        }
    });

    $("#motivo_ocorr").on("change", function(){
        // Se o motivo for LICENÇA MÉDICA habilita o input CID
       if($(this).val() == '6'){ 
           $("#input-cid").prop("disabled", false);
       }else{
           $("#input-cid").prop("disabled", true);
           $("#input-cid:text").val('');
       }
    });
    $("#contratos_modal").on("change",function(){
        var contrato = $(this).val();
        var url = siteurl + "ocorrencia/getCoordenadoresOcorrencia";
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { contrato : contrato },
            beforeSend: function(){
                $('#coordenador_modal').attr('disabled',true).selectpicker('refresh');
                $("#nome_modal").attr('disabled',true).selectpicker('refresh');
                $("#superior_modal").attr('disabled',true).selectpicker('refresh');
                $("#tipo_ocorr").selectpicker('deselectAll');
                $('#motivo_ocorr').html('').selectpicker('refresh');
            },
            success: function(data) {
                var option = "";
                for(var i=0; i < data.length; i++ ){
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                }
                $("#coordenador_modal").html(option).attr('disabled',false).selectpicker('refresh');
                $("#nome_modal").html('').attr('disabled',false).selectpicker('refresh');
                $("#superior_modal").html('').attr('disabled',false).selectpicker('refresh');
            }
        });
    });

    // carrega as opcoes do select Supervisor conoforme o Coordenador selecionado
    $("#coordenador_modal").on("change",function(){
        var coordenador = $(this).val();
        var url = siteurl + "frequencia/getSupervisoresFolhaSelect";
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { coordenador : coordenador },
            beforeSend: function(){
                $('#superior_modal').attr('disabled',true);
                $('#superior_modal').selectpicker('refresh');
            },
            success: function(data) {
                //console.log(data);
                var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    //console.log(data[i].IdMotivo);
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    //console.log(option);   
                }
                $("#superior_modal").html(option);
                $("#nome_modal").html('');
                $('#superior_modal').attr('disabled',false);
                $('.select_emp').remove();
                $('#superior_modal').selectpicker('refresh');
                $('#nome_modal').selectpicker('refresh');
            }
        });
    });

    // carrega as opções do multiselect Colaboradores conforme o Supervisor selecionado 
    $("#superior_modal").on("change",function(){
        var superior = $(this).val();
        var url = siteurl + "frequencia/getEmpregadosFolhaSelect"; 
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { superior : superior },
            beforeSend: function(){
                $('#nome_modal').attr('disabled',true);
                $('#nome_modal').selectpicker('refresh');
            },
            success: function(data) {
                var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                }
                $("#nome_modal").html(option);
                $('#nome_modal').attr('disabled',false);
                $('.select_emp').remove();
                $('#nome_modal').selectpicker('refresh');
            }
        });

    });


    $("#salvar_ocorr").on("click",function(){
        var url = "ocorrencia/validaMotivo";
        $.ajax({
            url : url,
            type : "POST",
            dataType : "json", 
            data : {
                motivo: $('#motivo_ocorr').val(),
            }
        }).done(function(data){
            if(data == true){
                gravaDados();
            }else{
                var dt = verificaDataMotivo();
                if(dt[0] == true){
                    if(dt[2] == 1){
                        mens(dt[1]);
                    }else if(dt[2] == 2){
                        mens(dt[1]);
                    }
                }else{
                    gravaDados();
                }
            }
        });
    
    });
    $("#editar_ocorr").on("click",function(){
    if(formValida()){
        Toast2.fire({
            title: 'Atenção!',
            text: 'Tem certeza que deseja atualizar os dados?',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: true,
        }).then((result) => {
            if(result.value){/* resposta sim*/
                    var url = "ocorrencia/setAlteracaoOcorrencia";
                    $.ajax({
                        url : url,
                        data : $("#formCadastroOcorrencia").serialize(),
                        type : "POST",
                        dataType : "json", 
                        beforeSend : function(){
                            $("#editar_ocorr").attr('disabled',true);
                        },
                        error : function(){
                            msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a ocorrência, tente novamente.</center></div>';
                            $("#alert-info").html(msg);
                            window.setTimeout(function () {//remove o alert do erro
                                $(".result").fadeTo(500, 0).slideUp(500, function () {
                                    $(this).remove();
                                });
                                }, 3000);
                            $("#editar_ocorr").attr('disabled',false);
                        },
                        success: function (data){
                        
                            if(data.length == 0){
                                var msg = "Operação realizada com sucesso!"; 
                                $.toaster({
                                    priority : "success", 
                                    title : ceacr+" - CP",
                                    message : msg,
                                    settings: {'timeout': 5000 }
                                });
                                $("#editar_ocorr").attr('disabled',false);
                                $("#modalOcorrencia").modal("hide");
                                $("#consultar").trigger("click");
                            }
                            else if(data.length == 1 ){
                                msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Já existe uma ocorrência lançada no período, favor realizar a exclusão ou edição antes de inserir uma nova!</center></div>';
                                $("#alert-info").html(msg);
                                window.setTimeout(function () {//remove o alert do erro
                                    $(".result").fadeTo(500, 0).slideUp(500, function () {
                                        $(this).remove();
                                    });
                                    }, 5000);
                                $("#editar_ocorr").attr('disabled',false);
                            }else{
                                var msg = "Não foi possível gravar as informações!"; 
                                $.toaster({
                                    priority : "danger", 
                                    title : ceacr+" - CP",
                                    message : msg,
                                    settings: {'timeout': 5000 }
                                });
                                $("#editar_ocorr").attr('disabled',false);
                            }
                        }
                    });
                }
            });
        }
    });
    function mens(mens){
        msg = '<br><div class="alert result alert-warning animated bounceIn col-md-auto btn-xs"><center><b>Atenção! </b>'+mens+'</center></div>';
        $("#alert-info").html(msg);
        window.setTimeout(function () {//remove o alert do erro
        $(".result").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
        }, 7000);
    }
    function gravaDados(){
        if(formValida()){
            Toast2.fire({
                title: 'Atenção!',
                text: 'Tem certeza que deseja salvar os dados informados?',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: true,
            }).then((result) => {
                if(result.value){/* resposta sim*/
                    var url = "ocorrencia/setCadastroOcorrencia";
                    $.ajax({
                        url : url,
                        data : $("#formCadastroOcorrencia").serialize(),
                        type : "POST",
                        dataType : "json", 
                        beforeSend : function(){
                            $("#salvar_ocorr").attr('disabled',true);
                        },
                        error : function(){
                            msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a ocorrência, tente novamente.</center></div>';
                            $("#alert-info").html(msg);
                            window.setTimeout(function () {//remove o alert do erro
                                $(".result").fadeTo(500, 0).slideUp(500, function () {
                                    $(this).remove();
                                });
                                }, 3000);
                            $("#salvar_ocorr").attr('disabled',false);
                        },
                        success: function (data){
                            
                            if(data.length == 0){
                                var msg = "Operação realizada com sucesso!"; 
                                $.toaster({
                                    priority : "success", 
                                    title : ceacr+" - CP",
                                    message : msg,
                                    settings: {'timeout': 5000 }
                                });
                                $("#salvar_ocorr").attr('disabled',false);
                                $("#modalOcorrencia").modal("hide");
                                $("#consultar").trigger("click");
                            }
                            else if(data.length == 1 ){
                                msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Já existe uma ocorrência lançada no período, favor realizar a exclusão ou edição antes de inserir uma nova!</center></div>';
                                $("#alert-info").html(msg);
                                window.setTimeout(function () {//remove o alert do erro
                                    $(".result").fadeTo(500, 0).slideUp(500, function () {
                                        $(this).remove();
                                    });
                                    }, 5000);
                                $("#salvar_ocorr").attr('disabled',false);
                            }else{
                                var msg = "Não foi possível gravar as informações!"; 
                                $.toaster({
                                    priority : "danger", 
                                    title : ceacr+" - CP",
                                    message : msg,
                                    settings: {'timeout': 5000 }
                                });
                                $("#salvar_ocorr").attr('disabled',false);
                            }
                        }
                    });
                }
            });
        }

    }
    function formValida(){   
        valid = true;
        // validação do campo nome 
        if($('#superior_modal').is(':visible')){
            if($("#superior_modal").val()=="" || $("#superior_modal").val() == null){
                valid = false;
                $("#superior_modal").css({'border-color': '#a94442'});
                $("#input_superv_modal_error").html("Selecione o(a) supervisor(a)");
            }else{
                $("#superior_modal").css({'border-color': 'lightgrey'});
                $("#input_superv_modal_error").html('');
            } 
        } 
        if($('#coordenador_modal').is(':visible')){
            if($("#coordenador_modal").val()=="" || $("#coordenador_modal").val() == null){
                valid = false;
                $("#coordenador_modal").css({'border-color': '#a94442'});
                $("#input_coordenador_modal_error").html("Selecione o(a) coordenador(a)");
            }else{
                $("#coordenador_modal").css({'border-color': 'lightgrey'});
                $("#input_coordenador_modal_error").html('');
            } 
        } 
        if($('#contratos_modal').is(':visible')){
            if($("#contratos_modal").val()=="" || $("#contratos_modal").val() == null){
                valid = false;
                $("#contratos_modal").css({'border-color': '#a94442'});
                $("#input_contrato_modal_error").html("Selecione o contrato!");
            }else{
                $("#contratos_modal").css({'border-color': 'lightgrey'});
                $("#input_contrato_modal_error").html('');
            } 
        }
        if($("#nome_modal").val()=="" || $("#nome_modal").val() == null){
            valid = false;
            $("#nome_modal").css({'border-color': '#a94442'});
            $("#modal_nome_error").html("Selecione o(a) empregado(a)");
        }else{
            $("#nome_modal").css({'border-color': 'lightgrey'});
            $("#modal_nome_error").html('');
        } 
        
        

        if($("#motivo_ocorr").val() == "" || $("#motivo_ocorr").val() == null){
            valid = false;
            $("#motivo_ocorr").css({'border-color': '#a94442'});
            $("#modal_motivo_error").html("Selecione o motivo");
        }else{
            $("#motivo_ocorr").css({'border-color': 'lightgrey'});
            $("#modal_motivo_error").html("");
        }
        
        if($("#tipo_ocorr").val() == "" || $("#tipo_ocorr").val() == null){
            valid = false;
            $("#tipo_ocorr").css({'border-color': '#a94442'});
            $("#modal_tipo_oc_error").html("Selecione o tipo de ocorrência!");
        }else{
            $("#tipo_ocorr").css({'border-color': 'lightgrey'});
            $("#modal_tipo_oc_error").html("");
        }
        // validação campo data início
        if($("#input-data-ini").val() ==""){
            valid = false;
            $("#input-data-ini").css({'border-color': '#a94442'});
            $("#input_data_ini_error").html("Data obrigatória");
        }else{
            /*if(verificaErroDataMenorHoje()){
                valid = false;
                $("#input-data-ini").css({'border-color': '#a94442'});
                $("#input_data_ini_error").html("Data menor ou igual que a atual");
            }else{*/
                $("#input-data-ini").css({'border-color': 'lightgrey'});
                $("#input_data_ini_error").html('');
            //}
        }
        // validação campo data fim 
        if($("#input-data-fim").val() ==""){
            valid = false;
            $("#input-data-fim").css({'border-color': '#a94442'});
            $("#input_data_fim_error").html("Data obrigatória");
        }else{
            if(verificaDiferDatas()){
                valid = false;
                $("#input-data-fim").css({'border-color': '#a94442'});
                $("#input_data_fim_error").html("Data fim menor que a início"); 
            }else{
                $("#input-data-fim").css({'border-color': 'lightgrey'});
                $("#input_data_fim_error").html('');
            }
        }
        // validação campo justificativa 
        if($("#justificativa").val().trim() == ""){
            valid = false;
            $("#justificativa").css({'border-color': '#a94442'});
            $("#justificativa_error").html("Justificativa obrigatória");
        }else{
            $("#justificativa").css({'border-color': 'lightgrey'});
            $("#justificativa_error").html("");
        }

        return valid;
    }

    /*function verificaErroDataMenorHoje(){
        var today = new Date(new Date().setHours(0,0,0,0));
        var parts = $("#input-data-ini").val().split('/');
        var mydate = new Date(parts[2], parts[1] - 1, parts[0]);
        if( Date.parse(mydate) <= Date.parse(today)){
            return true;
        }else{
            return false;
        }
    }*/

    function verificaTipoOcorrencia(){
        var valid = true;
        if($('#contratos_modal').is(':visible')){
            if($("#contratos_modal").val()=="" || $("#contratos_modal").val() == null){
                valid = false;
                $("#contratos_modal").css({'border-color': '#a94442'});
                $("#input_contrato_modal_error").html("Selecione o contrato!");
            }else{
                $("#contratos_modal").css({'border-color': 'lightgrey'});
                $("#input_contrato_modal_error").html('');
            } 

        }else{
            valid = true;

        }
        return valid;
    }

    function verificaDiferDatas(){
        var parts_ini = $("#input-data-ini").val().split('/');
        var parts_fim = $("#input-data-fim").val().split('/');

        data_ini = new Date(parts_ini[2], parts_ini[1] - 1, parts_ini[0]);
        data_fim = new Date(parts_fim[2], parts_fim[1] - 1, parts_fim[0]);

        if( Date.parse(data_fim) < Date.parse(data_ini)){
            return true;
        }else{
            return false;
        }
    }
    function verificaDataMotivo(){
        var parts_ini = $("#input-data-ini").val().split('/');
        var parts_fim = $("#input-data-fim").val().split('/');

        var data_atual = new Date();
        var mens = '';
        var val = false;
        var tipo = 0;
        
        data_ini = new Date(parts_ini[2], parts_ini[1] - 1, parts_ini[0]);
        data_fim = new Date(parts_fim[2], parts_fim[1] - 1, parts_fim[0]);
        
        if( Date.parse(data_fim) > Date.parse(data_ini)){
            mens = 'A DATA FIM não pode ser <b>maior</b> que a DATA INÍCIO para este tipo de motivo.';
            val = true;
            tipo = 1;
            var retorno = [val, mens, tipo];
            return retorno;
        }else if(Date.parse(data_ini) > Date.parse(data_atual)){
            mens = 'A DATA INÍCIO não pode ser <b>maior</b> que a DATA ATUAL para este tipo de motivo.';
            val = true;
            tipo = 2;
            var retorno = [val, mens, tipo];
            return retorno;
        }else{ 
            mens = '';
            val = false;
            tipo = 3;
            var retorno = [val, mens, tipo];
            return retorno;
        }
    }

    $(".input-cid").autocomplete({
        source: "./index.php/ocorrencia/autocomplete_cid",
        select: function (event, ui) {
            $(".ui-autocomplete").hide();
            $(this).val($.trim(ui.item.value.substr(8)));
        },
        minLength: 2
    });
    
    $(".datetimepicker").datetimepicker({
        timepicker:false,
        step:5,
        format:'d/m/Y',
        formatDate:'d/m/Y',
        scrollMonth : false,
        scrollInput : false,
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    });
    $('#contratos_modal').selectpicker({
        noneSelectedText: 'Selecione o(s) contrato(s)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });

    $('#coordenador_modal').selectpicker({
        noneSelectedText: 'Selecione o(a) coordenador(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });

    $('#superior_modal').selectpicker({
        noneSelectedText: 'Selecione o(a) supervisor(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });

    $('#nome_modal').selectpicker({
        noneSelectedText: 'Selecione o(a) empregado(a)',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });

    $('#tipo_ocorr').selectpicker({
        noneSelectedText: 'Selecione o tipo',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });

    $('#motivo_ocorr').selectpicker({
        noneSelectedText: 'Selecione o motivo',
        liveSearch: true,
        selectedTextFormat: '',
        noneResultsText: 'Nenhum resultado para {0}',
        // selectAllText: 'Marcar',
        // deselectAllText: 'Limpar',
        // actionsBox: true,
        liveSearchNormalize: true,
        styleBase: 'btn btn-sm',
        maxOptions: 1,
        // title: 'Selecione'
    });
});