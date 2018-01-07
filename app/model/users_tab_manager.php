<?php


namespace App\Model;

use app\entities\DBwrap;
use Nette\Security\Passwords;
use app\entities\users_list_ent_fact;
use App\Model\mask_email_address;

class users_tab_manager {
    protected $DBwrap;
    protected $data;
    
    public function __construct($data) {
        $this->data = $data;
        $this->DBwrap = new DBwrap;
    }
    
    public function check_doop() {
        $name = $this->data->name;
        $this->DBwrap->sendSQL("select count(*) as n from users where un = ?;", array($name));
        $result = $this->DBwrap->fetch()["n"];
        if ($result != 0){return true;}
        return false;
    }
    
    public function reg_user() {
        $hashed_pass = Passwords::hash($this->data->password);
        $payload = array($this->data->name, $this->data->email, $this->data->role,
            $hashed_pass);
        $this->DBwrap->sendSQL("insert into users(un, email, role, psw_hash) values (?, ?, ?, ?);", $payload);
    }
    
    public function log_user($name, $password) {
        $this->DBwrap->sendSQL("select id, role, psw_hash from users where un = ?;", array($name));
        if (!$row = $this->DBwrap->fetch()){return false;}
        if (!Passwords::verify($password, $row["psw_hash"])){return false;}
        return array("id" => $row["id"], "role" => $row["role"]);
    }
    
    public function display_users($name, $role) {
        $mask_email_address = new mask_email_address;
        $list_fact = new users_list_ent_fact;
        $this->DBwrap->sendSQL("select un, email, role from users;", array());
        $list = array();
        while ($row = $this->DBwrap->fetch()){
            $row_obj = $list_fact->get_ent($row);
            if ($role == "user" && $row["un"] != $name){
                $row_obj->email = $mask_email_address->mask($row_obj->email);
            }
            $list[] = $row_obj;
        }
        return $list;
    }
}
