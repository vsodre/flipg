<?php
//load this if there is an error
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'An undefined error has occured.';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login error</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <h1>Error with page.</h1>
        <p class="error"><?php echo $error; ?></p>  
    </body>
</html>