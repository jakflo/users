<?php


namespace App\Model;

use app\entities\login_aunt;
use Nette\Security\User;



class login_manager {
    
    protected $user;
    
    public function __construct(User $user) {
        $this->user = $user;
    }
    
    public function login($form) {
        $name = $form->name;
        $password = $form->password;
        $aunt = new login_aunt;
        $this->user->setAuthenticator($aunt);
        
        try{
            $this->user->login($name, $password);
            return true;
        }
        catch (\Nette\Security\AuthenticationException $e){
            return false;
        }
    }
    
    public function whos_logged() {
        if (!$this->user->isLoggedIn()){return false;}
        return array("name" => $this->user->getIdentity()->username, "role" => $this->user->getRoles()[0]);
    }
}
