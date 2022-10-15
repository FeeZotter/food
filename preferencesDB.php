<?php
    $table                   = "preferences";
    $persons                 = array("name", "password", "alias");
    $categories              = array("category");
    $cross_person_categories = array("cross_person_categories_id", "persons_id", "categories_id");
    $preferences             = array("preferences_id", "cross_person_categories_id", "preference", "rating");
?>