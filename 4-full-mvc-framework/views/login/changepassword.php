<section>
    <?php 
        if (isset($this->errors)) {
            foreach ($this->errors as $error) {
                echo '<div class="system_message alert">'.$error.'</div>';
            }
        }
    ?>
    <div class="content">
        <h1>Set new password</h1>  
        <!-- new password form box -->
        <form method="post" action="<?php echo URL; ?>login/setnewpassword" name="new_password_form">
            <input type='hidden' name='user_name' value='<?php echo $this->user_name; ?>' />
            <input type='hidden' name='user_password_reset_hash' value='<?php echo $this->user_password_reset_hash; ?>' />

            <label for="reset_input_password_new">
                <em>New password</em>
                <input id="reset_input_password_new" class="reset_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  
            </label>

            <label for="reset_input_password_repeat">
                <em>Confirm New password</em>
                <input id="reset_input_password_repeat" class="reset_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />        
            </label>

            <div class="buttons">
                <input type="submit"  name="submit_new_password" value="Submit new password" class="btn" />
            </div>
        </form>

        <a href="<?php echo URL; ?>login/index">Back to Login Page</a>
        
    </div>
</section>