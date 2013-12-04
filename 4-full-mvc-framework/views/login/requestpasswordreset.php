<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content skinny">
        <h1>Request a password reset</h1>
        <!-- request password reset form box -->
        <form method="post" action="<?php echo URL; ?>login/requestpasswordreset_action" name="password_reset_form">
            <header>
                <p>Enter your username and you'll get a mail with instructions:</p>
            </header>

            <label for="password_reset_input_username">
                <em>Username</em>
                <input id="password_reset_input_username" class="password_reset_input" type="text" name="user_name" required />
            </label>

            <div class="buttons">
                <input type="submit"  name="request_password_reset" value="Reset my password" class="btn"/>
            </div>
        </form>
        
    </div>
</section>