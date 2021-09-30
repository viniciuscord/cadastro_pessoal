<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ocorrencia_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function trataData($data){
        return implode('-', array_reverse(explode('/',$data)));
    }

    private function getIdCID($desc){
        if($desc){
            $desc = explode("/",$desc);
            $desc = trim($desc[0]);
            $data = $this->db->query("EXEC cp.ConsultaCid '$desc'")->row_array();
            return $data['IdCid'];
        }else{
            return null;
        }
        //return $this->db->query("exec [cp].[ConsultaCid] '$desc' ")->row_array();
    }

    private function getDadosComplementares($matricula){
        return $this->db->query("exec [cp].[ConsultaDadosDetalhado] '$matricula'")->row_array();
    }

    private function insertCadastroOcorrencia($param,$usr){
        $param['input-cid'] =  isset($param['input-cid']) ? $this->getIdCID($param['input-cid']) : "";
        $param['input-data-ini'] = $this->trataData($param['input-data-ini']);
        $param['input-data-fim'] = $this->trataData($param['input-data-fim']);
        $param_aux = $this->getDadosComplementares($param['nome_modal'][0]);

        if($param['tipo_ocorr'][0] == '1'){
            $this->db->simple_query("set no count on");
            return $this->db->query("exec cp.InsereOcorrenciasPonto '{$param['nome_modal'][0]}','{$param['motivo_ocorr'][0]}','{$usr}','{$param['justificativa']}','{$param['input-cid']}','{$param['input-data-ini']}','{$param['input-data-fim']}','{$param_aux['CPF']}','{$param_aux['IdFuncao']}' ")->result_array();
        }else{
            $this->db->simple_query("set no count on");
            return $this->db->query("exec cp.InsereOcorrenciaAdministrativa '{$param['nome_modal'][0]}','{$param['motivo_ocorr'][0]}','{$usr}','{$param['justificativa']}','{$param['input-data-ini']}','{$param['input-data-fim']}'")->result_array();
        }
    }

    private function updateCadastroOcorrencia($param,$usr){
        $param['input-cid'] =  isset($param['input-cid']) ? $this->getIdCID($param['input-cid']) : "";
        $param['input-data-ini'] = $this->trataData($param['input-data-ini']);
        $param['input-data-fim'] = $this->trataData($param['input-data-fim']);
        $param_aux = $this->getDadosComplementares($param['nome_modal'][0]);

        if($param['tipo_ocorr'][0] == '1'){
            sqlsrv_configure('WarningsReturnAsErrors', 0);
            return $this->db->query("exec cp.AlteraOcorrenciaPonto '{$param['num_ocorrencia']}','{$param['nome_modal'][0]}','{$param['motivo_ocorr'][0]}','{$usr}','{$param['justificativa']}','{$param['input-cid']}','{$param['input-data-ini']}','{$param['input-data-fim']}','{$param_aux['CPF']}','{$param_aux['IdFuncao']}'")->result_array();
        }else{
            sqlsrv_configure('WarningsReturnAsErrors', 0);
            return $this->db->query("exec cp.AlteraOcorrenciaAdministrativa '{$param['num_ocorrencia']}','{$param['nome_modal'][0]}','{$param['motivo_ocorr'][0]}','{$usr}','{$param['justificativa']}','{$param['input-data-ini']}','{$param['input-data-fim']}'")->result_array();
        }
        // print_r($usr)
    }


    public function getEmpregadosOcorr($usr){
        return $this->db->query("exec cp.ConsultaColaboradorFolha '$usr'")->result_array();
    }
    public function validaMotivo($motivo){
        $valida = $this->db->query("EXEC cp.validaMotivo")->result_array();
        foreach ($valida as $k => $value) {
            if($motivo == $value['IdMotivo']): return false; endif;
        }
        return true;
    }

    public function getDadosOcorrencia($usr){
        $param = $this->input->post();
        $param['periodo'] = $this->trataData($param['periodo']);
        $nome = $param['nome'] != "" ? implode(";",$param['nome']) : "";
        // $this->db->simple_query('set nocount on');
        return $this->db->query("exec cp.ConsultaOcorrencias '$usr','{$param['periodo']}','$nome' ")->result_array();
        //print_r($this->db->last_query());
    }
  
    public function getMotivoOcorr(){

        return $this->db->query("exec cp.ConsultaMotivosOcorrenciasPonto")->result_array();
    }

    public function getDadosOcorrenciaUsr(){
        $param = $this->input->post();
        return $this->db->query("exec cp.ConsultaUpdateOcorrencia '{$param['num_ocorrencia']}','{$param['matricula']}'")->row_array();
        //print_r($this->db->last_query());
    }

    public function getMotivos(){
        $tipo = $this->input->post("tipo");
        $contrato = $this->input->post('contrato');
        $contrato = $contrato[0];

        $modulo_acesso = array(	'modulo' => 'ocorrencia', 'submodulo' => null,'nome_function' => null, 'type' => 'model', 'acao' => 'negar', 'situacao' =>  1);
		$perfil = Permissao_helper::validaAcessoOcorrencia($modulo_acesso);
		
		if(!$perfil):
            $matSup = get_current_user();
            $this->db->simple_query('set nocount on');
            $idSupContrato = $this->db->query("EXEC cp.ConsultaColaboradorContratoOc '{$matSup}'")->row_array();
            $contrato = $idSupContrato['IdContrato'];
        endif;
        return $tipo[0] == '1' ? $this->db->query("exec [cp].[ConsultaMotivosOcorrenciasPontoNEW] '{$contrato}'")->result_array() : $this->db->query("exec [cp].[ConsultaMotivosOcorrenciasAdministrativasNEW] '{$contrato}'")->result_array();
    }

    public function getContratos(){
        return $this->db->query("EXEC cp.consultaConsultaContratosOC ''")->result_array();
    }
    public function getSupervisoresOCLogado($coordenador){
        return $this->db->query("EXEC cp.ConsultaSuperiorOCLOG '{$coordenador}'")->result_array();
    }
    public function getCoordenadoresOcorrencia($contrato){
        return $this->db->query("EXEC [cp].[ConsultaCoordOC] '{$contrato}',''")->result_array();
    }
    public function getConsultaCoordOCLogado($contrato){
        return $this->db->query("EXEC CP.ConsultaCoordOCLOG  '{$contrato}',''")->result_array();
    }

    public function getSupervisoresFolhaControlePonto(){
        $param = $this->input->post();
        $coordenador = $param['coordenador'] != "" ? implode(";",$param['coordenador']) : "2";
        return $this->db->query("EXEC [cp].[ConsultaSuperiorOC] '{$coordenador}'")->result_array();
    }

    public function getEmpregadosFolhaSelect(){
        $param = $this->input->post();
        // $superior = isset($param['superior'][0]) ? implode(";",$param['superior'][0]) : "2";
        $superior = $param['superior'] != "" ? implode(";",$param['superior']) : "2";
        return $this->db->query("exec [cp].[ConsultaColaboradorOC] '{$superior}'")->result_array();
    }

    public function getAutocompleteCID($term=null){
        $result = $this->db->query("EXEC cp.ConsultaCid '$term'")->result_array();
        $i = 0;
        echo "[";
        foreach ($result as $k => $v){
            if ($i == 0) {
                echo '"'.trim($v['CID']).'"';
            } else {
                echo ',"'.trim($v['CID']).'"';
            }
            $i ++;
        }
        echo "]";
    }

    public function setCadastroOcorrencia($usr){
        $param = $this->input->post();
        if($param['contr_ocorr'] == '0'){
            return $this->insertCadastroOcorrencia($param,$usr);
        }else{
            return $this->updateCadastroOcorrencia($param,$usr);
        }
    }

    public function setExclusaoOcorrencia($usr){
        sqlsrv_configure('WarningsReturnAsErrors', 0);
        $param = $this->input->post();
        $param['data_ini'] = $this->trataData($param['data_ini']);
        $param['data_fim'] = $this->trataData($param['data_fim']);
        return $this->db->query("EXEC cp.InativarOcorrencia '{$param['num_ocorrencia']}','{$param['matricula']}','{$param['id_motivo']}','{$usr}','{$param['ocorrencia']}','{$param['data_ini']}','{$param['data_fim']}'")->result_array();
        
    }

}