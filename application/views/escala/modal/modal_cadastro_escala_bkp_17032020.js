$(document).ready(function(){
    $("#salvar_escala").on("click",function(){
        var url = siteurl + "escala/cadastrarEscala";
        if(formValida()){
            $.ajax({
                url : url, 
                type : "POST",
                dataType : "json", 
                data : $("#formModalEscala").serialize(),
                beforeSend : function(){
                    $("#salvar_escala").attr("disabled",true);
                },
                error : function(){
                    msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a escala, tente novamente.</center></div>';
                    $("#alert-info").html(msg);
                    window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 3000);
                    $("#salvar_escala").attr("disabled",false);
                }
            }).done(function(data){
                if(data == null ){
                    msg = '<br><div class="alert result alert-success animated bounceIn col-md-auto btn-xs"><center>Escala registrada com sucesso.</center></div>';
                    $("#alert-info").html(msg);
                    window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 3000);
                }else{
                    msg = '<br><div class="alert result alert-warning animated bounceIn col-md-auto btn-xs"><center>'+data.Escala+'</center></div>';
                    $("#alert-info").html(msg);
                    window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 3000);
                }
                $("#salvar_escala").attr("disabled",false);
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
        // validação do campo horário
        if($("#input-data").val() == ""){
            valid = false;
            $("#input-data").css({'border-color': '#a94442'});
            $("#input_data_error").html("Data obrigatória");
        }else{
            if(verificaErroDataMenor()){
                valid = false;
                $("#input-data").css({'border-color': '#a94442'});
                $("#input_data_error").html('Data menor ou igual que o dia atual');
            }else{
                $("#input-data").css({'border-color': 'lightgrey'});
                $("#input_data_error").html('');
            }
        }

        // validação do campo horário entrada
        if($("#input-hr-ini").val() == ""){
            valid = false;
            $("#input-hr-ini").css({'border-color': '#a94442'});
            $("#input_hr_ini_error").html("Entrada obrigatória");
        }else{
            $("#input-hr-ini").css({'border-color': 'lightgrey'});
            $("#input_hr_ini_error").html('');
        }
        // validação do campo horário saída 
        if($("#input-hr-said").val() == ""){
            valid = false;
            $("#input-hr-said").css({'border-color': '#a94442'});
            $("#input_hr_said_error").html("Saída obrigatória");
        }else{
            $("#input-hr-said").css({'border-color': 'lightgrey'});
            $("#input_hr_said_error").html('');
        }

        // validação do campo justificativa
        if($("#justificativa").val().trim() == ""){
            valid = false;
            $("#justificativa").css({'border-color': '#a94442'});
            $("#justificativa_error").html("Justificativa obrigatória");
        }else{
            $("#justificativa").css({'border-color': 'lightgrey'});
            $("#justificativa_error").html('');
        }

        return valid;
    }

    function verificaErroDataMenor(){
        var today = new Date(new Date().setHours(0,0,0,0));
        var parts = $("#input-data").val().split('/');
        var mydate = new Date(parts[2], parts[1] - 1, parts[0]);
        if( Date.parse(mydate) <= Date.parse(today)){
            return true;
        }else{
            return false;
        }
    }

    // datepicker do campo data 
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