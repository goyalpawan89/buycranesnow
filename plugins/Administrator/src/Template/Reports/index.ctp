 <?php $todos=$todos+1680+500+1500;?>
 <style type="text/css">

      #counter-up,
      #counter-down {
        display: inline-block;
        margin-bottom: 10px;
        font-size: 100px;
        text-align: center;
        margin-left:10px;
      }
     
    </style>

<?php $descrip='Resumen del concurso.';?>

<h1 id="principal"><?php echo __('Totalizador'); ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>

<?php 
//echo pr($totales);
?>

<div class='item'>
	<article class='item1'>
	<aside class='border'>
	    <aside><h2 style='text-align:center;'><?php echo __('Jugadores'); ?></h2></aside>
	    
	    <aside style='text-align:center;'>
	    <i class="fa fa-cog fa-4x fa-spin"></i>
	    <div id="counter-up">0</div>
		</aside>

		<aside><h3 style='text-align:center;'><?php echo __('Retos Cumplidos'); ?>:  <?php 
	    $num=0;
	    foreach($totales as $key=>$conteo){
	    	$num=$num+count($conteo->ranking);
	    } 
		echo $num;
	    ?></h3></aside>
		



	</aside>
	</article>

	<article class='item2'>
	 <div id="container" class='border' style="height: 400px; margin: 0 auto"></div>
	</article>
</div>
 

<script type="text/javascript">
      var counterUp = $("#counter-up");
      counterUp.counter({
        autoStart: true,
        duration: 7000,
        countTo: <?php echo $todos;?>,
        placeholder: 0,
        easing: "easeOutCubic",
       
      });
      var counterDown = $("#counter-down");
      counterDown.counter({
        autoStart: false,
        countTo: 0,
        duration: 7000,
        easing: "easeOutCubic"
      });

</script>		



        
        <script>
	Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
	</script>

	<?php 
	$tipos=array(1=>'pie');
	$datos=array(1=>array(1=>'Femenino', 'Masculino'));
	$titulo=array(1=>'Género');
	$valores=array(1=>array(1=>50, 20));
	?>
    
    <?php 
	foreach($tipos as $tipo){ 
	
	?>
		<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						backgroundColor: '#FFFFFF',
						borderColor: '#fff',
						type: 'column', //pie, bar, column, area, scatter, line, spline, series
					},

					xAxis: {
				        categories: ['Ciclos']
				    },

					
					title: {
						text: '<?php echo $blogName;?>'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.series.name +'</b>: '+ this.y ;
						}
					},
					 
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: false
							},
							showInLegend: true
						}
					},

				        series: [
						
						<?php foreach($totales as $key=>$conteo){?>
				        	{
					            name: '<?php echo $conteo->name; ?>',
					            data: [<?php echo count($conteo->ranking);?>]
					        }, 

						<?php }?>
					        ]
					
				});
			});
				
		</script>
	

              <?php } ?>
	