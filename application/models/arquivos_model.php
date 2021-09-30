<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Arquivos_model extends CI_Model {

    private $login;
    private $senha;
    
    private $folder;
    private $driveLetter;

    private $folderbr;
    private $driveLetterbr;

    private $folderMan;
    private $driveLetterMan;


    public function __construct() {
        parent::__construct();
	
        $this->login = 'corpcaixa\s756004';
        $this->senha = 'GestaoQA2009';
        
        //será válida a letra que estiver na controller
        $this->driveLetter ='J'; //alterar na controller também método upload()
        $this->folder='\\\\arquivos.caixa\\br\\df7392fs201\\desenvolvimento\\subsidio\\upload';
        
        //será válida a letra que estiver na controller
        $this->driveLetterbr = 'M'; //alterar na controller também método upload()
        $this->folderbr = '\\\\Df7560sr145\\php$\\Sistema_subsidios';

        $this->driveLetterMan = 'K';
        $this->folderMan = '\\\\arquivos.caixa\\br\\df7392fs201\\desenvolvimento\\subsidio\\manuais';
        
    }

    

    public function download_manual(){
        $this->load->helper('download');
        $this->load->library('upload');
        
        $userName = $this->login;
        $password = $this->senha;

        $data_file['name'] = 'ManualDoUsuarioCP.pdf';

        if(!is_dir("$this->driveLetterMan:")){
            $WshNetwork = new COM("WScript.Network");
            $WshNetwork->MapNetworkDrive("$this->driveLetterMan:", $this->folderMan, FALSE, $userName, $password);
        }
        if(file_get_contents("$this->driveLetterMan:\\{$data_file['name']}")){
            $data = file_get_contents("$this->driveLetterMan:\\{$data_file['name']}");
        }
        force_download($data_file['name'],$data,true);

    }

    public function download_manual_2(){
        $this->load->helper('download');
        $this->load->library('upload');
        
        $userName = $this->login;
        $password = $this->senha;

        $data_file['name'] = 'ManualDoUsuarioCP.pdf';

        if(!is_dir("$this->driveLetterMan:")){
            $WshNetwork = new COM("WScript.Network");
            $WshNetwork->MapNetworkDrive("$this->driveLetterMan:", $this->folderMan, FALSE, $userName, $password);
        }
        if(file_get_contents("$this->driveLetterMan:\\{$data_file['name']}")){
            $data = file_get_contents("$this->driveLetterMan:\\{$data_file['name']}");
        }
        return $data;

    }
    

    /* =====================================================================
      FUNÇÕES EXTRAS
      ===================================================================== */

    //Exibir notificaÃ§Ã£o da sessÃ£o
    private function notification_output() {
        if ($this->session->userdata("message")) {
            if ($this->session->userdata("accept")) {
                $type_alert = "success";
            } else {
                $type_alert = "danger";
            }
            $data = "<div class='alert alert-$type_alert animated bounceIn'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Ã—</button>
			" . $this->session->userdata("message") . "</div>";
            $this->session->unset_userdata(array("message" => "", "accept" => ""));
            return $data;
        }
        return "";
    }

    //Configurar notificaÃ§Ã£o da sessÃ£o
    private function notification_input($message, $accept) {
        $this->session->set_userdata(array("message" => $message, "accept" => $accept));
    }
}