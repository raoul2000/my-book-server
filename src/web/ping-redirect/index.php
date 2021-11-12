<?php
$params = require __DIR__ . '/../../config/params.php';

$redirectUrl = $params['app']['qrcodeUrl'];
?>
<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="0; url=<?= $redirectUrl?>" />
        <script type="text/javascript">
            window.location.href = "<?= $redirectUrl?>"
        </script>
        <title>...</title>
    </head>
    <body>
        Si vous n'êtes pas redirigé automatiquement, suivez <a href="<?= $redirectUrl?>">ce lien</a> pour signaler un livre.
    </body>
</html>
