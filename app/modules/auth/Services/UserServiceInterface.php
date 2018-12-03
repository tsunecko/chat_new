<?php

namespace App\modules\auth\Services;

interface UserServiceInterface {

    /**
     * @return array User
     */
    public function getAll();

}
