<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Home extends CI_Controller {
	
	public function index() {			
		$data ['menu'] = true;
		$data ["view"] = "home";
		$data ["alert"] = $this->notification_output();		
		$this->load->view("includes/body",$data);
	}
	
	public function logoff() {
		$data ['view'] = "includes/logoff";
		$this->session->sess_destroy();
		$this->load->view ( "includes/body", $data );		
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
	public function usuario_perfil(){
		$this->load->model("Usuario_model");
		$res=$this->Usuario_model->setUsuarioPerfil();
		if($res===true){
			set_status_header(200,"ok");
		}else{
			set_status_header(404,$res);
		}
	}
	
	public function get_perfil(){
		$this->load->model('Usuario_model');
		echo json_encode($this->Usuario_model->getPerfilJSON());
	}
	
	public function teste2(){
		echo "ok";
	}
	
	public function teste(){		
		shell_exec('"C:/Program Files (x86)/PHP/v5.3/php.exe" index.php home teste1');						
	}
	
	public function teste1(){
		var_dump( is_cli());
		$db=$this->load->database('SR330',true);
		$db->query("insert into teligo.tb_arquivo(dt_arquivo) values(getdate())");
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