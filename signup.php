<?

include_once "includes/templates.php";
include_once "includes/class.User.php";
include_once "includes/functions.php";

$email = post('user-email1');
$pass1 = post('user-password1');
$pass2 = post('user-password2');
$first = post('user-firstname');
$last = post('user-lastname');
$was_user_created = false;

$errors = array();

if ($email !== ''){
   $errors = (User::new(
                $email,
                $pass1,
                $pass2,
                $first,
                $last
    ));
    $was_user_created = empty($errors);
}

beginPage("signup", "styles/signup.css");
mainMenu();
?>
       
<div class="tray dark">
    
    <section class="form">
        <? if ($was_user_created) { ?>
            <p class="errorMessage">Thanks for signing up! Please wait until your account is verified, and then try logging in.</p>
        <? } else { ?>
        
        <form id="signup" action="signup.php" method="post">
            
            <h1>Create an Account</h1>
            <p>Already have an account? <a href="login.php">Login!</a></p>
            
            <? errors($errors); ?>
            
            <div class='bubble'>
                <h2>Your Full Name</h2>
                <div class='fields'>
                    <div>
                        <p>Who are you? We use this information to verify your account. Also, your full name is displayed on your profile page (if you want it to be).</p>
                    </div>  
                    <div>
                        <label>First Name</label>
                        <input type="text" name="user-firstname" value="<?=formData("user-firstname")?>">
                        <label>Last Name</label>
                        <input type="text" name="user-lastname" value="<?=formData("user-lastname")?>">
                    </div>
                </div>
                <h2>Email Address</h2>
                <div class='fields'>
                    <div>
                        <p>In order to make an account, you must use a valid Ferris email address.</p>
                    </div>  
                    <div>
                        <label>Email</label>
                        <input type="text" name="user-email1" value="<?=formData("user-email1");?>">
                        <label>Confirm Email</label>
                        <input type="text" name="user-email2">
                    </div>
                </div>
                <h2>Password</h2>
                <div class='fields'>
                    <div>
                        <p>Choose a strong password!</p>
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" name="user-password1">
                        <label>Confirm Password</label>
                        <input type="password" name="user-password2"> 
                    </div>
                </div>
            </div><!-- end .bubble -->
            <input type="submit" value="Create Account">
        </form>
        <? } ?>
    </section>

<footer></footer>

</div> <!-- end .tray -->

<? endPage(); ?>