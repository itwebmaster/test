<?php
require_once 'bootstrap.php';
header('Content-Type: image/jpeg');
readfile(BannersHelper::randomImage());