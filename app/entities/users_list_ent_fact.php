<?php

use app\entities\users_list_ent;

namespace app\entities;


class users_list_ent_fact {
    
    public function get_ent($row) {
        $ent = new users_list_ent;
        $ent->name = $row["un"];
        $ent->email = $row["email"];
        $ent->role = $row["role"];
        return $ent;
    }
}
