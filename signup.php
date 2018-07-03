<?

include_once "includes/templates.php";
include_once "includes/class.User.php";
include_once "includes/functions.php";

$email = post('user-email1');
$pass = post('user-password1');
$first = post('user-firstname');
$last = post('user-lastname');
$alias = post('user-name');
$title = post('');
$was_user_created = false;

$errors = array();

if ($email !== ''){
   $errors = (User::new(
                $email,
                $pass,
                $first,
                $last,
                $alias,
                $title
            ));
    if($errors['err'] === ''){
        $was_user_created = true;
    }
}

beginPage("signup", "styles/signup.css");
mainMenu();
?>
       
<div class="tray">
    
    <section class="form">
        <? if ($was_user_created) { ?>
            <p class="errorMessage">Thanks for signing up! Please wait until your account is verified, and then try logging in.</p>
        <? } else { ?>
        
        <form id="signup" action="signup.php" method="post">
            
            <h1>Create an Account</h1>
            <p>Already have an account? <a href="login.php">Login!</a></p>
            
            <? if (!empty($errors)){ 
                echo "<p class='errorMessage'>Error: ".$errors['err']."</p>";  
            } ?>
            
            <div>                

                <h2>Your Name</h2>
                <p>Who are you? We use this information to verify your account. Also, your full name is displayed on your profile page (if you want it to be).</p>
                <div class='fields'>
                    <div>
                        <label>First Name</label>
                        <input type="text" name="user-firstname" value="<?=formData("user-firstname")?>">
                    </div>  
                    <div>
                        <label>Last Name</label>
                        <input type="text" name="user-lastname" value="<?=formData("user-lastname")?>">
                    </div>
                </div>
                
                <h2>Your Email</h2>
                <p>In order to make an account, you must use a valid Ferris email address.</p>
                <div class='fields'>
                    <div>
                        <label>Email</label>
                        <input type="text" name="user-email1" value="<?=formData("user-email1");?>">
                    </div>  
                    <div>
                        <label>Confirm Email</label>
                        <input type="text" name="user-email2">
                    </div>
                </div>
                
                <h2>Password</h2>
                <p>Choose a strong password!</p>
                <div class='fields'>
                    <div>
                        <label>Password</label>
                        <input type="password" name="user-password1">
                    </div>  
                    <div>
                        <label>Confirm Password</label>
                        <input type="password" name="user-password2"> 
                    </div>
                </div>
                
                <input type="submit" value="Create Account">
                <p>Already have an account? <a href="login.php">Login!</a></p>
                
            </div>
            
        </form>
        <? } ?>
    </section>

<footer></footer>

</div> <!-- end .tray -->

<? endPage(); ?>   