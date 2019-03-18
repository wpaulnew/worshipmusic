<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="<?php echo \vendor\library\Session::get("TOKEN") ?>">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content=""/>
  <meta name="author" content="">
  <meta name="keywords" content=""/>
  <link rel="stylesheet" href="/public/css/container.css">
  <title>Panel ( ͡° ͜ʖ ͡°)</title>
</head>

<?php foreach ($container["styles"] as $style) { echo $style; } ?>

<body>

<div class="panel">
  <?php echo $content; ?>
</div>

<script src="/public/javascript/jquery.min.js" charset="utf-8"></script>
<script src="/public/javascript/build.js" charset="utf-8"></script>

<?php foreach ($container["scripts"] as $script) { echo $script; } ?>

</body>
</html>
