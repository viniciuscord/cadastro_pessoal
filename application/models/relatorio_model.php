<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relatorio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); 
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
        ini_set('memory_limit', '-1');
    }

    private function trataData($data){
        return implode('-', array_reverse(explode('/',$data)));
    }

    public function getOpcoesCGC(){
        return $this->db->query("EXEC cp.SpMultiplaRetornaCGC ''")->result_array();
    }
    public function consultaContratosRelAtivos(){
        return $this->db->query("EXEC cp.consultaContratosRelAtivos ''")->result_array();
    }

    public function getOpcoesEmpresa($cgc=null){
        $param = $this->input->post();
        $cgc = isset($param['cgc']) ? implode(";",$param['cgc']) : "";
        return $this->db->query("EXEC cp.SpMultiplaRetornaEmpresa '$cgc',''")->result_array();
    }

    public function getOpcoesSuperior($emp=null){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        $cgc = isset($param['cgc']) ? implode(";",$param['cgc']) : "";
        $emp = isset($param['empresa']) ? implode(";",$param['empresa']) : "";
        return $this->db->query("EXEC cp.SpMultiplaRetornaSuperiorNEW '{$cgc}','{$emp}','{$contrato}',''")->result_array();
    }
    public function getContrato(){
        $param = $this->input->post();
        $contrato = isset($param['empresa']) ? implode(";",$param['empresa']) : "";
        return $this->db->query("EXEC cp.SpMultiplaRetornaContratos '{$contrato}'")->result_array();
    }
    public function getSuperiorContratosRelAtivos(){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        return $this->db->query("EXEC CP.consultaSuperioresContratosRelAtivos '{$contrato}',''")->result_array();
    }

    public function getOpcoesFuncao($func=null){
        $param = $this->input->post();

        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        $cgc = isset($param['cgc']) ? implode(";",$param['cgc']) : "";
        $emp = isset($param['empresa']) ? implode(";",$param['empresa']) : "";
        return $this->db->query("EXEC cp.SpMultiplaRetornaFuncaoNEW '{$cgc}','{$emp}','{$contrato}',''")->result_array();
    }

    public function getSupervisoresRelFreqLogado($coordenador){
        return $this->db->query("cp.ConsultaSuperiorRelFreqLOG '{$coordenador}'")->result_array();
    }

    public function getConsultaCoordRelFreqLogado($contrato){
        return $this->db->query("EXEC CP.ConsultaCoordRelFreqLOG '{$contrato}',''")->result_array();
    }

    public function getRelatorioResult(){ 
        $param = $this->input->post();
        $param['cerat'] = isset($param['cerat']) ? implode(";",$param['cerat']) : "";
        $param['empresa'] = isset($param['empresa']) ? implode(";",$param['empresa']) : "";
        $param['superior'] = isset($param['superior']) ? implode(";",$param['superior']) : "";
        $param['funcao'] = isset($param['funcao']) ? implode(";",$param['funcao']) : "";
        // return $this->db->query("EXEC cp.RelatorioConsolidado '{$param['agrupador']}','{$param['cerat']}','{$param['empresa']}','{$param['superior']}','{$param['funcao']}'")->result_array();
        return $this->db->query("EXEC cp.RelatorioConsolidadoNEW '{$param['agrupador']}','{$param['cerat']}','{$param['empresa']}','{$param['superior']}','{$param['funcao']}'")->result_array();
    }

    public function getRelatorioDetalhadoResult(){
        $param = $this->input->post();
        return $this->db->query("EXEC cp.RelatorioDetalhado '{$param['cgc']}','{$param['idEmpresa']}','{$param['codSuperior']}','{$param['idFuncao']}'")->result_array();
    }

    public function getSupervisores(){
        return $this->db->query("EXEC cp.SpMultiplaRetornaSuperiorPonto '' ")->result_array();
    }

    public function getContratoRelFreq(){
        return $this->db->query("EXEC cp.ConsultaContratosRelF ''")->result_array();
    }

    public function getContratoRelOcLancadas(){
        return $this->db->query("EXEC cp.ConsultaContratosRelOC ''")->result_array();
    }
    public function getContratoRelOcMotivos(){
        return $this->db->query("EXEC CP.ConsultaContratosRelOCMOT ''")->result_array();
    }

    public function getContratoRelListaOperador(){
        return $this->db->query("EXEC cp.consultaConsultaContratosRelLO ''")->result_array();
    }

    public function getRelatorioFrequencia(){
        $db = $this->load->database("odbc",true);
        $param = $this->input->post();
        $supervisor = isset($param['supervisor']) ? implode(";",$param['supervisor']) : "";
        $colaborador = isset($param['colaborador']) ? implode(";",$param['colaborador']) : "";
        $data = isset($param['data']) ? $this->trataData($param['data']) : date('Y-m');
        return $db->query("EXEC cp.RelatorioPontoColaboradores '{$colaborador}','{$supervisor}','{$data}'")->result_array();
    }

    public function getCoordRelFreq(){
        $param = $this->input->post();
        $coord = isset($param['coordenador']) ? implode(";",$param['coordenador']) : "";
        return $this->db->query("EXEC cp.ConsultaSuperiorRelF '{$coord}'")->result_array();
    }
    public function getColaboradoresRelFreq(){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        return $this->db->query("EXEC cp.ConsultaCoordRelF '{$contrato}',''")->result_array();
    }
    public function getCoordRelOcLancadas(){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        return $this->db->query("EXEC cp.ConsultaCoordRelOC '{$contrato}',''")->result_array();
    }
    public function getColaboradores(){
        $param = $this->input->post();
        $supervisor = isset($param['supervisor']) ? implode(";",$param['supervisor']) : "";
        return $this->db->query("EXEC cp.ConsultaColaboradorRelF '{$supervisor}'")->result_array();
    }
    public function getColaboradoresRelFreqSupervisor($supervisor){
        return $this->db->query("EXEC cp.ConsultaColaboradorRelF '{$supervisor}'")->result_array();
    }
    public function buscaColaborador(){
        $modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => null,'nome_function' => 'buscaColaborador', 'type' => 'model', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoRelatorioColaborador($modulo_acesso);
        // if($this->session->userdata("acesso") == "Administrador" || $this->session->userdata("acesso") == "Coordenador TI"){
        if($acesso){
            $param = $this->input->post();
            $supervisor = isset($param['superior']) ? implode(";",$param['superior']) : get_current_user();
        }else{
            $supervisor = get_current_user();
            if(get_current_user() == 'p981809' || get_current_user() == 'p536249' || get_current_user() == 'p566774'){/** MATRÍCULAS DE TESTE - DESENVOLVIMENTO */
                $supervisor = 'P661343';/**matricula ivan --- Teste*/
            }

        }
        $sql = "EXEC [cp].[RelatorioColaboradoresSimplificado] '{$supervisor}'";
        return $this->db->query($sql)->result_array();
    }
    public function consultaColaborador($matricula){
        $this->db->simple_query('set nocount on');
        $sql = "EXEC [cp].[spConsultaSuperiorOco] '$matricula' ";
        return $this->db->query($sql)->result_array();
    }
    public function consultaColaboradorRelOcLancadas($matricula){
        $sql = "EXEC [cp].[spConsultaSuperiorOco] '$matricula' ";
        return $this->db->query($sql)->result_array();
    }
    public function consultaSuperiorRelListaOperadores($matricula){
        $this->db->simple_query('set nocount on');
        $sql = "EXEC [cp].[ConsultaSuperiorRelLO] '$matricula' ";
        return $this->db->query($sql)->result_array();
    }
    public function getConsultaContratoRelListaOperadores(){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        $sql = "EXEC cp.ConsultaCoordRelLO '{$contrato}','' ";
        return $this->db->query($sql)->result_array();
    }
    public function getCoordenadoresFolha($user){
        return $this->db->query("exec cp.spConsultaCoordADM '$user', '' ")->result_array();
    }
    public function consulta_ocorrencia(){
        $param = $this->input->post();
        $t_ocorrencia =  implode(";",$param['tipo_ocorrencia']);

        $dtini = explode('/',$param['dt-ini']);
        $dtini = implode('-',array_reverse($dtini));

        $dtfim = explode('/',$param['dt-fim']);
        $dtfim = implode('-',array_reverse($dtfim));
        $superior = '';

        $modulo_acesso = array(	'modulo' => 'relatorio', 'submodulo' => null,'nome_function' => 'consulta_ocorrencia', 'type' => 'model', 'acao' => 'negar', 'situacao' =>  1);
		$acesso = Permissao_helper::validaAcessoRelatorioOcorrenciasLancadas($modulo_acesso);
        
        if($acesso){
            if(isset($param['superior'])){
                $superior = implode(';',$param['superior']);
            }

        }else{
            $superior = get_current_user();
            if(get_current_user() == 'p981809'){ /** TESTE DE DESENVOLVIMENTO */
                $superior = 'P661343';
            }

        }
        $sp = "EXEC cp.relatorioOcorrencia  '$dtini','$dtfim','$superior','{$t_ocorrencia}'";
        return $this->db->query($sp)->result_array();
    }
    public function consulta_ocorrencia_detalhado(){
        $param = $this->input->post();

        if(is_array($param['tipo_ocorrencia'])){
            $t_ocorrencia =  implode(";", $param['tipo_ocorrencia']);
        }else{
            $string_1 =  substr($param['tipo_ocorrencia'], 0, 1);
            $string_2 =  substr($param['tipo_ocorrencia'], 2, 3);

            $t_ocorrencia = trim($string_1.";".$string_2);
        }

        $motivo =  $param['motivo'];

        $dtini = explode('/',$param['dtinicio']);
        $dtini = implode('-',array_reverse($dtini));

        $dtfim = explode('/',$param['dtfim']);
        $dtfim = implode('-',array_reverse($dtfim));
        $superior = '';

        $sp = "EXEC cp.relatorioOcorrenciaDetalhado {$motivo}, '{$dtini}','{$dtfim}','{$param['inseridopor']}','{$param['matricula']}','{$t_ocorrencia}'";
        return $this->db->query($sp)->result_array();
    }
    public function consulta_motivo(){
        $sp = "EXEC cp.MultiplaretornaMotivo";
        return $this->db->query($sp)->result_array();
    }
    public function getMotivoRelOcMotivos(){
        $param = $this->input->post();
        $contrato = isset($param['contrato']) ? implode(";",$param['contrato']) : "";
        $sp = "EXEC cp.ConsultaMotivoRelOCMOT '{$contrato}'";
        $this->db->simple_query('set nocount on');
        return $this->db->query($sp)->result_array();
    }
    public function consulta_motivo_detalhes($motivo, $dt_ini, $dt_fim){
        $sp = "EXEC cp.RelatorioOcorrenciaPontoRH '$dt_ini','$dt_fim','$motivo'";
        $this->db->simple_query('set nocount on');
        $returno = $this->db->query($sp)->result_array();
        // print_r($this->db->last_query());
        return $returno;
    }
}