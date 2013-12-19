<section>    
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content">
    
        <header>
            <h3>Edit a user</h3>
        </header>

        <?php if ($this->user) { ?>
        
        <form method="post" action="<?php echo URL; ?>user/editSave/<?php echo $this->user->user_id; ?>">
            
            <header>
                <h3>Edit <b><?php echo $this->user->user_name; ?></b></h3>
            </header>

            <label for="login_input_username">
                <em>Username</em>
                <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" autofocus required value="<?php echo $this->user->user_name; ?>"/>
            </label>

            <!-- the email input field uses a HTML5 email type check -->
            <label for="login_input_email">
                <em>Email</em>
                <input id="login_input_email" class="login_input" type="email" name="user_email" required value="<?php echo $this->user->user_email; ?>"/>
            </label>

            <label>
                <em>Account Type</em>
                <div class="input-helper">
                    <select name="user_account_type">
                        <option value="1" <?php if($this->user->user_account_type === "1"){ echo "selected='selected'"; } ?>>User</option>
                        <option value="2" <?php if($this->user->user_account_type === "2"){ echo "selected='selected'"; } ?>>Manager</option>
                    </select>
                </div>
            </label>

            <input type="hidden" name="user_id" value="<?php echo $this->user->user_id; ?>" />

            <div class="buttons">
                <input type="submit" value='Save changes' class="btn"/>
            </div>
        </form>
        
        <?php } else { ?>
        
        <p>This User does not exist.</p>
        
        <?php } ?>
        
    </div>
</section>    