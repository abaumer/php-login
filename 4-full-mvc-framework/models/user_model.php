<?php

/**
 * This is basically a simple CRUD demonstration.
 */

class User_Model extends Model
{
    public $errors = array();
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers()
    {
        
        $umq = $this->db->prepare("SELECT user_id, user_name, user_email, user_active, user_account_type, user_has_avatar
                                           FROM users");
        $umq->execute();    
                
                return $umq->fetchAll();
        
    }    
    
    public function getUser($user_id)
    {
        
        $umq = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $umq->execute(array(
            ':user_id' => $user_id));    

        return $umq->fetch();
    }
    
    
    public function registerNewUser() {
        
        if (empty($_POST['user_name'])) {
          
            $this->errors[] = FEEDBACK_USERNAME_FIELD_EMPTY;

        } elseif (empty($_POST['user_password_new'])) {
          
            $this->errors[] = FEEDBACK_PASSWORD_FIELD_EMPTY;            
            
        } elseif (strlen($_POST['user_password_new']) < 6) {
            
            $this->errors[] = FEEDBACK_PASSWORD_TOO_SHORT;            
                        
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            
            $this->errors[] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
                        
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            
            $this->errors[] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
            
        } elseif (empty($_POST['user_email'])) {
            
            $this->errors[] = FEEDBACK_EMAIL_FIELD_EMPTY;
            
        } elseif (strlen($_POST['user_email']) > 64) {
            
            $this->errors[] = FEEDBACK_EMAIL_TOO_LONG;
            
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            
            $this->errors[] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
        
        } elseif (!empty($_POST['user_name'])
                  && strlen($_POST['user_name']) <= 64
                  && strlen($_POST['user_name']) >= 2
                  && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
                  && !empty($_POST['user_email'])
                  && strlen($_POST['user_email']) <= 64
                  && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
                  && !empty($_POST['user_password_new']) ) {
            
                // escapin' this, additionally removing everything that could be (html/javascript-) code
                $this->new_user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
                $this->new_user_email = htmlentities($_POST['user_email'], ENT_QUOTES);
                $this->new_user_password = htmlentities($_POST['user_password_new'], ENT_QUOTES);
                $this->user_account_type = $_POST('user_account_type');
                
                // no need to escape as this is only used in the hash function
                $this->user_password = $_POST['user_password_new'];

                // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $this->hash_cost_factor, if not, make $this->hash_cost_factor = null
                $this->hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
                
                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT, array('cost' => $this->hash_cost_factor));
                
                // check if user already exists                
                $sth = $this->db->prepare("SELECT * FROM users WHERE user_name = :user_name ;");
                $sth->execute(array(':user_name' => $this->user_name));
                
                $count =  $sth->rowCount();            

                if ($count == 1) {

                    $this->errors[] = FEEDBACK_USERNAME_ALREADY_TAKEN;

                } else {
                    
                    // generate random hash for email verification (40 char string)
                    $this->user_activation_hash = sha1(uniqid(mt_rand(), true));

                    // write new users data into database
                    //$query_new_user_insert = $this->db_connection->query("INSERT INTO users (user_name, user_password_hash, user_email, user_activation_hash) VALUES('".$this->user_name."', '".$this->user_password_hash."', '".$this->user_email."', '".$this->user_activation_hash."');");
                    
                    $sth = $this->db->prepare("INSERT INTO users (user_name, user_password_hash, user_email, user_activation_hash, user_account_type) VALUES(:user_name, :user_password_hash, :user_email, :user_activation_hash, :user_account_type) ;");
                    $sth->execute(array(':user_name' => $this->user_name, ':user_password_hash' => $this->user_password_hash, ':user_email' => $this->user_email, ':user_activation_hash' => $this->user_activation_hash, ':user_account_type' => $this->user_account_type));                    
                    
                    $count =  $sth->rowCount();

                    if ($count == 1) {
                        
                        $this->user_id = $this->db->lastInsertId();                      
                        
                        // send a verification email
                        if ($this->sendNewVerificationEmail()) {
                            
                            // when mail has been send successfully
                            $this->messages[] = FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED;
                            $this->registration_successful = true;
                            return true;
                            
                        } else {

                            // delete this users account immediately, as we could not send a verification email
                            // the row (which will be deleted) is identified by PDO's lastinserid method (= the last inserted row)
                            // @see http://www.php.net/manual/en/pdo.lastinsertid.php
                            
                            $sth = $this->db->prepare("DELETE FROM users WHERE user_id = :last_inserted_id ;");
                            $sth->execute(array(':last_inserted_id' => $this->db->lastInsertId() ));                            
                            
                            $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_FAILED;

                        }

                    } else {

                        $this->errors[] = FEEDBACK_ACCOUNT_CREATION_FAILED;

                    }
                }            
            
        } else {
            
            $this->errors[] = FEEDBACK_UNKNOWN_ERROR;
            
        }          
        
        // standard return. returns only true of really successful (see above)
        return false;
    }
    /**
     * sendNewVerificationEmail()
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */    
    private function sendNewVerificationEmail() {
        
        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_MANDRILL) {
            if (file_exists(LIBS . 'mandrill-api-php/src/Mandrill.php')) {
                require LIBS . 'mandrill-api-php/src/Mandrill.php'; 

                try {
                    $mandrill = new Mandrill(EMAIL_MANDRILL_APIKEY);

                    $mandrill->From = EMAIL_VERIFICATION_FROM_EMAIL;
                    $mandrill->FromName = EMAIL_VERIFICATION_FROM_NAME;
                    $mandrill->Recipient_email = $this->user_email;
                    $mandrill->Recipient_name = $this->user_name;
                    $mandrill->Recipient_id = $this->user_id;
                    $mandrill->Subject = EMAIL_VERIFICATION_SUBJECT;
                    $mandrill->Body    = EMAIL_VERIFICATION_CONTENT . EMAIL_VERIFICATION_URL.'/'.urlencode($this->user_id).'/'.urlencode($this->user_activation_hash);

                    $message = array(
                        'text' => $mandrill->Body,
                        'subject' => $mandrill->Subject,
                        'from_email' => $mandrill->From,
                        'from_name' => $mandrill->FromName,
                        'to' => array(
                            array(
                                'email' => $mandrill->Recipient_email,
                                'name' => $mandrill->Recipient_name
                            )
                        ),
                        'headers' => array('Reply-To' => $mandrill->From),
                        'important' => false,
                        'track_opens' => true,
                        'tags' => array('new_user')
                    );
                    $async = true;
                    $ip_pool = ''; // unused
                    $send_at = ''; // costs extra

                    $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
                    
                    if($result) {
                        $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_SUCCESSFUL;
                        return true;
                    }

                } catch(Mandrill_Error $e) {
                    // Mandrill errors are thrown as exceptions
                    $this->errors[] = 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
                    // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
                    return false;
                }
            } else {
                $this->errors[] = FEEDBACK_VERIFICATION_MAIL_ERROR_MADNRILL_NOEXISTS;
                return false;
            }


        } else { 
            if (EMAIL_USE_SMTP) {
                
                // Set mailer to use SMTP
                $mail->IsSMTP();
                //useful for debugging, shows full SMTP errors
                //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                // Enable SMTP authentication
                $mail->SMTPAuth = EMAIL_SMTP_AUTH;                               
                // Enable encryption, usually SSL/TLS
                if (defined(EMAIL_SMTP_ENCRYPTION)) {                
                    $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;                              
                }
                // Specify host server
                $mail->Host = EMAIL_SMTP_HOST;  
                $mail->Username = EMAIL_SMTP_USERNAME;                            
                $mail->Password = EMAIL_SMTP_PASSWORD;                      
                $mail->Port = EMAIL_SMTP_PORT;       
                
            } else {
                
                $mail->IsMail();            
            }
            
            $mail->From = EMAIL_VERIFICATION_FROM_EMAIL;
            $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
            $mail->AddAddress($this->user_email);
            $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
            $mail->Body    = EMAIL_VERIFICATION_NEWUSER_CONTENT . EMAIL_VERIFICATION_URL.'/'.urlencode($this->user_id).'/'.urlencode($this->user_activation_hash);

            if(!$mail->Send()) {
                
                $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_ERROR . $mail->ErrorInfo;
                return false; // TEMPORARY - set to false in production
               
            } else {
                
                $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_SUCCESSFUL;
                return true;
            }
            $this->errors[] = "mail sending error.  Not possible to email right now.  Please ask administrator for help configuring email functionality";
            return false; // TEMPORARY - set to false in production
        }
        
    }
    
    public function editSave($note_id, $note_text)
    {
                
        $umq = $this->db->prepare("UPDATE note 
                                   SET note_text = :note_text
                                   WHERE note_id = :note_id AND user_id = :user_id;");
        $umq->execute(array(
            ':note_id' => $note_id,
            ':note_text' => $note_text,
            ':user_id' => $_SESSION['user_id']));   
        
        $count =  $umq->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_EDITING_FAILED;
            return false;
        }                
                
                
    }
    
    public function delete($note_id)
    {
        $umq = $this->db->prepare("DELETE FROM note 
                                   WHERE note_id = :note_id AND user_id = :user_id;");
        $umq->execute(array(
            ':note_id' => $note_id,
            ':user_id' => $_SESSION['user_id']));   
        
        $count =  $umq->rowCount();
        
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_DELETION_FAILED;
            return false;
        }     
    }
}