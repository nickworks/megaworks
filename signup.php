<?

include "includes/templates.php";

include 'class.User.php';

$email = post('user-email');
$pass = post('user-password');
$first = post('user-firstname');
$last = post('user-lastname');
$alias = post('user-name');
$title = post('');

print_r(User::new(
    $email,
    $pass,
    $first,
    $last,
    $alias,
    $title
));

beginPage("signup", "styles/signup.css");
mainMenu();
?>


        
<div id="signup">
            <section class="left">
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
            </section>
            
        </div>

<? endPage(); ?>   