<?php
    function admin($name, $password)
    {
        if(hash('ripemd160', $name) != '1a003b58873a43d604b05d94a3a82263ef2ea907')
            return false; //wrong name
        if(hash('ripemd160', $password) != '92717f866acad4776c43a9b0b6e0dbaf29200f37')
            return false; //wrong password
        return true; //no wrongs
    }
?>