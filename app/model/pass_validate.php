<?php


namespace App\Model;

use app\entities\pass_validator_ent;

class pass_validate {
    
    public function validate($pass1, $pass_conf) {
        $validator_ent = new pass_validator_ent;
        
        if ($pass1 == ""){
            $validator_ent->err_pass1 = "zadejte heslo";
            $validator_ent->stat = true;
        }
        if (strlen($pass1) > 32){
            $validator_ent->err_pass1 = "max. 32 znaků";
            $validator_ent->stat = true;
        }
        if ($pass1 != "" && strlen($pass1) < 6){
            $validator_ent->err_pass1 = "nejméně 6 znaků";
            $validator_ent->stat = true;
        }
        if ($pass_conf == "" && $pass1 != ""){
            $validator_ent->err_pass_conf = "zadejte heslo znovu pro potvrzení";
            $validator_ent->stat = true;
        }
        if ($pass1 != $pass_conf && $pass1 != "" && $pass_conf != ""){
            $validator_ent->err_pass_conf = "hesla se neshodují";
            $validator_ent->stat = true;
        }
        
        return $validator_ent;
    }
}
