<?php $this->load->view("includes/header");?>
<body class="hold-transition skin-blue-light sidebar-mini sidebar-collapse fixed">
    <div class="wrapper">

		
			<?php if(isset($menu) && $menu===true):?>
				
			<?php $this->load->view("includes/menu");?>		
				
			<?php endif;?>
			
				<div class="content-wrapper" >
					
					<section class="content" >
						<?php $this->load->view ( $view );?>		
					</section>
				</div>
				
			<?php $this->load->view("includes/footer");?>		
			
		</div>
        
	</body>
	
</html>