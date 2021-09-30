<?php 
/**
 * SITUAÇÃO 1 - os perfis ADMINISTRADOR, RECURSOS HUMANOS E COORDENADOR DE TI, têm acesso total ao sistema;
 * 
 * SITUAÇÃO 2 - o perfil COORDENADOR visualiza apenas os colaboradores subordinados a ele;
 * 
 * SITUAÇÃO 3 - o perfil SUPERVISOR visualiza apenas os colaboradores subordinados a ele;
 * 
 * SITUAÇÃO 4 - o perfil GERENTE DE CONTRATO visualiza todos subordinados a ele, porém de mesmo contrato;
 * 
 * FALTA DEFINIR O PERFIL RECURSOS HUMANOS.
 */

class Permissao_helper{
	
	public function validaAcessoCadastro($modulo){
		if($modulo['type'] == 'controller'){

			$perfil = array('Colaborador');
			$perfil = in_array($this->session->userdata('acesso'),$perfil);
			return $perfil;
	
		}else if($modulo['type'] == 'view'){
			if($modulo['nome_view'] == 'cadastramento'):
				
				if($modulo['situacao'] == 1):
					$perfil = array('Administrador'/*, 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato'*/);/** Gerente de Contrato e Recursos Humanos visualiza apenas info do seu próprio contrato. */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
					return $perfil;
				else: 
					$perfil = array('Administrador', 'Recursos Humanos', /*'Coordenador TI',*/ 'Gerente Contrato');/** Coordenador e Supervisor não cadastra novo funcionário */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
					return $perfil;
				endif;
				
			elseif($modulo['nome_view'] == 'modal_cadastro'):
				$perfil = array('Administrador', 'Recursos Humanos'/*, 'Coordenador TI'*/);/** Coordenador e Supervisor altera apenas a aba empresa*/
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				return $perfil;
					
			else:
				return true;
				
			endif;

		}
		
	}
	public function validaAcessoFrequencia($modulo){
		if($modulo['type'] == 'controller'){
			if($modulo['submodulo']  == 'controle_folha' && $modulo['situacao'] == 1):
				$sit_1 = array('Administrador'/*, 'Coordenador TI'*/);
				$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

				$sit_2 = array('Coordenador', 'Coordenador TI');
				$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
				
				$sit_3 = array('Gerente Contrato','Recursos Humanos');
				$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

				$sit_4 =  array('Supervisor');
				$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

				if($sit_1): 
					return 1;
				elseif($sit_2):
					return 2;
				elseif($sit_3):
					return 4;
				else:
					return 3;
				endif;
			else: /** este não tem acesso a alteração de ponto */
				$perfil = array('Colaborador');
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			endif;
			
		}else{
			return false;
		}
		
	}
	public function validaAcessoFrequenciaFolhaPonto($modulo){
		if($modulo['type'] == 'controller'){

			$sit_1 = array('Administrador'/*, 'Coordenador TI'*/);
			$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

			$sit_2 = array('Coordenador','Coordenador TI');
			$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
			
			$sit_3 = array('Gerente Contrato','Recursos Humanos');
			$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

			$sit_4 =  array('Supervisor');
			$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

			if($sit_1): 
				return 1;
			elseif($sit_2):
				return 2;
			elseif($sit_3):
				return 4;
			else:
				return 3;
			endif;
			
		}else if($modulo['type'] == 'view'){
			
			$perfil = array('Colaborador');/** */
			$perfil = !in_array($this->session->userdata('acesso'),$perfil);

			return $perfil;
			
		}
		
	}
	public function validaAcessoOcorrencia($modulo){
		if($modulo['type'] == 'controller'){
			if($modulo['nome_function'] == 'index'){

				if($modulo['situacao'] == 1): 
					$sit_1 = array('Administrador'/*, 'Coordenador TI'*/);
					$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

					$sit_2 = array('Coordenador','Coordenador TI');
					$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
					
					$sit_3 = array('Gerente Contrato','Recursos Humanos');
					$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

					$sit_4 =  array('Supervisor');
					$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

					if($sit_1): 
						return 1;
					elseif($sit_2):
						return 2;
					elseif($sit_3):
						return 4;
					else:
						return 3;
					endif;
				else:
					$perfil = array('Colaborador');/** */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
					return $perfil;
				endif;
				
			}else if($modulo['nome_function'] == 'modalCadastroOcorrencia'){
				
				$sit_1 = array('Administrador'/*, 'Coordenador TI'*/);
				$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

				$sit_2 = array('Coordenador', 'Coordenador TI');
				$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
				
				$sit_3 = array('Gerente Contrato','Recursos Humanos');
				$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

				$sit_4 =  array('Supervisor');
				$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

				if($sit_1): 
					return 1;
				elseif($sit_2):
					return 2;
				elseif($sit_3):
					return 4;
				else:
					return 3;
				endif;
			}else{

				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato', 'Coordenador');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			}
			
		}/*else if($modulo['type'] == 'view'){
			#não tem validação;
			
		}*/
		else{/**model */
		$perfil = array('Administrador'/*, 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato'*/);/** */
			$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
			return $perfil;

		}
		
	}
	public function validaAcessoFechaFolha($modulo){
		if($modulo['type'] == 'controller'){
			if($modulo['nome_function'] == 'index'){
				$perfil = array('Administrador', 'Recursos Humanos'/*, 'Coordenador TI'*/, 'Gerente Contrato');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			}
			
		}
		
	}
	public function validaAcessoRelatorioColaborador($modulo){
		if($modulo['type'] == 'controller'){
			if($modulo['nome_function'] == 'index'){

				if($modulo['situacao'] == 1): 
					$sit_1 = array('Administrador', 'Coordenador TI');
					$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

					$sit_2 = array('Coordenador');
					$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
					
					$sit_3 = array('Gerente Contrato','Recursos Humanos');
					$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

					$sit_4 =  array('Supervisor');
					$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

					if($sit_1): 
						return 1;
					elseif($sit_2):
						return 2;
					elseif($sit_3):
						return 4;
					else:
						return 3;
					endif;
				else:
					$perfil = array('Colaborador');/** */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
					return $perfil;
				endif;
			}else if($modulo['type'] == 'view'){
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
			
				return $perfil;
			}else{
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato', 'Coordenador','Supervisor');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			}
		}else{
			$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Coordenador', 'Gerente Contrato');/** */
			$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
			return $perfil;
		}
	}
	public function validaAcessoRelatorioOcorrenciasLancadas($modulo){
		// if($modulo['type'] == 'view'){
		// 	$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato');/** */
		// 	$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
		// 	return $perfil;
		// }
		if($modulo['type'] == 'controller'){
			if($modulo['nome_function'] == 'rel_ocorrencia'){

				if($modulo['situacao'] == 1): 
					$sit_1 = array('Administrador', 'Coordenador TI');
					$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

					$sit_2 = array('Coordenador');
					$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
					
					$sit_3 = array('Gerente Contrato','Recursos Humanos');
					$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

					$sit_4 =  array('Supervisor');
					$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

					if($sit_1): 
						return 1;
					elseif($sit_2):
						return 2;
					elseif($sit_3):
						return 4;
					else:
						return 3;
					endif;
				else:
					$perfil = array('Colaborador');/** */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
					return $perfil;
				endif;
			}else if($modulo['type'] == 'view'){
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
			
				return $perfil;
			}else{
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato', 'Coordenador','Supervisor');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			}
		}else{
			$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Coordenador', 'Gerente Contrato');/** */
			$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
			return $perfil;
		}
	}
	public function validaAcessoRelatorioFrequencia($modulo){
		if($modulo['type'] == 'controller'){
			if($modulo['nome_function'] == 'rel_frequencia'){

				if($modulo['situacao'] == 1): 
					$sit_1 = array('Administrador', 'Coordenador TI');
					$sit_1 = in_array($this->session->userdata('acesso'),$sit_1);

					$sit_2 = array('Coordenador');
					$sit_2 = in_array($this->session->userdata('acesso'),$sit_2);
					
					$sit_3 = array('Gerente Contrato','Recursos Humanos');
					$sit_3 = in_array($this->session->userdata('acesso'),$sit_3);

					$sit_4 =  array('Supervisor');
					$sit_4 = in_array($this->session->userdata('acesso'),$sit_4);

					if($sit_1): 
						return 1;
					elseif($sit_2):
						return 2;
					elseif($sit_3):
						return 4;
					else:
						return 3;
					endif;
				else:
					$perfil = array('Colaborador');/** */
					$perfil = in_array($this->session->userdata('acesso'),$perfil);
		
					return $perfil;
				endif;
			}else if($modulo['type'] == 'view'){
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
			
				return $perfil;
			}else{
				$perfil = array('Administrador', 'Recursos Humanos', 'Coordenador TI', 'Gerente Contrato', 'Coordenador','Supervisor');/** */
				$perfil = in_array($this->session->userdata('acesso'),$perfil);
				
				return $perfil;
			}
		}
	}
}