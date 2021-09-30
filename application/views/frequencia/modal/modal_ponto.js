$(document).ready(function(){
    $("#opcao").on("change",function(){
        $("#input-hr").val('');
    });
    $("#salvar_dia").on("click",function(){
        var valid = formValida();
        if(valid){
            var data = $("#form-alt-ponto-dia").serialize();
            var url = siteurl + "frequencia/setRegistraPontoDiaADM"; 
            $.ajax({
                url : url, 
                type : "POST",
                data : data,
                dataType : 'json',
                beforeSend : function(){
                    $("#salvar_dia").attr('disabled',true);
                },
                error : function(){
                    msg = '<br><div class="alert result alert-danger animated bounceIn col-md-auto btn-xs"><center>Não foi possível inserir a escala, tente novamente.</center></div>';
                    $("#alert-info").html(msg);
                    window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 3000);
                    $("#salvar_dia").attr("disabled",false);
                },
                success: function (data){
                    if(data == '0'){
                        msg = '<br><div class="alert result alert-warning animated bounceIn col-md-auto btn-xs"><center>Ponto de entrada ainda não registrado.</center></div>';
                        $("#alert-info").html(msg);
                        window.setTimeout(function () {//remove o alert do erro
                            $(".result").fadeTo(500, 0).slideUp(500, function () {
                                $(this).remove();
                            });
                            }, 3000);
                    }else{
                        msg = '<br><div class="alert result alert-success animated bounceIn col-md-auto btn-xs"><center>Ponto registrado com sucesso.</center></div>';
                        $("#alert-info").html(msg);
                        window.setTimeout(function () {//remove o alert do erro
                            $(".result").fadeTo(500, 0).slideUp(500, function () {
                                $(this).remove();
                            });
                            }, 3000);
                    }   
                    $("#salvar_dia").attr('disabled',false);
                    //$("#pesq_folha_func").trigger( "click" );
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
            $("#nome_modal_error").html("Selecione o(a) empregado(a)");
        }else{
            $("#nome_modal").css({'border-color': 'lightgrey'});
            $("#nome_modal_error").html('');
        } 
        // validação do campo horário
        if($("#input-hr").val() == ""){
            valid = false;
            $("#input-hr").css({'border-color': '#a94442'});
            $("#input_hr_error").html("Prencha o horário");
        }else{
            $("#input-hr").css({'border-color': 'lightgrey'});
            $("#input_hr_error").html('');
        }
        return valid;
    }

})