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
                // console.log(data);
                if(data.tipo == true ){
                    // msg = '<br><div class="alert result alert-success animated bounceIn col-md-auto btn-xs"><center>Escala registrada com sucesso.</center></div>';
                    // $("#alert-info").html(msg);
                    // window.setTimeout(function () {//remove o alert do erro
                    //     $(".result").fadeTo(500, 0).slideUp(500, function () {
                    //         $(this).remove();
                    //     });
                    //     }, 3000);
                        $.toaster({
                            priority: "success",
                            type: "modal",
                            title : "CEACR/BR - CP", 
                            message: "Escala registrada com sucesso.<br>",
                            settings : {'timeout': 5000} 
                        });
                        $("#salvar_escala").attr("disabled",false);
                        $('.modal').modal('hide');
                        $('#consultar').trigger('click');
                }else{
                    // console.log(data.matricula);
                    if(data.matricula == ""){
                        $.toaster({
                            priority: "danger",
                            type: "modal",
                            title : "CEACR/BR - CP", 
                            message: data.mensagem,
                            settings : {'timeout': 5000} 
                        });
                        $("#salvar_escala").attr("disabled",false);
                        $('.modal').modal('hide');
                        $('#consultar').trigger('click');
                    }else{
                        msg = '<br><div class="alert result alert-warning animated bounceIn col-md-auto btn-xs"><center>O colaborador <b>'+data.matricula+'</b> já possue escala cadastrada para esta data, favor verificar.</center></div>';
                        $("#alert-info").html(msg);
                        window.setTimeout(function () {//remove o alert do erro
                        $(".result").fadeTo(500, 0).slideUp(500, function () {
                            $(this).remove();
                        });
                        }, 5000);
                        $("#salvar_escala").attr("disabled",false);    

                    }
                }
                
            });
        }
    });

    function formValida(){
        valid = true;
        // validação do campo nome 
        if($("#funcao_modal").is(':visible')){
            if($("#funcao_modal").val() == "" || $("#funcao_modal").val() == null){
                valid = false;
                $("#nome_modal").css({'border-color': '#a94442'});
                $("#input_funcao_error").html("Selecione a função");
            }else{
                $("#nome_modal").css({'border-color': 'lightgrey'});
                $("#input_funcao_error").html('');
            } 
            if($("#superior_modal").val() == "" || $("#superior_modal").val() == null){
                valid = false;
                $("#nome_modal").css({'border-color': '#a94442'});
                $("#input_colaborador_error").html("Selecione o(a) colaborador(a)");
            }else{
                $("#nome_modal").css({'border-color': 'lightgrey'});
                $("#input_colaborador_error").html('');
            } 
            if($("#colaborador_modal").val() == "" || $("#colaborador_modal").val() == null){
                valid = false;
                $("#nome_modal").css({'border-color': '#a94442'});
                $("#input_subordinado_error").html("Selecione o(a) subordinado(a)");
            }else{
                $("#nome_modal").css({'border-color': 'lightgrey'});
                $("#input_subordinado_error").html('');
            } 
            
        }

        if($("#sup_modal").is(':visible')){
            if($("#sup_modal").val() == "" || $("#sup_modal").val() == null){
                valid = false;
                $("#nome_modal").css({'border-color': '#a94442'});
                $("#input_sup_error").html("Campo obrigatório");
            }else{
                $("#nome_modal").css({'border-color': 'lightgrey'});
                $("#input_sup_error").html('');
            } 

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
    $('#funcao_modal').multiselect({
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		filterPlaceholder: "Pesquisar",
		maxHeight: '300',
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: "Selecione",
        allSelectedText: "Todos",
        nSelectedText: "Selecionados",
        selectAllText: "Todos"
    });
    $('#superior_modal').multiselect({
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		filterPlaceholder: "Pesquisar",
		maxHeight: '300',
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: "Selecione",
        allSelectedText: "Todos",
        nSelectedText: "Selecionados",
        selectAllText: "Todos"
    });
    $('#sup_modal').multiselect({
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		filterPlaceholder: "Pesquisar",
		maxHeight: '300',
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: "Selecione",
        allSelectedText: "Todos",
        nSelectedText: "Selecionados",
        selectAllText: "Todos"
    });
    $('#colaborador_modal').multiselect({
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		filterPlaceholder: "Pesquisar",
		maxHeight: '300',
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: "Selecione",
        allSelectedText: "Todos",
        nSelectedText: "Selecionados",
        selectAllText: "Todos"
    });
    $("#funcao_modal").on("change",function(){
        var opt = $(this).val();
        var url = siteurl + 'escala/consultaSuperiorFuncao';		
        $.ajax({
            url : url,
            type : "POST",
            data : { funcao : opt },
            dataType : "json",
            beforeSend : function(){
                var data = [{ label: "Carregando", value: '1'}];
                $("#superior_modal.multiselect").multiselect('dataprovider',data);
                $("#superior_modal.multiselect").multiselect('select','1');
                $("#superior_modal.multiselect").multiselect('disable');

            },
            success : function(data) {
                if(data != ''){
                    $("#superior_modal.multiselect").multiselect('dataprovider',data);
                }else{
                    var data = [{ label: "Nenhum resultado encontrado", value: '1'}];
                    $("#superior_modal.multiselect").multiselect('dataprovider',data);
                    $("#superior_modal.multiselect").multiselect('select','1');
                }
            }
        });
    });
    $("#superior_modal").on("change",function(){
        var sup = $(this).val();
        var url = siteurl + 'escala/consultaColaboradorEscala';		
        $.ajax({
            url : url,
            type : "POST",
            data : { superior : sup },
            dataType : "json",
            beforeSend : function(){
                var data = [{ label: "Carregando", value: '1'}];
                $("#colaborador_modal.multiselect").multiselect('dataprovider',data);
                $("#colaborador_modal.multiselect").multiselect('select','1');
                $("#colaborador_modal.multiselect").multiselect('disable');

            },
            success : function(data) {
                if(data != ''){
                    $("#colaborador_modal.multiselect").multiselect('dataprovider',data);
                }else{
                    var data = [{ label: "Nenhum resultado encontrado", value: '1'}];
                    $("#colaborador_modal.multiselect").multiselect('dataprovider',data);
                    $("#colaborador_modal.multiselect").multiselect('select','1');
                }
            }
        });
    });
    
});