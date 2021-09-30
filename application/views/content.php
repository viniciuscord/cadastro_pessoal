
<style>
.editable-click{
	cursor:pointer;
}
.btn-group > .btn{
	padding: 5px 10px;
	font-size: 12px;
	line-height: 1.5;
	border-radius: 3px;
}
.tamanho{
	max-height:400px;
	overflow-y:scroll;
}
.tamanho table{
	white-space: nowrap;
}
.table th{
	cursor:help;
}
.table.dataTable{
	margin-top:-1px !important;
}
.cursor{
	cursor:pointer;
}
.table th{
	background-color:#aaa5a5;
}

</style>
<div class="content">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h4 class="box-title">Anexo I-G</h4>
			<div class="box-tools">				
			</div>			
		</div>
	
		<div class="box-body">
			<form action="<?php echo current_url();?>" method="post" name="anexoig">
				<input type="hidden" value="0" name="0">
				<div class="row">
					<div class="col-lg-3">
						<b>Coordenação:</b>
						<select class="form-control input-sm" name="coordenacao[]" multiple="multiple">
							<?php foreach ($coordenacoes as $k=>$v):?>
								<option value="<?php echo $v->id_coordenacao_pk;?>" <?php echo $this->input->post('coordenacao') && in_array($v->id_coordenacao_pk,$this->input->post('coordenacao'))?'selected="selected"':'';?>><?php echo $v->desc_coordenacao;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-lg-3">
						<b>Tipo:</b>
						<select class="form-control input-sm" name="modulo[]" multiple="multiple">
							<?php foreach ($modulos as $k=>$v):?>
								<option value="<?php echo $v->id_modulo_pk;?>" <?php echo $this->input->post('modulo') && in_array($v->id_modulo_pk,$this->input->post('modulo'))?'selected="selected"':'';?>><?php echo $v->desc_modulo;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-lg-3">
						<b>Segmento:</b>
						<select class="form-control input-sm" name="segmento[]" multiple="multiple">
							<?php foreach ($segmentos as $k=>$v):?>
								<option value="<?php echo $v->desc_segmento;?>" <?php echo $this->input->post('segmento') && in_array($v->desc_segmento,$this->input->post('segmento'))?'selected="selected"':'';?>><?php echo $v->desc_segmento;?> </option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-lg-3">
						<b>Canal:</b>
						<select class="form-control input-sm" name="canal[]" multiple="multiple">
							<?php foreach ($canais as $k=>$v):?>
								<option value="<?php echo $v->id_canal_pk;?>" <?php echo $this->input->post('canal') && in_array($v->id_canal_pk,$this->input->post('canal'))?'selected="selected"':'';?>><?php echo $v->desc_canal;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-lg-3">
						<b>Fila:</b>
						<select class="form-control input-sm" name="fila[]" multiple="multiple">
							<?php foreach ($filas as $k=>$v):?>
								<option value="<?php echo $v->id_fila_pk;?>" <?php echo $this->input->post('fila') && in_array($v->id_fila_pk,$this->input->post('fila'))?'selected="selected"':'';?>><?php echo $v->desc_fila;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="col-lg-3">
						<b>Fila Estrat�gica:</b>
						<select class="form-control input-sm" name="estrat[]" multiple="multiple">						
							<option value="0">Sim</option>							
							<option value="1">N�o</option>							
						</select>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-12">
						<div class="pull-right">
							<button class="btn btn-sm btn-primary filtrar" type="submit"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
							<?php if($this->input->post()):?>
							<button class="btn btn-sm btn-default exportar" type="button"><span class="glyphicon glyphicon-file"></span> Exportar</button>
							
							<?php endif;?>
						</div>
					</div>
				</div>
			</form>
			<br>
			<div class="row">
			<?php if($this->input->post()):?>
				<div class="col-lg-12">
					<?php if($lista):?>
						<div class="tamanho">				
							<table class="table table-striped table-condensed small datatable-fila">
								<thead>
									<tr>
										<th title="Descri��o da fila">Fila</th>
										<th title="Segmento a qual a fila pertence">Segmento</th>
										<th title="Coordena��o a qual a fila pertence">Coordena��o</th>
										<th title="Tipo de atendimento da fila">Tipo</th>
										<th title="Canal de atendimento da fila">Canal</th>
										<th title="Carga hor�ria de treinamento">Carga de Trein.</th>
										<th title="Produtos tratados na fila">Produtos</th>
										<th title="Tempo m�dio padr�o de atendimento da fila">TMA</th>
										<th title="Hor�rio de funcionamento de Segunda-feira � Sexta-feira">Seg. a Sex.</th>
										<th title="Hor�rio de funcionamento aos S�bados">S�bado</th>
										<th title="Hor�rio de funcionamento aos Domingos e Feriados">Dom. e Fer.</th>
										<th title="Local da Presta��o do servi�o">Local</th>
										<th title="Informa se a fila � estrat�gica">Estrat�gica?</th>
										<th title="% de Bonifica��o caso a fila seja estrat�gica">% de Bon.</th>
										<th title="Per�odo de vig�ncia da bonifica��o da fila">Vig�ncia</th>										
										<th title="N�vel de servi�o padr�o da fila">NSP</th>
										<th>Tempo NS</th>
										<th title="N�vel de qualidade padr�o da fila">NQP</th>
										<th title="�ndice de finaliza��o em 1� n�vel da fila">IFA1</th>
										<th title="�ndice de tempestividade de atendimento em 2� n�vel da fila">ITA2</th>
										<th title="Prazo do �ndice de tempestividade de atendimento em 2� n�vel da fila">Prazo ITA2</th>
										<th title="% de Toler�ncia de abandono da fila">% Toler�ncia</th>
										<th title="Visualizar log de altera��es da fila">Log</th>										
									</tr>
								</thead>
								<tbody>
								<?php foreach ($lista as $k=>$v):?>
									<tr data-id="<?php echo $v->id_fila_pk;?>">
										<td><?php echo $v->desc_fila;?></td>
										<td><?php echo $v->desc_segmento;?></td>
										<td><?php echo $v->desc_coordenacao;?></td>
										<td><?php echo $v->desc_modulo;?></td>
										<td><?php echo $v->desc_canal;?></td>
										<td class="edt-carga" align="center"><?php echo date('H:i',strtotime($v->carga_treinamento));?></td>
										<td title="Clique para visualizar os produtos da fila" class="cursor view-window" data-remote="<?php echo site_url("fila/get_fila_produtos/$v->id_fila_pk");?>" data-title="Produtos da fila <?php echo $v->desc_fila;?>"><span class="glyphicon glyphicon-comment"></span></td>
										<td class="edt-tma" align="center"><?php echo number_format($v->tma,0,',','.');?></td>
										<td align="center"><span class="edt-func_segasex_in"><?php echo date('H:i',strtotime($v->func_dia_util_ini));?></span> �s <span class="edt-func_segasex_fim"><?php echo date('H:i',strtotime($v->func_dia_util_fim));?></span></td>
										<td align="center"><span class="edt-func_sab_in"><?php echo date('H:i',strtotime($v->func_sabado_ini));?></span> �s <span class="edt-func_sab_fim"><?php echo date('H:i',strtotime($v->func_sabado_fim));?></span></td>							
										<td align="center"><span class="edt-func_dom_ini"><?php echo date('H:i',strtotime($v->func_domingo_ini));?></span> �s <span class="edt-func_dom_fim"><?php echo date('H:i',strtotime($v->func_domingo_fim));?></span></td>							
										<td class="edt-local" align="center"><?php echo $v->desc_local;?></td>
										<td class="edt-estrat" align="center"><?php echo empty($v->id_est_pk)?'N�o':'Sim';?></td>
										<td class="edt-estrat-perc" align="center"><?php echo empty($v->id_est_pk)?'-':number_format(($v->percentual_ad-1)*100.0,10,',','.');?></td>
										<td class="vigencia-estrat" align="center"><?php if(empty($v->id_est_pk)):?>-<?php else:?><span class="edt-estrat_vigencia_ini"><?php echo date('d/m/Y',strtotime($v->dt_inicio_vigencia));?></span> � <span class="edt-estrat_vigencia_fim"><?php echo empty($v->dt_fim_vigencia)?'Em Branco':date('d/m/Y',strtotime($v->dt_fim_vigencia));?></span><?php endif;?></td>										
										<td class="edt-nsp" align="center"><?php echo number_format($v->nsp*100,10,',','.');?></td>
										<td class="edt-tempo" align="center"><?php echo $v->tempo_ns;?></td>
										<td class="edt-nqp" align="center"><?php echo number_format($v->nqp,10,',','.');?></td>
										<td class="edt-ifa1" align="center"><?php echo number_format($v->ifa1*100,10,',','.');?></td>
										<td class="edt-ita2" align="center"><?php echo number_format($v->ita2*100,10,',','.');?></td>
										<td class="edt-prazo" align="center"><?php echo date('H:i',strtotime($v->prazo_ita2));?></td>
										<td class="edt-tolerancia" align="center"><?php echo number_format($v->tolerancia_abandono*100,10,',','.');?></td>
										<td class="action" align="center"><div class="view-window" data-title="Log de altera��es da fila <?php echo Anexog_helper::getDescFila($v->id_fila_fk)?>" data-remote="<?php echo site_url("anexog/log/$v->id_fila_fk");?>"><span class="glyphicon glyphicon-time text-primary"></span></div></td>								
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
						</div>
					<?php else:?>
						<div class="alert alert-info animated bounceIn"><span class="glyphicon glyphicon-info-sign"></span> Nenhuma fila encontrada com os par�metros informados.</div>
					<?php endif;?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>



