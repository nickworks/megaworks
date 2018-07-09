<?

include "includes/templates.php";

beginPage("talk", "styles/talk.css");
mainMenu();
?>

<div class="tray">
            <h2>Join our community groups!</h2>
            <p>You can find our community all over the place! Follow us on Facebook, chat it up on Discord, or "research" games with others on our Steam group!</p>         
           </div>  
        
        <div class="content">
            <div class="discordEmbed"><iframe src="https://discordapp.com/widget?id=223170046019633162&theme=dark" width="300px" height="478" allowtransparency="true" frameborder="0"></iframe></div>
            
            <div class="group1">
                
                <div class=groupIcon>
                    <a href="https://www.facebook.com/groups/135662413450556/" target='_blank'>
                        <div id="facebook">
                            <p>Follow MEGA<br>
                                on Facebook!
                            </p>
                        </div></a>
                </div>
                
                
                <div class=groupIcon>
                    <a href="https://www.facebook.com/groups/31875193841/" target='_blank'>
                        <div id="facebook">
                            <p>Join DAGD<br>
                                on Facebook!
                            </p>
                        </div></a>
                </div>  
                
                
                <div class=groupIcon>
                    <a href="https://steamcommunity.com/groups/fsu-dagd" target='_blank'>
                        <div id="steam">
                            <p>Game with us<br>
                                on STEAM!
                            </p>
                        </div></a>
                </div>
            </div>
            
            <div class="group1">
                <? //Creates a second coloumn for icons ?>                              
            </div>
            
        </div>
           
            
          
            <footer></footer>
        

<? endPage(); ?>   