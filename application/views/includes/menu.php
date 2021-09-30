<?php 
	if($this->session->userdata("acesso") == 'Colaborador'):/** COLABORADOR */
		$menu = array (
			"Frequência"=> array("fa fa-clock-o",array(
				"Registro de Ponto"=>array("fa fa-circle-o",site_url('frequencia'))
			)),
			"Folha de Ponto"=>array("fa fa-print",site_url("frequencia/controle_folha_ponto")),
		);
	elseif($this->session->userdata("acesso") == 'Administrador' || $this->session->userdata("acesso") == 'Recursos Humanos'):/** ADMINISTRADOR E RH */
		$contrato = $this->session->userdata('contrato');
		if($contrato == 1):
			$menu = 
			
			array (
				"Cadastro"=>array("fa fa-user",site_url('cadastro')),
				"Frequência"=> array("fa fa-clock-o",
					array(
						"Registro de Ponto"=>array("fa fa-circle-o",site_url('frequencia')),
						"Controle de Ponto"=>array("fa fa-circle-o",site_url("frequencia/controle_folha")),
					)
				),
				"Folha de Ponto"=>array("fa fa-print",site_url("frequencia/controle_folha_ponto")),
				"Ocorrências" => array("fa fa-file-text-o",site_url('ocorrencia')),
				"Fechar Folha" => array("fa fa-calendar",site_url('fechar_folha')),
				// "Controle de Escala" => array("fa fa fa-calendar",site_url('escala')),
				"Relatórios" => array("fa fa-file-text",
					array(
						"Cadastros Ativos"=>array("fa fa-circle-o",site_url("relatorio")),
						"Frequência"=>array("fa fa-circle-o",site_url("relatorio/rel_frequencia")),
						"Lista de Operadores"=>array("fa fa-circle-o",site_url("relatorio_colaborador")),
						"Ocorrências Lançadas"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia")),
						"Ocorrências por Motivo"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia_motivo")),/** DISPONÍVEL APENAS PARA RH */
					)
				)
			);
		else: 
			$menu = 
			
			array (
				"Cadastro"=>array("fa fa-user",site_url('cadastro')),
				"Frequência"=> array("fa fa-clock-o",
					array(
						"Registro de Ponto"=>array("fa fa-circle-o",site_url('frequencia')),
						"Controle de Ponto"=>array("fa fa-circle-o",site_url("frequencia/controle_folha")),
					)
				),
				"Folha de Ponto"=>array("fa fa-print",site_url("frequencia/controle_folha_ponto")),
				"Ocorrências" => array("fa fa-file-text-o",site_url('ocorrencia')),
				// "Fechar Folha" => array("fa fa-calendar",site_url('fechar_folha')),
				// "Controle de Escala" => array("fa fa fa-calendar",site_url('escala')),
				"Relatórios" => array("fa fa-file-text",
					array(
						"Cadastros Ativos"=>array("fa fa-circle-o",site_url("relatorio")),
						"Frequência"=>array("fa fa-circle-o",site_url("relatorio/rel_frequencia")),
						"Lista de Operadores"=>array("fa fa-circle-o",site_url("relatorio_colaborador")),
						"Ocorrências Lançadas"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia")),
						"Ocorrências por Motivo"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia_motivo")),/** DISPONÍVEL APENAS PARA RH */
					)
				)
			);
			
		endif;
	elseif($this->session->userdata("acesso") == 'Coordenador TI'):/** COORDENADOR TI*/
		$menu = 
			array (
				"Cadastro"=>array("fa fa-user",site_url('cadastro')),
				"Frequência"=> array("fa fa-clock-o",
					array(
						"Registro de Ponto"=>array("fa fa-circle-o",site_url('frequencia')),
						"Controle de Ponto"=>array("fa fa-circle-o",site_url("frequencia/controle_folha")),
					)
				),
				"Folha de Ponto"=>array("fa fa-print",site_url("frequencia/controle_folha_ponto")),
				"Ocorrências" => array("fa fa-file-text-o",site_url('ocorrencia')),
				// "Fechar Folha" => array("fa fa-calendar",site_url('fechar_folha')),
				"Demandas TI" => array("fa fa-line-chart",site_url('demandas')),
				// "Controle de Escala" => array("fa fa fa-calendar",site_url('escala')),
				"Relatórios" => array("fa fa-file-text",
					array(
						"Cadastros Ativos"=>array("fa fa-circle-o",site_url("relatorio")),
						"Frequência"=>array("fa fa-circle-o",site_url("relatorio/rel_frequencia")),
						"Lista de Operadores"=>array("fa fa-circle-o",site_url("relatorio_colaborador")),
						"Ocorrências Lançadas"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia")),
						"Ocorrências por Motivo"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia_motivo")),/** DISPONÍVEL APENAS PARA RH */
					)
				)
			);
	else:	
		$menu = 
			array (
				"Cadastro"=>array("fa fa-user",site_url('cadastro')),
				"Frequência"=> array("fa fa-clock-o",
					array(
						"Registro de Ponto"=>array("fa fa-circle-o",site_url('frequencia')),
						"Controle de Ponto"=>array("fa fa-circle-o",site_url("frequencia/controle_folha")),
					)
				),
				"Folha de Ponto"=>array("fa fa-print",site_url("frequencia/controle_folha_ponto")),
				"Ocorrências" => array("fa fa-file-text-o",site_url('ocorrencia')),
				// "Fechar Folha" => array("fa fa-calendar",site_url('fechar_folha')),
				// "Controle de Escala" => array("fa fa fa-calendar",site_url('escala')),
				"Relatórios" => array("fa fa-file-text",
					array(
						"Cadastros Ativos"=>array("fa fa-circle-o",site_url("relatorio")),
						"Frequência"=>array("fa fa-circle-o",site_url("relatorio/rel_frequencia")),
						"Lista de Operadores"=>array("fa fa-circle-o",site_url("relatorio_colaborador")),
						"Ocorrências Lançadas"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia")),
						// "Ocorrências por Motivo"=>array("fa fa-circle-o",site_url("relatorio/rel_ocorrencia_motivo")),/** DISPONÍVEL APENAS PARA RH */
					)
				)
			);
	endif;
