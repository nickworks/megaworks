<?
include"includes/templates.php";

beginPage("event", "styles/event.css");
mainMenu();
?>
<div class="tray">
    <div class="feature">
    </div>
</div>
<div class="content">
    <aside>
        <div class="stats">
            <div>34 likes</div>
            <div>6 faves</div>
            <div>240 views</div>
            <div>8 comments</div>
        </div>
        <div class="hr"><!--<h3><span>Downloads</span></h3>--></div>
        <div class="split">
            <div>Downloads</div>
            <div>
                <a href="#" class="button">Additional Information</a>
            </div>
        </div>
        <div class="hr"><!--<h3><span>License</span></h3>--></div>
        <div class="split">
            <div>Date</div>
            <div>
                <ul>
                    <li><a href="#"><time datetime="2018-01-01 20:00">Month 01, 2018</time></a></li>
                    
                    <li><time>6pm - 8pm</time></li>
                </ul>
            </div>
        </div>
        <div class="hr"><!--<h3><span>Attribution</span></h3>--></div>
        <div class="split">
            <div>Location</div>
            <div>
                <ul>
                    <li><a href="#" class="work">Ferris State University</a></li>
                    <li><address>1201 S State St,</address></li>
                    <li><address>Big Rapids, MI 49307</address></li>
                </ul>
            </div>
        </div>
        <div class="hr"><!--<h3><span>Tags</span></h3>--></div>
        <div class="split">
            <div>Links</div>
            <div>
                <ul>
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
                    <li><a href="#">Additional Information</a></li>
                </ul>
            </div>
        </div>
    </aside>
    <section>
        <div class="description">
            <h1>Event Title and Date go here.</h1>
            <article>
                Description of the event goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi
            </article>
        </div>
    </section>
    <section>
        <div class="rsvp">
            <h1>RSVP</h1>
            <form>
                <div>
                    <h1>Your Name</h1>
                    <input type="text">
                </div>
                <div>
                    <h1>Additional People</h1>
                    <input type="text">
                </div>
                <div>
                    <h1>Special Notes (allergies, accomidations, etc)</h1>
                    <input type="text">
                </div>
                <div>
                    <button>Submit RSVP</button>
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="hr"><h3><span>Comments</span></h3></div>
        <? 
        comment();
        comment();
        comment();
        comment();
        ?>
    </section>
    <footer></footer>
</div>
<? endPage(); ?> 