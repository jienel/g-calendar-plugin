<?php
$authCode = '';
if(isset($_GET['code'])){
	$authCode = $_GET['code'];
}
$client = getClient($authCode);
if ( file_exists(CREDENTIALS_PATH)){
	$service = new Google_Service_Calendar($client);
	if(isset($_POST['add_new_calendar'])){
		$date_start = $_POST['start'];
		$date_start = date("Y-m-d", strtotime($date_start));
		$hour_start = $_POST['hour_start'].':'.$_POST['minute_start'].':00';
		$date_end = $_POST['dateend'];
		$date_end = date("Y-m-d", strtotime($date_end));
		$hour_end = $_POST['end_start'].':'.$_POST['minute_end'].':00';
		if(strtotime($date_start.'T'.$hour_start.'+01:00')<=strtotime($date_end.'T'.$hour_end.'+01:00')) {
			$date_end = $date_end.'T'.$hour_end.'+01:00';
		}else{
			$date_end = $date_start.'T'.$hour_start.'+01:00';
		}
		$event = new Google_Service_Calendar_Event(array(
			'summary' => ''.$_POST['eventname'].'',
			'location' => ''.$_POST['location'].'',
			'description' => ''.$_POST['description'].'',
			'colorId' => $_POST['colorpick'],
			'start' => array(
				'dateTime' => ''.$date_start.'T'.$hour_start.'+01:00',
				'timeZone' => 'Europe/London',
			),
			'end' => array(
				'dateTime' => $date_end,
				'timeZone' => 'Europe/London',
			),
				'recurrence' => array(
				'RRULE:FREQ=DAILY;COUNT=1'
			),
			'reminders' => array(
				'useDefault' => FALSE,
			'overrides' => array(
				array('method' => 'email', 'minutes' => 24 * 60),
				array('method' => 'popup', 'minutes' => 10),
			),
		  ),
		));
		$calendarId = 'primary';
		$event = $service->events->insert($calendarId, $event);
	}
	if(isset($_POST['update'])){
		$event = $service->events->get('primary', ''.$_POST['calendarid_this'].'');
		$event->setSummary(''.$_POST['summarydata'].'');
		$event->setDescription(''.$_POST['description'].'');
		$event->setLocation(''.$_POST['location'].'');
		$event->setcolorId(''.$_POST['colorpick'].'');
		$start = new Google_Service_Calendar_EventDateTime();
		$start->setDateTime(date('c', strtotime(''.$_POST['date'].'T'.$_POST['hour_start'].':'.$_POST['minute_start'].':00+01:00') ));
		$event->setStart($start);
		$this_end = date("Y-m-d", strtotime($_POST['dateend']));
		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime(date('c', strtotime($this_end.'T'.$_POST['end_start'].':'.$_POST['minute_end'].':00+01:00') ));
		if(strtotime(''.$_POST['date'].'T'.$_POST['hour_start'].':'.$_POST['minute_start'])<=strtotime(''.$_POST['dateend'].'T'.$_POST['end_start'].':'.$_POST['minute_end'])) {
		  $event->setEnd($end);
		}
		$updatedEvent = $service->events->update('primary', $event->getId(), $event);
	}
	if(isset($_POST['delete'])){
		$service->events->delete('primary', ''.$_POST['calendarid_this'].'');
	}
	$calendarId = 'primary';
	$optParams = array(
	  'orderBy' => 'startTime',
	   'timeMin' => date('Y-m-d', strtotime(date('Y-m-d')." -1 month")).'T00:00:00-00:00',
	  'singleEvents' => TRUE,
	);
	$results = $service->events->listEvents($calendarId, $optParams);
	$colors = $service->colors->get();	
?>
<div id="calendar"></div>
<button id="myBtn" style="display:none">Open Modal</button>
<div id="myModal" class="modal">
  <div class="modal-content"> <span class="close">&times;</span>
    <div class="details_here"></div>
  </div>
</div>
<?php

}
?>

<script>
var modal = document.getElementById('myModal');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
jQuery.noConflict();
  jQuery(document).ready(function($) {
	$('#calendar').fullCalendar({
		eventClick: function(eventObj) {
			if (eventObj.url) {
				alert(
					'Clicked ' + eventObj.title + '.\n' +
					'Will open ' + eventObj.url + ' in a new tab'
				);
				window.open(eventObj.url);
				return false; // prevents browser from following link in current tab.
			} else {
				$(".details_here").html('Getting Info.. Please wait');		
				var ajaxurl = '<?php echo get_site_url();?>/wp-admin/admin-ajax.php';
				$.ajax({
					url: ajaxurl,
					type: 'get',
					data: {
						'action':'get_info',
						'detail_id' : eventObj.id
					},
					success:function(data) {
					   $(".details_here").html(data);
					   $('.datepicker-input').datepicker({
							format: "M dd yyyy",
					   });
					},
					error: function(errorThrown){
						alert(errorThrown);
					}
				});   
				$("#myBtn").click();
			}
		},
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		firstDay: 1,
		defaultDate: '<?php echo date("Y-m-d")?>',
		navLinks: true, // can click day/week names to navigate views
		selectable: true,
		selectHelper: true,
		select: function(start, end) {
			$("#myBtn").click();
			var ajaxurl = '<?php echo get_site_url();?>/wp-admin/admin-ajax.php';
			var tstart = start+ '';
			var startend = end+ '';
			var result = tstart.split(' ');
			var dateend = startend.split(' ');
			$.ajax({
				url: ajaxurl,
				type: 'get',
				data: {
					'action':'add_calendar',
					'also':'alert'
				},
				success:function(data) {
					$(".details_here").html(data);
					$('.datepicker-input').datepicker({
						format: "M dd yyyy",
					});
					$('.star_date').val(result[1]+' '+result[2]+' '+result[3]);
					$('.end_date').val(dateend[1]+' '+dateend[2]+' '+dateend[3]);
					$('.date_here').removeClass('hide');
					$('.datepick').val(start);
				},
				error: function(errorThrown){
					alert(errorThrown);
				}
			});
		},
		editable: true,
		eventLimit: true, // 
		 disableDragging: true,
		events: [
		<?php
		foreach ($results->getItems() as $event) {
			if($event->colorId == '11'){
				$color = '#dc2127';
			}elseif($event->colorId == '10'){
				$color = '#51b749';
			}elseif($event->colorId == '9'){
				$color = '#5484ed';
			}elseif($event->colorId == '8'){
				$color = '#e1e1e1';
			}elseif($event->colorId == '7'){
				$color = '#46d6db';
			}elseif($event->colorId == '6'){
				$color = '#ffb878';
			}elseif($event->colorId == '5'){
				$color = '#fbd75b';
			}elseif($event->colorId == '4'){
				$color = '#ff887c';
			}elseif($event->colorId == '3'){
				$color = '#dbadff';
			}elseif($event->colorId == '2'){
				$color = '#7ae7bf';
			}else{
				$color = '#a4bdfc';
			}
				$start = $event->start->dateTime;
			if (empty($start)) {
				$start = $event->start->date;
			}
				$end = $event->end->dateTime;
			if (empty($end)) {
				$end = $event->end->date;
			}
		?>
		{
			id: '<?php echo $event->id ?>',
			title: '<?php echo addslashes($event->summary) ?>',
			start: '<?php echo date("Y-m-d", strtotime($start))?>',
			end: '<?php echo date("Y-m-d", strtotime($end))?>',
			color  : '<?php echo $color?>'
		},
		<?php 
		}
		?>
		]
	});
  });
</script>