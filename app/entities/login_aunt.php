<?php

namespace app\entities;

use App\Model\users_tab_manager;
use Nette\Security as NS;

class login_aunt implements NS\IAuthenticator{
    public function authenticate(array $credentials){
        list($name, $password) = $credentials;
        $DB_wrap = new users_tab_manager(null);
        $user_row = $DB_wrap->log_user($name, $password);
        
        
        if (!$user_row) {
            throw new NS\AuthenticationException('login_failed');
        }
        return new NS\Identity($user_row["id"], $user_row["role"], ['username' => $name]);
    }
}
