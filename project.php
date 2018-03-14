<?
    include "includes/templates.php";

    $comments = "";
    //$comments = array("comment();");

    beginPage("project", "styles/project.css");
    mainMenu();
?>
        <div class="tray">
            <div class="feature">
                <img src="imgs/placeholder-gallery-image.png">
            </div>
        </div>
        <div class="content">
            <article>
                <h1>Primary Headline</h1>
                <div class="bubble bottom">
                    <p>this is some text</p>
                    <div class="arrow bottom-left">
                        <div class="blocker"></div>
                        <div class="pointer"></div>
                    </div>
                </div>
                <div class="creator">
                    <div class="avatar"><img src="imgs/placeholder-avatar1.jpg"></div>
                    <h2>Namey McStudent</h2>
                    <h3>Texture Artist</h3>
                </div>
            </article>
            <aside>
                <div class="stats">
                    <div>34 likes</div>
                    <div>6 faves</div>
                    <div>240 views</div>
                    <div>8 comments</div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>Downloads</div>
                    <div>
                        <a href="#" class="button">The Game</a>
                        <a href="#" class="button">Source Code</a>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>License</div>
                    <div><a href="https://choosealicense.com/licenses/mit/" target="_blank" class="button license">MIT
                        <span class="bubble">
                            <span class="arrow top-right">
                                <span class="blocker"></span>
                                <span class="pointer"></span>
                            </span>
                            <span class="p"><em>Permissions:</em> You can do anything you want with this work.</span>
                            <span class="p"><em>Conditions:</em> You must provide attribution back to me.</span>
                            <span class="p"><em>Limitations:</em> I am waived of all liability, and the license provides no warranty.</span>
                        </span>
                    </a></div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>Attribution</div>
                    <div>
                        <ul>
                            <li><a href="#" class="work">Texture 16</a> by <a href="#" class="creator">Billy O'Student</a> <span class="license">(CC0)</span></li>
                            <li><span class="work">Music</span> by <span class="creator">My Uncle</span> <span class="license">(permission)</span></li>
                            <li><span class="work">Portions of the code</span> by <a href="#" class="creator">Nick Pattison</a> <span class="license">(MIT)</span></li>
                        </ul>
                    </div>
                </div>
                <div class="hr"></div>
                <div class="split">
                    <div>Tags</div>
                    <div>
                        <a href="#" class="tag button">game</a>
                        <a href="#" class="tag button">in-development</a>
                        <a href="#" class="tag button">unreal engine</a>
                        <a href="#" class="tag button">particles</a>
                    </div>
                </div>
            </aside>
            <? if($comments != "") { ?>
            <section>
                <div class="hr"><h3><span>Comments</span></h3></div>
                <? //TODO: Loop through and post each comment in the comments array. ?>
            </section>
            <? } ?>
<? endPage(); ?>