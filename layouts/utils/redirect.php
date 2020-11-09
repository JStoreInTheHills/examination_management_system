<?php

    session_start();

    function redirectToHomePage() {
        header("Location: /login");
        exit;
    };

    


?>