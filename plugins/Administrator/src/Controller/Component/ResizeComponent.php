<?php 

/*App::uses('Component', 'Controller');
App::uses('Controller',    'Controller');
App::uses('ClassRegistry', 'Utility');

App::uses('HttpSocket', 'Network/Http');
App::uses('JsonView', 'View');*/


namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class ResizeComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash');

	public $helpers = array('Session');
	public $controller = null;
	var $img;
	
	public function thumbnail($imgfile)
	{
		//detect image format
		$this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
		$this->img["format"]=strtoupper($this->img["format"]);
		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			$this->img["format"]="JPEG";
			$this->img["src"] = ImageCreateFromJPEG ($imgfile);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			$this->img["format"]="PNG";
			$this->img["src"] = ImageCreateFromPNG ($imgfile);
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			$this->img["format"]="GIF";
			$this->img["src"] = ImageCreateFromGIF ($imgfile);
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			$this->img["format"]="WBMP";
			$this->img["src"] = ImageCreateFromWBMP ($imgfile);
		} else {
			//DEFAULT
			//echo "Not Supported File";
			//exit();
		}
		@$this->img["lebar"] = imagesx($this->img["src"]); // ancho
		@$this->img["tinggi"] = imagesy($this->img["src"]); // alto
		//default quality jpeg
		$this->img["quality"]=75;
	}

	public function size_height($size=100)
	{
		//height
    	$this->img["tinggi_thumb"]=$size;
    	@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
	}

	public function size_width($size=100)
	{
		//width
		$this->img["lebar_thumb"]=$size;
    	@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
	}

	public function size_auto($size=100)
	{
		//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) {
    		$this->img["lebar_thumb"]=$size;
    		@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		} else {
	    	$this->img["tinggi_thumb"]=$size;
    		@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
 		}
	}

	public function jpeg_quality($quality=75)
	{
		//jpeg quality
		$this->img["quality"]=$quality;
	}

	public function show()
	{
		//show thumb
		@Header("Content-Type: image/".$this->img["format"]);

		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);

    		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			imageJPEG($this->img["des"],"",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"]);
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			imageGIF($this->img["des"]);
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			imageWBMP($this->img["des"]);
		}
	}

	public function save($save="")
	{
		//save thumb
		if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		

				if($this->img["lebar"] >= $this->img["lebar_thumb"] && $this->img["tinggi"] >= $this->img["tinggi_thumb"] ) { // si el ancho de la imagen es mayor o igual al tamaño dado para crear la miniatura la corte		    	
			    	$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
			    } else { // si la imagen es mas pequeña que el tamaño dado no la corte.
			    	$this->img["des"] = ImageCreateTrueColor($this->img["lebar"],$this->img["tinggi"]);
			    }

		    imagealphablending( $this->img["des"], false );
		    imagesavealpha( $this->img["des"], true );
			
				if($this->img["lebar"] >= $this->img["lebar_thumb"] && $this->img["tinggi"] >= $this->img["tinggi_thumb"] ) { // si el ancho de la imagen es mayor o igual al tamaño dado para crear la miniatura la corte		
					@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);
				} else { // si la imagen es mas pequeña que el tamaño dado no la corte.
					@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar"], $this->img["tinggi"], $this->img["lebar"], $this->img["tinggi"]);
			    }					


		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			imageJPEG($this->img["des"],"$save",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"],"$save");
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			imageGIF($this->img["des"],"$save");
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			imageWBMP($this->img["des"],"$save");
		}
	}


}