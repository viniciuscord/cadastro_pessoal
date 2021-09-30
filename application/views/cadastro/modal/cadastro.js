$(document).ready(function(){
	$('.tabs').click(function(){
		var type = $(this).data('type');
		// alert(type);
		if(type == 'green'){
			$(this).addClass('active-green');
			// $('.guia').addClass('tab-green');
			// $('.guia').removeClass('tab-orange');
			// $('.guia').removeClass('tab-blue');
			$('.tb1').removeClass('active');
			$('.tb1').removeClass('active-blue');
			$('.tb3').removeClass('active-orange');
		}else if(type == 'blue'){
			$(this).addClass('active-blue');
			// $('.guia').addClass('tab-blue');
			// $('.guia').removeClass('tab-green');
			// $('.guia').removeClass('tab-orange');
			$('.tb1').removeClass('active');
			$('.tb3').removeClass('active-orange');
			$('.tb2').removeClass('active-green');
		}else{
			$(this).addClass('active-orange');
			// $('.guia').addClass('tab-orange');
			// $('.guia').removeClass('tab-green');
			// $('.guia').removeClass('tab-blue');
			$('.tb1').removeClass('active');
			$('.tb1').removeClass('active-blue');
			$('.tb2').removeClass('active-green');
		}
	});
	// $('.tabs').hover(function(){
	// 	$(this).children().addClass('tabs-hover');
	// },function(){
	// 	$(this).children().removeClass('tabs-hover');

	// });
	const Toast2 = Swal.mixin({
		customClass:{
			confirmButton: 'btn btn-sm btn-success',
			cancelButton: 'btn btn-sm btn-danger'
		},buttonsStyling: false
    });
	const Toast3 = Swal.mixin({
		customClass:{
			confirmButton: 'btn btn-sm btn-success',
			// cancelButton: 'btn btn-sm btn-danger'
		},buttonsStyling: true
    });
    
	$( "#input-matri-super").selectpicker({
		noneSelectedText: 'Selecione o(a) supervisor(a)',
		liveSearch: true,
		selectedTextFormat: '',
		noneResultsText: 'Nenhum resultado para {0}',
		selectAllText: 'Marcar',
		deselectAllText: 'Limpar',
		// actionsBox: true,
		liveSearchNormalize: true,
		styleBase: 'btn btn-sm',
		maxOptions: 1
		// title: 'Selecione'
	});
	$( ".select-pk").selectpicker({
		// noneSelectedText: 'Selecione o(a) supervisor(a)',
		liveSearch: true,
		selectedTextFormat: '',
		noneResultsText: 'Nenhum resultado para {0}',
		selectAllText: 'Marcar',
		deselectAllText: 'Limpar',
		// actionsBox: true,
		liveSearchNormalize: true,
		styleBase: 'btn btn-sm',
		maxOptions: 1
		// title: 'Selecione'
	});
	$( ".select-empresa-funcao").selectpicker({
		noneSelectedText: 'Selecione',
		liveSearch: true,
		selectedTextFormat: '',
		noneResultsText: 'Nenhum resultado para {0}',
		selectAllText: 'Marcar',
		deselectAllText: 'Limpar',
		// actionsBox: true,
		liveSearchNormalize: true,
		styleBase: 'btn btn-sm',
		maxOptions: 1
		// title: 'Selecione'
	});
	$("#input-empresa").on("change",function(){
        var empresa = $(this).val();
		var url = siteurl + "cadastro/getContratoEmpresa";
		// alert(empresa);
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { empresa : empresa },
            beforeSend: function(){
				$('#input-contrato').attr('disabled',true).empty().selectpicker('refresh');
				$('#input-matri-super').attr('disabled',true).empty().selectpicker('refresh');
            },
            success: function(data) {
                var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.length; i++ ){
                    option = option + "<option value='"+data[i].IdContrato+"'>"+data[i].Contrato+"</option>";
                }
                $("#input-contrato").html(option);
                $('#input-contrato').attr('disabled',false);
                $('.select_emp').remove();
                $('#input-contrato').selectpicker('refresh');
                $('#input-func-empregado').html('');
                $('#input-func-empregado').selectpicker('refresh');
            }
        });
    });
	$("#input-contrato").on("change",function(){
        var funcao = $(this).val();
		var url = siteurl + "cadastro/getContratoFuncao";
		// alert(empresa);
        $.ajax({
            url : url, 
            type: "POST",
            dataType: "json",
            data : { funcao : funcao },
            beforeSend: function(){
                $('#input-func-empregado').attr('disabled',true).empty().selectpicker('refresh');
                $('#input-matri-super').attr('disabled',true).empty().selectpicker('refresh');
            },
            success: function(data) {
                var option = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.funcao.length; i++ ){
                    option = option + "<option value='"+data.funcao[i].IdFuncao+"'>"+data.funcao[i].NomeFuncao+"</option>";
				}
				
                var option_sup = "<option value='' class='select_emp'>Selecione o empregado</option>";
                for(var i=0; i < data.superior.length; i++ ){
                    option_sup = option_sup + "<option value='"+data.superior[i].Matricula+"'>"+data.superior[i].SUPERVISOR+"</option>";
                }

				$("#input-func-empregado").html(option);
                $('#input-func-empregado').attr('disabled',false);
                $('.select_emp').remove();
				$('#input-func-empregado').selectpicker('refresh');
				

                $("#input-matri-super").html(option_sup);
                $('#input-matri-super').attr('disabled',false);
                $('.select_emp').remove();
                $('#input-matri-super').selectpicker('refresh');
            }
        });
    });
	$('#mat').change(function(){
		$.toaster({
			priority : "warning", 
			title : ceacr+" - CP", 
			message : 'O valor do campo MATRÍCULA não pode ser alterado.',
			settings: {'timeout': 5000 }
		});
		$(this).val($('#input-matricula').val());
		$(this).attr('disabled','disabled');
	});
	$('.btn-copy').click(function(){
		$('#mat').select();
		var successful = document.execCommand('copy');
		var type_alert = '';
		var mens = '';
		if(successful){
			type_alert = 'info';
			mens = 'Matrícula copiada. Disponível na área de transferência.';
		}else{
			type_alert = 'danger';
			mens = 'Infelizmente não foi possível copiar a matrícula.';

		}
		$.toaster({
			priority : type_alert, 
			title : ceacr+" - CP", 
			message : mens,
			settings: {'timeout': 5000 }
		});
	});
	// máscaras 
	$("#input-hr-ini").mask('00:00', { placeholder: "__:__"} );
	$("#input-hr-fim").mask('00:00', { placeholder: "__:__"} );

	//$("#input-hr-fim").mask(maskBehavior, spOptions);
	$("#input-hr-alm-ini").mask('00:00', {placeholder: "__:__"});
	$("#input-hr-alm-fim").mask('00:00', {placeholder: "__:__"});
	$("#input-cpf").mask("000.000.000-00", { 'translation':{ 0: { pattern: /[0-9*]/ }}});
	$("#input-cep").mask("00000-000", { 'translation':{ 0: { pattern: /[0-9*]/ }}});
	$("#input-tel").mask("(00)000000000", { 'translation':{ 0: { pattern: /[0-9*]/}}, placeholder: "(__)_________"});
	$("#input-tel-op").mask("(00)000000000", { 'translation':{ 0: { pattern: /[0-9*]/}}, placeholder: "(__)_________"} );

    $("#salvar").on("click",function(){
		var url = siteurl + "cadastro/salvar_cadastro";
		$('.bloq-campos').removeAttr('disabled');
		var datastring = $("#form-formulario").serializeArray();
		var retorno = validateFormCadastro(datastring);

		if(retorno == '' ){
			var cpf = $("#input-cpf").val();
			var contrl = $("#input-contr-cadastro").val();
			var msg;
			var msg_confirm;
			if(contrl == 1 ){
				msg = "Dados atualizados com sucesso!";
				msg_confirm = "Tem certeza que deseja atualizar os dados?";
			}else{
				msg = "Usuário inserido com sucesso!";
				msg_confirm = "Tem certeza que deseja salvar os dados informados?";
			}
			Toast2.fire({
				title: 'Atenção!',
				text: msg_confirm,
				showCancelButton: true,
				confirmButtonText: 'Sim',
				cancelButtonText: 'Não',
				reverseButtons: true,
			}).then((result) => {

				if(result.value){/* resposta sim*/
					$.ajax({
						url : url, 
						type : "POST",
						data : datastring,
						error : function(jqXHR,exception){
							alert("Ocorreu um erro ao inserir o registro!");
						},
						success: function (data){
							$.toaster({
								priority : "success", 
								title : ceacr+" - CP", 
								message : msg,
								settings: {'timeout': 5000 }
							});
							$("#modalCadastro").modal("hide");
						}
					});
				}else{
					$('.bloq-campos').attr('disabled',true).selectpicker('refresh');
				}
			});
			
		}
		
    });

	$(".input-banco-nome").autocomplete({
        source: "./index.php/cadastro/autocomplete_banco",
        select: function (event, ui) {
			$(".ui-autocomplete").hide();
            $(this).val($.trim(ui.item.value.substr(8)));
        },
        minLength: 2
	});

	$(".input-unidade-nome").autocomplete({
		source: "./index.php/cadastro/autocomplete_unidades",
        select: function (event, ui) {
			$(".ui-autocomplete").hide();
            $(this).val($.trim(ui.item.value.substr(8)));
        },
        minLength: 2
	});

	$(".input-cid").autocomplete({
		source: "./index.php/cadastro/autocomplete_cid",
        select: function (event, ui) {
			$(".ui-autocomplete").hide();
            $(this).val($.trim(ui.item.value.substr(8)));
        },
        minLength: 2
	});
	
	$(".input-fila").autocomplete({
		source: "./index.php/cadastro/autocomplete_fila",
        select: function (event, ui) {
			$(".ui-autocomplete").hide();
            $(this).val($.trim(ui.item.value.substr(8)));
        },
        minLength: 2
	});

	$("#input-filhos").change(function(){
		var opt = $(this).children("option:selected").val();
		if(opt == 1 ){ // se for SIM 
			$("#div_qtd_filhos").show();
		}else{ // se for NAO
			$("#div_qtd_filhos").hide();
			$("#input-qtd-filhos").val('');
		}
	});

	$("#input-uf").change(function(){
		var opt = $(this).children("option:selected").html();	
		//alert(opt);
	});

	$("#input-cep").change(function(){
		var value = $(this).val();
		if(value.length > 7){
			// prepara os dados para o webservice do CEP 
			var url = 'https://viacep.com.br/ws/'+value+'/json';
			$.ajax({
				url : url,
				type : "GET",
				dataType : "json",
				success : function(data){
					if(data.cep){
						$("#input-endereco").val(data.logradouro);
						$("#input-complemento").val(data.complemento);
						$("#input-uf option[value="+data.uf+"]").prop('selected',true);
						$("#input-cidade").val(data.localidade);
						$("#input-bairro").val(data.bairro);
					}
				}
			});
		}
	});

	
	
    $(".datetimepicker").datetimepicker({
		timepicker:false,
		step:5,
		format:'d/m/Y',
		maxDate: '0',
		formatDate:'d/m/Y',
		scrollMonth : false,
		scrollInput : false,
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	});
	$('#input-qtd-filhos').on('blur', function(){
		var qtd_filhos = $(this).val();
		if(qtd_filhos == 0 || qtd_filhos == ''){
			$('#div_qtd_filhos').hide();
			$(this).val('');
			var option = '<option value="">Selecione</option><option value="1">SIM</option><option value="2" selected>NÃO</option>';
			$('#input-filhos').empty();
			$('#input-filhos').html(option);
			$('#input-filhos').selectpicker('refresh');

		}
	});
	desabilitaCampos();
	$('#input-dt-nascim').on('blur', function(){
		verificaDataNasc($(this).val());
	});
	$('.btn-mais').click(function(){
		qtdFilhosMais();
	});
	$('.btn-menos').click(function(){
		qtdFilhosMenos();
	});
	function verificaDataNasc(dt){
        var parts_ini = dt.split('/');
		var ano = parseInt(parts_ini[2]);
		var idade = new Date().getFullYear() - ano;
		if(dt != ""){
			if(idade < 18){
				Toast3.fire(
					'Atenção! Verifique a Data de Nascimento.',
					'De acordo com a data informada o colaborador possui <b style="color: #f56954;">'+idade+' anos</b> de idade.',
					'info',
				)
				$('#input-dt-nascim').css({'border-color': '#a94442'});
				$('#dt_nasc_error').text('Menor de Idade');
			}else{
				$('#input-dt-nascim').css({'border-color': 'lightgrey'});
				$('#dt_nasc_error').text('');
			}
		}

    }
	// valida campos do formulário de cadastro
	function validateFormCadastro(data){
		var url = siteurl + "validacao/validaCadastro";
		var valid = '';
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			async : false ,
			dataType: 'json',
			beforeSend: function (){
				$("#salvar").attr('disabled',true);
				$(".text-danger").html('');
			},
			error : function(jqXHR,exception){
				alert("Ocorreu um erro ao inserir o registro!");
				valid = 'error';
				$("#salvar").attr('disabled',false);
			},
			success: function (data){
				var campo = '';
				if(data.error){
					// Validação do CPF
					if(data.cpf_error){
						$("#input-cpf").css({'border-color': '#a94442'});
						$("#cpf_error").html(data.cpf_error);
						var cpf = '<br> - CPF;';
						campo = campo + cpf;
					}else{
						$("#input-cpf").css({'border-color': 'lightgrey'});
					}
					// Validação do Nome
					if(data.name_error){
						$("#input-name").css({'border-color': '#a94442'});
						$("#name_error").html(data.name_error);
						var nome = '<br> - NOME;';
						campo = campo + nome;
					}else{
						$("#input-name").css({'border-color': 'lightgrey'});
					}
					// Validação da Dt. Admissão
					if(data.data_adm_error){
						$("#input-data-adm").css({'border-color': '#a94442'});
						$("#data_adm_error").html(data.data_adm_error);
						var dt_adm = '<br> - DATA ADMISSÃO;';
						campo = campo + dt_adm;
					}else{
						$("#input-data-adm").css({'border-color': 'lightgrey'});
					}
					// Validação campo banco 
					if(data.banco_nome_error){
						$("#input-banco-nome").css({'border-color': '#a94442'});
						// $("#banco_nome_error").html(data.banco_nome_error);
						var banco = '<br> - BANCO ('+data.banco_nome_error+');';
						campo = campo + banco;
					}else{
						$("#input-banco-nome").css({'border-color': 'lightgrey'});
						
					}
					// Validação campo Unidade
					if(data.unidade_error){
						$("#input-unidade").css({'border-color':'#a94442'});
						$("#unidade_error").html(data.unidade_error);
						var banco = '<br> - UNIDADE;';
						campo = campo + banco;
					}else{
						$("#input-unidade").css({'border-color': 'lightgrey'});
						
					}
					// Validação campo Horário Inicio
					if(data.hr_ini_error){
						$("#input-hr-ini").css({'border-color':'#a94442'});
						$("#hr_ini_error").html(data.hr_ini_error);
						var horini = '<br> - HORÁRIO INICIAL;';
						campo = campo + horini;
					}else{
						$("#input-hr-ini").css({'border-color': 'lightgrey'});	
					}
					// Validação campo Horário Fim 
					if(data.hr_fim_error){
						$("#input-hr-fim").css({'border-color':'#a94442'});
						$("#hr_fim_error").html(data.hr_fim_error);
						var horfim = '<br> - HORÁRIO FINAL;';
						campo = campo + horfim;
					}else{
						$("#input-hr-fim").css({'border-color':'lightgrey'});
					
					}
					// Validação campo Horário Almoço(início)
					if(data.hr_al_ini_error){
						$("#input-hr-alm-ini").css({'border-color':'#a94442'});
						$("#hr_al_ini_error").html(data.hr_al_ini_error);
						var almoco_ini = '<br> - ALMOÇO INICIAL;';
						campo = campo + almoco_ini;
					}else{
						$("#input-hr-alm-ini").css({'border-color':'lightgrey'});
					}
					// Validação campo Horário Almoço(fim)
					if(data.hr_al_fim_error){
						$("#input-hr-alm-fim").css({'border-color':'#a94442'});
						$("#hr_al_fim_error").html(data.hr_al_fim_error);
						var almoco_fim = '<br> - ALMOÇO FINAL;';
						campo = campo + almoco_fim;
					}else{
						$("#input-hr-alm-fim").css({'border-color': 'lightgrey'});
					}
					
					if(data.empresa_error){
						$("#input-empresa").css({'border-color':'#a94442'});
						$("#empresa_error").html(data.empresa_error);
						var empresa = '<br> - EMPRESA;';
						campo = campo + empresa;
					}else{
						$("#empresa_error").css({'border-color': 'lightgrey'});
					}
					if(data.contrato_error){
						$("#input-contrato").css({'border-color':'#a94442'});
						$(".contrato_error").html(data.contrato_error);
						var contrato = '<br> - CONTRATO;';
						campo = campo + contrato;
					}else{
						$("#input-contrato").css({'border-color': 'lightgrey'});
					}

					if(data.funcao_error){
						$("#input-funcao").css({'border-color':'#a94442'});
						$("#funcao_error").html(data.funcao_error);
						var funcao = '<br> - FUNCÃO;';
						campo = campo + funcao;
					}else{
						$("#funcao_error").css({'border-color': 'lightgrey'});
					}

					Toast3.fire(
						'Por favor, verifique o(s) seguinte(s) campo(s).',
						campo,
						'error',
					)
					valid = 'error';

				}else{
					$(".input-sm").css({'border-color': 'lightgrey'});
				}
				
				$("#salvar").attr('disabled',false);
			}
		});
		//console.log(msg);
		return valid;
	}
	$('[data-toggle="tooltip"]').tooltip();

});
function qtdFilhosMais(){
	var valor = $('#input-qtd-filhos').val();
	if(valor == '' || valor == 0){
		valor = 0;
	}
	valor = parseInt(valor,10)+1;
	$('#input-qtd-filhos').val(valor);
}
function qtdFilhosMenos(){
	var valor = $('#input-qtd-filhos').val();
	if(valor == '' || valor == 0){
		valor = 0;
	}
	valor = parseInt(valor,10)-1;
	if(valor < 0){
		valor = '';
	}
	$('#input-qtd-filhos').val(valor);
	$('#input-qtd-filhos').trigger('blur');
}

    $("#checkbox_email").on("change", function(){
		if(!$(this).is(':checked')){
			$("#input-email").attr("readonly", false);
		}else{
			$("#input-email").attr("readonly", true);
			$("#input-email:text").val('');

	   }
    });