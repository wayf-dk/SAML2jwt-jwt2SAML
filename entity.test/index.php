<?php

$uri = preg_split("/[\W]/", $_SERVER['HTTP_HOST'])[0];
include "$uri.php";
