<?

include "includes/templates.php";

beginPage("signup", "styles/edit.css");
mainMenu();
?>


        
  <div class="content">         
         
            <section>
                <div id="name">
            <section class="left">
                
                <form class="edit" action="#" method="post">
                    <div>
                         <div class="avatar"><img src="imgs/placeholder-avatar1.jpg"></div>
                        <h2>Picture</h2>   
                        
                        <input type="text" id="picture" name="Picture">
                        <button type="submit">File</button>
                        <button type="submit">Submit</button>
                    
                         <div class="hr"><h3></h3></div>
                    </div>
                    <div>
                        <h2>Screen Name</h2>                        
                        <input type="text" id="screenName" name="user-name">
                        <button type="submit">Submit</button>  
                        <a id="nametext">jimbolemons</a>
                         <div class="hr"><h3></h3></div>
                    </div>
                    <div>
                        <h2>Title</h2>                        
                        <input type="text" id="title" name="title">
                        <button type="submit">Submit</button> 
                        <a id="titletext">Not An Artist</a>
                         <div class="hr"><h3></h3></div>
                    </div>
                    <div>
                        <h2>Resume</h2>                        
                        <input type="text" id="resume" name="user-name">
                        <button type="submit">File</button> 
                        <button type="submit">Submit</button>
                        <a id="resumetext">McDonaldsApp.pdf</a>
                         <div class="hr"><h3></h3></div>
                    </div>
                    <div>
                        <h2>About</h2>                        
                        <textarea rows="10" cols="65"></textarea>
                        <div><button id="aboutButt" type="submit">Submit</button> </div>                       
                         <div class="hr"><h3></h3></div>
                    </div>
                    <div>
                    <button id="finishbutt" type="submit"><h1>Finish</h1></button> 
                    <footer>neat</footer>
                    </div>                
                    
               
   

<? endPage(); ?>   