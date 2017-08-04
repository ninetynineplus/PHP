<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$limit = 30;
if($_POST["key"]["limit"]) $limit = $_POST["key"]["limit"];

$page = 1;
if($_POST["key"]["page"]) $page = $_POST["key"]["page"];

if(count($model) > 0)
{
?>
<div class="table-responsive" id="list-content" style="display: block;">
	<div class="pagination-limit" style="display:inline;">
		<label>Show limit : </label>
		<select class="limit" id="limit" name="limit">
		<option value="5" <?=($limit==5)? "selected=Selected" : "";?>>5</option>
		<option value="30" <?=($limit==30)? "selected=Selected" : "";?>>30</option>
		<option value="50" <?=($limit==50)? "selected=Selected" : "";?>>50</option>
		<option value="100" <?=($limit==100)? "selected=Selected" : "";?>>100</option>
		</select>
	</div>
	<div class="pagination-page" style="display:inline">
		<label>Page : </label>
		<select name="page" id="selectpage">
			<?php for($i=1;$i<=$pages;$i++) { ?>
			<option value="<?=$i;?>" <?=($page==$i)? "selected=Selected" : "";?>><?=$i;?></option>
			<?php } ?>
		</select>
	</div>
	<table class="table table-hover table-striped table-userlist">
		<tr>
			<td>Start</td>
			<td>Service</td>
			<td>Customer</td>
			<td>Provider</td>
			<td>Requested Gender</td>
			<td>Status</td>
			<td>Tools</td>
		<tr>
		<?php foreach($model as $k=>$v) { $data = (object)$v;?>
		<tr>
			<td><?=$data->start_datetime;?></td>
			<td><?=$data->servicename;?></td>
			<td><?=$data->custname;?></td>
			<td><?=$data->provname;?></td>	
			<td><?=$data->pref_provider_gender;?></td>
			<td><?=$status[$data->status];?></td>
			<td>
				<a href="#" class="edit-app" data-id="<?=$data->id;?>">
					<span class="glyphglyphicon glyphicon glyphglyphicon glyphicon-search"></span>
				</a>
				<a href="#" class="remove-app" data-id="<?=$data->id;?>">
					<span class="remove-app glyphglyphicon glyphicon glyphglyphicon glyphicon-remove"></span>
				</a>
			</td>
		</tr>
	<?php } ?>
	</table>
</div>	

<?php } ?>		