<div class="modal fade modal-info" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">		      	
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			<span class='glyphicon glyphicon-remove modal-close'></span>		        		
		</button>
		<h4 class="modal-title" ></h4>		        
		</div>
		<div class="modal-body">
		        
		</div>
		     
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	
	$(".table").tableHeadFixer({"head" : 1});
	
	$(".datatable-fila").dataTable({
		"oLanguage": {
			"sLengthMenu": "_MENU_ por p�gina",
			"sInfoEmpty": "N�o foram encontrados registros",
			"sInfo": "(_START_ a _END_) registros",
			"sInfoFiltered": "(filtrado de _MAX_ registro(s))",
			"sZeroRecords": "Nenhum resultado",
			"sSearch":"Filtrar",
			
		},
		"order": [],
		"bFilter":false,
		"bPaginate":false
	});
	

	$(".exportar").click(function(){
		$("[name=anexoig]").attr("action",site_url("fila/exportar"));
		$(".filtrar").click();
		$("[name=anexoig]").attr("action",'<?php echo current_url();?>');
	});
	
	$('select[name="coordenacao[]"]').multiselect({
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		selectAllText: ' Todos',
		buttonWidth:"100%",
		nonSelectedText:"Todos",
		nSelectedText:"Selecionados",		
		onDropdownHide:function(element, checked){
			carregar_segmentos();					
			carregar_filas();					
		}
	});
	
	$('select[name="modulo[]"]').multiselect({
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		selectAllText: ' Todos',
		buttonWidth:"100%",
		nonSelectedText:"Todos",
		nSelectedText:"Selecionados",
		onDropdownHide:function(element, checked){
			carregar_segmentos();
			carregar_filas();					
		}
	});
	
	$('select[name="fila[]"]').multiselect({
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		selectAllText: ' Todos',
		buttonWidth:"100%",
		nonSelectedText:"Todos",
		nSelectedText:"Selecionados"
		
	});
	
	$('select[name="segmento[]"]').multiselect({
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		selectAllText: ' Todos',
		buttonWidth:"100%",
		nonSelectedText:"Todos",
		nSelectedText:"Selecionados",
		onDropdownHide:function(element, checked){			
			carregar_filas();					
		}
	});
	
	$('select[name="canal[]"],select[name="estrat[]"]').multiselect({
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		includeSelectAllOption: true,
		selectAllText: ' Todos',
		buttonWidth:"100%",
		nonSelectedText:"Todos",
		nSelectedText:"Selecionados",
		onDropdownHide:function(element, checked){
			carregar_filas();					
		}
	});

