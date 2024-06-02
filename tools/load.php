

<?php

function load($page=''){

    if(!empty($page)){
        $url = 'http://'.$_SERVER['HTTP_HOST'];
        echo dirname(($_SERVER['PHP_SELF']));
    }
    // echo dirname(($_SERVER['PHP_SELF']));
    // echo 'http://'.$_SERVER['HTTP_HOST'];
    // echo '<br>';
    echo __FILE__."  PPP  ". $_SERVER['SCRIPT_URI'];
}

load();

?>