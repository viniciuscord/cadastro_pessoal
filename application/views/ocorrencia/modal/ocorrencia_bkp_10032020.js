$(document).ready(function(){
    $("#tipo_ocorr").on("change",function(){
        var tipo = $(this).val();
        var url = siteurl + "ocorrencia/getMotivos";
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { tipo : tipo },
            beforeSend: function(){
                $("#motivo_ocorr").addClass("loading-screen");
            },
            success: function(data) {
                //console.log(data);
                var option = "<option value=''>Selecione o motivo</option>";
                for(var i=0; i < data.length; i++ ){
                    //console.log(data[i].IdMotivo);
                    option = option + "<option value='"+data[i].IdMotivo+"'>"+data[i].Descricao+"</option>";
                    //console.log(option);   
                }
                $("#motivo_ocorr").html(option);
                $("#motivo_ocorr").removeClass("loading-screen");
            }
        });
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


    $("#coordenador_modal").on("change",function(){
        var coordenador = $(this).val();
        var url = siteurl + "frequencia/getSupervisoresFolhaSelect";
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { coordenador : coordenador },
            beforeSend: function(){
                $("#superior_modal").addClass("loading-screen");
            },
            success: function(data) {
                //console.log(data);
                var option = "<option value=''>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    //console.log(data[i].IdMotivo);
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    //console.log(option);   
                }
                $("#superior_modal").html(option);
                $("#superior_modal").removeClass("loading-screen");
            }
        });
    });

    $("#superior_modal").on("change",function(){

        var superior = $(this).val();
        var url = siteurl + "frequencia/getEmpregadosFolhaSelect"; 

        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { superior : superior },
            beforeSend: function(){
                $("#nome_modal").addClass("loading-screen");
            },
            success: function(data) {
                //console.log(data);
                var option = "<option value=''>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    //console.log(data[i].IdMotivo);
                    option = option + "<option value='"+data[i].MatriculaSCP+"'>"+data[i].Nome+"</option>";
                    //console.log(option);   
                }
                $("#nome_modal").html(option);
                $("#nome_modal").removeClass("loading-screen");
            }
        });

    });


    $("#salvar_ocorr").on("click",function(){
        if(formValida()){
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
                        var msg = "Ocorrência editada com sucesso!"; 
                        $.toaster({
                            priority : "success", 
                            title : "CEACR/BR - CP:", 
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
                            title : "CEACR/BR - CP:", 
                            message : msg,
                            settings: {'timeout': 5000 }
                        });
                        $("#salvar_ocorr").attr('disabled',false);
                    }
                }
            });
        }
    });

    function formValida(){   
        valid = true;
        // validação do campo nome 
        if($("#nome_modal").val()==""){
            valid = false;
            $("#nome_modal").css({'border-color': '#a94442'});
            $("#modal_nome_error").html("Selecione o(a) empregado(a)");
        }else{
            $("#nome_modal").css({'border-color': 'lightgrey'});
            $("#modal_nome_error").html('');
        } 

        if($("#motivo_ocorr").val() == ""){
            valid = false;
            $("#motivo_ocorr").css({'border-color': '#a94442'});
            $("#modal_motivo_error").html("Selecione o motivo");
        }else{
            $("#motivo_ocorr").css({'border-color': 'lightgrey'});
            $("#modal_motivo_error").html("");
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

});