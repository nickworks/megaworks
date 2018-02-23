<?
include_once "includes/templates.php";
include_once "api/functions.php";
include_once "api/class.CoolDB.php";

$db = new CoolDB();

$eventInfo = $db->query("SELECT * FROM `events`;", array());

//print_r($eventInfo); exit;

beginPage("events", "styles/events.css");
mainMenu();
?>

<? function event() { ?>
<li>
    <figure>
        <a href="event.php" id="eventPicture"></a>
        <time><? echo $time; ?></time>
    </figure>
    
    <h2><a href="event.php"><? echo $title; ?></a></h2>
    <p>Description of Event - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut</p>
</li>
<? } ?>

<? function event(string $time, string $title) { ?>
<li>
    <figure>
        <a href="event.php" id="eventPicture"></a>
        <time><? echo $time; ?></time>
    </figure>
    
    <h2><a href="event.php"><? echo $title; ?></a></h2>
    <p>Description of Event - Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut exercitation ullamco laboris nisi ut aliquip ex ea commodo aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quiamagni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam voluptatem. Ut enim ad minima veniam, quis nostrum exercitationemcorporis suscipit laboriosam, nisi ut</p>
</li>
<? } ?>
<div id="calendar">
</div>
<div id="upcomingEvents">
    <h1>
        Upcoming Events
    </h1>
    <ul>
        <?
        event("March 3rd", "Super Cool Event");
        event("March 6th - March 8th", "An Even Better Event");
        event("March 11th", "The Best Event");
        event("March 18th - March 21st", "The Bestest Event");
        ?>
    </ul>
</div>
<? endPage(); ?> 