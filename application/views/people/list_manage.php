<script type="text/javascript">
function post_manage_person()
{
    if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
    {
    	update_row(response.person_id,'<?php echo
        site_url("$controller_name/get_row")?>');    
    }
    else //refresh entire table
    {
    	do_search(true,function()
    	{
    		//highlight new row
    		highlight_row(response.person_id);
    	});
    }
}


function listadd_submit()
{

	var checked = $('#listmanage-form :checked').length
	$('#listmanage-form select').each(function() {
		if ($(this).val() != '0') {
			   checked += 1
		}
	});
    if (checked < 1) {
        alert('Please select at least one list or group to manage. If you changed your mind, press escape.');
        return;
    }
	
    $.ajax({url: '<?php echo $addAjaxUrl?>', 
            data: $('#listmanage-form').serialize(),
            type: 'POST',
            success: function(response) {
                  if (typeof(response) != 'object') {
                      var data = JSON.parse(response);
                  } else {
                      var data = response;
                  }
                  if (data.success) {
                      set_feedback(data.message, 'success_message', false);
                  } else {
                      set_feedback(data.message, 'error_message', true);
                  }
                  post_person_form_submit(data);
                  $("#TB_imageOff").unbind("click");
                  $("#TB_closeWindowButton").unbind("click");
                  $("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
                  $("#TB_load").remove();
              },
            error: function(response) {
                    if (typeof(response) != 'object') {
                        var data = JSON.parse(response);
                    } else {
                        var data = response;
                    }
                    if (data.success) {
                        set_feedback(data.message, 'success_message', false);
                    } else {
                        set_feedback(data.message, 'error_message', true);
                    }
                    post_person_form_submit(data);
            	  $("#TB_imageOff").unbind("click");
          	      $("#TB_closeWindowButton").unbind("click");
        	      $("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
        	      $("#TB_load").remove();
              }
           });
}

function listremove_submit()
{

	var checked = $('#listmanage-form :checked').length
	$('#listmanage-form select').each(function() {
        if ($(this).val() != '0') {
               checked += 1
        }
    });
    if (checked < 1) {
        alert('Please select at least one list or group to manage. If you changed your mind, press escape.');
        return;
    }
    
    $.ajax({url: '<?php echo $removeAjaxUrl?>', 
            data: $('#listmanage-form').serialize(),
            type: 'POST',
            success: function(response) {
                  if (typeof(response) != 'object') {
                      var data = JSON.parse(response);
                  } else {
                      var data = response;
                  }
                  if (data.success) {
                      set_feedback(data.message, 'success_message', false);
                  } else {
                      set_feedback(data.message, 'error_message', true);
                  }
                  post_person_form_submit(data);
                  $("#TB_imageOff").unbind("click");
                  $("#TB_closeWindowButton").unbind("click");
                  $("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
                  $("#TB_load").remove();
              },
            error: function(response) {
                    if (typeof(response) != 'object') {
                        var data = JSON.parse(response);
                    } else {
                        var data = response;
                    }
                    if (data.success) {
                        set_feedback(data.message, 'success_message', false);
                    } else {
                        set_feedback(data.message, 'error_message', true);
                    }
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
    <h2><?php echo $this->lang->line('common_list_manage');?></h2>
    <div id='list-form-wrapper-left'>
        <p class='helpertext'><?php echo $this->lang->line('common_list_manage_helpertext')?></p>
    </div>
    <div id='list-form-wrapper-right'>
        <div id='list-form-wrapper-right-top'>
            <form id="listmanage-form">
            <?php foreach ($personids as $id) { ?>
                <?php echo form_hidden('personid[]', $id);?>
            <?php } ?>
            
            <div class="list" id="header">
                <p class="descriptor" id="lists-descriptor">Lists</p>
                <div class="list-groups">
                    <p class="descriptor">Groups</p>
                </div>
                <div class="clear"><!--  --></div>
            </div>
            
            <?php echo $this->load->view('partial/list_manage_form.php')?>
            
            </form>
        </div>
        <div id='list-form-wrapper-right-bottom'>
            <button id="listadd-submit" class="submit_button float_right" onclick="listadd_submit()">Subscribe</button>
            <button id="listremove-submit" class="submit_button float_right" onclick="listremove_submit()">Unsubscribe</button>
        </div>
    </div>
</div>