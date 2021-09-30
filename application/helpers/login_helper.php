<?php 

class Login_helper{
	
	//perfil do usuário logado $u - usuário(int)
	public static function getAcesso($u){
		if(get_current_user()!='p743786'){
			$ci=&get_instance();
			$db=$ci->load->database('SR611',true);	
			$qr=$db
			->select("top 1 isnull(nomePerfil,'DEFAULT') acesso " ,false)
			->join("TSegPerfis p with(nolock)", "a.idPerfil=p.idPerfil", "left",false)			
			->join("TSegSubModulos sm with(nolock)", "sm.idSubModulo=p.idSubModulo", "left",false)			
			->join("TSegModulos m with(nolock)", "m.idModulo=sm.idModulo", "left",false)			
			->join("TSegSistemas s with(nolock)", "s.idSistema=m.idSistema", "left",false)			
			->where("matCef", $u)
			->where("s.idSistema", ID_SISTEMA)
			->where("a.dataExpira >getdate()")
			->order_by('p.idPerfil desc')
			->get("TSegControlaAcessos a with(nolock)")->row();

			if($qr){
				return $qr->acesso;
			}else{
				return 'DEFAULT';
			}
			
		}else{
			return "Administração";
		}
	}
	
	public static function getNome(){
		$ci=get_instance();
		$db=$ci->load->database('SR611',true);
		$nome=$db->
		select("Nome")->
		where("MatriculaSCP like '%".get_current_user()."%'")->
		get("DB7392_CADASTRO_PESSOAL.cp.Funcionarios")->
		result();
		$arr=explode(" ",$nome[0]->Nome);
		$tam=count($arr);
		return strtolower($arr[0].' '.$arr[$tam-1]);
	}

	public function getUnidade(){
		// $db = $this->load->database('SR611',true);
		// $user = get_current_user();
		// $db->simple_query('set nocount on');
		// $query =  "EXEC cp.ConsultaCgcSigla '{$user}'";
		// $exec = $db->query($query)->result_array();
		// print_r($exec);
		// exit();
		
		// if($exec){
			// 	$unidade['unidade'] = $exec[0]['Sigla'];
			// 	$unidade['unidade_compl'] = 'Centralizadora de Atendimento Cobrança Remota /'.$exec[0]['Sigla'];
			// }else{
				// 	$unidade = 'CEACR';
				// 	$unidade['unidade_compl'] = 'Centralizadora de Atendimento Cobrança Remota';
				
				// }
		$unidade['unidade'] = 'CEACR';
		return $unidade;
	}
	// public function validaLocalContrato(){
	// 	$db = $this->load->database('SR611',true);
	// 	$user = get_current_user();
	// 	// $user = 'p019102'; /**teste */
	// 	$db->simple_query('set nocount on');
	// 	$query =  "EXEC [cp].[consultaContratoFechamentoFolha] '{$user}'";
	// 	$exec = $db->query($query)->row_array();
	// 	// print_r($exec['IdContrato']);
	// 	// exit();
		
	// 	return $exec['IdContrato'];
	// }
}
