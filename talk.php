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
            <div class="discordEmbed"><iframe src="https://discordapp.com/widget?id=223170046019633162&theme=dark" width="300px" height="474" allowtransparency="true" frameborder="0"></iframe></div>
            
            <div class="group1">
                <div class=groupIcon><a href="https://www.facebook.com/groups/135662413450556/"><div id="mega-facebook"></div></a></div>
                <div class=groupIcon><a href="https://www.facebook.com/groups/31875193841/"><div id="dagd-facebook"></div></a></div>  
                <div class=groupIcon><a href="https://steamcommunity.com/groups/fsu-dagd"><div id="dagd-steam"></div></a></div>
            </div>
            
            <div class="group1">
                <? //Creates a second coloumn for icons ?>                              
            </div>
            
        </div>
           
            
          
            <footer></footer>
        

<? endPage(); ?>   