<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Demandas extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Demandas_ti_model",'demandas');
		$this->load->helper('form');
	}
	
	public function index(){
		$acesso = $this->acessoPermitido();
		if($acesso){/** verifica se o usuário tem acesso */
			if($this->input->post('mes')): /**verifica se o usuario informou algum mes para realizar a pesquisa */
				$mes = $this->input->post('mes');
				$ano = $this->input->post('ano');
				$dados_data = $this->contaDias($mes,$ano);
	
				$data ['demandas_por_funcao'] = $this->demandas->buscaHorasPorFuncao($dados_data['ini'], $dados_data['fim']);	
				$data ['mes'] = $this->mes($mes);
				$data ['post'] = $this->input->post('mes');
				$data ['post_ano'] = $ano;
				
				echo json_encode($data);
			else: /** carregamento inicial */
				$data ['mes_padrao'] = date('n');
				$data ['ano_padrao'] = date('Y');
				$data_ini = date('Y-m').'-01';
				$data_fim = date('Y-m-d');
				$data ['menu'] = true;
				$data ['view'] = "demandas/index_demandas";	
				$data ['demandas_por_funcao'] = $this->demandas->buscaHorasPorFuncao($data_ini, $data_fim);	
				$data ['demandas_por_funcionario'] = $this->demandas->buscaHorasPorFuncionario($data_ini, $data_fim);	
				$data ['tot_func'] = count($data['demandas_por_funcionario']);	
				$data ['meses'] = $this->calendario();
				$data ['mes'] = $this->mes(date('n'));
				$data ['alert'] = $this->notification_output();
				$this->load->view("includes/body",$data);
			endif;
		}else{
			$data ['menu'] = true;
			$data ['view'] = "acessonegado/accessdenied";
			$this->load->view("includes/body",$data);
		}
	}
	// public function recarregaHorasMes(){
	// 	$data ['mes_padrao'] = date('n');
	// 	$data ['ano_padrao'] = date('Y');
	// 	$data_ini = date('Y-m').'-01';
	// 	$data_fim = date('Y-m-d');
	// 	// $data ['menu'] = true;
	// 	// $data ['view'] = "demandas/index_demandas";	
	// 	$data ['demandas_por_funcao'] = $this->demandas->buscaHorasPorFuncao($data_ini, $data_fim);	
	// 	$data ['demandas_por_funcionario'] = $this->demandas->buscaHorasPorFuncionario($data_ini, $data_fim);	
	// 	$data ['tot_func'] = count($data['demandas_por_funcionario']);	
	// 	// $data ['meses'] = $this->calendario();
	// 	$data ['mes'] = $this->mes(date('n'));
	// 	// $data ['alert'] = $this->notification_output();
	// 	$data ['view_horas_mes'] = $this->load->view("demandas/horas_demandas",$data,true);
	// 	echo json_encode($data);
	// }
	public function buscaHorasPorFuncionarioIndividual(){
		$param['post'] = $this->input->post();
		$param['datas'] = $this->contaDias($this->input->post('mes_padrao'),$this->input->post('ano_padrao'));
		$horas_individual['reg'] = $this->demandas->buscaHorasPorFuncionarioIndividual($param);	
		$horas_individual['status'] = $this->input->post('status');
		echo json_encode($horas_individual);
	}
	public function buscaHorasPorFuncionarioView(){
		$mes = $this->input->post('post_mes');
		$ano = $this->input->post('post_ano');
		$dados_data = $this->contaDias($mes,$ano);
		$data ['mes_padrao'] = $mes;
		$data ['ano_padrao'] = $ano;

		$data ['demandas_por_funcionario'] = $this->demandas->buscaHorasPorFuncionario($dados_data['ini'], $dados_data['fim']);
		$data ['tot_func'] = count($data['demandas_por_funcionario']);
		$this->load->view('demandas/equipe',$data);
	}
	public function buscaDadosProspeccao(){
		$param['qtd_func'] = $this->input->post('qtd_func');
		$param['data'] = $this->input->post('ano').'-'.$this->input->post('mes').'-01';
		
		$data['dados'] = $this->demandas->buscaDadosProspeccao($param);
		$data['mes'] = $this->mes($this->input->post('mes'));
		$data['ano'] = $this->input->post('ano');
		$data['view'] = $this->load->view('demandas/prospeccao',$data,true);
		echo json_encode($data);
	}
	public function calendario(){
		$mes = array('Janeiro', 'Fevereiro','Março','Abril','Maio','Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro','Dezembro');
		return $mes;
	}
	public function contaDias($mes,$ano){
		$qtde_dia_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //verifica quantos dias tem o mês informado

		$dados['ini'] = $ano.'-'.$mes.'-01';
		$dados['fim'] = $ano.'-'.$mes.'-'.$qtde_dia_mes;
		return $dados;
	}
	public function export_dados_excel(){
		$this->load->library('exportexcel');
		$this->load->helper('url');
		if($this->input->post()){
			$mes = $this->input->post('mes_param');
			$ano = $this->input->post('ano_param');
			$dados_data = $this->contaDias($mes,$ano);

			$data ['demandas_por_funcionario'] = $this->demandas->buscaHorasPorFuncionario($dados_data['ini'], $dados_data['fim']);
			$data ['demandas_por_funcao'] = $this->demandas->buscaHorasPorFuncao($dados_data['ini'], $dados_data['fim']);
			$nome_mes = $this->mes($mes);

			$this->exportexcel->export_dados_demanda_ti($data,$nome_mes);
		}else{
			echo 'Ops! não conseguimos construir o arquivo com as informações solicitadas.';
			// redirect('demandas','refresh');
			
		}
	}

	public function validaProspeccao(){
		$data_final = $this->input->post('ano').'-'.$this->input->post('mes');
		$data_inicio = date('Y-n');
		if(strtotime($data_inicio) < strtotime($data_final)){
			echo 'maior';
		}else{
			echo 'menor';
		}
	}

	public function acessoNegado(){
		if($this->session->userdata("acesso") == "Colaborador"){
			return true;
		}else{
			return false;
			
		}

	}
	public function acessoPermitido(){
		$perfil = array('Coordenador TI');
		$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
		if($perfil){
			return true;
		}else{
			return false;
			
		}

	}
	public function mes($mes){

		switch ($mes) {
			case 1:
				return 'Janeiro';
				break;
			case 2:
				return 'Fevereiro';
				break;
			case 3:
				return 'Março';
				break;
			case 4:
				return 'Abril';
				break;
			case 5:
				return 'Maio';
				break;
			case 6:
				return 'Junho';
				break;
			case 7:
				return 'Julho';
				break;
			case 8:
				return 'Agosto';
				break;
			case 9:
				return 'Setembro';
				break;
			case 10:
				return 'Outubro';
				break;
			case 11:
				return 'Novembro';
			break;
			
			default:
				return 'Dezembro';
				break;
		}
	}

	/*=====================================================================
	 FUNÇÕES EXTRAS
	=====================================================================*/
	
	//Exibir notificação da sessão
	private function notification_output(){
		if($this->session->userdata("message")){
			if($this->session->userdata("accept")) $type_alert = "success";
			else $type_alert = "danger";
			$data='<script>$(document).ready(function(){$.toaster({ priority : "'.$type_alert.'", title : "Alerta", message : "'.$this->session->userdata("message").'",settings:{"timeout":3000}});});</script>';
			$this->session->unset_userdata(array("message"=>"","accept"=>""));
			return $data;
		}
		return "";
	}
	
	//Configurar notificação da sessão
	private function notification_input($message,$accept){
		$this->session->set_userdata(array("message"=>$message,"accept"=>$accept));
	}

	// calcula as horas de debito e extra da folha de ponto
	private function calculaHora($time, $format = '%d:%s'){
		settype($time, 'integer');
		if ($time == 0 ) {
			return '';
		}
		$hours = floor($time/60);
		$minutes = $time%60;
		if ($minutes < 10) {
			$minutes = '0'.$minutes;
		}
		if ($hours < 10 ){
			$hours = '0'.$hours;
		}
		$timeFormat = $hours.':'.$minutes;
		return $timeFormat;
	}

}