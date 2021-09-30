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
		if($this->session->userdata("acesso") == "Administrador" || $this->session->userdata('acesso') == "Planejamento"){
			$data ['funcao'] = $this->escala->getFuncaoEscala();
		}else{
			$superior = get_current_user();
			if(get_current_user() == 'p981809' || get_current_user() == 'p536249' || get_current_user() == 'p566774'){/** MATRÍCULAS DE TESTE - DESENVOLVIMENTO */
				$superior = "p560433"; /** MATRÍCULA DO GUILHERME */
			}
			$data ['colaborador'] = $this->escala->consultaColaboradorEscala($superior);
			
		}
		// echo $this->db->last_query();
		// $data ['empregados'] = $this->escala->getEmpregadosFolha(get_current_user());
		$this->load->view("includes/body",$data);
	}
	
	public function getDadosEscala(){
		$data['dados'] = $this->escala->getDadosEscala();
		// echo $this->db->last_query();
		$this->load->view("escala/consulta_escala",$data);
	}

	public function modalCadastroEscala(){
		// $data['empregados'] = $this->escala->getEmpregadosFolha(get_current_user());
		if($this->session->userdata("acesso") == "Administrador"){
			$data ['funcao'] = $this->escala->getFuncaoEscala();
		}else{
			$superior = get_current_user();
			if(get_current_user() == 'p981809' || get_current_user() == 'p536249' || get_current_user() == 'p566774'){/** MATRÍCULAS DE TESTE - DESENVOLVIMENTO */
				$superior = "p560433"; /** MATRÍCULA DO GUILHERME */
			}
			$data ['colaborador'] = $this->escala->consultaColaboradorEscala($superior);
		}
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
	public function consultaSuperiorFuncao(){
		$func = "";
		$funcao = $this->input->post('funcao');
		
		if($funcao){
			foreach ($funcao as $value) {
				$func .= $value.';';
			}
			
			$funcao = substr($func,0,-1);
			$resultado = $this->escala->consultaSuperiorFuncao($funcao);
			$count = 0;
			foreach ($resultado as $row) {
				$resultado[$count]['label'] = $row['Nome'];
				$resultado[$count]['value'] = $row['MatriculaSCP'];
				$count++;
			}
		}else{
			$resultado = "";

		}
		echo json_encode($resultado);
	}
	public function consultaColaboradorEscala(){
		$sup = "";
		$superior = $this->input->post('superior');
	
		if($superior){
			foreach ($superior as $value) {
				$sup .= $value.';';
			}
			
			$superior = substr($sup,0,-1);
			$resultado = $this->escala->consultaColaboradorEscala($superior);
			$count = 0;
			foreach ($resultado as $row) {
				$resultado[$count]['label'] = $row['Nome'];
				$resultado[$count]['value'] = $row['MatriculaSCP'];
				$count++;
			}
		}else{
			$resultado = "";
		}
		echo json_encode($resultado);
	}

}