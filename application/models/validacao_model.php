<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Validacao_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    private function getQueryBuild($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    private function trataData($data){
        return implode('-', array_reverse(explode('/',$data)));
    }


    public function validaCampoHora($hrs){
        if($hrs != null ){
            if (preg_match('/^\d{2}:\d{2}$/', $hrs)) {
                if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $hrs)) {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return true;
        }
        
    }

    public function validaCPF($cpf){
        
        $cpf = preg_replace("/[^0-9]/","",$cpf);
        $auxCpf = str_split($cpf);
        if(count($auxCpf) != 11 ||
            $cpf == "00000000000" ||
            $cpf == "11111111111" ||
            $cpf == "22222222222" ||
            $cpf == "33333333333" ||
            $cpf == "44444444444" ||
            $cpf == "55555555555" ||
            $cpf == "66666666666" ||
            $cpf == "77777777777" ||
            $cpf == "88888888888" ||
            $cpf == "99999999999"
        ){
            return false;
        }
        $val = 0;
        for($i=0;$i<9;$i++){
            $val += (10 - $i) * $auxCpf[$i];
        }
        $rest = $val % 11;
        if($rest < 2 ){
            $primDig = 0;
        }
        if($rest >= 2 ){
            $primDig = 11 - $rest;
        }
        if(!($primDig == substr($cpf,-2,1))){
            return false;
        }
        $val = 0;
        for($i=0;$i<10;$i++){
            $val += (11 - $i) * $auxCpf[$i];
        }
        $rest = $val % 11;
        if($rest < 2 ){
            $segDig = 0;
        }
        if($rest >= 2 ){
            $segDig = 11 - $rest;
        }
        if(!($segDig == substr($cpf,-1))){
            return false;
        }
        return true;

    }


    public function validaCpfCadastrado($cpf){
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $sql = "select [idFuncionario] from cp.Funcionarios where cpf = '$cpf'";
        $result = $this->getQueryBuild($sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function validaNomeBanco($nome){
        if(trim($nome) != '' ){
            $term = trim($nome);
            $sql = "
            select 
                [IdBancoFuncionario]
            from 
                [cp].[codigoBanco] 
            where 
                CONCAT([IdBancoFuncionario],' - ' collate SQL_Latin1_General_CP1_CI_AS,[Nome]) LIKE '%$term%' collate SQL_Latin1_General_CP1_CI_AS     
            ";
            $result = $this->getQueryBuild($sql);
         
            if(count($result) > 1 || empty($result) ){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function validaNomeUnidades($nome){
        if(trim($nome) != ''){
            $cgc = trim($nome);
            $sql = "EXEC cp.ConsultaUnidades '$cgc'";
            $result = $this->getQueryBuild($sql);
            if(count($result) > 1 || empty($result)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function validaOcorrenciaCadastrada(){
        $param = $this->input->post();
        $dt_ini = $this->trataData($param['input-data-ini']);
        $dt_fim = $this->trataData($param['input-data-fim']);
        return $this->getQueryBuild("EXEC cp.ValidaOcorrenciaCadastrada_new '{$param['nome_modal']}','{$dt_ini}','{$dt_fim}' ");
    }

}