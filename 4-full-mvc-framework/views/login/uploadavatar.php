<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content">

        <h1>Change Profile Picture</h1>
        
        <form action="<?php echo URL; ?>login/uploadavatar_action" method="post" enctype="multipart/form-data">
            <header>
                <p>Upload a new profile image from your computer <br/><i>(will be scaled to 44x44 px)</i></p>
            </header>

            <label for="avatar_file">
                <em>Avatar</em>
                <div class="input-helper">
                    <input type="file" name="avatar_file" required />
                </div>
            </label>

            <!-- max size 5 MB (as many people directly upload high res pictures from their digicams) -->
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
            
            <div class="buttons">
                <input name="submit" type="submit" value="Upload image" class="btn" />
            </div>
        </form>
        
    </div>
</section>