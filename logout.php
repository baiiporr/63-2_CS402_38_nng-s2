<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION["stutdentName"]);
unset($_SESSION["stutdentID"]);
header("Location:login.html");
session_destroy();