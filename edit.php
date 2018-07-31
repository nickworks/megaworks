<?

include_once "includes/templates.php";
include_once "includes/class.User.php";
include_once "includes/functions.php";

beginPage("edit", "styles/edit.css");
mainMenu();
?>


<div class="tray dark">
    
    <section class="form">

        
        <form id="signup" action="signup.php" method="post">
            
            <h1>Edit Profile</h1>
            <p>Edit your user information here.</p>
            

            
            <div class='bubble'>
                <h2>Profile Picture</h2>
                
                <div class="fields">
                    <button>Select File</button>                     
                </div>
                <h2>Resume</h2>
                
                <div class="fields">
                    <button>Select File</button>                     
                </div>
                <h2>Links</h2>
                
                <div class="fields">
                    <label>Portfolio</label>    
                </div>
                
                <input type="text" name="user-portfolio-link" value="<?=formData("user-portfolio-link")?>">
                
                <h2>User Bio</h2>
                
                <div class="fields">
                    <label>Bio</label>    
                </div>
                
                <input type="text" name="user-bio" value="<?=formData("user-bio")?>">
                
                
                <h2>Your Full Name</h2>
                <div class='fields'>
                    <div>
                    </div>  
                    <div>
                        <label>First Name</label>
                        <input type="text" name="user-firstname" value="<?=formData("user-firstname")?>">
                        <label>Last Name</label>
                        <input type="text" name="user-lastname" value="<?=formData("user-lastname")?>">
                        <label>Hide Personal Info?</label>
                        <input type="checkbox" name="user-privacy">                        
                    </div>
                </div>
                <h2>Title</h2>
                <div class='fields'>
                    <div>
                        <p></p>
                    </div>  
                    <div>
                        <label>New Title</label>
                        <input type="text" name="user-title" value="<?=formData("user-title");?>">
                    </div>
                </div>
                <h2>Alias</h2>
                <div class='fields'>
                    <div>
                        <p></p>
                    </div>  
                    <div>
                        <label>New Alias</label>
                        <input type="text" name="user-alias" value="<?=formData("user-alias");?>">
                    </div>
                </div>
                <h2>Contact Info</h2>
                <div class='fields'>
                    <div>
                        <label>New Email</label>
                        <input type="text" name="user-email1" value="<?=formData("user-email1");?>">
                        <label>Confirm New Email</label>
                        <input type="text" name="user-email2"> 
                    </div>
                </div>
            </div><!-- end .bubble -->
            <input type="submit" value="Save Changes">
        </form>

    </section>

<footer></footer>

</div>

                    
               
   

<? endPage(); ?>   