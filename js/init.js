$(document).ready(function(){

	;(function ($) { $.fn.datepicker.language['pt-BR'] = {
		days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
		daysMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
		months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
		today: 'Hoje',
		clear: 'Limpar',
		dateFormat: 'dd/mm/yyyy',
		timeFormat: 'hh:ii',
		firstDay: 0
	}; })(jQuery);


	$(".date-mask").mask('00/00/0000',{placeholder: "__/__/____"}, {'translation':{ 0: { pattern: /[0-9*]/}}});
	
	$(".hours-input").mask('00:00', { placeholder: "__:__"} );

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
	
	
	$(".menu-toggle span").click(function(){
		$(".navbar").fadeToggle("slow");
	});
	
	$('body').on('click', '.view-modal', function(){
		var modal_win = $(".modal-info");
		var remote = $(this).data('remote');
		modal_win.modal();
		$.ajax({
			url:remote,
			method:"POST",
			async:true,
			success:function(data){
				modal_win.find(".modal-content").html(data);
			}
		}).fail(function(data){
			modal_win.find(".modal-content").html(data);
            //modal_win.find(".modal-content").html("<div class='modal-body'><span class='glyphicon glyphicon-alert text-danger'></span></div>");
		});	
	});
	
	$(".datatable").dataTable({
        "oLanguage": {
            "sLengthMenu": "_MENU_ por página",
            "sInfoEmpty": "Não foram encontrados registros",
            "sInfo": "(_START_ a _END_) registros",
            "sInfoFiltered": "(filtrado de _MAX_ registro(s))",
            "sZeroRecords": "Nenhum resultado",
            "sSearch": "Filtrar",
            "oPaginate":
                    {
                        "sNext": "<span class='glyphicon glyphicon-chevron-right'></span>",
                        "sPrevious": "<span class='glyphicon glyphicon-chevron-left'></span> "
                    }
        },
        "order": [],
        "bPaginate": true
	});
	
	$('.multiselect').multiselect({
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

	
});



