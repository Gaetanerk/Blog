<?php
session_start();
session_destroy(); //destroy the session
header("location:./index.html");
exit();