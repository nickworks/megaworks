<?

include_once "includes/templates.php";
include_once "api/class.User.php";
include_once "api/functions.php";

// GET FORM DATA:
$mail = post("user-email");
$pass = post("user-password");
$redirect = get("redirect");
if($redirect !== htmlentities($redirect)) $redirect = "";

// LOGIN THE USER:
if(!empty($mail)){
    $result = User::login($mail, $pass);
}

// REDIRECT:
if(User::isLoggedIn()) {
    if(empty($redirect)) $redirect = "profile.php";
    header("location:{$redirect}");
}

// BUILD THE PAGE:
beginPage("login", "styles/login.css");
mainMenu();
?>

<div id="login">
            <section class="left">
                <h1>Login</h1>
                <form class="login" action="login.php?redirect=<?=htmlentities($redirect)?>" method="post">
                    <div>
                        <h2>Email*</h2>
                        <input type="text" id="name" name="user-email">
                    </div>
                    <div>
                        <h2>Password*</h2>
                        <input type="password" id="password" name="user-password">
                    </div>
                    <div>
                        <p id="forgot-password"><a href="#">Forgot your password?</a></p>
                    </div>
                    <div class="button" id="confirm-login">
                        <button id="submitB" type="submit">Log In</button>
                    </div>
                </form>
            </section>
            <section class="right">
                <div class="centerLine"></div>
                <h1>I don't have an account</h1>
                <div class="button" id="create-account">
                    <a href="signup.php">
                        <button id="CreateAnAccount" href="signup.php">Create an account</button>
                    </a>
                </div>
            </section>
<footer>neat</footer>
        </div>

<? endPage(); ?> 