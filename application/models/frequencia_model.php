<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frequencia_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set('sqlsrv.ClientBufferMaxKBSize','5242880'); 
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','5242880');
        ini_set('memory_limit', '-1');
    }

    private function trataData($data){
        return implode('-', array_reverse(explode('/',$data)));
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

    public function calculaTotalParcial($data){
        $array = array();
        $ret = array();
        // monda um array com os saldos do dia 
        foreach ($data as $k=>$val){
            $array[$k]['Sald'] = ($val['Cred'] - $val['Deb1']);
        }
        $total = 0;
        // percorre o array somando os totais do dia 
        foreach ($array as $row){
            $total = $total + $row['Sald']; 
        }
        // verifica se o saldo é negativo ou positivo
        if($total < 0 ){
            $ret['saldo'] = "N";
        }else{
            $ret['saldo'] = "P";
        }

        $ret['total'] = $this->calculaHora(abs($total));
       
        return $ret;
    }

    public function getDadosTelaPonto($usr){
        $this->db->simple_query("set nocount on");
        return $this->db->query("exec cp.ConsultaEmpregadoTelaPonto '$usr'")->row_array();
    }

    public function getVerificaPonto($usr){
        return $this->db->query("exec cp.VerificaPonto '$usr'")->row_array();
    }
    public function limitarFuncoes(){
        return $this->db->query("exec cp.RestringeFuncaoOperador")->result_array();
    }

    public function setRegistroPonto($usr){
        // se o id for 1 registra a entrada caso seja 2 registra a saída
        $id = $this->input->post("id");
        $this->db->simple_query("set nocount on");
        return $this->db->query("exec cp.RegistraPonto $usr, $id")->row_array();
    }

    public function getFolhaFrequencia($usr,$date=null){
        if($date == null){
            $date = date('Y-m');
        }
        if($this->input->post('periodo')){
           $date =  implode('-', array_reverse(explode('/',$this->input->post('periodo'))));
        }
        return $this->db->query("exec cp.ConsultaPontoFolhaColaboradorNEW '$usr','$date'")->result_array();
    }

    public function getEmpregadosFolha($usr){
         return $this->db->query("exec cp.ConsultaColaboradorFolha '$usr'")->result_array(); /**DESCARTE */
    }
    public function getEmpregadosContPonto($usr){
         return $this->db->query("exec cp.ConsultaColaboradorContP '$usr'")->result_array();
    }

    public function getEmpregadosFolhaSelect(){
        $param = $this->input->post();
        $superior = isset($param['superior'][0]) ? $param['superior'][0] : "2";
        return $this->db->query("exec cp.spConsultaColaboradorADM '{$superior}'")->result_array();
    }
    public function getEmpregadosFolhaSelectNew(){/**DESCARTE */
        $param = $this->input->post();
        $superior = isset($param['superior'][0]) ? $param['superior'][0] : "2";
        return $this->db->query("exec cp.spConsultaColaboradorADM '{$superior}'")->result_array();
    }
    public function getEmpregadosControleFolha(){
        $param = $this->input->post();
        $superior = isset($param['superior'][0]) ? implode(";",$param['superior']) : "2";
        return $this->db->query("exec cp.ConsultaColaboradorContP '{$superior}'")->result_array();
    }
    public function validaDiaUtil($data,$param){
        return $this->db->query("exec [cp].[consultaFechaFolha] '{$data}',$param")->result_array();
    }

    public function getCoordenadoresFolha($user){
        return $this->db->query("exec cp.spConsultaCoordADM '$user', '' ")->result_array(); /**DESCARTE */
    }
    public function getConsultaCoordContPonto(){
        $param = $this->input->post();
        $contrato = isset($param['contrato'][0]) ? $param['contrato'][0] : "2";
        return $this->db->query("EXEC cp.ConsultaCoordContP '{$contrato}',''")->result_array();
    }
    public function getConsultaCoordContPontoLogado($contrato){
        return $this->db->query("EXEC cp.ConsultaCoordContPLOG  '{$contrato}',''")->result_array();
    }
    public function getConsultaCoordFolhaPontoLogado($contrato){
        return $this->db->query("EXEC cp.ConsultaCoordFPLOG  '{$contrato}',''")->result_array();
    }
    public function getConsultaSupervisoresFolhaPontoLogado($coord){
        return $this->db->query("EXEC cp.ConsultaSuperioresFPLOG '{$coord}'")->result_array();
    }

    public function getPesqFolhaFuncionario($usr){
        $param = $this->input->post();
        $param['data'] = implode('-', array_reverse(explode('/',$param['data'])));
        $param['superior'] = isset($param['superior']) ? $param['superior'] : $usr;
        //print_r($param);
        //die();
        //$param['data-fim'] = $this->trataData($param['data-fim']);
        // return $this->db->query("EXEC cp.RelatorioPontoFolhaADM '{$param['nome']}','{$param['data']}','{$param['superior']}'")->result_array();
         return $this->db->query("EXEC cp.RelatorioPontoFolhaAdmVerificador '{$param['nome']}','{$param['data']}','{$param['superior']}'")->result_array();
         //print_r($this->db->last_query());
    }

    public function setRegistraPontoDiaADM($usr){
        $param = $this->input->post();
        if($param['opcao'] == '1' ){
            $this->db->simple_query("set nocount on");
            return $this->db->query("EXEC cp.RegistraPontoAdmDIA '{$param['nome_modal']}','{$param['opcao']}','{$usr}','{$param['input-hr']}',''")->result_array();
        }else if($param['opcao'] == '2'){
            $this->db->simple_query("set nocount on");
            return $this->db->query("EXEC cp.RegistraPontoAdmDIA '{$param['nome_modal']}','{$param['opcao']}','{$usr}','','{$param['input-hr']}'")->result_array();
        }
    }

    public function setRegistroLoteFolha($usr){
        
        $param = $this->input->post('arr');
        $this->db->trans_begin();
        $str = "";
        
        foreach($param as $row){
            $row['data'] = $this->trataData($row['data']);
            $str.= "{$usr};{$row['matricula']};{$row['data']};{$row['eAutorizada']};{$row['sAutorizada']};{$row['eAutorizadaAlmoco']};{$row['sAutorizadaAlmoco']};{$row['eAutorizadaPausa1']};{$row['sAutorizadaPausa1']};{$row['eAutorizadaPausa2']};{$row['sAutorizadaPausa2']}|";
        }

        $this->db->query("exec cp.RegistraPontoAdmFolhaAlt '$str'");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ret ['mensagem'] = "Algo deu errado, por favor tente novamente!";
            $ret ['tipo'] = false;
        }else{
            $this->db->trans_commit();
            $ret ['mensagem'] = "Status alterado com sucesso!";
            $ret ['tipo'] = true;
        }
        return $ret;
    }

    public function getEmpregadosFolhaPonto($user){
        return $this->db->query("EXEC cp.spConsultaSuperiorADM '$user'")->result_array(); /**DESCARTE */
    }
    public function getEmpregadosFolhaPontoFP($user){
        return $this->db->query("EXEC [cp].[ConsultaColaboradorFP] '$user'")->result_array();
    }

    public function getFolhaEmpregadoPonto($user=null){
        $param = $this->input->post(); 
        // se o parametro superior existir significa que o perfil é ADMINISTRADOR, caso contrário pega a matrícula do SUPERVISOR
        $superior = isset($param['superior']) ? implode(";",$param['superior']) : $user;
        $periodo = $this->trataData($this->input->post('periodo'));
        $nome = isset($param['nome']) ? implode(";", $param['nome']) : '';
        if($superior == $nome ){
            $superior = implode(';',$param['coordenador']);
        }
        return $this->db->query("EXEC cp.spConsultaPontoFolhaColaborador '$periodo','$superior','$nome'")->result_array();
    }

    public function getCoordenadoresFolhaPonto($user){
        return $this->db->query("exec cp.spConsultaCoordADM '$user', '' ")->result_array(); /**DESCARTE */
    }
    public function getContratos(){
        return $this->db->query("EXEC [cp].[consultaConsultaContratosFP] ''")->result_array();
    }
    public function getContratoContPonto(){
        return $this->db->query("EXEC [cp].[consultaConsultaContratosContP] ''")->result_array();
    }
    public function consultaCoordFolhaPonta($contrato){
        $param = $contrato[0];
        return $this->db->query("EXEC [cp].[ConsultaCoordFP] '{$param}',''")->result_array();
    }
    public function ConsultaColaboradorContratoFP(){
        $param = get_current_user();
        return $this->db->query("EXEC [cp].[ConsColaboradorContratoFP] '{$param}', '1'")->result_array();
    }

    public function getSuperioresFolhaPonto(){
        return $this->db->query("exec cp.spConsultaSuperiorPontoFolhaADM ''")->result_array();
    }

    public function getSupervisoresFolhaControlePonto(){
        $param = $this->input->post();
        $coordenador = $param['coordenador'] != "" ? implode(";",$param['coordenador']) : "2";
        return $this->db->query("EXEC cp.spConsultaSuperiorADM '{$coordenador}'")->result_array(); /**DESCARTE */
    }

    public function getSupervisoresFolhaControlePontoFP(){
        $param = $this->input->post();
        $coordenador = $param['coordenador'] != "" ? implode(";",$param['coordenador']) : "2";
        return $this->db->query("EXEC [cp].[ConsultaSuperiorFP] '{$coordenador}'")->result_array();
    }

    public function getSupervisoresFolhaControlePontoNew(){
        $param = $this->input->post();
        // print_r($param);
        // exit();
        $coordenador = $param['coordenador'][0] != "" ? $param['coordenador'][0] : "2";
        return $this->db->query("EXEC cp.spConsultaSuperiorADM '{$coordenador}'")->result_array();/**DESCARTE */
    }
    public function getSupervisoresControlePonto(){
        $param = $this->input->post();
        $coordenador = $param['coordenador'][0] != "" ? implode(";",$param['coordenador']) : "2";
        return $this->db->query("EXEC cp.ConsultaSuperiorContP '{$coordenador}'")->result_array();
    }
    public function getSupervisoresControlePontoLogado($coordenador){
        return $this->db->query("EXEC cp.ConsultaSuperiorContPLOG '{$coordenador}'")->result_array();
    }
    public function getSupervisoresFolhaPontoLogado($coordenador){
        return $this->db->query("EXEC cp.ConsultaSuperiorFolhaPontoLOG '{$coordenador}'")->result_array();
    }

    public function getEmpregadosFolhaControlePonto(){
        $param = $this->input->post();
        $superior = !empty($param['superior']) ? implode(";",$param['superior']) : "2";
        return $this->db->query("exec cp.spConsultaColaboradorADM '{$superior}'")->result_array();/**DESCARTE */
        
    }
    public function getEmpregadosFolhaControlePontoFPADM(){
        $param = $this->input->post();
        $superior = !empty($param['superior']) ? implode(";",$param['superior']) : "2";
        return $this->db->query("exec cp.ConsultaColaboradorFPADM '{$superior}'")->result_array();
        
    }

    public function getEmpregadosFolhaControlePontoFP(){
        $param = $this->input->post();
        $superior = !empty($param['superior']) ? implode(";",$param['superior']) : "2";
        return $this->db->query("exec [cp].[ConsultaColaboradorFP] '{$superior}'")->result_array();
        
    }

}