$(document).ready(function() {
    $('#alternar').click(function() {
        if ($('#v_2_members').is(':visible')) {
            $('#v_2_members').fadeOut();
            $('#v_1_members').fadeIn();
        } else {
            $('#v_2_members').fadeIn();
            $('#v_1_members').fadeOut();
            $('#detalhe-invidual').slideUp();
        }
    });
    $(".datepicker-my").mask('0000',{placeholder: "Informe o ano Ex: 2000"}, {'translation':{ 0: { pattern: /[0-9*]/}}});
    $('.datepicker-my').datepicker({
        language:"pt-BR",
        view:"years",		
        minView:"years",
        dateFormat: 'yyyy',
        autoClose: true,
        // minDate: new Date(currentYear, currentMonth-1, currentDate),       
        // maxDate:new Date(),
        // monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
        // 'Jul','Ago','Set','Out','Nov','Dez']
    });
    $('.nome_func').on('click', function(){
        var mat = $(this).data('mat');
        var status_hora = $(this).data('status');
        var mes_padrao = $('#mes_param').val();
        var ano_padrao = $('#ano_param').val();
        $.ajax({
            type: "post",
            url: siteurl + "demandas/buscaHorasPorFuncionarioIndividual",
            data: {
                matricula: mat,
                status: status_hora,
                mes_padrao: mes_padrao,
                ano_padrao: ano_padrao
            },
            dataType: "json",
            beforeSend: function(){
                $('.overlay-new').show();
            },
            success: function (data) {
            //   console.log(data.status);
                var nome = data.reg.NOME.split(" ");
                var ultimo_nome = nome.length-1;
                var primeiro_nome = nome[0];
                var ultimo_nome = nome[ultimo_nome];
                var nome_compl = primeiro_nome+' '+ultimo_nome;
                $('.overlay-new').hide();
                $('.nome-func-ind').text(nome_compl);
                $('.nome-funcao-ind').text(data.reg.FUNCAO);
                $('.hor-previsto').text(data.reg.TOTALHORASMES);
                $('.hor-realizada').text(data.reg.TOTAL);
                
                $('#detalhe-invidual').slideDown();

                if(data.reg.FUNCAO == 'ANALISTA DE SISTEMAS JR.'){
                    $('.widget-user-header').addClass('bg-aqua-active').removeClass('bg-red-active').removeClass('bg-green-active');
                }else if(data.reg.FUNCAO == 'ANALISTA DE SISTEMAS PL.'){
                    $('.widget-user-header').addClass('bg-red-active').removeClass('bg-aqua-active').removeClass('bg-green-active');
                }else{
                    $('.widget-user-header').addClass('bg-green-active').removeClass('bg-aqua-active').removeClass('bg-red-active');
                }
                
                if(data.status == 1){
                    $('.hor-negativo').text(data.reg.HNEGATIVA).addClass('text-red');
                    $('.hor-positivo').text(data.reg.HEXTRA).removeClass('text-green');
                }else{
                    $('.hor-positivo').text(data.reg.HEXTRA).addClass('text-green');
                    $('.hor-negativo').text(data.reg.HNEGATIVA).removeClass('text-red');
                }
            }
        });
    });
    $(".exportar").on("click",function(){
        $("#form-excel").submit();
    });
    $('.info-box-function').click(function(){
        var type = $(this).data('type');
        dataFuncao(type);
    });
    $('.mes-apuracao').on('click',function(){
        var mes = $(this).data('mes');
        var ano = $('#input_ano').val();
        $('.pai-mes-apuracao').children().removeClass('bg-purple');
        $(this).addClass('bg-purple');

        $.ajax({
            type: "post",
            url: siteurl + "demandas",
            data: {
                mes: mes,
                ano: ano
            },
            beforeSend: function(){
                $('.overlay-new').show();
                $('#detalhe-invidual').slideUp();
            },
            dataType: "json",
            success: function (data) {
                // console.log(data);
                var i;
                var cont;
                var info_box = '';
                var progress_number = '';
                var hora = '';
                var min = '';
                var html_visao_1 = '';
                var html = '';
                var html_progress_bar = '';
                var color_bar = '';
                $('#mes_param').val(data.post);
                
                // informações por funcao ****************************************
                for (i = 0; i < data.demandas_por_funcao.length; i++){
                    info_box = '.number-info-box-'+i;
                    split = data.demandas_por_funcao[i].Total.split(':');
                    hora = split[0];
                    min = split[1];
                    $(info_box).text(hora+' Horas e '+min+' Minutos');
                }
                // fim informações por funcao ************************************

                // informações por funcao/barra de progresso ****************************************
                for (i = 0; i < data.demandas_por_funcao.length; i++){
                    if(i == 0){
                      color_bar = 'aqua';
                    }else if(i == 1){
                      color_bar = 'red';
                    }else if(i == 2){
                      color_bar = 'green';
                    }else if(i == 3){
                      color_bar = 'yellow';
                    }else{ 
                      color_bar = 'aqua';
                    }
                    progress_number = '.number-progress-'+i;
                    progress_bar = '<div class="progress-bar progress-bar-'+i+' progress-bar-'+color_bar+'" style="width:'+data.demandas_por_funcao[i].Percentual+'"></div>';
                    split = data.demandas_por_funcao[i].Total.split(':');
                    split_2 = data.demandas_por_funcao[i].TotalPorFuncao.split(':');
                    percentual = data.demandas_por_funcao[i].Percentual;
                    hora = split[0];
                    min = split[1];
                    hora_total = split_2[0]
                    min_total = split_2[1]
                    percentual = progress_bar[0]
                    $(progress_number).html(hora.bold()+':'+min.bold()+'/'+hora_total+':'+min_total);
                    html_progress_bar = '.new-progress-bar'+i;
                    $(html_progress_bar).html(progress_bar).attr('data-original-title', data.demandas_por_funcao[i].Percentual+' Concluído');
                }
                // fim informações por funcao/barra de progresso ************************************

                
                // atualiza btn de mes de referencia *****************************
                var html = '<button type="button" class="btn btn-box-tool btn-sm btn-default" data-toggle="popover" title="Mês de Apuração" data-placement="bottom" data-content="Todos os dados exibidos são do mês de '+data.mes+' de '+data.post_ano+'."> <i class="fa fa-info-circle"></i> '+data.mes+' de '+data.post_ano+'</button>';
                $('.btn-mes-info').html(html);
                $('.JR').show();
                $('.PL').show();
                $('.SR').show();
                $('.total').show();
                $('[data-toggle="popover"]').popover();
                // fim atualiza btn de mes de referencia *************************
                
                
                // informações por funcionário *********************************
                $.ajax({
                    type: "post",
                    url: siteurl + "demandas/buscaHorasPorFuncionarioView",
                    data: {
                        post_mes: data.post,
                        post_ano: data.post_ano
                    },
                    // dataType: "dataType",
                    success: function (response) {
                        $('.equipe').html(response);
                        $('.overlay-new').hide();
                        $.toaster({
                            priority : "success", 
                            title : ceacr+" - CP", 
                            message : "Dados carregados com sucesso",
                            settings: {'timeout': 3000 }
                        }); 
                    }
                });
                // fim informações por funcionário *****************************
            }
        });
    });
    function dataFuncao(type){
        if(type == 'jr'){
            $('.total').hide();
            $('.PL').hide();
            $('.SR').hide();
            $('.JR').show();

        }else if(type == 'pl'){
            $('.total').hide();
            $('.JR').hide();
            $('.SR').hide();
            $('.PL').show();

        }else if(type == 'sr'){
            $('.total').hide();
            $('.JR').hide();
            $('.PL').hide();
            $('.SR').show();
            
        }else{
            $('.JR').show();
            $('.PL').show();
            $('.SR').show();
            $('.total').show();
            
        }
    }
    $('[data-toggle="popover"]').popover();
});