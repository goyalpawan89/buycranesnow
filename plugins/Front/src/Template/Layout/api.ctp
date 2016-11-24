<?= $this->Flash->render(); ?>
<?=  $this->fetch('content'); 


              //fancybox css        
        echo $this->Html->css('Front.fancybox/jquery.fancybox');
        echo $this->Html->css('Front.fancybox/jquery.fancybox-buttons');
        echo $this->Html->css('Front.fancybox/jquery.fancybox-thumbs');

        //fancybox scripts        
        echo $this->Html->script('Front.fancybox/jquery.fancybox.pack');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-buttons');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-media');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-thumbs');
        echo $this->Html->script('Front.fancybox/fancy');



    echo $this->Html->script('Front.front/customs');
    
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    ?>