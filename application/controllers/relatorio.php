<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Relatorio extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Relatorio_model",'relatorio');
    }
    
    public function index(){
        $data ['menu'] = true;
		$data ['view'] = "relatorio/cadastros/relatorio";		
		$data ['contratos'] = $this->relatorio->consultaContratosRelAtivos();
		// $data ['empresas'] = $this->relatorio->getOpcoesEmpresa();
		// $data ['superiores'] = $this->relatorio->getOpcoesSuperior();
		// $data ['funcoes'] = $this->relatorio->getOpcoesFuncao();
		$this->load->view("includes/body",$data);
	}
    // public function index(){
    //     $data ['menu'] = true;
	// 	$data ['view'] = "relatorio/cadastros/relatorio";		
	// 	$data ['cgc'] = $this->relatorio->getOpcoesCGC();
	// 	$data ['empresas'] = $this->relatorio->getOpcoesEmpresa();
	// 	$data ['superiores'] = $this->relatorio->getOpcoesSuperior();
	// 	$data ['funcoes'] = $this->relatorio->getOpcoesFuncao();
	// 	$this->load->view("includes/body",$data);
	// }
	
	public function getRelatorioResult(){
		$data['dados'] = $this->relatorio->getRelatorioResult();
		$this->load->view("relatorio/cadastros/consulta_relatorio",$data);
	}

	public function modalRelatorioDetalhado(){
		$data['dados'] = $this->relatorio->getRelatorioDetalhadoResult();
		$this->load->view("relatorio/cadastros/consulta_detalhado",$data);
	}

	public function getEmpresas(){
		$data = $this->relatorio->getOpcoesEmpresa();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['NomeEmpresa'];
			$data[$count]['value'] = $row['IdEmpresa'];
			$count++;
		}
		echo json_encode($data);
	}

	public function getContrato(){
		$data = $this->relatorio->getContrato();
		echo json_encode($data);
	}
	public function getSuperior(){
		$data = $this->relatorio->getOpcoesSuperior();
		$count = 0;
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSuperior'];
			$count++;
		}
		echo json_encode($data);
	}
	public function getSuperiorContratosRelAtivos(){
		$data = $this->relatorio->getSuperiorContratosRelAtivos();
		echo json_encode($data);
	}

	public function getFuncao(){
		$data = $this->relatorio->getOpcoesFuncao();
		// $count = 0;
		// foreach($data as $row){
		// 	$data[$count]['label'] = $row['NomeFuncao'];
		// 	$data[$count]['value'] = $row['IdFuncao'];
		// 	$count++;
		// }
		echo json_encode($data);
	}

	public function getColaboradores(){
		$data = $this->relatorio->getColaboradores();
		$count = 0; 
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}
	public function getCoordRelFreq(){
		$data = $this->relatorio->getCoordRelFreq();
		echo json_encode($data);
	}
	public function getCoordRelOcLancadas(){
		$data = $this->relatorio->getCoordRelOcLancadas();
		echo json_encode($data);
	}
	public function getColaboradoresRelFreq(){
		$data = $this->relatorio->getColaboradoresRelFreq();
		$count = 0; 
		foreach($data as $row){
			$data[$count]['label'] = $row['Nome'];
			$data[$count]['value'] = $row['MatriculaSCP'];
			$count++;
		}
		echo json_encode($data);
	}


	public function export_dados_cadastro(){
		$this->load->library('exportexcel');
		$data = $this->relatorio->getRelatorioDetalhadoResult(); 	
		$this->exportexcel->export_dados_cadastro($data);
	}
	public function exporta_relatorio_ocorrencia_motivo(){
		$this->load->library('exportexcel');
		$motivo = implode(';',$this->input->post('motivo'));
		$dt_ini = implode('-', array_reverse(explode('/',$this->input->post('dt-ini'))));
		$dt_fim = implode('-', array_reverse(explode('/',$this->input->post('dt-fim'))));
		
		$data = $this->relatorio->consulta_motivo_detalhes($motivo, $dt_ini, $dt_fim);
		$this->exportexcel->exporta_relatorio_ocorrencia_motivo($data);
	}

	public function exportar_dados_frequencia(){
		$this->load->library('exportexcel');
		$data['dados'] = $this->relatorio->getRelatorioFrequencia();
		foreach ($data['dados'] as $k=>$val){
			$data['dados'][$k]['Deb1'] = $this->calculaHora($val['Deb1']);
			$data['dados'][$k]['Cred'] = $this->calculaHora($val['Cred']);
		}
		$this->exportexcel->export_dados_frequencia($data['dados']);
	}

	public function rel_frequencia(){
		$data['menu'] = true;
		$data['view'] = "relatorio/frequencia/relatorio";

		$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => null,'nome_function' => 'rel_frequencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoRelatorioFrequencia($modulo_acesso);
		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->relatorio->getContratoRelFreq();
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
			$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => null,'nome_function' => 'rel_frequencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  $sit);
			$acesso = Permissao_helper::validaAcessoRelatorioFrequencia($modulo_acesso);
			if($acesso){

				$data ['view'] = "acessonegado/accessdenied";		
			
			}else{

				$superior = get_current_user();
				if(get_current_user() == 'p981809'){/**MATRICULA DE TESTE */
					$superior = 'P661343';
				}
				$data['colaboradores'] = $this->relatorio->getColaboradoresRelFreqSupervisor($superior);
		
			}
		}

		$this->load->view("includes/body",$data);
	}
	public function getRelatorioFrequencia(){
		$data['dados'] = $this->relatorio->getRelatorioFrequencia();
		foreach ($data['dados'] as $k=>$val){
			$data['dados'][$k]['Deb1'] = $this->calculaHora($val['Deb1']);
			$data['dados'][$k]['Cred'] = $this->calculaHora($val['Cred']);
		}
		$this->load->view("relatorio/frequencia/consulta_frequencia",$data);
	}
	public function rel_ocorrencia(){
		$data['menu'] = true;
		$data['view'] = "relatorio/ocorrencia/ocorrencia";
		// if($this->session->userdata("acesso") ==  "Administrador" || $this->session->userdata("acesso") == "Coordenador TI" ):
		// 	$data['contratos'] = $this->relatorio->getContratoRelOcLancadas();
		// 	// $data['coordenadores'] = $this->relatorio->getCoordenadoresFolha(get_current_user());
		// endif;

		$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_ocorrencia_lancadas','nome_function' => 'rel_ocorrencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoRelatorioOcorrenciasLancadas($modulo_acesso);

		if($acesso === 1){/**acesso para ADMINISTRADOR E COORDENADOR DE TI */

			$data ['situacao'] = 1;
			$data ['contratos'] = $this->relatorio->getContratoRelOcLancadas();
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
			$modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => 'rel_ocorrencia_lancadas','nome_function' => 'rel_ocorrencia', 'type' => 'controller', 'acao' => 'negar', 'situacao' =>  $sit);
			$acesso = Permissao_helper::validaAcessoRelatorioOcorrenciasLancadas($modulo_acesso);
			if($acesso){

				$data ['view'] = "acessonegado/accessdenied";		
			
			}
			// else{
			// 	$data ['situacao'] = null;
			// 	$superior = get_current_user();
			// 	if(get_current_user() == 'p981809'){/**MATRICULA DE TESTE */
			// 		$superior = 'P661343';
			// 	}
			// 	$data['colaboradores'] = $this->relatorio->getColaboradoresRelFreqSupervisor($superior);
		
			// }
		}
		$this->load->view("includes/body",$data);
	}

	public function consulta_ocorrencia(){
		$data['colaborador'] = $this->relatorio->consulta_ocorrencia();
		$this->load->view("relatorio/ocorrencia/consulta_ocorrencia",$data);
	}
	public function consulta_ocorrencia_detalhado(){
		$data['detalhe'] = $this->relatorio->consulta_ocorrencia_detalhado();
		$this->load->view("relatorio/ocorrencia/consulta_ocorrencia_detalhado",$data);
	}
	
	public function exportar_ocorrencia_detalhado(){
		$this->load->library('exportexcel');
		$data['detalhe'] = $this->relatorio->consulta_ocorrencia_detalhado();
		$this->exportexcel->exportar_ocorrencia_detalhado($data['detalhe']);
	}

	public function consultaColaborador(){
		$sup = "";
		$superior = $this->input->post('coordenador');
	
		if($superior){
			foreach ($superior as $value) {
				$sup .= $value.';';
			}
			
			$superior = substr($sup,0,-1);
			$resultado = $this->relatorio->consultaColaborador($superior);
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
	public function consultaColaboradorRelOcLancadas(){
		$sup = "";
		$superior = $this->input->post('coordenador');
	
		if($superior){
			foreach ($superior as $value) {
				$sup .= $value.';';
			}
			
			$superior = substr($sup,0,-1);
			$resultado = $this->relatorio->consultaColaboradorRelOcLancadas($superior);
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

	
	public function teste(){
		$data['dados'] = $this->relatorio->getRelatorioFrequencia();
		echo json_encode($data['dados']);
	}
	public function getMotivoRelOcMotivos(){
		$data = $this->relatorio->getMotivoRelOcMotivos();
		echo json_encode($data);
	}
	public function rel_ocorrencia_motivo(){
		$acesso = $this->acessoPermitido();
		$data ['menu'] = true;
		if($acesso):
			$data ['view'] = "relatorio/ocorrencia/ocorrencia_motivo";		
			$data['contratos'] = $this->relatorio->getContratoRelOcMotivos();
			// $data['motivos'] = $this->relatorio->consulta_motivo();
		else:
			$data ['view'] = "acessonegado/accessdenied";	
		endif;
		$this->load->view("includes/body",$data);
	}
	public function result_ocorrencia_motivo(){
		$motivo = implode(';',$this->input->post('motivo'));
		$dt_ini = implode('-', array_reverse(explode('/',$this->input->post('dt-ini'))));
		$dt_fim = implode('-', array_reverse(explode('/',$this->input->post('dt-fim'))));
		
		$data['detalhe_motivos'] = $this->relatorio->consulta_motivo_detalhes($motivo, $dt_ini, $dt_fim);
		$this->load->view('relatorio/ocorrencia/consulta_ocorrencia_motivo',$data);
	}

	public function acessoPermitido(){
		$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato');
		$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
		if($perfil){
			return true;
		}else{
			return false;
			
		}

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