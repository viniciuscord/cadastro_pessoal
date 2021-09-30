<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Escala_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    private function trataData($data){
        return implode('-', array_reverse(explode('/',$data)));
    }

   public function getEmpregadosFolha($usr){
        return $this->db->query("exec cp.ConsultaColaboradorFolha '$usr'")->result_array();
   }

   public function getDadosEscala(){
       $param = $this->input->post();
       $superior = get_current_user();
       if(get_current_user() == 'p981809' || get_current_user() == 'p536249' || get_current_user() == 'p566774'){/** MATRÍCULAS DE TESTE - DESENVOLVIMENTO */
            $superior = "p560433"; /** MATRÍCULA DO GUILHERME */
        }
       if( $this->input->post('sup')): $mt = implode(';',$param['sup']); else: $mt = ""; endif;
       if( $this->input->post('colaborador')): $col = implode(';',$param['colaborador']); else: $col = ""; endif;
       if( $this->input->post('status')): $status = implode(';',$param['status']); else: $status = ""; endif;
       $param['periodo'] = $this->trataData($param['periodo']);

       $this->db->simple_query("set nocount on");
       if($this->session->userdata("acesso") == "Planejamento" || $this->session->userdata("acesso") == "Administrador"){
         return $this->db->query("exec cp.ConsultaEscalaPlanejamento_new '{$param['periodo']}', '{$col}', '{$status}'")->result_array();
       }else{
          return $this->db->query("exec cp.ConsultaEscalaSupervisor_new '{$param['periodo']}', '{$mt}','{$status}','{$superior}' ")->result_array();
       }
    }

   public function setEscala($usr){
        $param = $this->input->post();
        $param['input-data'] = $this->trataData($param['input-data']);

        $this->db->trans_begin();
        if($this->input->post('sup_modal')){ /* ação para supervisor*/
        
        foreach ($param['sup_modal'] as $matricula) {
            $this->db->simple_query("set nocount on");
            $valida_escala = $this->db->query("exec [cp].[ValidaEscalaNova] '{$matricula}', '{$param['input-data']}'")->row_array();
            if($valida_escala['MENS'] == 'OK'){
                $result = $this->db->query("exec cp.InsereEscalaNew '{$matricula}', '{$param['input-data']}', '{$param['input-hr-ini']}', '{$param['input-hr-said']}','$usr', '{$param['justificativa']}'")->row_array();
                // $result = $this->db->query("exec cp.InsereEscala '{$matricula}', '{$param['input-data']}', '{$param['input-hr-ini']}', '{$param['input-hr-said']}','$usr', '{$param['justificativa']}'")->row_array();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $ret ['matricula'] = "";
                    $ret ['mensagem'] = "Algo deu errado, por favor tente novamente!";
                    $ret ['tipo'] = false;
                    return $ret;
                }
            }else{
                $this->db->trans_rollback();
                $ret ['matricula'] = $valida_escala['MATRICULA'];
                $ret ['tipo'] = false;
                return $ret;

            }
        }
        
        }else{ /* ação para administrador*/
            
            foreach ($param['colaborador_modal'] as $matricula) {
                $this->db->simple_query("set nocount on");
                $valida_escala = $this->db->query("exec [cp].[ValidaEscalaNova] '{$matricula}', '{$param['input-data']}'")->row_array();
                if($valida_escala['MENS'] == 'OK'){

                    $result = $this->db->query("exec cp.InsereEscalaNew '{$matricula}', '{$param['input-data']}', '{$param['input-hr-ini']}', '{$param['input-hr-said']}','$usr', '{$param['justificativa']}'")->row_array();
                    $this->db->query("exec cp.AutorizaEscala '{$matricula}','$usr','{$param['input-data']}','Autorização Automática do Sistema - Escala criada por Administrador',1")->row_array();
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $ret ['matricula'] = "";
                        $ret ['mensagem'] = "Algo deu errado, por favor tente novamente!";
                        $ret ['tipo'] = false;
                        return $ret;
                    }
                }else{
                    $this->db->trans_rollback();
                    $ret ['matricula'] = $valida_escala['MATRICULA'];
                    $ret ['tipo'] = false;
                    return $ret;

                }
            }
            
        }
        $this->db->trans_commit();
        $ret ['mensagem'] = "Escala cadastrada com sucesso!";
        $ret ['tipo'] = true;
        return $ret;
    }

    public function getDadosEscalaEmpregado(){
        $param = $this->input->post();
        $param['data'] = $this->trataData($param['data']);
        $this->db->simple_query("set nocount on");
        return $this->db->query("exec cp.ConsultaEscala '{$param['matricula']}','{$param['data']}' ")->row_array();
    }

    public function setDadosEscalaPlanejamento($usr){
        $param = $this->input->post();
        return $this->db->query("exec cp.AutorizaEscala '{$param['matricula']}','$usr','{$param['data']}','{$param['justificativa']}','{$param['solicitacao']}'")->row_array();
    }

    public function setDadosEscalaSupervisor($usr){
        $param = $this->input->post();
        return $this->db->query("exec cp.AlteraEscalaFuncionario '{$param['matricula']}','{$param['data']}','{$param['input-hr-ini']}','{$param['input-hr-said']}','$usr','{$param['justificativa']}'")->row_array();
    }
    public function getFuncaoEscala(){
        return $this->db->query("exec cp.consultaFuncaoEscala")->result_array();
    }
    public function consultaSuperiorFuncao($sup){
        $this->db->simple_query('set nocount on');
        $sql = "exec cp.consultaSuperiorFuncao '$sup' ";
        return $this->db->query($sql)->result_array();
    }
    public function consultaColaboradorEscala($matricula){
        $this->db->simple_query('set nocount on');
        $sql = "exec cp.consultaColaboradorEscala '$matricula' ";
        return $this->db->query($sql)->result_array();
    }

}