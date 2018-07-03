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
    
<div id="signup">   
    
    <section class="form">
        <? if ($was_user_created) { ?>
            <p class="errorMessage">Thanks for signing up! Please wait until your account is verified, and then try logging in.</p>
        <? } else { ?>
        
        <form class="signup" action="signup.php" method="post">
            
            <h1>Create an Account</h1>
                <? if (!empty($errors)){ 
                    echo "<p class='errorMessage'>Error:".$errors['err']."</p>";  
                } ?>
            <p>Already have an account? <a href="login.php">Login!</a></p>
            
            <div>
                <div class="input">
                    <h1>Account Identity</h1>
                    <section class="left">
                        <label>Username</label>
                        <input type="text" name="user-name" value="<?if(isset($_POST["user-name"])) echo $_POST["user-name"]; ?>">
                    </section>
                    <section class="right">                    
                        <p>Username is how others will see you on the site. Only alphanumeric characters are allowed.</p>
                    </section>
                    <section class="left">
                        <label>Title</label>
                        <input type="text" name="user-occupation" value="<?if(isset($_POST["user-occupation"])) echo $_POST["user-occupation"]; ?>"> 
                    </section>
                    <section class="right">                    
                        <p>Are you a Programmer? Artist? Gamer? Dancer? Alien? TELL US!</p>
                    </section>
                    
                    <div class="clear"></div>
                </div>
                
                <div class="input">
                    <h1>Personal Information</h1>
                    <section class="left">
                        <label>First Name</label>
                        <input type="text" name="user-firstname" value="<?if(isset($_POST["user-firstname"])) echo $_POST["user-firstname"]; ?>">
                        </section>  
                    <section class="right">
                        <p>Let the world know who is behind the brilliant work shared on this site!
                    </section>
                    <section class="left">
                        <label>Last Name</label>
                        <input type="text" name="user-lastname" value="<?if(isset($_POST["user-lastname"])) echo $_POST["user-lastname"]; ?>">
                    </section>  
                    <section class="right">
                        <p>Let the world know who is behind the brilliant work shared on this site!
                    </section>
                    <div class="clear"></div>
                
                </div>
                
                <div class="input">
                    <h1>Contact Information</h1>
                    <section class="left">
                        <label>Email</label>
                        <input type="text" name="user-email1" value="<?if(isset($_POST["user-email1"])) echo $_POST["user-email1"]; ?>">
                    </section>
                    <section class="right">    
                        <p>We need your email for account verification purposes and notifications if you choose to opt in.</p>
                    </section>
                    <section class="left">
                        <label>Confirm Email</label>
                        <input type="text" name="user-email2">
                    </section>
                    <section class="right">
                        <p>We need your email for account verification purposes and notifications if you choose to opt in.</p>
                    </section>
                    <div class="clear"></div>
                </div>
                
                <div class="input">
                    <h1>Security</h1>
                    <section class="left">
                        <label>Password</label>
                        <input type="password" name="user-password1">
                    </section>
                    <section class="right">
                        <p>Choose a strong, complex, but easy to remember password.<br><br>
                        It is best to use a mixture of capitals, numbers, and symbols.</p>
                    </section>
                    <section class="left">
                        <label>Confirm Password</label>
                        <input type="password" name="user-password2"> 
                    </section>
                    <section class="right">
                        <p>Choose a strong, complex, but easy to remember password.<br><br>
                        It is best to use a mixture of capitals, numbers, and symbols.</p>
                    </section>
                    <div class="clear"></div>
                </div>
                
                <div class="input">
                
                <input type="submit" value="Create Account">

                <p>Already have an account? <a class="linkText" href="login.php">Login!</a></p>

            </div>
            </div>
            
        </form>
        <? } ?>
    </section>
    </div>

<footer></footer>

</div> <!-- end .tray -->

<? endPage(); ?>   