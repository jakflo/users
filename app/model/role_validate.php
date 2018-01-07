<?php


namespace App\Model;

use App\Model\name_validate;

class role_validate {
    
    public function validate($data) {
        $validator = new name_validate;
        $validator_ent = $validator->validate($data, 7);
   
        
        if ($validator_ent->stat){return $validator_ent;}
        if ($validator_ent->tested_var != "admin" && $validator_ent->tested_var != "user"){
            $validator_ent->err = "neplatná role";
            $validator_ent->stat = true;
        }
        return $validator_ent;
    }
}
