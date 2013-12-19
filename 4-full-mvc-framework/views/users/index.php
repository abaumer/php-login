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
        
        <h1>Users</h1>

        <div class="block">
            <table>
            <?php
            
                if ($this->users) {
                    
                    foreach($this->users as $key => $value) {
                        echo '<tr>';
                        echo '<td>' . $value->user_name . '</td>';
                        echo '<td>' . $value->user_account_type . '</td>';
                        echo '<td><a href="'. URL . 'user/edit/' . $value->user_id.'">Edit</a></td>';
                        echo '<td><a href="'. URL . 'user/delete/' . $value->user_id.'">Delete</a></td>';
                        echo '</tr>';
                    }            
                    
                } else {
            
                    echo 'No notes yet. Create one !';
                
                }
            ?>
            </table>
        </div>


        <hr/>


    </div>
</section>