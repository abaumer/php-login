<section>    
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    if (isset($this->success)) {
        foreach ($this->success as $success) {
            echo '<div class="system_message alert">'.$success.'</div>';
        }
    }
    ?>
    <div class="content">
        
        <h1>New User</h1>

        <form method="post" action="<?php echo URL;?>user/create">
            <header>
                <h3>Create a New User</h3>
            </header>

            <label for="login_input_username">
                <em>New Username</em>
                <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" autofocus required />
            </label>

            <!-- the email input field uses a HTML5 email type check -->
            <label for="login_input_email">
                <em>User's Email</em>
                <input id="login_input_email" class="login_input" type="email" name="user_email" required />
            </label>

            <label>
                <em>Account Type</em>
                <div class="input-helper">
                    <select name="user_account_type">
                        <option value="1">User</option>
                        <option value="2">Manager</option>
                    </select>
                </div>
            </label>

            <label>
                <em>User Password</em>
                <input type="text" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
            </label>

            <div class='buttons'>
                <input type="submit" value='Create this user' autocomplete="off" class="btn" />
            </div>
        </form>

        
        
    </div>
</section>