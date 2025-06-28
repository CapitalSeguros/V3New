<?
?>
			<!-- User info -->
			<ul class="user-info pull-left">
				<li class="profile-info dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> 
						<img 
                        	width="44" class="img-circle avatar" alt="" 
                        	src="<?=base_url("assetsApp/")?>/images/MyProfile/avatar_male.png"
                        >
						<?= $this->tank_auth->get_usernamecomplete(); ?> 
						<span class="caret"></span>
					</a>
			  
				<!-- User action menu -->
				<ul class="dropdown-menu">
					<!-- <li><a href="#/"><i class="icon-user"></i>Mi perfil</a></li> -->
					<!-- <li><a href="#/"><i class="icon-mail"></i>Messages</a></li> -->
					<!-- <li><a href="#"><i class="icon-clipboard"></i>Tasks</a></li> -->
					<!-- <li class="divider"></li> -->
					<!-- <li><a href="#"><i class="icon-cog"></i>Account settings</a></li> -->
					<li><a href="<?=base_url()?>auth/logout"><i class="icon-logout"></i>Cerrar sesión</a></li>
				</ul>
				<!-- /user action menu -->
				
				</li>
			</ul>
			<!-- /user info -->