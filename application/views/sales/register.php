<?php $this->load->view("partial/header"); ?>

<?php $this->load->view("sales/register_content"); ?>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	init();
});

function init()
{

	if(message != null)
	{
		alert(message.text);
	}

	$(".content-form").submit(function(event){
		event.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: $(this).serialize(),
			success: function(data){
				$('#content').html(data);
				init();
			}
		});
	});

	$(".content-submit").click(function(event){
		event.preventDefault();
		$.ajax({
			url: $(this).attr("href"),
			success: function(data){
				$('#content').html(data);
				init();
			}
		});
	});

	$( ".edit-item" ).change(function() {
  		$(this).closest("form").submit();
	});

	$('.selectpicker').selectpicker();

	$("#item").autocomplete({source: function (request, response) {

		$.ajax({
			url: "<?php echo site_url("sales/item_search"); ?>",
			data: request,
			dataType: "json",
			type: "POST",
			success: function(data){
				response(data);
			}
		});
  	}, delay:10, minLength:0, select: function(event, ui){
  		if(ui.item){
            $('#item').val(ui.item.value);
        }
  		$("#add_item_form").submit();
  	}});

  	$("#customer").autocomplete({source: function (request, response) {

		$.ajax({
			url: "<?php echo site_url("sales/customer_search"); ?>",
			data: request,
			dataType: "json",
			type: "POST",
			success: function(data){
				response(data);
			}
		});
  	}, delay:10, minLength:0, select: function(event, ui){
  		if(ui.item){
            $('#customer').val(ui.item.value);
        }
  		$("#select_customer_form").submit();
  	}});

	$('#item').focus();

	 $("#sales-add-payment").click(function()
    {
    	$('#add_payment_form').submit();
    });

    $("#finish_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("sales_confirm_finish_sale"); ?>'))
    	{
    		$('#finish_sale_form').submit();
    	}
    });

	$("#suspend_sale_button").click(function()
	{
		if (confirm('<?php echo $this->lang->line("sales_confirm_suspend_sale"); ?>'))
    	{
    		$('#suspend_sale_form').submit();
    	}
	});

    $("#cancel_sale_button").click(function()
    {
    	if (confirm('<?php echo $this->lang->line("sales_confirm_cancel_sale"); ?>'))
    	{
    		$('#cancel_sale_form').submit();
    	}
    });

	$("#add_payment_button").click(function()
	{
	   $('#add_payment_form').submit();
    });

	$("#payment_types").change(checkPaymentTypeGiftcard).ready(checkPaymentTypeGiftcard);
}


function checkPaymentTypeGiftcard()
{
	if ($("#payment_types").val() == "<?php echo $this->lang->line('sales_giftcard'); ?>")
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
		$("#amount_tendered").val('');
		$("#amount_tendered").focus();
	}
	else
	{
		$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");		
	}
}

</script>