//=========edi��o liberada apenas para coordenadores e administradores do sistema ==========
<?php if($this->session->userdata("acesso")!="Funcion�rios CAIXA"):?>
	
	$(".edt-carga").editable({
	    type: 'text',
	    title:'Carga hor�ria de treinamento',
	    pk:0,
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    placement:'right',
	    url: site_url("fila/set_fila"),
	    params : function(params){
			var data={};			    			    
			data['id']=$(this).closest('tr').data("id");
			data['campo']='carga_treinamento';
			data['valor']=params.value;
        	return data;
		}
	});	
	
	$(".edt-tma").editable({
	    type: 'text',
	    title:'TMA',
	    pk:0,	    
	    placement:'right',	    
	    url: site_url("fila/set_fila"),
	    params : function(params){
			var data={};			    			    
			data['id']=$(this).closest('tr').data("id");
			data['campo']='tma';
			data['valor']=params.value;
			return data;
		}
		
	});
	
	$(".edt-func_segasex_in").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento de Seg � Sex',
	    pk:0,
	    placement:'right',
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='func_dia_util_ini';
		    	data['valor']=params.value;
                return data;
            }
		
	});

	
	$(".edt-func_segasex_fim").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento de Seg � Sex',
	    pk:0,
	    placement:'right',
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='func_dia_util_fim';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-func_sab_in").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento S�bado',
	    pk:0,
	    placement:'right', 
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
			var data={};			    			    
			data['id']=$(this).closest('tr').data("id");
			data['campo']='func_sabado_ini';
			data['valor']=params.value;
			return data;
		}		
	});
	$(".edt-func_sab_fim").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento S�bado',
	    pk:0,
	    placement:'right', 
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='func_sabado_fim';
		    	data['valor']=params.value;
				return data;
            }
		
	});
	
	$(".edt-func_dom_ini").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento Domingos e Feriados',
	    pk:0,
	    placement:'right',
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='func_domingo_ini';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-func_dom_fim").editable({
	    type: 'text',
	    title:'Hor�rio de funcionamento Domingos e Feriados',
	    pk:0,
	    placement:'right',
	    tpl:"<input type='text' class='form-control input-sm input-hora'  readonly='readonly'>",
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='func_domingo_fim';
		    	data['valor']=params.value;
                return data;
            }
		
	});

	$(".edt-local").editable({
	    type: 'select',
	    title:'Local de atendimento',
	    pk:0,	   
	    placement:'right', 
	    url: site_url("fila/set_fila"),
	    source:[{text:'SIA TRECHO 3/4',value:1},{text:'CRS 505',value:2},{text:'SHOPPING SIA',value:3}],
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='id_local_fk';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-estrat").editable({
	    type: 'select',
	    title:'Fila Estrat�gica?',
	    pk:0,	   
	    placement:'right', 
	    url: site_url("fila/set_fila"),
	    source:[{text:'Sim',value:1},{text:'N�o',value:0}],
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='estrategica';
		    	data['valor']=params.value;
                return data;
        },
        success:function(r,v){
        	if(v==1){
    		    
    	    	$(this).closest('tr').find(".edt-estrat-perc").html('0,0000000000').editable({
    			    type: 'text',
    			    title:'Valor %',
    			    pk:0,	   
    			    placement:'right', 
    			    url: site_url("fila/set_fila"),		    
    			    params : function(params){
    				    	var data={};			    			    
    				    	data['id']=$(this).closest('tr').data("id");
    				    	data['campo']='percentual_ad';
    				    	data['valor']=params.value;
    		                return data;
    		            }
    				
    			});
    			
    	    	$(this).closest('tr').find(".vigencia-estrat").html('');
    	    	$(this).closest('tr').find(".vigencia-estrat").append('<span class="edt-estrat_vigencia_ini">'+moment(new Date()).format("DD/MM/YYYY")+'</span>');
    	    	$(this).closest('tr').find(".vigencia-estrat .edt-estrat_vigencia_ini")
    	    	.editable({
    			    type: 'text',
    			    title:'Data in�cio da vig�ncia',
    			    pk:0,	   
    			    placement:'right', 
    			    url: site_url("fila/set_fila"),
    			    tpl:"<input type='text' class='form-control input-sm input-data'  readonly='readonly'>",		    
    			    params : function(params){
    				    	var data={};			    			    
    				    	data['id']=$(this).closest('tr').data("id");
    				    	data['campo']='dt_inicio_vigencia';
    				    	data['valor']=params.value;
    		                return data;
    		            }    				
    			});
    			$(this).closest('tr').find(".vigencia-estrat").append(' � ');
    	    	$(this).closest('tr').find(".vigencia-estrat").append('<span class="edt-estrat_vigencia_fim">Em Branco</span>');
    	    	$(this).closest('tr').find(".vigencia-estrat .edt-estrat_vigencia_fim")   	    	
    	    	.editable({
    			    type: 'text',
    			    title:'Data fim da vig�ncia',
    			    pk:0,	   
    			    placement:'right', 
    			    url: site_url("fila/set_fila"),
    			    tpl:"<input type='text' class='form-control input-sm input-data'  readonly='readonly'>",		    
    			    params : function(params){
    				    	var data={};			    			    
    				    	data['id']=$(this).closest('tr').data("id");
    				    	data['campo']='dt_fim_vigencia';
    				    	data['valor']=params.value;
    		                return data;
    		            }
    				
    			});
    	    }else{    	    	
    	    	$(this).closest('tr').find('.edt-estrat-perc').editable('destroy').html('-');
    	    	$(this).closest('tr').find('.edt-estrat_vigencia_ini').editable('destroy');
    	    	$(this).closest('tr').find('.edt-estrat_vigencia_fim').editable('destroy');
    	    	$(this).closest('tr').find('.vigencia-estrat').html('-');
    	    	
    	    }
		}
		
	});
	

	$(".edt-estrat-perc").editable({
	    type: 'text',
	    title:'Valor %',
	    pk:0,	   
	    placement:'right', 
	    url: site_url("fila/set_fila"),		    
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='percentual_ad';
		    	data['valor']=params.value;
                return data;
            }
	});
	
	$(".edt-estrat_vigencia_ini").editable({
	    type: 'text',
	    title:'Data de In�cio da vig�ncia',
	    pk:0,	   
	    placement:'right', 
	    url: site_url("fila/set_fila"),
	    tpl:"<input type='text' class='form-control input-sm input-data' readonly='readonly'>",		    
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='dt_inicio_vigencia';
		    	data['valor']=params.value;
                return data;
            }
	});
	
	$(".edt-estrat_vigencia_fim").editable({
	    type: 'text',
	    title:'Data de Fim da vig�ncia',
	    pk:0,	   
	    placement:'right', 
	    url: site_url("fila/set_fila"),
	    tpl:"<input type='text' class='form-control input-sm input-data-fim' readonly='readonly'>",		    
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='dt_fim_vigencia';
		    	data['valor']=params.value;
                return data;
            }
	});
	
	$(".edt-estrat").each(function(){
		var a=$(this);
		if(a.html().trim()=="Sim"){
		   a.closest('tr').closest(".edt-estrat-perc").editable('destroy');
		   a.closest('tr').closest(".edt-estrat-perc").editable({
		    type: 'text',
		    title:'Valor %',
		    pk:0,	   
		    placement:'right', 
		    url: site_url("fila/set_fila"),		    
		    params : function(params){
			    	var data={};			    			    
			    	data['id']=$(this).closest('tr').data("id");
			    	data['campo']='estrategica_perc';
			    	data['valor']=params.value;
	                return data;
	            }					
			});
		}else{
			a.closest('tr').find('.edt-estrat-perc').editable('destroy').html('-');
		}
	});
	
	
	$(".edt-nsp").editable({
	    type: 'text',
	    title:'% de NSP',
	    pk:0,	    
	    placement:'right',
	    url: site_url("fila/set_fila"),		    
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='nsp';
		    	data['valor']=params.value;
                return data;
            }			
	});
	
	$(".edt-tempo").editable({
	    type: 'text',
	    title:'Tempo NS(seg)',
	    pk:0,	    
	    placement:'right',
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='tempo_ns';
		    	data['valor']=params.value;
                return data;
            }
		
	});

	$(".edt-nqp").editable({
	    type: 'text',
	    title:'% NQP',
	    pk:0,	    
	    placement:'right',
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='nqp';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-ifa1").editable({
	    type: 'text',
	    title:'% IFA1',
	    pk:0,	    
	    placement:'right',	
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='ifa1';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-ita2").editable({
	    type: 'text',
	    title:'% ITA2',
	    pk:0,
	    placement:'left',	    
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='ita2';
		    	data['valor']=params.value;
                return data;
            }
		
	});
	
	$(".edt-prazo").editable({
	    type: 'text',
	    title:'Prazo ITA2',
	    pk:0,	    
	    placement:'left',
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    	var data={};			    			    
		    	data['id']=$(this).closest('tr').data("id");
		    	data['campo']='prazo_ita2';
		    	data['valor']=params.value;
                return data;
            }
	});
	
	$(".edt-tolerancia").editable({
	    type: 'text',
	    title:'% Toler�ncia de abandono',
	    pk:0,
	    placement:'left',
	    url: site_url("fila/set_fila"),
	    params : function(params){
		    var data={};
		    data['id']=$(this).closest('tr').data("id");
		    data['campo']='tolerancia_abandono';
		    data['valor']=params.value;
			return data;
		}
	});

	$(document).on("focus", ".input-hora", function () {
		$(this).datetimepicker({
			datepicker:false,
			timepicker:true,
			step:5,
			format:'H:i',
			formatDate:'H:i'		
		});
		
		$(this).mask("99:99");				
		
	});
	
	$(document).on("focus", ".input-data", function () {
		$(this).datetimepicker({
			datepicker:true,
			timepicker:false,
			step:5,
			format:'d/m/Y',
			formatDate:'d/m/Y',
			monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],		
		});				
	});
        
        $(document).on("focus", ".input-data-fim", function () {
		$(this).datetimepicker({
			datepicker:true,
			timepicker:false,
			step:5,
                        minDate: 0,
			format:'d-m-Y',
			formatDate:'d/m/Y',
			monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],		
		});				
	});
	
	$(document).on("blur", ".input-hora", function () {
		$(this).datetimepicker('destroy');
	});
	
	$(document).on("keyup", ".input-perc", function () {
		//mascara(this,numero_d);
		this.value=/^[0-9.,]+$/.exec(this.value);		
	});
	
