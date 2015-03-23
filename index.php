<!DOCTYPE html>
 <head>
    <title></title>

    <meta http-equiv="Content-Language" content="en" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=550; user-scalable=0;" />
    
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Kreon:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        
    <meta property="og:description" content="Read all your favorite blogs' updates in only one place!"/>
    
    <script src="js/jquery-2.1.3.js" type="text/javascript"></script>
    
             
</head>
<body> 
    <div id="wrapper">
        <section class="dobra1">
            <table class="social-table">
                <tr><td valign="middle"><div class="twitter-hover social-slide"></div></td></tr>
                <tr><td><a href="https://www.facebook.com/TheFlipG"><div class="facebook-hover social-slide"></div></a></td></tr>
                <tr><td><div class="google-hover social-slide"></div></td></tr>
                <tr><td><div class="linkedin-hover social-slide"></div></td></tr>
                <tr><td><div class="instagram-hover social-slide"></div></td></tr>
                <tr><td><div class="tumblr-hover social-slide"></div></td></tr>
                <tr><td><div class="stumbleupon-hover social-slide"></div></td></tr>
            </table>
            
            
            <article>
                <header>
                <img src="images/logo.png" alt="Logo" style="width:300px;height:150px;margin:0px" >  
                </header>
            
            <div id="registrationdiv">
                <form action="" method="POST">
                    <input type="text" name="login" value="" placeholder="Login" />
                    <input type="submit" value="" /> 
                    <input type="password" name="password" value="" placeholder="Password" /><br>
                    <button class="submitbutton">Submit</button><br>
                    
                    New to FlipG? Just <a href="#" onclick="load_registration()" style="text-decoration: none; color:white;">SIGN UP</a>
                </form>
                </div>
            </article>
        </section>
            
    <!-- Loading the registration page on the div -->
    <script>
        function load_registration(){
            $("#registrationdiv").load("registration.php");
        }
    </script>
    
    
    </div>
 </body>
