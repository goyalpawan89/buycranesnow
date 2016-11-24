<style>
ul{
	padding: 0px 0px 0px 30px;
}</style>
<div class="alert alert-danger alert-dismissable">  
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <?php echo h($message); //echo pr($params['error']); ?>
 
<ul>
	 <?php 
  /*for($a=0;$a<=count($params['error']);$a++){

	echo "|"; echo h($dato);
	echo '<br>';
  }*/
foreach($params['error'] as $value){
	//echo pr($value);

	foreach($value as $llave=>$dato){
		/*echo pr($dato);
		echo $key;*/
		foreach ($dato as $key => $final) {
			# code...
			?>
			
				<li>Campo: <?php echo $llave; ?> - Error: <?php echo $final;?></li>
			
			<?php	
		}
		
	}
}
  ?><ul>
</div>

