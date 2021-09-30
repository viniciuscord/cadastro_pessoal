<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Login_model extends CI_Model{
	private $login;
	//chama as validações de acesso e dados da sessao
	public function __construct(){
		$this->login=get_current_user();
		$this->load->library('user_agent');
		if ($this->agent->browser() == 'Internet Explorer'){
			$data['view']="includes/browser";
			$data['menu']=false;
			die($this->load->view("includes/body",$data,true));
		}else{
			if(!$this->valida_acesso()){
				$data['view']="includes/logoff";
				$data['menu']=true;
				$this->load->view("includes/body",$data);
				$this->output->get_output();
			}else{
				if (!$this->session->userdata("login")){
					$this->login();
				}
				
				echo $this->output->get_output();
				
			}
		}
	}
	
	//verifica os dados no BD e coloca na sessão caso ainda nao tenha
	public function login(){
		$result = $this->acesso();
		if ($result) {
			$this->session->set_userdata(array("nome"=>false,"acesso"=>false,"idPerfil"=>false,"login"=>false,"cgc"=>false,"contrato"=>false));
			$sess_data = array (
					"nome" 		=> 	$this->nome(),
					"acesso"	=> 	$result->acesso,
					"idPerfil" 	=>	$result->idPerfil,
					"login" 	=> 	true,
					"cgc" 		=> 	$result->CGC,
					"contrato"	=>	$result->IdContrato
			);			
			$this->session->set_userdata($sess_data);			
		}else{
			$this->session->set_userdata(array("nome"=>false,"acesso"=>false,"idPerfil"=>false,"login"=>false,"cgc"=>false,"contrato"=>false));
			$sess_data = array (
					"nome" 		=> $this->nome(),
					"acesso" 	=> "DEFAULT",
					"idPerfil" 	=>	$result->idPerfil,
					"login" 	=> true,
					"cgc" 		=> 	$result->CGC,
					"contrato"	=>	$result->IdContrato
			);
			
			$this->session->set_userdata($sess_data);
		}
	}
	
	//verifica o perfil do usuario logado no SO, caso nao exista , retorna DEFAULT, caso comexe com 'C' retorna ADMINISTRADOR
	public function acesso(){
		if($this->config->item("id_sistema") == 0) {
			return "Administrador";
		}else{		
			$db=$this->load->database('SR611',true);
			$user = get_current_user();			
			$sp = "EXEC cp.RetornaPerfil '{$user}'";/**retorno o tipo de acesso conforme o sistma gestão de acesso */
			$qr = $db->query($sp)->row();	
			
			if($qr){
				return $qr;
			}else{				
				return 'DEFAULT';
			}
			
		}
	}
	
	//valida o acesso de acordo com o controller e o metodo corrente na pagina comparando o acesso do perfil do usuario logado
	public function valida_acesso(){			
		$pasta=strtolower(trim($this->router->directory));
		$controller=strtolower(trim($this->router->directory.$this->router->class));
		$method=strtolower(trim($this->router->directory.$this->router->class).'/'.$this->router->method);	
		
		$c_supervisor=array("home","campanha");					
		$c_operador=array("home","campanha");
		$acesso = $this->acesso();	
		switch ($acesso->acesso){
			case "Administrador":return true;break;
			case "Monitor": return true; break;/**este perfil foi desativado no gestão acesso */
			case "Caixa": return true; break;/**este perfil foi desativado no gestão acesso */
			case "Colaborador": return true; break;
			case "Planejamento": return true; break;/**este perfil foi desativado no gestão acesso */
			case "Coordenador": return true; break;
			case "Coordenador TI": return true; break;
			case "Gerente Contrato": return true; break;
			case "Recursos Humanos": return true; break;
			case "Supervisor": return true; break;
			default:if(in_array($controller,$c_operador)) return true;break;
		}
		return false;			
	}
	
	//pega o nome do usuario pela matricula
	public function nome(){
		return Login_helper::getNome();
	}
	
	public function log(){
		$method=strtolower(trim($this->router->directory.$this->router->class).'/'.$this->router->method);
		if($method!="home/index"){
			$this->db->set("usr_log",substr(get_current_user(),1));
			$this->db->insert("exper.tb_log_acesso");
		}
	}
	
	//altera o perfil do usuario no scai
	public function setUsuarioPerfil(){
		$db=$this->load->database("SR611",true);
		$db->trans_begin();
		//desativa perfis do usuario que tenham o id do sistema
		$up="delete a
				from TSegControlaAcessos a with(nolock)
						left join TSegPerfis p with(nolock) on a.idPerfil=p.idPerfil
						left join TSegSubModulos sm with(nolock) on sm.idSubModulo=p.idSubModulo
						left join TSegModulos m with(nolock) on m.idModulo=sm.idModulo
						left join TSegSistemas s with(nolock) on s.idSistema=m.idSistema
				where 
					matCef = '$this->login'
					and s.idSistema=".$this->config->item("id_sistema");;
		if(!$db->query($up)){
			$db->trans_rollback();
			return "Erro ao atualizar registro antigo";
		}
		
		$ins="insert into TSegControlaAcessos(idPerfil,matCef,dataLiberado,dataExpira,dataUltimoAcesso,matInseriu)
			  select ".$this->input->post("val")." idPerfil,'$this->login' matCef,getdate() dataLiberado,getdate()+360 dataExpira,getdate() dataUltimoAcesso,'$this->login' matInseriu";
		if(!$db->query($ins)){
			$db->trans_rollback();			
			return "Erro ao atualizar registro";
		}
				
		//incluir perfil selecionado
		$db->trans_commit();
		return true;
	}
	
	//retorna lista de perfis do sistema
	public function getPerfilJSON(){
			$db=$this->load->database('SR611',true);
			return $db
			->select("nomePerfil text,idPerfil value" ,false)
			->join("TSegSubModulos sm with(nolock)", "sm.idSubModulo=p.idSubModulo", "left",false)
			->join("TSegModulos m with(nolock)", "m.idModulo=sm.idModulo", "left",false)
			->join("TSegSistemas s with(nolock)", "s.idSistema=m.idSistema", "left",false)
			->where("s.idSistema", $this->config->item("id_sistema"))
			->order_by('p.idPerfil desc')
			->get("TSegPerfis p with(nolock)")->result();
	}
	
}
?>