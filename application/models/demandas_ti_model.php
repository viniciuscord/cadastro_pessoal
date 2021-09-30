<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Demandas_ti_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set('sqlsrv.ClientBufferMaxKBSize','5242880'); 
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','5242880');
        ini_set('memory_limit', '-1');
    }

    public function buscaHorasPorFuncao($dt_ini, $dt_fim){
        $this->db->simple_query('set nocount on');
        return $this->db->query("EXEC [cp].[HorasPorFuncaoTotal] '{$dt_ini}', '{$dt_fim}' ")->result_array();
    }
    public function buscaHorasPorFuncionario($dt_ini, $dt_fim){
        $this->db->simple_query('set nocount on');
        return $this->db->query("EXEC [cp].[HorasPorAnalitas] '{$dt_ini}', '{$dt_fim}' ")->result_array();
    }
    public function buscaDadosProspeccao($param){
        $this->db->simple_query('set nocount on');
        return $this->db->query("EXEC [cp].[HorasQTDMESProspeccao] '{$param['data']}',{$param['qtd_func']}")->result_array();
    }
    public function buscaHorasPorFuncionarioIndividual($param){
        $this->db->simple_query('set nocount on');
        return $this->db->query("EXEC [cp].[HorasPorAnalistaIndividual] '{$param['datas']['ini']}', '{$param['datas']['fim']}','{$param['post']['matricula']}' ")->row_array();
    }

}