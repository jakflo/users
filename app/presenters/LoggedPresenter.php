<?php


namespace App\Presenters;
use Nette\Security\User;
use App\Model\login_manager;
use App\Model\users_tab_manager;


class LoggedPresenter extends BasePresenter{
    
    public function handleLogout() {
        $user = $this->getUser();
        $user->logout();
        $this->redirect("Homepage:default");
    }
    
    protected function check_whos_logged() {
        $login_manager = new login_manager($this->getUser());
        if (!$logged_user = $login_manager->whos_logged()){
            $this->redirect("Homepage:default");
        }
        return $logged_user;
    }
    
    public function renderDefault(){
        $logged_user = $this->check_whos_logged();
        $this->template->name = $logged_user["name"];
        $this->template->role = $logged_user["role"];
    }
    
    public function renderDisplay_list() {
        $logged_user = $this->check_whos_logged();
        $user_tab_manager = new users_tab_manager(null);
        $users_list = $user_tab_manager->display_users($logged_user["name"], $logged_user["role"]);
        $this->template->name = $logged_user["name"];
        $this->template->users_list = $users_list;
    }
}
