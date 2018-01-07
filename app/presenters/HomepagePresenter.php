<?php

namespace App\Presenters;

use Nette\Application\UI;
use App\Model\reg_form_validate;
use App\Model\log_form_validate;
use App\Model\users_tab_manager;
use Nette\Security\User;
use App\Model\login_manager;



class HomepagePresenter extends BasePresenter{
    protected function createComponentRegistrationForm(){
        $form = new UI\Form;
        $form->addText('name', 'Jméno:');
        $form->addText('email', 'Email:');
        $form->addRadioList('role', 'Oprávnění:', ['admin' => 'správce', 'user' => 'uživatel']);
        $form["role"]->setDefaultValue("user");
        $form->addPassword('password', 'Heslo:');
        $form->addPassword('password_again', 'Heslo znovu:');
        $form->addButton('login', 'Registrovat');
        // $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }
    
    protected function createComponentLoginForm(){
        $form = new UI\Form;
        $form->addText('name', 'Jméno:');
        $form->addPassword('password', 'Heslo:');
        $form->addButton('login', 'Přihlásit se');
        // $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }
    
    public function handleRegForm($data) {
        $form_obj = json_decode($data);
        $regform_validator = new reg_form_validate($form_obj);
        $validated_form = $regform_validator->validate();
        if ($validated_form["stat"]){
            $this->sendResponse(new \Nette\Application\Responses\JsonResponse($validated_form["errs"]));
        }
        $user_tab_manager = new users_tab_manager($validated_form["data"]);
        if ($user_tab_manager->check_doop()){
            $validated_form["errs"]->name = "uživatel již existuje";
        }
        else {$validated_form["errs"]->name = "OK";
            $user_tab_manager->reg_user();        
        }
        $this->sendResponse(new \Nette\Application\Responses\JsonResponse($validated_form["errs"]));
    }
    
    public function handleLogForm($data) {
        $form_obj = json_decode($data);
        $log_form_validator = new log_form_validate;
        $validated_form = $log_form_validator->validate($form_obj);
        if ($validated_form["stat"]){
            $this->sendResponse(new \Nette\Application\Responses\JsonResponse($validated_form["errs"]));
        }
        $user = $this->getUser();
        $login_manager = new login_manager($user);
        if (!$login_manager->login($validated_form["data"])){
            $validated_form["errs"]->name = "neexistující uživatel, nebo chybné heslo";
        }
        else {$validated_form["errs"]->name = "OK";}
        $this->sendResponse(new \Nette\Application\Responses\JsonResponse($validated_form["errs"]));
    }
    
    public function renderDefault(){
        $user = $this->getUser();
        if ($user->isLoggedIn()){
            $this->redirect("Logged:");
        }
                 
        $this->template->anyVariable = 'any value';
    }
}
