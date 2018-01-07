<?php


namespace App\Model;

use app\entities\reg_form_ent;
use App\Model\reg_form_validate;

class log_form_validate {
    
    public function validate($data) {
        $form = new reg_form_ent;
        $form->name = $data->name;
        $form->password = $data->password;
        $regform_validator = new reg_form_validate($form);
        $validated_form = $regform_validator->validate();
        if ($validated_form["errs"]->name == "" && $validated_form["errs"]->password == ""){
            $validated_form["stat"] = false;
        }
        return $validated_form;
    }
}
