<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Ocorrencia extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Ocorrencia_model",'ocorrencia');
		$this->load->model("Frequencia_model",'frequencia');
		$this->load->model("Validacao_model",'validacao');
		$this->load->helper('form');
	}
	
	public function index(){
		$data ['menu'] = true;
		$data ['view'] = "ocorrencia/ocorrencias";		
		//$data ['empregados'] = $this->ocorrencia->getEmpregadosOcorr('p560433'); 
		if($this->session->userdata("acesso") == "Administrador"){
			$data['coordenadores'] = $this->frequencia->getCoordenadoresFolha(get_current_user());
			$data['empregados'] = array();
			//$data['superiores'] = $this->frequencia->getSuperioresFolhaPonto();
		}else{
			$data['empregados'] = $this->ocorrencia->getEmpregadosOcorr(get_current_user()); 
			//$data ['empregados'] = $this->ocorrencia->getEmpregadosOcorr('p560433'); 
		}
		$this->load->view("includes/body",$data);
	}                                                                  

	public function modalCadastroOcorrencia(){
		$data['motivos'] = $this->ocorrencia->getMotivoOcorr();
		if($this->session->userdata("acesso") == "Administrador"){
			$data['coordenadores'] = $this->frequencia->getCoordenadoresFolha(get_current_user());
			$this->load->view("ocorrencia/modal/modal_ocorrencia_adm",$data);
		}else{
			$data['empregados'] = $this->ocorrencia->getEmpregadosOcorr(get_current_user()); 
			$this->load->view("ocorrencia/modal/modal_ocorrencia",$data);
		}
	}

	public function getDadosOcorrencia(){
		if($this->session->userdata("acesso") == "Administrador"){
			// valida��o necess�ria para realizar a consulta de forma correta no perfil Adm
			$superior = $this->input->post("superior");	
			$nome = $this->input->post("nome");
			if($superior == $nome )
				$usr = $this->input->post("coordenador");
			else	
				$usr = $superior;
		}else{
			$usr = get_current_user();
		}
		$data['dados'] = $this->ocorrencia->getDadosOcorrencia($usr);
		$this->load->view("ocorrencia/consulta_ocorrencia",$data);
	}

	public function setCadastroOcorrencia(){
		$data = $this->validacao->validaOcorrenciaCadastrada();
		if($data[0]['retorno'] == 1 ){
			echo json_encode($this->ocorrencia->setCadastroOcorrencia(get_current_user()));
		}else{
			echo json_encode($data);
		}
		
	}

	public function modalEditDadosOcorrencia(){
		$data['dados'] = $this->ocorrencia->getDadosOcorrenciaUsr();
		$data['motivos'] = $this->ocorrencia->getMotivoOcorr();
		$data['empregados'] = $this->ocorrencia->getEmpregadosOcorr(get_current_user()); 
		$this->load->view("ocorrencia/modal/modal_ocorrencia",$data);
	}

	public function modalExcluirOcorrencia(){
		$data['dados'] = $this->ocorrencia->getDadosOcorrenciaUsr();
		$this->load->view("ocorrencia/modal/modal_exclusao",$data);
	}

	public function setExclusaoOcorrencia(){
		echo json_encode($this->ocorrencia->setExclusaoOcorrencia(get_current_user()));
	}
  
	public function getMotivos(){
		echo json_encode($this->ocorrencia->getMotivos());
	}
		
	public function autocomplete_cid(){
		$this->ocorrencia->getAutocompleteCID($this->input->get("term"));
	}


}