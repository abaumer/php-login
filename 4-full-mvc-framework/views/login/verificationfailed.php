<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content">

        <h1>Verification failed</h1>

        <div class="block center">
            <br/><br/>      
            <a href="<?php echo URL; ?>login/index" class="btn">Go to login</a>
            <br/><br/>
        </div>
        
    </div>
</section>