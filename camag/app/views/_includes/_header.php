<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
    <link rel="stylesheet" href="<?=URL?>css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
             <li><a href="<?=URL?>Home/">Home</a></li>
            </div>
            <nav>
                <ul>
                    <li><a href="<?=URL?>gallery/">Gallery</a></li>
                    <?php if (Session::loggedIn()):?>
                        <?php if (Session::get('stat') == 'Yes'):?>
                        <li><a href="<?=URL?>settings">Settings</a></li>
                        <?php endif?>
                        <li><a href="<?=URL?>home/logout">Logout</a></li>
                    <?php endif?>
                </ul>
            </nav>
        </div>
    </header>
