<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cadastramento_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set('sqlsrv.ClientBufferMaxKBSize','5242880'); 
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','5242880');
        ini_set('memory_limit', '-1');
    }

    private function execProcedureAtualizacao($sql){
        $this->db->trans_begin();
        if(!$this->db->query($sql)){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }

    private function trataData($data){
		return implode('-', array_reverse(explode('/',$data)));
	}
	private function trataHora($horario){
        if($horario != null ){
            return date('Y-m-d H:i:s',strtotime("1999-01-01 ".$horario));
        }else{
            return null;
        }
    }
    
    private function inicializaCamposCadastramento(){
		// inicializa os campos conforme execução da procedure 
		$data = array ( 
			'MatriculaSCP'=>"",
			'Nome'=>"",
			'CPF'=>"",
			'MaeFuncionario'=>"",
			'Endereco'=>"",
			'Bairro'=>"",
			'Cidade'=>"",
			'ComplementoEndereco'=>"",
			'UF'=>"",
			'CEP'=>"",
			'Email'=>"",
			'RGFuncionario' => "",
			'RGOrgaoExpedidor' => "",
			'RGUF' => "",
			'RGDataExpedicao' => "",
			'PIS' => "",
			'CTPS' => "",
			'CTPSSerie' => "",
			'CTPSDataExpedicao' => "",
			'IdSexo' => "",
			'IdEstadoCivil' => "",
			'DataNascimento' => "",
			'IdGrauInstrucao' => "",
			'MatriculaSuperior' => "",
			'DataAdmissao' => "",
			'DataDemissao' => "",
			'Telefone1' => "",
			'Telefone2' => "",
			'MatriculaEmpresa' => "",
			'CGC' => "",
			'SITE' => "",
			'HorarioInicio' => "",
			'HorarioFim' => "",
			'HorarioAlmocoInicio' => "",
			'HorarioAlmocoFim' => "",
			"IdFuncao" => "",
			"IdEmpresa" => "",
			"IdContrato" => "",
			"IdSituacao" => "",
			"IdTelefonia1" => "",
			"IdTelefonia2" => "",
			"IdNivel" => "",
			"InicioPonto" => "",
			"IdBancoFuncionario" => "",
			"Agencia" => "",
			"DigitoAgencia" => "",
			"Conta" => "",
			"DigitoConta" => "",
			"TipoConta" => "",
			"OperacaoConta" => "", 
			"PostoTrabalho" => "", 
			"IdFila" => "",
			"NumeroArmario" => "",
			"NumeroFone" => "",
			"DependentesIR" => "",
			"Filhos" => "",
			"QuantidadeFilhos" => "",
			"Cid" => "",
			"Estabilidade" => "",
			"AlteradoPor" => "" 
		);
		return $data;
	}
    

    public function getIdBanco($banco=null){
        if($banco){
            $this->db->simple_query("set no count on");
            $sql = "
            Select
                [IdBancoFuncionario]
            from 
                [cp].[codigoBanco] 
            where 
                CONCAT([IdBancoFuncionario],' - ' collate SQL_Latin1_General_CP1_CI_AS,[Nome]) LIKE '%$banco%' collate SQL_Latin1_General_CP1_CI_AS     
            ";
            $data = $this->db->query($sql)->result_array();
            return $data[0]['IdBancoFuncionario'];
        }else{
            return null;
        }
    }

    public function getIdCGC($cgc=null){
        if($cgc){
            $this->db->simple_query("set no count on");
            $data = $this->db->query("EXEC cp.ConsultaUnidades '$cgc'")->result_array();
            return $data[0]['CGC'];
        }else{
            return null;
        }
       
    }

    public function getIdCid($cid=null){
        if($cid){
            $cid = explode("/",$cid);
            $cid = trim($cid[0]);
            $this->db->simple_query("set no count on");
            $data = $this->db->query("EXEC cp.ConsultaCid '$cid'")->result_array();
            return $data[0]['IdCid'];
        }else{
            return null;
        }
    }

    public function getIdFila($fila=null){
        if($fila){
            $this->db->simple_query("set no count on");
            $data = $this->db->query("EXEC cp.ConsultaFilaSegmento '$fila'")->result_array();
            return $data[0]['FilaId'];
        }else{
            return null;
        }
    }

    public function getStatusCivil(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaEstadoCivil")->result_array();
    }

    public function getGrauInstrucao(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaGrauInstrucao")->result_array();
    }

    public function getFuncaoEmpregado(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaFuncao")->result_array();
    }
    public function getConsultaContratoCadastro(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC [cp].[consultaConsultaContratosCadastro] ''")->result_array();
    }

    public function getEmpresas(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaEmpresa")->result_array();
    }

    public function getContrato($contrato){

        // print_r($contrato[0]['IdContrato']);
        // exit();
        $this->db->simple_query("set nocount on");
        return $this->db->query("EXEC cp.ConsultaContratosNew '{$contrato}'")->result_array();
    }
    public function getConsultaSexo(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaSexo")->result_array();
    }

    public function getConsultaSituacao(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaSituacao")->result_array();
    }

    public function getConsultaEstabilidade(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaEstabilidade")->result_array();
    }

    public function getConsultaFilhos(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaFilhos")->result_array();
    }


    public function getDadosEditCadastro($cpf){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC cp.ConsultaUpdateColaborador '$cpf'")->result_array();
    }

    
    public function getAutocompleteBanco($term=null){
        $this->db->simple_query("set no count on");
        $result = $this->db->query("EXEC cp.ConsultaCodigoBanco '%$term%'")->result_array();
        $i = 0;
        echo "[";
		foreach ($result as $k => $v) {
			if ($i == 0) {
				echo '"'.trim($v['Nome']).'"';
			} else {
				echo ',"'.trim($v['Nome']).'"';
			}
			$i ++;
		}
		echo "]";
    }
    public function retornaCodidoBanco(){
        $this->db->simple_query("set no count on");
        $result = $this->db->query("exec [cp].[retornaCodigoBanco]")->result_array();
        return $result;
    }

    public function getAutocompleteUnidades($term=null){
        $result = $this->db->query("EXEC cp.ConsultaUnidades '%$term%'")->result_array();
        $i = 0;
        echo "[";
        foreach ($result as $k => $v){
            if ($i == 0) {
				echo '"'.trim($v['SIGLA']).'"';
			} else {
				echo ',"'.trim($v['SIGLA']).'"';
			}
			$i ++;
		}
		echo "]";
    }

    public function getAutocompleteFila($term=null){
        $result = $this->db->query("EXEC cp.ConsultaFilaSegmento '%$term%'")->result_array();
        $i = 0;
        echo "[";
        foreach ($result as $k => $v){
            if ($i == 0) {
                echo '"'.trim($v['Fila']).'"';
            } else {
                echo ',"'.trim($v['Fila']).'"';
            }
            $i++;
        }
        echo "]";

    }
    public function getContratoEmpresa(){
        $param = $this->input->post();
        $empresa = $param['empresa'][0] != "" ? $param['empresa'][0] : "9999";
        $this->db->simple_query("set nocount on");
        return $this->db->query("EXEC [cp].[ConsultaContratosNEW] '{$empresa}'")->result_array();
    }
    public function getContratoFuncao(){
        $param = $this->input->post();
        $funcao = $param['funcao'][0] != "" ? $param['funcao'][0] : "9999";
        $this->db->simple_query("set nocount on");
        return $this->db->query("EXEC [cp].[ConsultaFuncaoNEW] {$funcao}")->result_array();
    }
    public function getContratoSuperior(){
        $param = $this->input->post();
        $funcao = $param['funcao'][0] != "" ? $param['funcao'][0] : "9999";
        $this->db->simple_query("set nocount on");
        return $this->db->query("EXEC [cp].[consultaSupervisorCadastro] {$funcao}")->result_array();
    }

    public function setInsereFuncionario($campos){
        $sql = "EXEC cp.InsereFuncionario ".$campos;
        return $this->execProcedureAtualizacao($sql);
    }

    public function setAtualizaFuncionario($campos){
        $sql = "EXEC cp.AlteraCadastroFuncionario ".$campos;
        return $this->execProcedureAtualizacao($sql);
    }

    public function getSupervisoresAutocomplete(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC [cp].[consultaSupervisor] ")->result_array();
    }
    public function getSupervisoresAutocompleteCadastro($contrato){
        // $this->db->simple_query("set no count on");
        // return $this->db->query("EXEC cp.consultaSuperioresContratosCadastro '{$contrato}',''  ")->result_array();
        return $this->db->query("EXEC [cp].[consultaSupervisorCadastroNEW] '{$contrato}'")->result_array();
    }

    public function getUF(){
        $this->db->simple_query("set no count on");
        return $this->db->query("EXEC [cp].[spMultiplaRetornaUFstados] ''")->result_array();
    }
                         
    public function getCidade($uf){
        return $this->db->query("exec cp.SelecionaMunicipios '$uf'")->result_array();
    }

    public function getCadastroUsuario($nome,$cpf,$matricula,$inativo,$contrato){
        $nome = trim($nome);
        $cpf = trim($cpf);
        $matricula = trim($matricula);
        $contrato = isset($contrato) ? implode(";",$contrato) : "";
        $this->db->simple_query('set nocount on');
        if($nome != null){
            if($inativo == "0"){
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioInativoCF] '{$contrato}','{$nome}'")->result_array();
            }else{
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioCF] '{$contrato}','{$nome}'")->result_array();
            }
            if(isset($result)){
                return $result;
            }
        }else if($cpf != null) {
            if($inativo == "0"){
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioInativoCF] '{$contrato}','{$cpf}'")->result_array();
            }else{
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioCF] '{$contrato}', '{$cpf}'")->result_array();
            }
            
            if(isset($result)){
                return $result;
            }
        }else if($matricula != null){
            if($inativo == "0"){
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioInativoCF] '{$contrato}', '{$matricula}'")->result_array();
            }else{
                $result = $this->db->query("EXEC [cp].[consultaCadastroFuncionarioCF] '{$contrato}', '{$matricula}'")->result_array();
            }
            if(isset($result)){
                return $result;
            }
        }
    }

    

    public function montaDadosCadastramento(){
        // monta o array com a ordem de execução da procedure 
        $data = $this->inicializaCamposCadastramento();
        // paramentros do formulário de cadastramento
        $param = $this->input->post();
        $param['IdEmpresa'] = $param['IdEmpresa'][0];
        $param['IdContrato'] = $param['IdContrato'][0];
        $param['IdFuncao'] = $param['IdFuncao'][0];
 

        // monta os dados com a ordem de execução da procedure
        foreach($data as $key=>$val){
            if(array_key_exists($key,$param)){
                $data[$key] = $param[$key];
            }
        }

        // tratativa das formatações para inserção no banco
        $data['DataNascimento'] = $this->trataData($data['DataNascimento']);
        $data['CPF'] = preg_replace("/[^0-9]/", "", $data['CPF']);
        $data['RGDataExpedicao'] = $this->trataData($data['RGDataExpedicao']);
        $data['CTPSDataExpedicao'] = $this->trataData($data['CTPSDataExpedicao']);
        $data['IdBancoFuncionario'] = $this->getIdBanco (trim($data['IdBancoFuncionario']));
        $data['CGC'] = $this->getIdCGC(trim($data['CGC']));
        $data['DataAdmissao'] = $this->trataData($data['DataAdmissao']);
        $data['DataDemissao'] = $this->trataData($data['DataDemissao']);
        $data['HorarioInicio'] = $this->trataHora($data['HorarioInicio']);
        $data['HorarioFim'] = $this->trataHora($data['HorarioFim']);
        $data['HorarioAlmocoInicio'] = $this->trataHora($data['HorarioAlmocoInicio']);
		$data['HorarioAlmocoFim'] = $this->trataHora($data['HorarioAlmocoFim']);
        $data['IdFila'] = $this->getIdFila($data['IdFila']);
        if($data['Email'] == null || $data['Email'] == ""): $data['Email']= null; else: $data['Email']= $data['Email']; endif;

        // log 
        $data['AlteradoPor'] = get_current_user();

        // preenche os inputs vazios para criar a string da procedure 
        foreach($data as $key=>$value){
            if($value == null ){
                $data[$key] = "''";
            }else{
                $data[$key] = "'".$value."'";
            }
        }
        return $data;
    }

}

?>