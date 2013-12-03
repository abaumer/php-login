<!doctype html>
<html>
<head>
	<title><?php echo SITE_TITLE; ?></title>
    <meta charset="utf-8">
	
    <!-- Main stylesheet imports bootstrap css and adds custom 
    <link href='http://fonts.googleapis.com/css?family=Lato|Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'> -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/style.css" />
	<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>
</head>
<body>
    
    <header>
      <a href="<?php echo URL; ?>" class="logo"><?php echo SITE_NAME; ?></a>

      <nav>
        <?php if (Session::get('user_logged_in') == true):?>
          <a id="showmobilemenu" class="mobile-menu">Menu</a>
          <a href="<?php echo URL; ?>login/logout" class="hidden-lt600">Logout</a>
        <?php endif; ?>  


        <!-- for not logged in users -->
        <?php if (Session::get('user_logged_in') == false):?>
          <a href="<?php echo URL; ?>login/index" class="<?php if ($this->checkForActiveControllerAndAction($filename, "login/index")) { echo 'active'; } ?>" >Login</a>
        <?php endif; ?>

      </nav>

    </header>
    <div class="page">

        <div class="header_left_box">
         
        </div>

        <?php if (Session::get('user_logged_in') == true): ?>
            <div class="header_right_box">
                
                <div class="namebox">
                    Hello <?php echo Session::get('user_name'); ?> !
                </div>
                
                <div class="avatar">
                    <?php if (USE_GRAVATARS) { ?>
                        <img src='<?php echo Session::get('user_gravatar_image_url'); ?>' />
                    <?php } else { ?>
                        <img src='<?php echo Session::get('user_avatar_file'); ?>' />
                    <?php } ?>
                </div>                

            </div>
        <?php endif; ?>

        <div class="clear-both"></div>

	