?>
	 <header class="main-header" style="border-bottom:linear-gradient(to right, rgb(0,92,169), rgb(0,181,229));">
		<!-- Logo -->
		<a href="<?php echo site_url();?>" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini">
				<img src="<?php echo base_url('images/logo-caixa-x.png');?>" />
			</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg">
				<img src="<?php echo base_url('images/logo-caixa.png');?>" />            
			</span>
		</a>
		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>

				<!-- <span class="navbar-brand"><?php echo $this->config->item('nome_sistema');?></span> -->
				<span class="navbar-brand">Cadastro Pessoal</span>

			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="<?php echo site_url("home/logout"); ?>" class="dropdown-toggle" >
							<span class="hidden-xs"><i class="glyphicon glyphicon-user"></i> <span style="text-transform:uppercase">
							<span style="display:inline-block;">
								<?php echo $this->session->userdata('nome');?>          								
							</span>
							<?php if(ENVIRONMENT=="development"):?>									
							<span style="display:inline-block;height:30px;margin-top: -5px;margin-bottom: -10px;">
								<img src="<?php echo base_url("images/dev.png");?>" style="height: 100%">														
							</span>
							<?php endif;?>	
							</span>
							
							</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		
	</header>

	<aside class="main-sidebar ">
		<section class="sidebar">
			<ul class="sidebar-menu">
			
			<?php foreach($menu as $k=>$v):?>
				<!--  menus -->
				<li class="treeview">
					<a href="<?php echo is_array($v[1])?"#":$v[1];?>">
						<i class="<?php echo $v[0];?>"></i>						
						<span><?php echo $k;?></span>
						<?php if(is_array($v[1])):?>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
						<?php endif;?>
					</a>
					<!--  sub-menus -->
					<?php if(is_array($v[1])):?>
					<ul class="treeview-menu">
						<li>
						<?php foreach($v[1] as $k1=>$v1):?>
								<a href="<?php echo $v1[1];?>">
									<span class=" <?php echo $v1[0]?>"></span> 
									<?php echo $k1;?>
								</a>
						<?php endforeach;?>
						</li>						
					</ul>
					<?php endif?>
				</li>
				<?php endforeach;?>					
				<li class="treeview">
					<a href="<?= site_url('arquivos');?>" target="_blank">
						<i class="fa fa-book"></i>						
						<span>Manual do Usuário</span>
					</a>
				</li>
			</ul>
		</section>
	</aside>	

