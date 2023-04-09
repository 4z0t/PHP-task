<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    readfile("index.html"); 
    exit;
}

