<section>
    <?php 
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message alert">'.$error.'</div>';
        }
    }
    ?>
    <div class="content">

        <h1>Change account type</h1>
        
        <div class="block">
            <p>
                This page is a basic implementation of the upgrage-process.
                User can click on that button to upgrade their accounts from
                "basic account" to "premium account". This script simple offers
                a clickable button that will upgrade/downgrade the account instantly.
                In a real world application you would implement something like a
                pay-process. 
            </p>
            
            <p>
                This view belong to the <b>login-controller / changeaccounttype()-method.</b>
                <br/>The model used is <b>login->changeAccountType().</b>        
            </p>
        </div>

        <h2>Currently your account type is: <?php echo Session::get('user_account_type'); ?></h2>
            
            
            <!-- basic implementation for two account type: type 1 and type 2 -->    
            <?php if (Session::get('user_account_type') == 1) { ?>
            <form action="<?php echo URL; ?>login/changeaccounttype_action" method="post">
                <div class="buttons">
                    <input type="submit" name="user_account_upgrade" value="Upgrade my account" class="btn"/>
                </div>
            </form>
            <?php } elseif (Session::get('user_account_type') == 2) { ?>
            <form action="<?php echo URL; ?>login/changeaccounttype_action" method="post">
                <div class="buttons">
                    <input type="submit" name="user_account_downgrade" value="Downgrade my account" class="btn"/>
                </div>
            </form>    
            <?php } ?>

        
    </div>
</section>