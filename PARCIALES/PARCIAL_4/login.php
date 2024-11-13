<?php
session_start();
require 'config.php'; // Archivo que contiene client_id y client_secret

$auth_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=" . CLIENT_ID . "&redirect_uri=" . REDIRECT_URI . "&scope=email%20profile";

header("Location: $auth_url");
exit;
?>