<?php

$uri = preg_split("/[\W]/", $_SERVER['REQUEST_URI'])[1];
include "$uri.php";
