<?php
	header ( "Cache-Control: no-store, no-cache, must-revalidate" );
	header ( "Cache-Control: post-check=0, pre-check=0", false );
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="description" content="<?php echo $this->config->item('nome_sistema');?>" />
	<meta name="robots" content="noodp, noydir">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url("images/favicon.ico");?>">
	  	<?php $this->load->view("includes/js")?>
	  	<?php $this->load->view("includes/css")?>  
		<title><?php if(isset($title)) echo $title; else echo $this->config->item('nome_sistema');?></title>
	<base href="<?php echo base_url();?>">
	<script type="text/javascript">
		var siteurl='<?php echo site_url();?>/'
		var base_url='<?php echo base_url();?>'
		var ceacr='<?php $ceacr = Login_helper::getUnidade(); echo $ceacr['unidade'];?>'
		// alert(ceacr);
		function site_url(url){
			return siteurl+url;
		}
		<?php if(ENVIRONMENT=="production"):?>
			$(document).contextmenu(function(){return false});
		<?php endif;?>
	</script>

</head>