<?php endif;?>
	
	
});


function carregar_segmentos(){
	$('body').append('<div class="loading-screen"></div>');
	$.post(site_url('fila/segmento_filtrar'),{
		coordenacao:$('[name="coordenacao[]"]').val(),
		modulo:$('[name="modulo[]"]').val()
	},function(data){
		var a=JSON.parse(data);
		if(a.length>0){
			$('[name="segmento[]"] option').remove();
			for(x in a){
				$('[name="segmento[]"]').append('<option>'+a[x].desc_segmento+'</option>');
			}
			$('[name="segmento[]"]').multiselect('rebuild');
		}else{
			$('[name="segmento[]"]').html('');
			$('[name="segmento[]"]').multiselect('rebuild');
			alert('Nenhum segmento cadastrado para as coordena��es/tipos selecionadas');
		}
		$('.loading-screen').remove();
		
	}).fail(function(){
		alert('Erro ao carregar segmentos');
		$('.loading-screen').remove();
	});
}

function carregar_filas(){
	$('body').append('<div class="loading-screen"></div>');
	$.post(site_url('fila/fila_filtrar'),{
		coordenacao:$('[name="coordenacao[]"]').val(),
		segmento:$('[name="segmento[]"]').val(),
		modulo:$('[name="modulo[]"]').val(),
		canal:$('[name="canal[]"]').val(),
		estrat:$('[name="estrat[]"]').val()
	},function(data){
		var a=JSON.parse(data);
		if(a.length>0){
			$('[name="fila[]"] option').remove();
			for(x in a){
				$('[name="fila[]"]').append('<option value='+a[x].id_fila_pk+'>'+a[x].desc_fila+'</option>');
			}
			$('[name="fila[]"]').multiselect('rebuild');
		}else{
			$('[name="fila[]"]').html('');
			$('[name="fila[]"]').multiselect('rebuild');
			alert('Nenhuma fila cadastrada para os par�metros selecionados');
		}
		$('.loading-screen').remove();
	}).fail(function(){
		alert('Erro ao carregar filas');
		$('.loading-screen').remove();
	});
}

</script>