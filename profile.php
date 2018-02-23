<?

include "includes/templates.php";
include "includes/profileFunctions.php";

beginPage("home", array("styles/profile.css"));
mainMenu();
?>
        <div class="tray">
            <div class="carasol">
                    <?
                     doThingMany(5, "addThumbnail", array("imgs/placeholder-gallery-image.png"));
                    ?>
            </div>
        </div>
        <div class="content">
            <article>
                <div class="creator">
                    <div class="avatar"><img src="imgs/placeholder-avatar1.jpg"></div>
                    <h2>Namey McStudent</h2>
                    <h3>Texture Artist</h3>
                </div>
                <div class="bubble top">
                    <p>My bio goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in </p>
                    <div class="arrow top-left">
                        <div class="blocker"></div>
                        <div class="pointer"></div>
                    </div>
                </div>
            </article>
            <aside>
                <div class="split">
                    <div>My Resume</div>
                    <div>
                        <a href="#" class="button">Download</a>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>Contact Me</div>
                    <div>
                        <ul>
                            <li><a href="#" class="work">Email</a></li>
                            <li><a href="#" class="work">Twitter</a></li>
                            <li><a href="#" class="work">Facebook</a></li>
                        </ul>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>My Links</div>
                    <div>
                        <ul>
                            <li><a href="#" class="work">My DeviantArt</a></li>
                            <li><a href="#" class="work">My Grandma’s Etsy</a></li>
                            <li><a href="#" class="work">My Tumbler</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
            <section>
                <div class="hr"><h3><span>Comments</span></h3></div>
                
                <?
                doThingMany(3, "addComment", array("imgs/placeholder-avatar1.jpg", "Lorem ipsum. lots of text goes here. This is the comment that the other user has typed in. Neat."));
                ?>
            </section>
            <section id="allProjectsSection">
                <h3 id="allProjects">All Projects</h3>
                <div class="hr"></div>
                <div class="more">
                    <? 
                    doThingMany(16, "addThumbnail", array("imgs/placeholder-gallery-image.png", "Project Name"));
                    ?>
                </div>
            </section>
            
        </div>
        <footer class="main"></footer>
<? endPage(); ?>        