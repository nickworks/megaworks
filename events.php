<?
include_once "includes/templates.php";
include_once "includes/functions.php";
include_once "includes/class.MegaDB.php";

//TODO: only get events for the selected month...
$events = MegaDB::query("SELECT * FROM `events` ORDER BY `events`.`date_start` ASC;", array());

foreach($events as &$event){
    $event['datetime_start']=new DateTime($event['date_start']);
    $event['datetime_end']=new DateTime($event['date_end']);
} 

//print_r($events); exit;

function buildCalendar(){
    global $events;
    
    $m=get('m');
    $y=get('y');
    
    if(empty($m))$m=(new DateTime())->format('m');
    if(empty($y))$y=(new DateTime())->format('Y');
    
    $m=intval($m);
    $y=intval($y);
    
    if($m<1)$m=1;
    if($m>12)$m=12;
    
    $jd=cal_to_jd(CAL_GREGORIAN, $m, 1, $y);
    $numOfDays=cal_days_in_month(CAL_GREGORIAN, $m, $y);
    $startOfMonth=jddayofweek($jd,0);
    $monthName=jdmonthname($jd, CAL_MONTH_GREGORIAN_LONG);
    $monthHasStarted=false;
    
    //////////////////////////////// Filter out events that aren't this month:
    $eventsThisMonth=array();
    foreach($events as $key=>$event){
        
        $dateMonthStart =new DateTime("$y-$m-01");
        $dateMonthEnd   =new DateTime("$y-$m-$numOfDays");
        
        $diff1 = $dateMonthStart->diff($event['datetime_end']);
        $diff2 = $dateMonthEnd->diff($event['datetime_start']);
        
        if($diff1->invert) continue; // this event ended before the month began...
        if(!$diff2->invert) continue; // this event begins after this month...

        array_push($eventsThisMonth, $event);
    }
    
    
    $next=($m>=12)?"m=1&y=".($y+1):"m=".($m+1)."&y=$y";
    $prev=($m<=01)?"m=12&y=".($y-1):"m=".($m-1)."&y=$y";
    
    echo "<div class='month'>";
    echo "<div class='title'><a href='events.php?$prev'>&ltrif;</a>";
    echo " $monthName $y <em>(".count($eventsThisMonth)." events)</em> ";
    echo "<a href='events.php?$next'>&rtrif;</a></div>";
    echo "<div class='week head'>";
    echo "<div class='day'>SUN</div>";
    echo "<div class='day'>MON</div>";
    echo "<div class='day'>TUES</div>";
    echo "<div class='day'>WED</div>";
    echo "<div class='day'>THRS</div>";
    echo "<div class='day'>FRI</div>";
    echo "<div class='day'>SAT</div>";
    echo "</div>";
    
    for($n=1;$n<$numOfDays;){
        echo "<div class='week'>";
        for($i=0;$i<7;$i++){
            if($i>=$startOfMonth)$monthHasStarted=true;
            if($monthHasStarted && $n<=$numOfDays){
                
                $eventsThisDay=array();
                $thisDate = new DateTime("$y-$m-$n");
                foreach($eventsThisMonth as $event){
                    
                    $diff1 = $thisDate->diff($event['datetime_start']);
                    $diff2 = $thisDate->diff($event['datetime_end']);
                    
                    $daysUntilEvent = ($diff1->invert ? -1 : 1) * $diff1->days;
                    
                    if($daysUntilEvent <= 0 && $diff2->invert === 0){
                        array_push($eventsThisDay, $event);
                    }
                }
                $class=(empty($eventsThisDay))?'day':'day special';
                echo "<div class='{$class}'>{$n}";
                foreach($eventsThisDay as $event){
                    echo "<a href='event.php?id=".$event['id']."'>";
                    echo $event['title']."</a>";
                }
                echo "</div>";
                $n++;
            } else {
                echo "<div class='day empty'></div>";
            }
        }
        echo "</div>";
    }
    echo "</div>";
}

beginPage("events", array("styles/events.css", "styles/calendar.css"));
mainMenu();
?>

<div class="tray">
    <h1>Event Calendar</h1>
    <div class="feature">
        <? buildCalendar(); ?>
    </div>
</div>

<div id="upcomingEvents">
    <h1>
        Upcoming Events
    </h1>
    <ul>
        <?
        foreach($events as $event) {
            $sd = new DateTime($event["date_start"]);
            $fsd = date_format($sd, 'M d, Y h:i A');
            $psd = date_parse($fsd);
            $ed = new DateTime($event["date_end"]);
            $fed = date_format($ed, 'M d, Y h:i A');
            $ped = date_parse($fed);
            
            if($psd['year'] == $ped['year'] && $psd['month'] == $ped['month'] && $psd['day'] == $ped['day']) {
                $fed = date_format($ed, 'h:i A'); 
            }
            //print_r($psd); exit; // month day, year time
            //print_r(date_format($t, 'Y-m-d H:i:s')); 
            //print_r(date_format($t, 'M d, Y h:i A ')); exit;
            event($event["id"], $fsd." - ".$fed, $event["title"], $event["location"], $event["location_link"], $event["description"], $event["image"]);
        }
        ?>
    </ul>
   <footer></footer>
</div>
<? endPage(); ?> 