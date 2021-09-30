<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Frequencia extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Frequencia_model",'frequencia');
		$this->load->helper('form');
		// $this->output->enable_profiler = true;
	}
	
	public function index(){
		$data ['menu'] = true;
		$data ['view'] = "frequencia/ponto";		
		$data ['alert'] = $this->notification_output();
		$data ['dados'] = $this->frequencia->getDadosTelaPonto(get_current_user());		
		$data ['verificaPonto'] = $this->frequencia->getVerificaPonto(get_current_user());
		$funcoes_bloqueadas = $this->frequencia->limitarFuncoes();

		$funcoes = array();
		
		foreach ($funcoes_bloqueadas as $k => $v) {
			array_push($funcoes, $v['IdFuncao']);
		}

		$data ['funcoes_bloqueadas'] = $funcoes;
		$data ['folha'] = $this->frequencia->getFolhaFrequencia(get_current_user());
		
		$data ['total_parc'] = $this->frequencia->calculaTotalParcial($data['folha']);
		foreach ($data['folha'] as $k=>$val){
			$data['folha'][$k]['Deb1'] = $this->calculaHora($val['Deb1']);
			$data['folha'][$k]['Cred'] = $this->calculaHora($val['Cred']);
		}
		// subordinados - caso supervisor
		$data ['empregados'] = $this->frequencia->getEmpregadosFolha(get_current_user()); 
		$this->load->view("includes/body",$data);
	}

	// registra o ponto 
	public function setRegistroPonto(){
		$data['dados'] = $this->frequencia->setRegistroPonto(get_current_user());
		echo json_encode($data['dados']);
	}

	public function getFolhaFuncionario(){
		$data['dados'] = $this->frequencia->getPesqFolhaFuncionario(get_current_user());
		
		$this->load->view("frequencia/folha_edicao",$data);
		//$this->load->view("frequencia/folha_edicao_teste",$data);
   }

	// modal de registro de ponto - dia 
	public function viewModalPonto(){
		$data ['empregados'] = $this->frequencia->getEmpregadosFolha(get_current_user()); 
		//$data ['empregados'] = $this->frequencia->getEmpregadosFolha('p560433'); 
		$this->load->view("frequencia/modal/modal_ponto", $data );
	}

	public function setRegistraPontoDiaADM(){
		$data['result'] = $this->frequencia->setRegistraPontoDiaADM(get_current_user());
		if(empty($data['result'])){
			$data['result'] = '0';
			echo json_encode($data['result']);
		}else{
			echo json_encode($data['result']);
		}
	}

	public function setRegistroLoteFolha(){
		echo json_encode($this->frequencia->setRegistroLoteFolha(get_current_user()));
	}

	public function controle_folha(){
		$data ['menu'] = true;
		$data ['alert'] = $this->notification_output();

		$sit = 1;
		$modulo_acesso = array(	'modulo' => 'frequencia', 'submodulo' => 'controle_folha', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  $sit);
		$acesso = Permissao_helper::validaAcessoFrequencia($modulo_acesso);

		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->frequencia->getContratoContPonto();
			$data ['empregados'] = array();
			$data ['view'] = "frequencia/controle_folha";		

		}else if($acesso === 2){/** acesso para COORDENADORES */

			$data ['situacao'] = 2;
			$coordenador = get_current_user();
			$teste_desenv = array('p981809','p566774'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
			if($teste_desenv): $coordenador = 'p560433'; endif;
			$data ['superiores'] = $this->frequencia->getSupervisoresControlePontoLogado($coordenador);
			$data ['empregados'] = array();
			$data ['view'] = "frequencia/controle_folha";		

		}else if($acesso === 4){/** acesso para RECURSOS HUMANOS e GERENTE DE CONTRATO */

			$data ['situacao'] = 4;
			$data ['coordenadores'] = $this->frequencia->getConsultaCoordContPontoLogado($this->session->userdata('contrato'));
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			$data ['view'] = "frequencia/controle_folha";		

		}else{

			$sit = 3;
			$modulo_acesso = array(	'modulo' => 'frequencia', 'submodulo' => 'controle_folha', 'type' => 'controller', 'acao' => 'negar', 'situacao' => $sit);
			$acesso = Permissao_helper::validaAcessoFrequencia($modulo_acesso);
			if($acesso){
				$data ['view'] = "acessonegado/accessdenied";		
			}else{
				$data ['view'] = "frequencia/controle_folha";		
				$data ['empregados'] = $this->frequencia->getEmpregadosContPonto(get_current_user()); 
				// $data ['empregados'] = $this->frequencia->getEmpregadosContPonto('P999192'); /**matricula de teste */
			}
		}
		//$data ['empregados'] = $this->frequencia->getEmpregadosFolha('p560433'); 
		$this->load->view("includes/body",$data);
	}

	public function consultaFiltroFolha(){
		$data['folha'] = $this->frequencia->getFolhaFrequencia(get_current_user());
		$data ['total_parc'] = $this->frequencia->calculaTotalParcial($data['folha']);
		foreach ($data['folha'] as $k=>$val){
			$data['folha'][$k]['Deb1'] = $this->calculaHora($val['Deb1']);
			$data['folha'][$k]['Cred'] = $this->calculaHora($val['Cred']);
		}
		$this->load->view("frequencia/folha",$data);
	}

	public function controle_folha_ponto(){
		$data['menu'] = true; 
		$data['view'] = "frequencia/folha_colaborador";

		$modulo_acesso = array(	'modulo' => 'frequencia', 'submodulo' => 'controle_folha_ponto', 'type' => 'controller', 'acao' => 'permitir', 'situacao' =>  1);
		$perfil = Permissao_helper::validaAcessoFrequenciaFolhaPonto($modulo_acesso);
		
		if($perfil === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->frequencia->getContratos();
			$data ['empregados'] = array();

		}else if($perfil === 2){/** acesso para COORDENADORES */

			$data ['situacao'] = 2;
			$coordenador = get_current_user();
			$teste_desenv = array('p981809'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
			if($teste_desenv): $coordenador = 'p560433'; endif;
			$data ['superiores'] = $this->frequencia->getConsultaSupervisoresFolhaPontoLogado($coordenador);
			$data ['empregados'] = array();

		}else if($perfil === 4){/** acesso para RECURSOS HUMANOS e GERENTE DE CONTRATO */

			$data ['situacao'] = 4;
			$data ['coordenadores'] = $this->frequencia->getConsultaCoordFolhaPontoLogado($this->session->userdata('contrato'));
			$data ['superiores'] = array();
			$data ['empregados'] = array();

		}else{ /**acesso SUPERVISOR */

			$data ['empregados'] = $this->frequencia->getEmpregadosFolhaPontoFP(get_current_user()); 
		}

		$this->load->view("includes/body",$data);
	}

	public function getSupervisoresFolhaSelect(){
		$data =  $this->frequencia->getSupervisoresFolhaControlePonto();
		echo json_encode($data);
	}
	public function getConsultaCoordContPonto(){

		$resultado = $this->frequencia->getConsultaCoordContPonto();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function getSupervisoresFolhaSelectNew(){/**DESCARTE */

		$resultado = $this->frequencia->getSupervisoresFolhaControlePontoNew();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function getSupervisoresControlePonto(){

		$resultado = $this->frequencia->getSupervisoresControlePonto();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function consultaCoordFolhaPonta(){
		$contrato = $this->input->post('contrato');
		$resultado = $this->frequencia->consultaCoordFolhaPonta($contrato);
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function getEmpregadosFolhaSelectNew(){/**DESCARTE */
		$resultado = $this->frequencia->getEmpregadosFolhaSelectNew();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
		
	}
	public function getEmpregadosControleFolha(){
		$resultado = $this->frequencia->getEmpregadosControleFolha();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
		
	}
 


	public function validaDiaUtil(){
		if($this->input->post()){
			$data = implode('-', array_reverse(explode('/',$this->input->post('data'))));
			$param = 1;
		}else{
			$param = 2;
			$data = date('Y-m-d');
		}
		$resultado = $this->frequencia->validaDiaUtil($data,$param);
		if($resultado[0]['Status'] == 0){
			echo 'bloq';
		}else{
			echo '';
		}
	}
	public function getCoordenadorFolhaSelectNew(){
		$resultado = $this->frequencia->getCoordenadoresFolha(get_current_user());
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
		
	}
	public function getSupervisoresFolhaControlePonto(){
		$data =  $this->frequencia->getSupervisoresFolhaControlePonto();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		
		echo json_encode($data);
	}
	public function getSupervisoresFolhaControlePontoFP(){
		$data =  $this->frequencia->getSupervisoresFolhaControlePontoFP();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		
		echo json_encode($data);
	}

	public function getEmpregadosFolhaSelect(){
		$data = $this->frequencia->getEmpregadosFolhaSelect();
		$count = 0;
		foreach ($data as $row) {
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}

	public function getEmpregadosFolhaControlePonto(){
		$data = $this->frequencia->getEmpregadosFolhaControlePonto();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}
	public function getEmpregadosFolhaControlePontoFPADM(){
		$data = $this->frequencia->getEmpregadosFolhaControlePontoFPADM();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}
	public function getEmpregadosFolhaControlePontoFP(){
		$data = $this->frequencia->getEmpregadosFolhaControlePontoFP();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}

	public function getFolhaPontoPrint(){
		if($this->input->post()){
			$data['folhas'] = $this->frequencia->getFolhaEmpregadoPonto(get_current_user()); 
			// $data['folhas'] = $this->frequencia->getFolhaEmpregadoPonto('P999192'); /**matricula de teste*/
			//$data['folhas'] = $this->frequencia->getEmpregadosFolhaPonto('P661343');
		}
		// echo $this->db->last_query();
		// exit;
		if(!empty($data['folhas'])){
				//print_r($this->db->last_query());
			$matricula = $data['folhas'][0]['Matricula'];
			//echo $matricula;
			$i = 0;
			$j = 0;
			$arr = array();
			
			foreach($data['folhas'] as $row){
				if(($row['Matricula'] != $matricula)){
					$arr[$j++];
					$matricula = $row['Matricula'];
				}
				$arr[$j][] = $row;
			}

			$data['folhas'] = $arr;
			$this->load->view("frequencia/new_print_folha",$data);
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
		$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI');
		$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
		if($perfil){
			return true;
		}else{
			return false;
			
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