<footer class="main-footer">
	<div class="pull-right hidden-xs">
      <b>Version</b> 1.3.1
    </div>
    <strong>Copyright &copy; <?=date('Y')?>. Argus Partners </a>.</strong> All rights
    reserved.
</footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
	$page_link = '<?=base_url().'admin'.$this->uri->slash_segment(2, 'both');?>';

	$('.sidebar-menu a').each(function(index, el) {
		if($(el).attr('href') == $page_link){
			$(el).parent().addClass('active');
			$(el).closest('.treeview').addClass('active').addClass('menu-open');
		}
	});

	$save_btn = $(document).find('.box form .btn-success');
	$(document).bind('keydown', function(event) {
	    if (event.ctrlKey || event.metaKey) {
	    	if(String.fromCharCode(event.which).toLowerCase() == 's'){
	    		event.preventDefault();
	            $save_btn.click();
	    	}
	    }
	});

	if(CKEDITOR!==null){
		CKEDITOR.on('instanceReady', function () {
		    $.each(CKEDITOR.instances, function (instance) {
		        CKEDITOR.instances[instance].document.on("keydown", function(event) {
		        	event = event.data.$;
				    if (event.ctrlKey || event.metaKey) {
				    	if(String.fromCharCode(event.which).toLowerCase() == 's'){
				    		event.preventDefault();
				    		$save_btn.click();
				    	}
				    }
				});
		    });
		});
	}
	$('select').select2();
</script>
</body>
</html>