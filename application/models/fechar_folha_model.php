<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fechar_folha_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set('sqlsrv.ClientBufferMaxKBSize','5242880'); 
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','5242880');
        ini_set('memory_limit', '-1');
    }

    public function buscaFolhas($data){
        return $this->db->query("exec [cp].[consultaFechaFolhaEdicao] '{$data}'")->result_array();
    }
    public function setAberturaFolha($id_folha, $user, $opcao){
        $this->db->trans_begin();
        $sp = "EXEC cp.AlteraFecharfolha {$id_folha}, '{$user}',{$opcao}";

        $this->db->query("$sp")->result_array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $ret ['mensagem'] = "Algo deu errado, por favor tente novamente!";
            $ret ['tipo'] = false;
        }else{
            $this->db->trans_commit();
            $ret ['mensagem'] = "Folha alterada com sucesso!";
            $ret ['tipo'] = true;
        }
        return $ret;
    }
    public function buscaMesFechamentoAutomatico(){
        $data = date('Y-m-d');
        // $sp = "
        //     DECLARE @DATE DATE
        //     SET @DATE = '{$data}'
            
        //     SELECT *--MesData
        //     FROM [DB7392_CADASTRO_PESSOAL].[cp].[fechaFolha]
        //     WHERE YEAR(MESDATA) = YEAR(GETDATE())
        //     AND MONTH( MESDATA ) = (	
        //                                 SELECT MONTH((CASE WHEN (@DATE) >= (MesData) THEN @DATE  ELSE dateadd(month,-1,MesData) END))
        //                                 FROM [DB7392_CADASTRO_PESSOAL].[cp].[fechaFolha] A 
        //                                 WHERE YEAR(MesData) =   YEAR(GETDATE())
        //                                 AND MONTH(MESDATA) = MONTH(@DATE)
        //                                 AND A.VerificaLog = 1
        //                             )+1
        //     ";
        $sp = "exec cp.folhaDataExibicao '{$data}'";
        // print_r(nl2br($sp));
        // exit();
        $this->db->simple_query('set nocount on');
        return $this->db->query("$sp")->result_array();
    }
    public function fechaFolhaBuscaMes(){
        $date = date('Y-m-d');
        $sp = "EXEC cp.FECHAFOLHABUSCAMES '$date'";
        return $this->db->query("$sp")->result_array();
    }

}