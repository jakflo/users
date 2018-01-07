<?php


namespace app\entities;

use app\entities\validator_ent;

class validator_ent_fact {
    
    public function get_ent($data) {
        $entity = new validator_ent;
        $cleared_data = stripslashes(trim($data));
        $entity->tested_var = $cleared_data;
        if ($entity->tested_var == ""){
            $entity->err = "nutno vyplnit";
            $entity->stat = true;
        }
        return $entity;
    }
}
