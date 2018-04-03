<?php
$client = getClient(NULL);
$service = new Google_Service_Calendar($client);
$colors = $service->colors->get();
?>

<div id="basic-form">
  <form class="form-horizontal" role="form" method="post" action="">
    <div class="form-group">
      <label for="eventname">Event Name</label>
      <input type="text" name="eventname" class="form-control" id="eventname" required>
    </div>
    <div class="form-group">
      <label for="Location">Location</label>
      <input type="text" name="location" class="form-control" id="Location">
    </div>
    <div class="form-group">
      <label for="Description">Description</label>
      <input type="text" name="description" class="form-control" id="Description">
    </div>
    <div class="input-daterange input-group" id="datepicker">
      <div class="form-group">
        <label for="DatePick">Date Start</label>
        <input type="text" name="start" class="form-control star_date datepicker-input"  id="DatePick" >
      </div>
      <div class="form-group">
        <label for="DatePick">Time Start</label>
        <div style="clear:both"></div>
        <div class="col-sm-6" style="float:left">
          <select class="form-control" name="hour_start">
            <?php
			$i = 1;
			 for ($x = 00; $x <= 23; $x++) { 
					if ($i < 10) {
							$value = str_pad($x, 2, "0", STR_PAD_LEFT);
					}
			?>
            <option value="<?php echo $value?>" <?php if(date("H") == $value){?> selected <?php }?>> <?php echo $value//date("H",$i)?></option>
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
            <option value="<?php echo $value?>" <?php if(date("i") == $value){?> selected <?php }?>> <?php echo $value//date("H",$i)?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div style="clear:both"></div>
      <div class="form-group">
        <label for="dateend">Date End</label>
        <input type="text" name="dateend" class="form-control end_date datepicker-input" id="dateend" >
      </div>
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
        <option value="<?php echo $count++?>" style="color:<?php echo $color->background?>"><?php echo $color->background?></option>
        <?php }?>
      </select>
    </div>
    <button type="submit" class="btn btn-default" name="add_new_calendar">Add New event</button>
  </form>
</div>
