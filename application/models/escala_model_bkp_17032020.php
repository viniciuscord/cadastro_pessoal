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
       $param['periodo'] = $this->trataData($param['periodo']);
       $this->db->simple_query("set nocount on");
       if($this->session->userdata("acesso") == "Planejamento"){
         return $this->db->query("exec cp.ConsultaEscalaPlanejamento '{$param['periodo']}'")->result_array();
       }else{
          return $this->db->query("exec cp.ConsultaEscalaSupervisor '{$param['periodo']}', '{$param['nome']}' ")->result_array();
       }
    }

   public function setEscala($usr){
       $param = $this->input->post();
       $param['input-data'] = $this->trataData($param['input-data']);
       return $this->db->query("exec cp.InsereEscala '{$param['nome_modal']}', '{$param['input-data']}', '{$param['input-hr-ini']}', '{$param['input-hr-said']}','$usr', '{$param['justificativa']}'")->row_array();
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

}