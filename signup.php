<?

include_once "includes/templates.php";
include_once "api/class.User.php";
include_once "api/functions.php";

$email = post('user-email');
$pass = post('user-password');
$first = post('user-firstname');
$last = post('user-lastname');
$alias = post('user-name');
$title = post('');
$was_user_created = false;


if ($email !== ''){
    echo $email;
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
       
<div>
    
<div id="signup">   
    <? if ($email !== ''){ 
        if($errors['err'] != ''){ ?>
            <p class="errorMessage">Error: <?= $errors['err'] ?></p>
        <? }
    } ?>
    
    <section class="form">
        <? if ($was_user_created) { ?>
            <p class="errorMessage">Thanks for signing up! Please wait until your account is verified, and then try logging in.</p>
        <? } else { ?>
        
        <form class="signup" action="signup.php" method="post">
            
            <h1>Create an Account</h1>
            
            <div class="haveText" >
                    <p>Already have an account? <a class="linkText" href="login.php">Login!</a></p>
                </div>
            
            <div>
                <div class="input" id="formDiv">
                    <section class="left">
                        <h1>Personal Information</h1>
                        <h2>Username</h2>
                            <input type ="text" id ="username" name="user-name">
                        <h2>First Name</h2>
                            <input type ="text" id ="firstname" name="user-firstname">
                        <h2>Last Name</h2>
                            <input type ="text" id ="lastname" name="user-lastname">
                    </section>
                    
                    <section class="right">
                    <h1></h1>
                        <p>Lorem ipsum dolor sit amet, mauris placerat ac sit cras, suspendisse convallis metus nonummy sapien, arcu conubia at, felis lectus, consectetuer lacus tempor.</p>
                    </section>
                    
                    
                </div>
                
                <div id="divider"></div>
                
                <div class="input" id="formDiv">
                    <section class="left"> 
                        <h1></h1>
                        <h2>Title</h2>
                        <input type ="text" id ="title" name="user-occupation"> 
                    </section>  
                    <section class="right">
                        <h1></h1>
                        <p>Are you a Programmer? Artist? Gamer? Dancer? Alien? TELL US ALREADY!</p>
                    </section>
                </div>
                
                <div id="divider"></div>
                
                <div class="input" id="formDiv">
                    <section class="left">
                        <h1>Contact Information</h1>
                        <h2>Email</h2>
                            <input type ="text" id ="email" name="user-email">
                        <h2>Confirm Email</h2>
                            <input type ="text" id ="email" name="user-email">
                    </section>
                    <section class="right">
                        <h1></h1>
                        <p>Lorem ipsum dolor sit amet, mauris placerat ac sit cras, suspendisse convallis metus nonummy sapien, arcu conubia at, felis lectus, consectetuer lacus tempor.</p>
                    </section>
                </div>
                
                <div id="divider"></div>
                
                <div class="input" id="formDiv">
                    <section class="left">
                        <h1>Security</h1>
                        <h2>Password</h2>
                            <input type ="password" id ="password" name="user-password">
                        <h2>Confirm Password</h2>
                            <input type ="password" id ="password" name="user-password"> 
                    </section>
                    <section class="right">
                        <h1></h1>
                        <p>Lorem ipsum dolor sit amet, mauris placerat ac sit cras, suspendisse convallis metus nonummy sapien, arcu conubia at, felis lectus, consectetuer lacus tempor.</p>
                    </section>
                </div>
                <div id="divider"></div>
            <div class="input" id="formDiv">
                
                <div class="button" id="confirm-signup">
                    <button type="submit">Create Account</button>
                </div>
                
                <div class="haveText" >
                    <p>Already have an account? <a class="linkText" href="login.php">Login!</a></p>
                </div>
            </div>
            </div>
            
        </form>
        <? } ?>
    </section>
    </div>
    <div class="formHR"></div>
    <footer></footer>
    
    
</div>

<? endPage(); ?>   