<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Fechar_folha extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Fechar_folha_model",'fechar_folha');
		$this->load->helper('form');
		// $this->output->enable_profiler = true;
	}
	
	public function index(){
		$perfil = $this->acessoPermitido();
		$data ['menu'] = true;
		if($perfil){
			// calculo anual
			$data_inicial = date('Y')."-01-01";
			$data_final =  date('Y')."-12-31";
			$data_atual = date("Y-m-d");
			// $data_atual = '2020-06-05';
			
			$dias_dtInicial_x_dtFinal = $this->diferenca($data_inicial, $data_final);// retorna quantidade de dias entre a data inicial e final
			$dias_dtAtual_x_dtFinal = $this->diferenca($data_atual, $data_final);// retorna quantidade de dias entre a data atual e final
			$dias_dtAtual_x_dtInicial = $this->diferenca($data_inicial, $data_atual);// retorna quantidade de dias entre a data atual e inicial
			$porcentagem = round((($dias_dtAtual_x_dtInicial / $dias_dtInicial_x_dtFinal) * 100), 0);
			
			// calculo mensal
			$resultado = $this->fechar_folha->buscaMesFechamentoAutomatico();
			$mes_inicial = date('Y-m')."-01";
			$mes_final = $resultado[0]['MesData'];
			
			$dias_dtmesinicial_x_dtmesfinal = $this->diferenca($mes_inicial, $mes_final);// retorna quantidade de dias entre a data inicial e final
			$dias_fim_mes = $this->diferenca($data_atual, $mes_final);// retorna quantidade de dias entre a data atual e final
			$dias_dtmesatual_x_dtmesinicial = $this->diferenca($mes_inicial, $data_atual);// retorna quantidade de dias entre a data atual e inicial
			$porcentagem_fim_mes = round((($dias_dtmesatual_x_dtmesinicial / $dias_dtmesinicial_x_dtmesfinal) * 100), 0);

			
			$data ['ano_percent'] = $porcentagem;
			$data ['mes_percent'] = $porcentagem_fim_mes;
			$mes_vigente = $this->fechar_folha->fechaFolhaBuscaMes();
			
			$data ['data_mes_encerramento'] = $mes_final;
			$data ['mes_atual'] = $this->mesAtual($mes_vigente[0]['Meses']);
			$data ['mes_anterior'] = $this->mesAnterior($mes_final,$dias_fim_mes);
			$data ['dias_fim_ano'] = $dias_dtAtual_x_dtFinal;
			$data ['dias_fim_mes'] = $dias_fim_mes;
			$data ['view'] = "fechar_folha/fechar_folha";		
			$data ['alert'] = $this->notification_output();
		}else{
			$data ['view'] = "acessonegado/accessdenied";		
		}
		$this->load->view("includes/body",$data);
	}

	public function buscaFolhas(){
	
		$resultado['dados'] = $this->fechar_folha->buscaFolhas($this->input->post('ano'));
		$this->load->view('fechar_folha/fecha_folha_edicao',$resultado);
	}
	public function alterarFolha(){
		$id_folha = $this->input->post('id_folha');
		$opcao = $this->input->post('opcao');
		$user = get_current_user();
		$resultado = $this->fechar_folha->setAberturaFolha($id_folha, $user, $opcao);
		echo json_encode($resultado);
	}
	public function mesAnterior($dt,$dias){

		$data_final = implode('-', array_reverse(explode('/',$dt)));
		$data_inicio = date('Y-m-d');
		if(strtotime($data_inicio) > strtotime($data_final)){
			$mes = date('n');
		}else{
			$mes = date('n')-1;
		}
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
	public function mesAtual($mes){
		$mes = explode('-',$mes);
		$mes = $mes[1];

		switch ($mes) {
			case '01':
				return 'Janeiro';
				break;
			case '02':
				return 'Fevereiro';
				break;
			case '03':
				return 'Março';
				break;
			case '04':
				return 'Abril';
				break;
			case '05':
				return 'Maio';
				break;
			case '06':
				return 'Junho';
				break;
			case '07':
				return 'Julho';
				break;
			case '08':
				return 'Agosto';
				break;
			case '09':
				return 'Setembro';
				break;
			case '10':
				return 'Outubro';
				break;
			case '11':
				return 'Novembro';
			break;
			
			default:
				return 'Dezembro';
				break;
		}
	}
	public function acessoPermitido(){
		// $contrato = Login_helper::validaLocalContrato();
		$contrato = $this->session->userdata('contrato');

		if($contrato == '1'):
			
			$perfil = array('Administrador', 'Recursos Humanos'/*, 'Coordenador TI'*/);
			$perfil = in_array($this->session->userdata('acesso'),$perfil);
			
			if($perfil){
				return true;
			}else{
				return false;
			}
		else:
			return false;
		endif;
		

	}

	public function acessoNegado(){
		if($this->session->userdata("acesso") == "Colaborador"){
			return true;
		}else{
			return false;
			
		}

	}
	public function diferenca($data1, $data2){
 
		// diferença em segundos entre as datas 2 e 1
		$diferenca = strtotime($data2) - strtotime($data1);
	 
		// 1 dia = 86400 segundos
		$segundos_de_um_dia = 60 * 60 * 24;
	 
		// total de dias entre as datas
		$dias = intval( $diferenca / $segundos_de_um_dia );
	 
		return $dias;
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