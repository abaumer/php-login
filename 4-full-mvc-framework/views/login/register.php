<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content skinny">
        <h1>Register</h1>

        <!-- register form -->
        <form method="post" action="<?php echo URL; ?>login/register_action" name="registerform">
            <header>
                <h3>Sign up</h3>
            </header>

            <!-- the user name input field uses a HTML5 pattern check -->
            <label for="login_input_username">
                <em>Username</em>
                <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" autofocus required />
            </label>

            <!-- the email input field uses a HTML5 email type check -->
            <label for="login_input_email">
                <em>Email</em>
                <input id="login_input_email" class="login_input" type="email" name="user_email" required />
            </label>

            <label for="login_input_password_new">
                <em>Password</em>
                <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  
            </label>

            <label for="login_input_password_repeat">
                <em>Confirm password</em>
                <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
            </label>
            
            <div class="buttons">
                <input type="submit"  name="register" value="Register" class="btn" />
            </div>
            
        </form>
        
    </div>
</section>