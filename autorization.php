<!DOCTYPE html>
<html lang="ru">

<head>
   <title><?= "Autorization"; ?></title>
   <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/assets/styles2.css">
   <link rel="icon" href="../img/person.ico" type="image/x-icon" />
</head>

<body>
   <div class="wrapper">
      <div class="container">
         <header>
            <span>Авторизация</span>
            
         </header>
         <main>
               <form action="verification.php" method='post'>
                  <input type='text' placeholder ='Логин' name="login" required>
                  <input type="password" placeholder ='Пароль' name="pass" required>
                  <input type="submit" value="Отправить" class="button">
               </form>
         </main>
         <footer>

         </footer>
      </div>
   </div>
</body>

</html>
