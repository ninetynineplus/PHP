<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$service = $services->get_batch();
$therapists = $providers->get_batch();

$data = null;
if($id > 0)
{
	$data = $model->getBooking($id);
}

?>
<legend>Appointment Details</legend>

<input id="appointment-id" value="<?=($data ? $data->id : "");?>" type="hidden">
<?php if($data): ?>
<div class="form-group" id="div-bookdt">
	<label for="book-datetime" class="col-sm-3 control-label">Book Date / Time *</label>
	<div class="col-sm-7">
		<input id="book-datetime" class="form-control" type="text" disabled value="<?=$data->book_datetime;?>">
	</div>
</div>
<?php endif; ?>
<div class="form-group">
	<label for="email" class="col-sm-3 control-label">Customer Email</label>
	<div class="col-sm-7">
		<input id="email" class="form-control required" type="text" value="<?=($data ? $data->custmail : "");?>">
	</div>
</div>
<div class="form-group">
	<label for="name" class="col-sm-3 control-label">Customer Name</label>
	<div class="col-sm-7">
		<input id="name" class="form-control" type="text" value="<?=($data ? $data->custname : "");?>" readonly>
	</div>
</div>
<div class="form-group">
	<label for="select-service" class="col-sm-3 control-label">Service *</label>
	<div class="col-sm-7">
		<select id="select-service" class="required form-control">
			<?php foreach($service as $k=>$v) { ?>
			<optgroup label="<?=$v["name"];?>">
				<?php if(count($v["packprice"]) > 0) {foreach($v['packprice'] as $i => $j) { ?>
					<option value="<?=$j->serviceid;?>,<?=$j->duration;?>" <?=(($data && $data->id_services == $j->serviceid && $data->duration == $j->duration) ? "selected=Selected" : "");?>>
						<?=$v["name"];?> <?=$j->duration;?> Minutes : <?=$j->price;?>
					</option>
				<?php } } ?>
			</optgroup>
			<?php } ?>
		</select>
	</div>
</div>
<div class="form-group">
	<label for="select-gender" class="col-sm-3 control-label">Requested Gender *</label>
	<div class="col-sm-7">
		<select id="select-gender" class="required form-control">
			<option value="Male" <?=(($data && $data->pref_provider_gender == "Male") ? "selected=Selected" : "");?>>Male</option>
			<option value="Female" <?=(($data && $data->pref_provider_gender == "Female") ? "selected=Selected" : "");?>>Female</option>
		</select>
	</div>
</div>
<div class="form-group">
	<label for="select-provider" class="col-sm-3 control-label">Provider *</label>
	<div class="col-sm-7">
		<?php if(count($therapists) > 0):?>
		<select id="select-provider" class="required form-control">
			<?php foreach($therapists as $k=>$v) { ?>
			<option value="<?=$v['id'];?>" <?=(($data && $data->provid == $v['id']) ? "selected=Selected" : "");?>><?=$v['first_name'];?> <?=$v['last_name'];?></option>
			<?php } ?>
		</select>
		<?php endif;?>
	</div>
</div>
<div class="form-group">
	<label for="start-datetime" class="col-sm-3 control-label">Start Date / Time *</label>
	<div class="col-sm-7">
		<input id="start-datetime" class="form-control boyDatepicker required" type="text" value="<?=($data ? $data->start_datetime : "");?>">
	</div>
</div>
<div class="form-group">
	<label for="address" class="col-sm-3 control-label">Address *</label>
	<div class="col-sm-7">
		<textarea id="address" class="form-control required"><?=($data ? $data->address : "");?></textarea>
	</div>
</div>
<div class="form-group">
	<label for="payment" class="col-sm-3 control-label">Payment *</label>
	<div class="col-sm-7">
		<select id="payment" class="required form-control">
			<option value="Cash" <?=(($data && $data->payment == "Cash") ? "selected=Selected" : "");?>>Cash</option>
			<option value="Voucher" <?=(($data && $data->payment == "Voucher") ? "selected=Selected" : "");?>>Voucher</option>
		</select>
	</div>
</div>
<div class="form-group" id="div-voucher">
	<label for="voucher" class="col-sm-3 control-label">Voucher Code *</label>
	<div class="col-sm-7">
		<input id="voucher" class="form-control" type="text" value="<?=(($data && $data->voucher) ? $data->voucher : "");?>">
	</div>
</div>
<div class="form-group">
	<label for="pay" class="col-sm-3 control-label">Pay</label>
	<div class="col-sm-7">
		<input id="pay" class="form-control" type="text" value="<?=(($data && $data->pay) ? $data->pay : "");?>">
	</div>
</div>
<div class="form-group">
	<label for="select-status" class="col-sm-3 control-label">Status *</label>
	<div class="col-sm-7">
		<select id="select-status" class="required form-control">
			<option value="0" <?=(($data && $data->status == 0) ? "selected=Selected" : "");?>>Waiting</option>
			<option value="1" <?=(($data && $data->status == 1) ? "selected=Selected" : "");?>>Appointed</option>
			<option value="2" <?=(($data && $data->status == 2) ? "selected=Selected" : "");?>>Canceled</option>
			<option value="3" <?=(($data && $data->status == 3) ? "selected=Selected" : "");?>>Reject</option>
			<option value="4" <?=(($data && $data->status == 4) ? "selected=Selected" : "");?>>Done</option>
		</select>
	</div>
</div>
<script type="text/javascript">
$(function () {
	if($('#payment').val() == "Cash")
	{
		$("#div-voucher").hide();
	}
	$('#payment').change(function() {
		if($(this).val() == "Cash")
		{
			$("#div-voucher").hide();
			$("#voucher").removeClass("required");
		}else{
			$("#div-voucher").show();
			$("#voucher").addClass("required");
		}
	});	
});
</script>
                        