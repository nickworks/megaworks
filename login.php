<?

include "includes/templates.php";

beginPage("login", "styles/login.css");
mainMenu();
?>

<div id="login">
            <section class="left">
                <h1>Login</h1>
                <form class="login" action="#" method="post">
                    <div>
                        <h2>Username*</h2>
                        <input type="text" id="name" name="user-name">
                    </div>
                    <div>
                        <h2>Password*</h2>
                        <input type="text" id="password" name="user-password">
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
                    <a href="signup.html">
                        <button id="CreateAnAccount" href="signup.html">Create an account</button>
                    </a>
                </div>
            </section>

        </div>

