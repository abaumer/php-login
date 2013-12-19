<?php

class User extends Controller {

    public function __construct() {

        // a little note on that (seen on StackOverflow):
        // "As long as myChild has no constructor, the parent constructor will be called / inherited."
        // This means wenn a class thats extends another class has a __construct, it needs to construct
        // the parent in that constructor, like this:   
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be useable by logged-in users
        // need this line! Otherwise not-logged in users could do actions
        // if all of your pages should only be useable by logged-in users: Put this line into
        // libs/Controller->__construct
        // TODO: test this!
        Auth::handleLogin();
    }

    public function index() {
        
        // get all users (of the logged in user)
        $this->view->users = $this->model->getAllUsers();
        $this->view->errors = $this->model->errors;
        $this->view->render('users/index');
    }

    
    public function create() {
        
        $registration_successful = $this->model->registerNewUser();

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        if ($registration_successful == true) {
            $this->view->users = $this->model->getAllUsers();
            $this->view->render('users/index');
        } else {
            $this->view->users = $this->model->getAllUsers();
            $this->view->render('users/index');
        } 

        // $this->model->registerNewUser();
        // header('location: ' . URL . 'user');
    }

    
    public function edit($user_id) {
        
        $this->view->user = $this->model->getUser($user_id);
        $this->view->errors = $this->model->errors;
        $this->view->render('users/edit');
    }


    public function editSave($user_id) {

        if(!$_POST){
            header('location: ' . URL . 'user');
        }
        
        // do editSave() in the note_model, passing user_id from URL and note_text from POST via params
        $save_successful = $this->model->editSave();

        if($save_successful === true) {
            $this->view->success = $this->model->errors;
            $this->view->users = $this->model->getAllUsers();
            $this->view->render('users/index');
        } else {
            $this->view->errors = $this->model->errors;
            $this->view->user = $this->model->getUser($user_id);
            $this->view->render('users/edit');
        }        
    }

    public function delete($note_id) {
        
        $this->model->delete($note_id);
        header('location: ' . URL . 'user');
    }

}