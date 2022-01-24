<?php
if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'getCalender':
			getCalender($_POST['year'],$_POST['month']);
			break;
		case 'getEvents':
			getEvents($_POST['date']);
			break;
		case 'addEvent':
			addEvent($_POST['date'],$_POST['title']);
			break;
		default:
			break;
	}
}
function getCalender($year = '',$month = '')
{
	$dateYear = ($year != '')?$year:date("Y");
	$dateMonth = ($month != '')?$month:date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
	
?>
	<div id="calender_section">
		<h2>
        	<select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
			<select name="year_dropdown" class="year_dropdown dropdown1"><?php echo getYearList($dateYear); ?></select>
        </h2>
		<div id="event_list" class="none"></div>
        <div id="event_add" class="none">
        	<p>Dodaj zajęcia dnia <span id="eventDateView"></span></p>
            <p><b>Nazwa przedmiotu: </b><input type="text" id="eventTitle" value=""/></p>
            <input type="hidden" id="eventDate" value=""/>
            <input type="hidden" id="addEventBtn" value="Dodaj"/>
        </div>
		<div id="calender_section_top">
			<ul>
				<li>Poniedziałek</li>
				<li>Wtorek</li>
				<li>Środa</li>
				<li>Czwartek</li>
				<li>Piątek</li>
				<li>Sobota</li>
				<li>Niedziela</li>
			</ul>
		</div>
		<div id="calender_section_bot">
			<ul>
			<?php 
				$dayCount = 1; 
				for($cb=1;$cb<=$boxDisplay;$cb++){
					if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
						$currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
						$eventNum = 0;
						include 'config.php';
						$result = $db->query("SELECT title FROM events WHERE date = '".$currentDate."' AND status = 1");
						$eventNum = $result->num_rows;
						if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
							echo '<li date="'.$currentDate.'" class="grey date_cell">';
						}elseif($eventNum > 0){
							echo '<li date="'.$currentDate.'" class="light_sky date_cell">';
						}else{
							echo '<li date="'.$currentDate.'" class="date_cell">';
						}
						echo '<span>';
						echo $dayCount;
						echo '</span>';
						echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">';
						echo '<div class="date_window">';
						echo '<div class="popup_event">Zajęcia ('.$eventNum.')</div>';
						echo ($eventNum > 0)?'<a href="javascript:;" onclick="getEvents(\''.$currentDate.'\');">Sprawdź</a><br/>':'';
						echo '<a href="javascript:;" onclick="addEvent(\''.$currentDate.'\');"></a>';
						echo '</div></div>';
						echo '</li>';
						$dayCount++;
			?>
			<?php }else{ ?>
				<li><span>&nbsp;</span></li>
			<?php } } ?>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		function getCalendar(target_div,year,month){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'func=getCalender&year='+year+'&month='+month,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}
		
		function getEvents(date){
			$.ajax({
				type:'POST',
				url:'functions.php',
				data:'func=getEvents&date='+date,
				success:function(html){
					$('#event_list').html(html);
					$('#event_add').slideUp('slow');
					$('#event_list').slideDown('slow');
				}
			});
		}
		function addEvent(date){
			$('#eventDate').val(date);
			$('#eventDateView').html(date);
			$('#event_list').slideUp('slow');
			$('#event_add').slideDown('slow');
		}
		$(document).ready(function(){
			$('#addEventBtn').on('click',function(){
				var date = $('#eventDate').val();
				var title = $('#eventTitle').val();
				$.ajax({
					type:'POST',
					url:'functions.php',
					data:'func=addEvent&date='+date+'&title='+title,
					success:function(msg){
						if(msg == 'ok'){
							var dateSplit = date.split("-");
							$('#eventTitle').val('');
							alert('Pomyślnie dodano zajęcia.');
							getCalendar('calendar_div',dateSplit[0],dateSplit[1]);
						}else{
							alert('Problem, coś nie wyszło.');
						}
					}
				});
			});
		});
		$(document).ready(function(){
			$('.date_cell').mouseenter(function(){
				date = $(this).attr('date');
				$(".date_popup_wrap").fadeOut();
				$("#date_popup_"+date).fadeIn();	
			});
			$('.date_cell').mouseleave(function(){
				$(".date_popup_wrap").fadeOut();		
			});
			$('.month_dropdown').on('change',function(){
				getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$('.year_dropdown').on('change',function(){
				getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$(document).click(function(){
				$('#event_list').slideUp('slow');
			});
		});
	</script>
<?php
}
function toLocaleDateString($s) {
    if (date("l, d F Y", $s) == date("l, d F Y", time())) {
        $date = 'Dzisiaj' . date(", d F Y, G:i:s", $s);
    } else {
        $date = date("l, d F Y, G:i:s", $s);
    }

    $date = str_replace('Monday', 'Poniedziałek', $date);
    $date = str_replace('Tuesday', 'Wtorek', $date);
    $date = str_replace('Wednesday', 'Środa', $date);
    $date = str_replace('Thursday', 'Czwartek', $date);
    $date = str_replace('Friday', 'Piątek', $date);
    $date = str_replace('Saturday', 'Sobota', $date);
    $date = str_replace('Sunday', 'Niedziela', $date);

    $date = str_replace('January', 'Stycznia', $date);
    $date = str_replace('February', 'Lutego', $date);
    $date = str_replace('March', 'Marca', $date);
    $date = str_replace('April', 'Kwietnia', $date);
    $date = str_replace('May', 'Maja', $date);
    $date = str_replace('June', 'Czerwca', $date);
    $date = str_replace('July', 'Lipca', $date);
    $date = str_replace('August', 'Sierpnia', $date);
    $date = str_replace('September', 'Września', $date);
    $date = str_replace('October', 'Października', $date);
    $date = str_replace('November', 'Listopada', $date);
    $date = str_replace('December', 'Grudnia', $date);

    return $date;
}
date_default_timezone_set('Europe/Warsaw');
function dateV($format,$timestamp=null){
	$to_convert = array(
		'l'=>array('dat'=>'N','str'=>array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela')),
		'F'=>array('dat'=>'n','str'=>array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień')),
		'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
	);
	if ($pieces = preg_split('#[:/.\-, ]#', $format)){	
		if ($timestamp === null) { $timestamp = time(); }
		foreach ($pieces as $datepart){
			if (array_key_exists($datepart,$to_convert)){
				$replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
			}else{
				$replace[] = date($datepart,$timestamp);
			}
		}
		$result = strtr($format,array_combine($pieces,$replace));
		return $result;
	}
}
function getAllMonths($selected = ''){
date_default_timezone_set('Europe/Warsaw');
	
	$options = '';
	for($i=1;$i<=12;$i++)
	{
		$value = ($i < 01)?'0'.$i:$i;
	
		$selectedOpt = ($value == $selected)?'selected':'';
		$options .= '<option value="'.$value.'" '.$selectedOpt.' >'.dateV("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
      
	}
return $options;

}
function getYearList($selected = ''){
	$options = '';
	for($i=2015;$i<=2025;$i++)
	{
		$selectedOpt = ($i == $selected)?'selected':'';
		$options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
	}
	return $options;
}



function getEvents($date = ''){
	
	include 'config.php';
	$eventListHTML = '';
	$date = $date?$date:date("Y-m-d");
	$result = $db->query("SELECT title FROM events WHERE date = '".$date."' AND status = 1");
	if($result->num_rows > 0){
		
		$eventListHTML = '<h2>Zajęcia dnia '.DateV('l j f Y',strtotime($date)).'</h2>';
		$eventListHTML .= '<ul>';
		while($row = $result->fetch_assoc()){ 
            $eventListHTML .= '<li>'.$row['title'].'</li>';
        }
		$eventListHTML .= '</ul>';
	}
	echo $eventListHTML;
}
function addEvent($date,$title){
	include 'config.php';
	$currentDate = date("Y-m-d H:i:s");
	$insert = $db->query("INSERT INTO events (title,date,created,modified) VALUES ('".$title."','".$date."','".$currentDate."','".$currentDate."')");
	
	if($insert){
		echo 'ok';
	}else{
		echo 'err';
	}
}
?>