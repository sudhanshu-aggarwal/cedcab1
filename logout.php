<?php
session_start();
session_destroy();

header('Location: /cedcab/login.php');