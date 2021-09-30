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
		$modulo_acesso = array(	'modulo' => 'ocorrencia', 'submodulo' => null,'nome_function' => 'index', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoOcorrencia($modulo_acesso);

		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->ocorrencia->getContratos();
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			
		}else if($acesso === 2){/** acesso para COORDENADORES */

			$data ['situacao'] = 2;
			$coordenador = get_current_user();

			/**TESTE DESENVOLVIMETNO ***********************************************************************/
			$teste_desenv = array('p981809'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
			if($teste_desenv): $coordenador = 'p560433'; endif;
			/********************************************************************************************* */

			$data ['superiores'] = $this->ocorrencia->getSupervisoresOCLogado($coordenador);
			$data ['empregados'] = array();
			
		}else if($acesso === 4){/** acesso para RECURSOS HUMANOS e GERENTE DE CONTRATO */
			
			$data ['situacao'] = 4;
			$data ['coordenadores'] = $this->ocorrencia->getConsultaCoordOCLogado($this->session->userdata('contrato'));
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			
		}else{
			
			$sit = 3;
			$modulo_acesso = array(	'modulo' => 'ocorrencia', 'submodulo' => null,'nome_function' => 'index', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  $sit);
			$acesso = Permissao_helper::validaAcessoOcorrencia($modulo_acesso);
			if($acesso){

				$data ['view'] = "acessonegado/accessdenied";		
			
			}else{

				/**TESTE DESENVOLVIMETNO ***********************************************************************/
				$sup = get_current_user();
				$teste_desenv = array('p981809'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
				if($teste_desenv): $sup = 'P661343'; endif;
				/********************************************************************************************* */

				$data ['view'] = "ocorrencia/ocorrencias";		
				$data ['empregados'] = $this->frequencia->getEmpregadosContPonto($sup); 
		
			}
		}
		$this->load->view("includes/body",$data);
	}
	
	public function getCoordenadoresOcorrencia(){
		$param = $this->input->post('contrato');
		$contrato = $param[0];

		$resultado = $this->ocorrencia->getCoordenadoresOcorrencia($contrato);
		$count = 0;
		foreach ($resultado as $row) {
			$resultado[$count]['label'] = $row['Nome'];
			$resultado[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($resultado);
	}
	public function getSupervisoresFolhaSelect(){
		$data =  $this->ocorrencia->getSupervisoresFolhaControlePonto();
		echo json_encode($data);
	}
	public function getEmpregadosFolhaSelect(){
		// $data = $this->frequencia->getEmpregadosFolhaSelect();
		$data = $this->ocorrencia->getEmpregadosFolhaSelect();
		$count = 0;
		foreach ($data as $row) {
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MATRICULA'];
			$count++;
		}
		// echo $this->db->last_query();
		echo json_encode($data);
	}

	public function modalCadastroOcorrencia(){
		$data['motivos'] = $this->ocorrencia->getMotivoOcorr();
		$modulo_acesso = array(	'modulo' => 'ocorrencia', 'submodulo' => null,'nome_function' => 'modalCadastroOcorrencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoOcorrencia($modulo_acesso);
		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->ocorrencia->getContratos();
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			$this->load->view("ocorrencia/modal/modal_ocorrencia_adm",$data);
			
		}else if($acesso === 2){/** acesso para COORDENADORES */

			$data ['situacao'] = 2;
			$coordenador = get_current_user();

			/**TESTE DESENVOLVIMETNO ***********************************************************************/
			$teste_desenv = array('p981809'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
			if($teste_desenv): $coordenador = 'p560433'; endif;
			/********************************************************************************************* */

			$data ['superiores'] = $this->ocorrencia->getSupervisoresOCLogado($coordenador);
			$data ['empregados'] = array();
			$this->load->view("ocorrencia/modal/modal_ocorrencia_adm",$data);
			
		}else if($acesso === 4){/** acesso para RECURSOS HUMANOS e GERENTE DE CONTRATO */
			
			$data ['situacao'] = 4;
			$data ['coordenadores'] = $this->ocorrencia->getConsultaCoordOCLogado($this->session->userdata('contrato'));
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			$this->load->view("ocorrencia/modal/modal_ocorrencia_adm",$data);
			
		}else{
			
			$data['empregados'] = $this->ocorrencia->getEmpregadosOcorr(get_current_user()); 
			// $data['empregados'] = $this->ocorrencia->getEmpregadosOcorr('P661343'); 
			$this->load->view("ocorrencia/modal/modal_ocorrencia",$data);
		
		}

	}

	public function getDadosOcorrencia(){
		$modulo_acesso = array(	'modulo' => 'ocorrencia', 'submodulo' => null,'nome_function' => 'getDadosOcorrencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoOcorrencia($modulo_acesso);
		if($acesso){
			// valida��o necess�ria para realizar a consulta de forma correta no perfil Adm
			$superior = $this->input->post("superior");	
			$nome = $this->input->post("nome");
			if($superior == $nome ):
				$usr = $this->input->post("coordenador");
			else:
				$usr = $superior;
			endif;
			$usr = implode(';', $usr);
		}else{
			// $usr = 'P661343'; /**matricula teste */
			$usr = get_current_user();
		}
		$data['dados'] = $this->ocorrencia->getDadosOcorrencia($usr);
		// echo $this->db->last_query();
		// exit();
		$this->load->view("ocorrencia/consulta_ocorrencia",$data);
	}

	public function setCadastroOcorrencia(){
		$tipo_oc = $this->input->post('tipo_ocorr');
		$data = $this->validacao->validaOcorrenciaCadastrada();
		if($tipo_oc[0] == "2"){
			echo json_encode($this->ocorrencia->setCadastroOcorrencia(get_current_user()));
		}else{
			if($data[0]['retorno'] == 1 ){
				echo json_encode($this->ocorrencia->setCadastroOcorrencia(get_current_user()));
			}else{
				echo json_encode($data);
			}
		}
	}
	public function setAlteracaoOcorrencia(){
			echo json_encode($this->ocorrencia->setCadastroOcorrencia(get_current_user()));
	}
	public function validaMotivo(){
			$param = $this->input->post('motivo');
			echo json_encode($this->ocorrencia->validaMotivo($param));
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