<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Validacao extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
        //$this->output->enable_profiler(true);
        $this->load->model("Validacao_model",'validacao');
    }
    
    public function validaCadastro(){
		$data = $this->input->post();
		$dataReturn['error'] = false;

		$empresa = $this->input->post("IdEmpresa");
		$contrato = $this->input->post("IdContrato");
		$funcao = $this->input->post("IdFuncao");
		if($this->input->post("CPF") == null ){
			$dataReturn['error'] = true;
			$dataReturn['cpf_error'] = "CPF obrigatório";
		}
		else if(!$this->validacao->validaCPF($this->input->post("CPF"))){
			$dataReturn['error'] = true;
			$dataReturn['cpf_error'] = "CPF inexistente";
		}
		else if($this->validacao->validaCpfCadastrado($this->input->post("CPF")) && $this->input->post("input-contr-cadastro") != 1 ){
			$dataReturn['error'] = true;
			$dataReturn['cpf_error'] = "CPF já cadastrado no sistema";
		}
		if(trim($this->input->post("Nome")) == '' ){
			$dataReturn['error'] = true;
			$dataReturn['name_error'] = "Nome obrigatório";
		}
		if($empresa == null ){
			$dataReturn['error'] = true;
			$dataReturn['empresa_error'] = "Campo obrigatório";
		}
		if($contrato == null ){
			$dataReturn['error'] = true;
			$dataReturn['contrato_error'] = "Campo obrigatório";
		}
		if($funcao == null ){
			$dataReturn['error'] = true;
			$dataReturn['funcao_error'] = "Campo obrigatório";
		}
		if($this->input->post("DataAdmissao") == null ){
			$dataReturn['error'] = true;
			$dataReturn['data_adm_error'] = "Data obrigatória";
		}
		if($this->validacao->validaNomeBanco($this->input->post("IdBancoFuncionario"))){
			$dataReturn['error'] = true;
			$dataReturn['banco_nome_error'] = "Nome do banco incompleto";
		}
		if($this->validacao->validaNomeUnidades($this->input->post("CGC"))){
			$dataReturn['error'] = true;
			$dataReturn['unidade_error'] = "Nome da unidade incompleto";
		}
		if(!$this->validacao->validaCampoHora($this->input->post("HorarioInicio"))){
			$dataReturn['error'] = true;
			$dataReturn['hr_ini_error'] = "Horário inválido";
		}
		if(!$this->validacao->validaCampoHora($this->input->post("HorarioFim"))){
			$dataReturn['error'] = true;
			$dataReturn['hr_fim_error'] = "Horário inválido";
		}
		if(!$this->validacao->validaCampoHora($this->input->post("HorarioAlmocoInicio"))){
			$dataReturn['error'] = true;
			$dataReturn['hr_al_ini_error'] = "Horário inválido";
		}
		if(!$this->validacao->validaCampoHora($this->input->post("HorarioAlmocoFim"))){
			$dataReturn['error'] = true;
			$dataReturn['hr_al_fim_error'] = "Horário inválido";
		}
		echo json_encode($dataReturn);
	}
	
	
	public function validaConsultaCadastro(){
		// $data = $this->input->post();
		$dataReturn['error'] = false;
		if((trim($this->input->post("matricula")) == '') && (trim($this->input->post("nome")) == '') && (trim($this->input->post("cpf")) == '')){
			$dataReturn['error'] = true;
			$dataReturn['pesq_error'] = "Favor preencher ao menos um dos campos de consulta*";
		}
		// $data = array_filter($data);
		// if(empty($data)){
		// 	$dataReturn['error'] = true;
		// 	$dataReturn['pesq_error'] = "Favor preencher ao menos um dos campos de consulta*";
		// }
		echo json_encode($dataReturn);
	}

}