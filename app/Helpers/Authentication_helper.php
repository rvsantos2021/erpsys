<?php

if (!function_exists('userIsLogged')) {
    function userIsLogged()
    {
        return service('Authentication')->getLoggedUserData();
    }
}
