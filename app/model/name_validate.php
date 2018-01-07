<?php


namespace App\Model;

use app\entities\validator_ent_fact;

class name_validate {
    public function validate($data, $max_len) {
        $validator_ent_fact = new validator_ent_fact();
        $validator_ent = $validator_ent_fact->get_ent($data);
        if (strlen($validator_ent->tested_var) > $max_len){
            $validator_ent->err = "max. ". $max_len . " znaků";
            $validator_ent->stat = true;
        }

        
        
        return $validator_ent;
    }
}
