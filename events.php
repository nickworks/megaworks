<?
include_once "includes/templates.php";
include_once "api/class.CoolDB.php";


$db = new CoolDB();

$events = $db->query("SELECT * FROM `events` ORDER BY `events`.`date_start` ASC;", array());

//print_r($t); exit;

beginPage("events", "styles/events.css");
mainMenu();
?>
<!--
<div id="calendar">
    
</div>
-->
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
            event($fsd." - ".$fed, $event["title"], $event["location"], $event["location_link"], $event["description"], $event["image"]);
        }
        ?>
    </ul>
</div>
<? endPage(); ?> 