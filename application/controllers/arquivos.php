<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Arquivos extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("Cadastramento_model",'cadastramento');
		$this->load->helper('form');
	}
	
	
	public function index(){
		$this->load->model('Arquivos_model');
		$content = $this->Arquivos_model->download_manual_2();
	
		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($content));
		header('Content-Disposition: inline; filename="ManualDoUsuarioCP.pdf"');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Pragma: public');
		ini_set('zlib.output_compression','0');
	
		die($content);
		
    }

	
	/*=====================================================================
	 FUNÇÕES EXTRAS
	=====================================================================*/
	
	//Exibir notificação da sessão
	private function notification_output(){
		if($this->session->userdata("message")){
			if($this->session->userdata("accept")) $type_alert = "success";
			else $type_alert = "danger";
			$data='<script>$(document).ready(function(){$.toaster({ priority : "'.$type_alert.'", title : "Alerta", message : "'.$this->session->userdata("message").'",settings:{"timeout":3000}});});</script>';
			$this->session->unset_userdata(array("message"=>"","accept"=>""));
			return $data;
		}
		return "";
	}
	
	//Configurar notificação da sessão
	private function notification_input($message,$accept){
		$this->session->set_userdata(array("message"=>$message,"accept"=>$accept));
	}


}