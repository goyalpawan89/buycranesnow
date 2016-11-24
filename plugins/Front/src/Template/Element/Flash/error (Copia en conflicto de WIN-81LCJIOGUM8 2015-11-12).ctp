     <script type="text/javascript">
      $(document).ready(function() {
      
      $.magnificPopup.open({
        items: {
          src: '<div id="small-dialog" class="zoom-anim-dialog popup"><p><i class="fa fa-exclamation-triangle" style="color:#E00707; font-size:20px;"></i> <b><?php echo h($message); ?>.</b></p></div>', // can be a HTML string, jQuery object, or CSS selector
          type: 'inline',
        }
      });
       
      });
    </script>