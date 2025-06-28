<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Role
	{
		function __construct()
		{
			try 
			{
				$this->CI =& get_instance();
			} 
			catch (Exception $e) {
				
			}
			
		}

		function Is_Mater($data)
		{
			#$IdPerfil = $this->CI->tank_auth->get_userprofile();
			$perfil = $this->CI->catalogos_model->get_Profile($data["Profile"]);

			if(strtoupper($perfil) == "MASTER")
			{
				$this->getID();
				$this->getName();
				return true;
			}

			return false;
		}

		function Is_Vendedor($data)
		{
			#$IdPerfil = $this->CI->tank_auth->get_userprofile();
			$perfil = $this->CI->catalogos_model->get_Profile($data["Profile"]);
			$IDvenNS = $this->getIDNS();

			if(strtoupper($perfil) == "VENDEDOR" && $IDvenNS > 0)
			{
				$this->getID();
				$this->getIDNS();
				
				return true;
			}
			
			return false;
		}

		function Is_Operativo($data)
		{
			#$IdPerfil = $this->CI->tank_auth->get_userprofile();
			$perfil = $this->CI->catalogos_model->get_Profile($data["Profile"]);
			
			if(strtoupper($perfil) == "OPERATIVO")
			{
				$this->getID();
				$this->getName();
				
				return true;
			}

			return false;
		}
		
      	function Is_Nube($data)
		{
			#$IdPerfil = $this->CI->tank_auth->get_userprofile();
			$perfil = $this->CI->catalogos_model->get_Profile($data["Profile"]);
			
			if(strtoupper($perfil) == "NUBE")
			{
				$this->getID();
				$this->getName();
				
				return true;
			}

			return false;
		}

		function Is_Promotor($data)
		{
			#$IdPerfil = $this->CI->tank_auth->get_userprofile();
			$perfil = $this->CI->catalogos_model->get_Profile($data["Profile"]);
			$IDvenNS = $this->getIDNS();

			if(strtoupper($perfil) == "PROMOTOR" && $IDvenNS > 0)
			{
				$this->getID();
				$this->getIDNS();
				
				return true;
			}
			
			return false;
		}

		function getID()
		{
			return $this->CI->tank_auth->get_IDVend();
		}

		function getName()
		{
			return $this->CI->tank_auth->get_username();
		}

		function getIDNS()
		{
			#return $this->CI->tank_auth->get_IDVendNS();
			$UID = $this->CI->tank_auth->get_user_id();
			return $this->CI->catalogos_model->get_IDVendNS($UID);
		}

		function getRolID($rol)
		{
			return $this->CI->catalogos_model->get_ProfileID($rol);
		}
		
		function getVendedores($idVendedor = 0, $idSuperior = 0){
						
			$vendedor_temp = $this->CI->catalogos_model->get_Vendedor($idVendedor, $idSuperior);
  

			if(isset($vendedor_temp)){
				foreach($vendedor_temp as $ven){
					$this->vendedor[] = $ven->IDVend;
				}

                //si es operativo traigo todos
		       $contador = count($vendedor_temp);
               if($contador >  1)
               {
					foreach($vendedor_temp as $ven){
					$this->vendedor[] = '999999';
					$this->vendedor[] = '999005';
					$this->vendedor[] = '999007';
					$this->vendedor[] = '0';
					}	
				}	
			}

			return isset($this->vendedor)? $this->vendedor : array();
		}
	}
?>