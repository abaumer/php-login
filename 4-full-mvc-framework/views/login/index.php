<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content skinny">
        <h1>Login</h1>
        <form action="<?php echo URL; ?>login/login" method="post">
            <header>
                <h3>Login</h3>
            </header>

            <label>
                <em>Username</em>
                <input type="text" name="user_name" autofocus required autocomplete="off"/>
            </label>
            
            <label>
                <em>Password</em>
                <input type="password" name="user_password" required autocomplete="off"/>
            </label>
            
            <!--
            <label>
                <em>Remember me</em>
                <div class="input-helper">
                    <input type="checkbox" name="user_rememberme" />
                </div>
            </label>
            -->
                        
            <div class="buttons">
                <input type="submit" class="btn" />
            </div>
                
        </form>    
        
        <div class="center">
            <br/>
            <a href="<?php echo URL; ?>login/register">Sign up</a>
            |
            <a href="<?php echo URL; ?>login/requestpasswordreset">Forgot my Password</a>
        </div>
        
    </div>
</section>