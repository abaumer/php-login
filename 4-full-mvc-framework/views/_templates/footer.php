       </div><!-- end .page -->
        <footer>
            <div class="debug-helper-box alert">
                DEBUG HELPER: you are in the view: <?php echo $filename; ?>
                <hr/>
            </div>

            <nav>
                <ul id="menu">
                    <li <?php if ($this->checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo URL; ?>index/index">Index</a>
                    </li>
                    <li <?php if ($this->checkForActiveController($filename, "help")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo URL; ?>help/index">Help</a>
                    </li>
                    <li <?php if ($this->checkForActiveController($filename, "overview")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo URL; ?>overview/index">Overview</a>
                    </li>            
                    <?php if (Session::get('user_logged_in') == true):?>
                    <li <?php if ($this->checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo URL; ?>dashboard/index">Dashboard</a>   
                    </li>   
                    <?php endif; ?>                    
                    <?php if (Session::get('user_logged_in') == true):?>
                    <li <?php if ($this->checkForActiveController($filename, "note")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo URL; ?>note/index">My Notes</a>
                    </li>   
                    <?php endif; ?>                    


                    <?php if (Session::get('user_logged_in') == true):?>
                        <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                            <!--<a href="#">My Account</a>-->
                            <a href="<?php echo URL; ?>login/showprofile">My Account</a>
                            <ul class="sub-menu">
                                <!--
                                <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo URL; ?>login/showprofile">Show my profile</a>
                                </li>
                                -->
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
                                <li <?php if ($this->checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo URL; ?>login/logout">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>          

                    <!-- for not logged in users -->
                    <?php if (Session::get('user_logged_in') == false):?>

                        <li <?php if ($this->checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo URL; ?>login/index">Login</a>
                        </li>  
                        <li <?php if ($this->checkForActiveControllerAndAction($filename, "login/register")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo URL; ?>login/register">Register</a>
                        </li>         
                        <li <?php if ($this->checkForActiveControllerAndAction($filename, "login/requestpasswordreset")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo URL; ?>login/requestpasswordreset">Forgot my Password</a>
                        </li>

                    <?php endif; ?>

                </ul>  
                <a href="http://jumpsand.com" target="_blank" title="Jumpsand Web Design & Development Tucson Arizona">&copy Jumpsand LLC</a>
            </nav>
        </footer>
    </body>
</html>