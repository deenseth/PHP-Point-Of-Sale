<script type="text/javascript">

function listadd_submit(){
    $.ajax({url: '<?=$ajaxUrl?>', 
            data: $('#listadd-form').serialize(),
            type: 'POST',
            success: function(data) {
                  returneddata = data.split(':');
                  if (returneddata[0] == '0') {
                	  set_feedback(returneddata[1], 'error_message', false);
                  } else {
                	  set_feedback(returneddata[1], 'success_message', false);
                  }
                  $("#TB_imageOff").unbind("click");
                  $("#TB_closeWindowButton").unbind("click");
                  $("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
                  $("#TB_load").remove();
              },
            error: function(data) {
            	  set_feedback('Unable to add! (Unknown Error)', 'error_message', false);
            	  $("#TB_imageOff").unbind("click");
          	      $("#TB_closeWindowButton").unbind("click");
        	      $("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
        	      $("#TB_load").remove();
              }
           });
}


</script>
<form id="listadd-form">
<?php echo form_hidden('isPost', '1');?>
<?php foreach ($personids as $id) { ?>
    <?php echo form_hidden('personid[]', $id);?>
<? } ?>
<?php foreach ($lists as $list) { ?>
    <?php echo form_checkbox($list['name'], $list['name'], 0);?>
    <?php echo form_label($list['name'], $list['name']);?>
    <br/>
<? } ?>
</form>
<button id="listadd-submit" onclick="listadd_submit()">Submit</button>