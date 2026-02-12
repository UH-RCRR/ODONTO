<?php

class SubadminController {

    public function dashboard() {
        requireSubadmin();
        require_once 'views/subadmin/dashboard.php';
    }

}
