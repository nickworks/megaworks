<?

include_once "includes/templates.php";
include_once "includes/class.User.php";
include_once "includes/functions.php";

$cURL = get('redirect');

// GET FORM DATA:
$mail = post("user-email");
$pass = post("user-password");
$redirect = get("redirect");
if($redirect !== htmlentities($redirect)) $redirect = "";

// LOGIN THE USER:
$errs = empty($mail) ? null : User::login($mail, $pass);

// REDIRECT:
if(User::isLoggedIn()) {
    if(empty($redirect)) $redirect = "profile.php";
    header("location:{$redirect}");
}

// BUILD THE PAGE:
beginPage("login", "styles/login.css");
mainMenu();
?>

<div class="tray dark">
    <div id="login">

        <? errors($errs); ?>
        <div class="flex">
            <section>
                <h1>Login</h1>
                <form class="login" action="login.php?redirect=<?=htmlentities($redirect)?>" method="post">
                    <div>
                        <label>Email</label>
                        <input type="text" id="name" name="user-email">
                    </div>
                    <div>
                        <label>Password</label>
                        <input type="password" id="password" name="user-password">
                    </div>
                    <p><a href="reset.php">Forgot your password?</a></p>
                    <input type="submit" value="Log In" id="confirm-login">
                </form>
            </section>
            <section><div class="centerLine"></div></section>
            <section>
                <h1>Don't have an account?</h1>
                <h2>Signing up is easy!</h2>
                <a href="signup.php" id="create-account" href="signup.php">Create an account</a>
            </section>
        </div><!-- .flex -->
    </div><!-- #login -->
    <footer></footer>
</div>

<? endPage(); ?> 