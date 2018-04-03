<<<<<<< HEAD
<?php
$client = getClient(NULL);
$service = new Google_Service_Calendar($client);
$event = $service->events->get('primary', "".$_GET['detail_id']."");
	$start = $event->start->dateTime;
	if (empty($start)) {
		$start = date("M d Y", strtotime($event->start->date));
		
	}else{
		$start = date("M d Y", strtotime($start));
	}
		$end = $event->end->dateTime;
	if (empty($end)) {
		$end = date("M d Y", strtotime($event->end->date));
	}else{
		$end = date("M d Y", strtotime($end));
	}
	$i = 1;
	$colors = $service->colors->get();
//print_r($event);

?>
<form action="" method="post">
<div class="form-group">
  <label for="eventname">Event Name</label>
  <input type="text" value="<?php echo $event->summary?>" class="summary form-control" name="summarydata" required>
  <input type="hidden" value="<?php echo $event->id?>" class="summary form-control" name="calendarid_this" required>
</div>
<div class="form-group">
  <label for="Location">Location</label>
  <input type="text" value="<?php echo $event->location?>" name="location" class="form-control" id="Location" >
</div>
<div class="form-group">
  <label for="Description">Description</label>
  <input type="text" value="<?php echo $event->description?>" name="description" class="form-control" id="Description" >
</div>
<div class="input-daterange input-group" id="datepicker">
  <div class="form-group">
    <label for="DatePick">Date Start</label>
    <input type="text" value="<?php echo $start?>" name="date" class="form-control star_date datepicker-input" id="DatePick" >
  </div>
  <div class="form-group">
    <label for="DatePick">Time Start</label>
    <div style="clear:both"></div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="hour_start">
        <?php for ($x = 00; $x <= 23; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>" <?php if(date("H") == $value){?> selected <?php }?>> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="minute_start">
        <?php for ($x = 00; $x <= 59; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>" <?php if(date("i") == $value){?> selected <?php }?>> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
  </div>
  <div style="clear:both"></div>
  <div class="form-group">
    <label for="dateend">Date End</label>
    <input type="text" name="dateend" value="<?php echo $end?>" class="form-control end_date datepicker-input" id="dateend">
  </div>
  <div style="clear:both"></div>
  <div class="form-group">
    <label for="DatePick">Time End</label>
    <div style="clear:both"></div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="end_start">
        <?php for ($x = 00; $x <= 23; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>"> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="minute_end">
        <?php for ($x = 00; $x <= 59; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>"> <?php echo $value//date("H",$i)?></option>
        <?php }?>
      </select>
    </div>
  </div>
</div>
<div style="clear:both"></div>
<div class="form-group">
  <label for="dateend">Colour</label>
  <select class="form-control" name="colorpick">
    <?php  
	$count = 1;
	foreach ($colors->getEvent() as $key => $color) { ?>
    <option <?php if($event->colorId == $count){ echo 'selected';}?>  value="<?php echo $count?>" style="color:<?php echo $color->background?>"><?php echo $color->background?></option>
    <?php 
	$count++;
	}?>
  </select>
</div>
<div style="clear:both"></div>
<div class="modal-footer">
  <button type="submit" class="btn btn-danger" name="delete" value="delete_cal">Delete</button>
  <button type="submit" class="btn btn-primary" name="update" value="updat_cal">Save changes</button>
</div>
=======
<?php
$client = getClient(NULL);
$service = new Google_Service_Calendar($client);
$event = $service->events->get('primary', "".$_GET['detail_id']."");
	$start = $event->start->dateTime;
	if (empty($start)) {
		$start = date("M d Y", strtotime($event->start->date));
		
	}else{
		$start = date("M d Y", strtotime($start));
	}
		$end = $event->end->dateTime;
	if (empty($end)) {
		$end = date("M d Y", strtotime($event->end->date));
	}else{
		$end = date("M d Y", strtotime($end));
	}
	$i = 1;
	$colors = $service->colors->get();
//print_r($event);

?>
<form action="" method="post">
<div class="form-group">
  <label for="eventname">Event Name</label>
  <input type="text" value="<?php echo $event->summary?>" class="summary form-control" name="summarydata" required>
  <input type="hidden" value="<?php echo $event->id?>" class="summary form-control" name="calendarid_this" required>
</div>
<div class="form-group">
  <label for="Location">Location</label>
  <input type="text" value="<?php echo $event->location?>" name="location" class="form-control" id="Location" >
</div>
<div class="form-group">
  <label for="Description">Description</label>
  <input type="text" value="<?php echo $event->description?>" name="description" class="form-control" id="Description" >
</div>
<div class="input-daterange input-group" id="datepicker">
  <div class="form-group">
    <label for="DatePick">Date Start</label>
    <input type="text" value="<?php echo $start?>" name="date" class="form-control star_date datepicker-input" id="DatePick" >
  </div>
  <div class="form-group">
    <label for="DatePick">Time Start</label>
    <div style="clear:both"></div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="hour_start">
        <?php for ($x = 00; $x <= 23; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>" <?php if(date("H") == $value){?> selected <?php }?>> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="minute_start">
        <?php for ($x = 00; $x <= 59; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>" <?php if(date("i") == $value){?> selected <?php }?>> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
  </div>
  <div style="clear:both"></div>
  <div class="form-group">
    <label for="dateend">Date End</label>
    <input type="text" name="dateend" value="<?php echo $end?>" class="form-control end_date datepicker-input" id="dateend">
  </div>
  <div style="clear:both"></div>
  <div class="form-group">
    <label for="DatePick">Time End</label>
    <div style="clear:both"></div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="end_start">
        <?php for ($x = 00; $x <= 23; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>"> <?php echo $value?></option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-6" style="float:left">
      <select class="form-control" name="minute_end">
        <?php for ($x = 00; $x <= 59; $x++) { 
            if ($i < 10) {
                    $value = str_pad($x, 2, "0", STR_PAD_LEFT);
            }
    ?>
        <option value="<?php echo $value?>"> <?php echo $value//date("H",$i)?></option>
        <?php }?>
      </select>
    </div>
  </div>
</div>
<div style="clear:both"></div>
<div class="form-group">
  <label for="dateend">Colour</label>
  <select class="form-control" name="colorpick">
    <?php  
	$count = 1;
	foreach ($colors->getEvent() as $key => $color) { ?>
    <option <?php if($event->colorId == $count){ echo 'selected';}?>  value="<?php echo $count?>" style="color:<?php echo $color->background?>"><?php echo $color->background?></option>
    <?php 
	$count++;
	}?>
  </select>
</div>
<div style="clear:both"></div>
<div class="modal-footer">
  <button type="submit" class="btn btn-danger" name="delete" value="delete_cal">Delete</button>
  <button type="submit" class="btn btn-primary" name="update" value="updat_cal">Save changes</button>
</div>
>>>>>>> 9a1b936111136a9547c8f71a951156f6d32b9e88
</form>