<section>
    <?php 
        if (isset($this->errors)) {
            foreach ($this->errors as $error) {
                echo '<div class="system_message alert">'.$error.'</div>';
            }
        }
    ?>
    <div class="content">

        <h1>Your profile</h1>

        <div class="block">
            <div>
                Your username: <?php echo Session::get('user_name'); ?>
            </div>
                        
            <div>
                Your gravatar pic (on gravatar.com): <img src='<?php echo Session::get('user_gravatar_image_url'); ?>' />
            </div>   
            
            <div>
                Your avatar pic (saved on local server): <img src='<?php echo Session::get('user_avatar_file'); ?>' />
            </div> 
            
            <div>
                Your account type is: <?php echo Session::get('user_account_type'); ?>
            </div>
            <hr/>
            <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                <a href="<?php echo URL; ?>login/changeaccounttype">Change account type</a>
            </li>                           
            <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                <a href="<?php echo URL; ?>login/uploadavatar">Upload an avatar</a>
            </li>                          
            <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                <a href="<?php echo URL; ?>login/editusername">Edit my username</a>
            </li>
            <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                <a href="<?php echo URL; ?>login/edituseremail">Edit my email</a>
            </li>
        </div>
        
    </div>
</section>