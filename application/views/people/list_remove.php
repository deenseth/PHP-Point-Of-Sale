<script type="text/javascript">

function listremove_submit(){
    $.ajax({url: '<?=$ajaxUrl?>', 
            data: $('#listremove-form').serialize(),
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

<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/list-form.css" />

<div id="list-form-wrapper">
    <h2><?php echo $this->lang->line('common_list_remove');?></h2>
    <div id='list-form-wrapper-left'>
        <p class='helpertext'><?=$this->lang->line('common_list_remove_helpertext');?></p>
    </div>
    <div id='list-form-wrapper-right'>
        <div id='list-form-wrapper-right-top'>
        <form id="listremove-form" class="float_right">
            <?php foreach ($personids as $id) { ?>
                <?php echo form_hidden('personid[]', $id);?>
            <? } ?>
            <?php foreach ($lists as $list) { ?>
                <?php echo form_checkbox($list['name'], $list['name'], 0);?>
                <?php echo form_label($list['name'], $list['name']);?>
                <br/>
            <? } ?>
        </form>
        </div>
        <div id='list-form-wrapper-right-bottom'>
            <button id="listremove-submit" class="submit_button float_right" onclick="listremove_submit()">Submit</button>
        </div>
    </div>
    <div class="clear"><!--  --></div>
</div>