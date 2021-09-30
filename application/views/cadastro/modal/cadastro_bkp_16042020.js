$(document).ready(function(){
	const Toast2 = Swal.mixin({
		customClass:{
			confirmButton: 'btn btn-sm btn-success',
			cancelButton: 'btn btn-sm btn-danger'
		},buttonsStyling: false
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
	$('#mat').change(function(){
		$.toaster({
			priority : "warning", 
			title : "CEACR/BR - CP", 
			message : 'O valor do campo MATRÍCULA não pode ser alterado.',
			settings: {'timeout': 5000 }
		});
		$(this).val($('#input-matricula').val());
		$(this).attr('disabled','disabled');
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
								title : "CEACR/BR - CP", 
								message : msg,
								settings: {'timeout': 5000 }
							});
							$("#modalCadastro").modal("hide");
						}
					});
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
				if(data.error){
					// Validação do CPF
					if(data.cpf_error){
						$("#input-cpf").css({'border-color': '#a94442'});
						$("#cpf_error").html(data.cpf_error);
					}else{
						$("#input-cpf").css({'border-color': 'lightgrey'});
					}
					// Validação do Nome
					if(data.name_error){
						$("#input-name").css({'border-color': '#a94442'});
						$("#name_error").html(data.name_error);
					}else{
						$("#input-name").css({'border-color': 'lightgrey'});
					}
					// Validação da Dt. Admissão
					if(data.data_adm_error){
						$("#input-data-adm").css({'border-color': '#a94442'});
						$("#data_adm_error").html(data.data_adm_error);
					}else{
						$("#input-data-adm").css({'border-color': 'lightgrey'});
					}
					// Validação campo banco 
					if(data.banco_nome_error){
						$("#input-banco-nome").css({'border-color': '#a94442'});
						$("#banco_nome_error").html(data.banco_nome_error);
					}else{
						$("#input-banco-nome").css({'border-color': 'lightgrey'});
					
					}
					// Validação campo Unidade
					if(data.unidade_error){
						$("#input-unidade").css({'border-color':'#a94442'});
						$("#unidade_error").html(data.unidade_error);
					}else{
						$("#input-unidade").css({'border-color': 'lightgrey'});
						
					}
					// Validação campo Horário Inicio
					if(data.hr_ini_error){
						$("#input-hr-ini").css({'border-color':'#a94442'});
						$("#hr_ini_error").html(data.hr_ini_error);
					}else{
						$("#input-hr-ini").css({'border-color': 'lightgrey'});	
					}
					// Validação campo Horário Fim 
					if(data.hr_fim_error){
						$("#input-hr-fim").css({'border-color':'#a94442'});
						$("#hr_fim_error").html(data.hr_fim_error);
					}else{
						$("#input-hr-fim").css({'border-color':'lightgrey'});
					
					}
					// Validação campo Horário Almoço(início)
					if(data.hr_al_ini_error){
						$("#input-hr-alm-ini").css({'border-color':'#a94442'});
						$("#hr_al_ini_error").html(data.hr_al_ini_error);
					}else{
						$("#input-hr-alm-ini").css({'border-color':'lightgrey'});
					}
					// Validação campo Horário Almoço(fim)
					if(data.hr_al_fim_error){
						$("#input-hr-alm-fim").css({'border-color':'#a94442'});
						$("#hr_al_fim_error").html(data.hr_al_fim_error);
					}else{
						$("#input-hr-alm-fim").css({'border-color': 'lightgrey'});
					}
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


});