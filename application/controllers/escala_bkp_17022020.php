<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Escala extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Escala_model",'escala');
		$this->load->helper('form');
		//$this->output->enable_profiler(true);
    }
    
    public function index(){
        $data ['menu'] = true;
		$data ['view'] = "escala/escala";	
		$data ['empregados'] = $this->escala->getEmpregadosFolha(get_current_user());
		$this->load->view("includes/body",$data);
	}
	
	public function getDadosEscala(){
		$data['dados'] = $this->escala->getDadosEscala();
		$this->load->view("escala/consulta_escala",$data);
	}

	public function modalCadastroEscala(){
		$data['empregados'] = $this->escala->getEmpregadosFolha(get_current_user());
		$this->load->view("escala/modal/modal_cadastro_escala",$data);
	}

	public function cadastrarEscala(){
		echo json_encode($this->escala->setEscala(get_current_user()));
	}

	public function modalEditarEscala(){
		$data['dados'] = $this->escala->getDadosEscalaEmpregado();
		$this->load->view("escala/modal/modal_edicao_escala",$data);
	}

	public function alterarEscalaPlanejamento(){
		$this->escala->setDadosEscalaPlanejamento(get_current_user());
		echo json_encode($this->escala->setDadosEscalaPlanejamento(get_current_user()));
	}
	
	public function alterarEscalaSupervisor(){
		echo json_encode($this->escala->setDadosEscalaSupervisor(get_current_user()));
	}

}