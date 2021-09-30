<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Cadastro extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Cadastramento_model",'cadastramento');
		$this->load->helper('form');
	}
	
	//gerenciamento de campanhas(listagem)
	public function index(){
		$modulo_acesso = array(	'modulo' => 'cadastro', 'submodulo' => null, 'type' => 'controller', 'acao' => 'negar', 'situacao' => 1);
		$acesso = Permissao_helper::validaAcessoCadastro($modulo_acesso);

		if($acesso){
			$data ['view'] = "acessonegado/accessdenied";
		}else{
			$data ['view'] = "cadastro/cadastramento";		
			$data ['funcoes'] = $this->cadastramento->getFuncaoEmpregado();
			$data ['contratos'] = $this->cadastramento->getConsultaContratoCadastro();
		}
		$data ['menu'] = true;
		if($this->input->post()){
			$nome = $this->input->post("nome");
			$cpf = preg_replace("/[^0-9]/", "", $this->input->post("cpf"));
			$matricula = $this->input->post("matricula");
			if($this->input->post("contrato")): $contrato = $this->input->post("contrato"); else: $contrato = array(); $contrato[0] = $this->session->userdata('contrato'); endif;
			$inativo = $this->input->post("inativo");
			$data ['dados'] = $this->cadastramento->getCadastroUsuario($nome,$cpf,$matricula,$inativo,$contrato);
		}
		$data ['alert'] = $this->notification_output();
		$this->load->view("includes/body",$data);
	}


	
	public function salvar_cadastro(){
		if($this->input->post()){
			// inicializa os campos conforme ordem de execução da procedure 
			$dataCadastro = $this->cadastramento->montaDadosCadastramento();			
			// transforma o array em string para montar a procedure 
			$camposQuery = implode($dataCadastro,",");
			$controleCadastro = $this->input->post("input-contr-cadastro");
			if($controleCadastro == 0 ){
				$this->cadastramento->setInsereFuncionario($camposQuery);
			}else{
				$this->cadastramento->setAtualizaFuncionario($camposQuery);
			}
			//print_r($this->db->last_query());
		}
	}

	public function consulta_cadastro(){
		$data ['menu'] = true;
		$data ['view'] = "cadastro/cadastramento";	
		$nome = $this->input->post("nome");
		$cpf = preg_replace("/[^0-9]/", "", $this->input->post("cpf"));
		$matricula = $this->input->post("matricula");
		$data ['dados'] = $this->cadastramento->getCadastroUsuario($nome,$cpf,$matricula);
		$data ['alert'] = $this->notification_output();			
		$this->load->view("includes/body",$data);
	}


	public function cadastro_novo(){
		$data['supervisor'] = $this->cadastramento->getSupervisoresAutocomplete();
		$data['statusCivil'] = $this->cadastramento->getStatusCivil();
		$data['escolaridade'] = $this->cadastramento->getGrauInstrucao();
		$data['funcoes'] = $this->cadastramento->getFuncaoEmpregado();
		$data['empresas'] = $this->cadastramento->getEmpresas();
		$contrato = '';
		$data['contratos'] = $this->cadastramento->getContrato($contrato);
		$data['sexo'] = $this->cadastramento->getConsultaSexo();
		$data['situacao'] = $this->cadastramento->getConsultaSituacao();
		$data['estabilidades'] = $this->cadastramento->getConsultaEstabilidade();
		$data['filhos'] = $this->cadastramento->getConsultaFilhos();
		$data['ufs'] = $this->cadastramento->getUF();
		$data['bancos'] = $this->cadastramento->retornaCodidoBanco();
		
		$this->load->view("cadastro/modal/modal_cadastro",$data);
	}

	public function editar_cadastro(){
		$cpf = $this->input->post("cpf");
		$data['statusCivil'] = $this->cadastramento->getStatusCivil();
		$data['escolaridade'] = $this->cadastramento->getGrauInstrucao();
		$data['dados'] = $this->cadastramento->getDadosEditCadastro($cpf);
		$contrato = $data['dados'][0];
		$data['funcoes'] = $this->cadastramento->getFuncaoEmpregado();
		$data['empresas'] = $this->cadastramento->getEmpresas();
		$data['contratos'] = $this->cadastramento->getContrato($contrato['IdEmpresa']);
		$data['sexo'] = $this->cadastramento->getConsultaSexo();
		$data['situacao'] = $this->cadastramento->getConsultaSituacao();
		$data['estabilidades'] = $this->cadastramento->getConsultaEstabilidade();
		$data['filhos'] = $this->cadastramento->getConsultaFilhos();
		$data['ufs'] = $this->cadastramento->getUF();
		// $data['supervisor'] = $this->cadastramento->getSupervisoresAutocomplete();
		$data['supervisor'] = $this->cadastramento->getSupervisoresAutocompleteCadastro($contrato['IdContrato']);
		// print_r($this->db->last_query());
		// exit();
		$data['bancos'] = $this->cadastramento->retornaCodidoBanco();

		
		$this->load->view("cadastro/modal/modal_cadastro",$data);
	}

	public function getContratoEmpresa(){

		$resultado = $this->cadastramento->getContratoEmpresa();
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Contrato'];
			$resultado[$count]['value'] = $row['IdContrato'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function getContratoFuncao(){

		$resultado['funcao'] = $this->cadastramento->getContratoFuncao();
		$resultado['superior'] = $this->cadastramento->getContratoSuperior();
		$count = 0;
		echo json_encode($resultado);
	}


	public function download_planilha(){
		$this->load->library('exportexcel');
		$this->exportexcel->download_planilha_cadastro();
	}




	public function cadastro_planilha(){
		$this->load->view("cadastro/modal/modal_cadastro_planilha");
	}

	public function autocomplete_banco(){
		$this->cadastramento->getAutocompleteBanco($this->input->get("term"));
	}

	public function autocomplete_unidades(){
		$this->cadastramento->getAutocompleteUnidades($this->input->get("term"));
	}

	public function autocomplete_fila(){
		$this->cadastramento->getAutocompleteFila($this->input->get("term"));
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


}