<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Relatorio_Colaborador extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Relatorio_model",'relatorio');
    }
    
    public function index(){
        $data ['menu'] = true;
		$data ['view'] = "relatorio/colaborador/colaborador";	
		// $data['coordenadores'] = $this->relatorio->getCoordenadoresFolha(get_current_user());
		// $data['contratos'] = $this->relatorio->getContratoRelListaOperador();
		$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_colaborador','nome_function' => 'index', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoRelatorioColaborador($modulo_acesso);

		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->relatorio->getContratoRelListaOperador();
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			
		}else if($acesso === 2){/** acesso para COORDENADORES */

			$data ['situacao'] = 2;
			$coordenador = get_current_user();

			/**TESTE DESENVOLVIMETNO ***********************************************************************/
			$teste_desenv = array('p981809'); $teste_desenv = in_array(get_current_user(),$teste_desenv);
			if($teste_desenv): $coordenador = 'p560433'; endif;
			/********************************************************************************************* */

			$data ['superiores'] = $this->relatorio->getSupervisoresRelFreqLogado($coordenador);
			$data ['empregados'] = array();
			
		}else if($acesso === 4){/** acesso para RECURSOS HUMANOS e GERENTE DE CONTRATO */
			
			$data ['situacao'] = 4;
			$data ['coordenadores'] = $this->relatorio->getConsultaCoordRelFreqLogado($this->session->userdata('contrato'));
			$data ['superiores'] = array();
			$data ['empregados'] = array();
			
		}else{
			
			$sit = 3;
			$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_colaborador','nome_function' => 'index', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  $sit);
			$acesso = Permissao_helper::validaAcessoRelatorioColaborador($modulo_acesso);
			if($acesso){

				$data ['view'] = "acessonegado/accessdenied";		
			
			}else{
				$data ['situacao'] = null;
				$superior = get_current_user();
				if(get_current_user() == 'p981809'){/**MATRICULA DE TESTE */
					$superior = 'P661343';
				}
				$data['colaboradores'] = $this->relatorio->getColaboradoresRelFreqSupervisor($superior);
		
			}
		}
		$this->load->view("includes/body",$data);
	}

    public function buscaColaborador(){
		$data['colaborador'] = $this->relatorio->buscaColaborador();
		$this->load->view("relatorio/colaborador/consulta_colaborador",$data);
	}

	public function exportar_lista_operadores(){
		$this->load->library('exportexcel');
		$data['colaborador'] = $this->relatorio->buscaColaborador();
		$this->exportexcel->exportar_lista_operadores($data['colaborador']);
	}

	public function getConsultaContratoRelListaOperadores(){
		$resultado = $this->relatorio->getConsultaContratoRelListaOperadores();
		echo json_encode($resultado);
	}

	public function consultaSuperiorRelListaOperadores(){
		$sup = "";
		$superior = $this->input->post('coordenador');
	
		if($superior){
			foreach ($superior as $value) {
				$sup .= $value.';';
			}
			
			$superior = substr($sup,0,-1);
			$resultado = $this->relatorio->consultaSuperiorRelListaOperadores($superior);
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