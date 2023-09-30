<DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <header>
      <a href='/php_mvc_blog'>Home</a>
      <a href='?controller=personas&action=index'>Personas</a>
      <a href='?controller=miembros&action=index'>Miembros</a>
      <a href='?controller=visitantes&action=index'>Visitantes</a>
    </header>

    <?php require_once('routes.php'); ?>

    <footer>
      Copyright
    </footer>
  <body>
<html>