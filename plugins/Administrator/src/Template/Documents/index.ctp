<?php /* */ ?>
<style>
UL.jqueryFileTree {
	font-family: Verdana, sans-serif;
	font-size: 12px;
	line-height: 18px;
	padding: 0px;
	margin: 0px;
}

UL.jqueryFileTree LI {
	list-style: none;
	padding: 0px;
	padding-left: 20px;
	margin: 0px;
	white-space: nowrap;
}

UL.jqueryFileTree A {
	color: #333;
	text-decoration: none;
	display: block;
	padding: 0px 2px;
}

UL.jqueryFileTree A:hover {
	background: #BDF;
}

/* Core Styles */
.jqueryFileTree LI.directory { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/directory.png) left top no-repeat; }
.jqueryFileTree LI.expanded { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/folder_open.png) left top no-repeat; }
.jqueryFileTree LI.file { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/file.png) left top no-repeat; }
.jqueryFileTree LI.wait { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/spinner.gif) left top no-repeat; }
/* File Extensions*/
.jqueryFileTree LI.ext_3gp { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_afp { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_afpa { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_asp { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_aspx { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_avi { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_bat { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/application.png) left top no-repeat; }
.jqueryFileTree LI.ext_bmp { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_c { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_cfm { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_cgi { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_com { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/application.png) left top no-repeat; }
.jqueryFileTree LI.ext_cpp { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_css { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/css.png) left top no-repeat; }
.jqueryFileTree LI.ext_doc { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/doc.png) left top no-repeat; }
.jqueryFileTree LI.ext_docx { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/doc.png) left top no-repeat; }
.jqueryFileTree LI.ext_exe { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/application.png) left top no-repeat; }
.jqueryFileTree LI.ext_gif { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_fla { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/flash.png) left top no-repeat; }
.jqueryFileTree LI.ext_h { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_htm { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/html.png) left top no-repeat; }
.jqueryFileTree LI.ext_html { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/html.png) left top no-repeat; }
.jqueryFileTree LI.ext_jar { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/java.png) left top no-repeat; }
.jqueryFileTree LI.ext_jpg { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_jpeg { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_js { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/script.png) left top no-repeat; }
.jqueryFileTree LI.ext_lasso { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_log { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/txt.png) left top no-repeat; }
.jqueryFileTree LI.ext_m4p { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/music.png) left top no-repeat; }
.jqueryFileTree LI.ext_mov { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_mp3 { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/music.png) left top no-repeat; }
.jqueryFileTree LI.ext_mp4 { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_mpg { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_mpeg { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_ogg { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/music.png) left top no-repeat; }
.jqueryFileTree LI.ext_pcx { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_pdf { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/pdf.png) left top no-repeat; }
.jqueryFileTree LI.ext_php { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/php.png) left top no-repeat; }
.jqueryFileTree LI.ext_png { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_ppt { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/ppt.png) left top no-repeat; }
.jqueryFileTree LI.ext_psd { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/psd.png) left top no-repeat; }
.jqueryFileTree LI.ext_pl { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/script.png) left top no-repeat; }
.jqueryFileTree LI.ext_py { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/script.png) left top no-repeat; }
.jqueryFileTree LI.ext_rb { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/ruby.png) left top no-repeat; }
.jqueryFileTree LI.ext_rbx { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/ruby.png) left top no-repeat; }
.jqueryFileTree LI.ext_rhtml { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/ruby.png) left top no-repeat; }
.jqueryFileTree LI.ext_rpm { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/linux.png) left top no-repeat; }
.jqueryFileTree LI.ext_ruby { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/ruby.png) left top no-repeat; }
.jqueryFileTree LI.ext_sql { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/db.png) left top no-repeat; }
.jqueryFileTree LI.ext_swf { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/flash.png) left top no-repeat; }
.jqueryFileTree LI.ext_tif { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_tiff { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/picture.png) left top no-repeat; }
.jqueryFileTree LI.ext_txt { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/txt.png) left top no-repeat; }
.jqueryFileTree LI.ext_vb { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_wav { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/music.png) left top no-repeat; }
.jqueryFileTree LI.ext_wmv { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/film.png) left top no-repeat; }
.jqueryFileTree LI.ext_xls { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/xls.png) left top no-repeat; }
.jqueryFileTree LI.ext_xlsx { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/xls.png) left top no-repeat; }
.jqueryFileTree LI.ext_xml { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/code.png) left top no-repeat; }
.jqueryFileTree LI.ext_zip { background: url(http://labs.abeautifulsite.net/archived/jquery-fileTree/demo/images/zip.png) left top no-repeat; }
</style>
		
        
        <script src="<?php echo $this->Url->build('/', true);?>js/document/jquery.js" type="text/javascript"></script>
		<script src="<?php echo $this->Url->build('/', true);?>js/document/jquery.easing.js" type="text/javascript"></script>
		<script src="<?php echo $this->Url->build('/', true);?>js/document/jqueryFileTree.js" type="text/javascript"></script>

		
		<?php $carpeta=$this->Url->build('/', true).$carpeta;?>

		<?php  $titulo = 'Documentos'; 
	         $descrip='Podrás observar los achivos organizados por carpetas.';?>

		<i class="fa fa-cloud-download fa-5x" style='float:right'></i>

		<h1 id="principal" class="sinmargenabajo"><?php echo $titulo;?></h1>
		<p id="descripcion"><?php echo __($descrip); ?></p>

		

		<script type="text/javascript">
		
			
			$(document).ready( function() {
				

				$('#fileTreeDemo_1').fileTree({ root: '../', script: '<?php echo $carpeta;?>/connectors/jqueryFileTree.php', folderEvent: 'click', expandSpeed: 750, collapseSpeed: 750, expandEasing: 'easeOutBounce', collapseEasing: 'easeOutBounce', loadMessage: 'Un momento...'  }, 

					function(file) { 
				 		window.open(file,"_blank")
				 	}

				);
			
			});
		</script>

	
	
			<div style="margin:10px; zoom:1.1;" id="fileTreeDemo_1" class='item border'>
            </div>

