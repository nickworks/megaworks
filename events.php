<?
include"includes/templates.php";

beginPage("events", "styles/events.css");
mainMenu();
?>
<div id="calendar">
    <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;height=700&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=7dsrlhv2rmhdu0u95j1v6u7fkc%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=America%2FNew_York" style="border-width:0" width="1500" height="700" frameborder="0"></iframe>
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
    <footer>neat</footer>
</div>
<? endPage(); ?> 