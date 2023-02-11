<?php
    function admin($name, $password)
    {
        if(hash('ripemd160', $name) != 'cbab26c4570a17bd673d64d6bc1f2df9d9b3206c')
            return false; //wrong name
        if(hash('ripemd160', $password) != '82f0b74a5e3581e346ecf2915ca6e806434d9863')
            return false; //wrong password
        return true; //no wrongs
    }
?>