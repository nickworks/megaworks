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
       
<div id="signup">
    <? if ($email !== ''){ 
        if($errors['err'] != ''){ ?>
            <p class="errorMessage">Error: <?= $errors['err'] ?></p>
        <? }
    } ?>
    <section class="left">
        <? if ($was_user_created) { ?>
            <p class="errorMessage">Thanks for signing up! Please wait until your account is verified, and then try logging in.</p>
        <? } else { ?>
        <form class="signup" action="signup.php" method="post">
            <h1>Sign Up</h1>
            <div>
                <h2>What should we call you?</h2>
                    <input type ="text" id ="username" name="user-name">
                <h2>What is your name?</h2>
                    <input type ="text" id ="firstname" name="user-firstname">
                <h2>What is your last name?</h2>
                    <input type ="text" id ="lastname" name="user-lastname">
                <h2>Email</h2>
                    <input type ="text" id ="email" name="user-email">
                <h2>Password</h2>
                    <input type ="password" id ="password" name="user-password">
            </div>
            <div class="button" id="confirm-signup">
                <button type="submit">Sign Up</button>
            </div>
            <div class="haveText" >
                <p>Already have an account? <a class="linkText" href="login.php">Login!</a></p>
            </div>
        </form>
        <? } ?>
    </section>   
    <footer></footer>
</div>

<? endPage(); ?>   