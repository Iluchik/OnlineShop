<?php
   if (!isset($_SESSION)) session_start();
   echo "<div style='display:none'>";
               require 'configDB.php';
			   echo "</div>";
?>

<!DOCTYPE html>

<html lang="ru">
<head>
   <title> Online shop</title>
   <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/assets/styles.css">
   <link rel="icon" href="../img/kimono-dress.ico" type="image/x-icon" />
   <!-- <script src="/assets/jquery-ui.min.js"></script> -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>
<header>

</header>
<body>
   <div class="wrapper">
      <div class="container">
         <header class="header">

            <div class="active-user"><?
               echo($_SESSION["login"]);
            ?></div>
            <span>Online Shop</span>
            <div class="icons">

               <?php
                  if (empty($_SESSION)){
					$count = count($_COOKIE) - 1;
                     echo (
                        "<div class='user-autorization'>
                           <form method='post' action='autorization.php'>
                              <input class='btn-autorization' type='submit' value='' class='button'>
                           </form>
                        </div>");
                     } else {
                        echo(
                           "</div>
                           <div class='user-autorization'>
                           <form method='post' action='delete-session.php'>
                              <input class='logout-btn' type='submit' value='Выйти' class='button'>
                           </form>
                           </div> ");
                           $count = 0;
                           $user_id = $_SESSION['user_id'];
                           $query = $pdo->prepare("SELECT * FROM `users_goods` WHERE user_id = :user_id");
                           $query->bindParam(':user_id', $user_id);
                           $query->execute();
                           while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                              $count++;
                           }
                     }

                        
                     echo (
                        "<div class='cart'>
                           <a href='cart.php'><img src='img/shopping-bag.svg' alt=''></a>");

                        //    if ($count > 0){
                              echo ("<div class='quantity-cart' style='visibility:hidden'><span></span>
                        </div>");
                        //    }

               ?>
             <!-- <img src='img/user_icon.svg' alt=''> -->
            </div>

         </header>
			<script>
					$.ajax({
						url: 'configDB.php',
						method: 'POST',
						dataType: 'JSON',
						success: function(data) {
							// console.log(data);
							$.ajax({
								url: 'counter.php',
								method: 'POST',
								dataType:'JSON',
								success: function(response) {
									if (response.counter > 0) {
										$("div.quantity-cart").attr("style", "visible");
										$("div.quantity-cart span").text(`${response.counter}`)
									}
								}
							})
							$.each(data.goodData, function(index, record) {
								let form = $("<form method='post' action='add.php' class='goods'>").attr("id", `${record.id}`);
								const divProdCard = $("<div class='product-card' id='productCard' data-good>");
								let img = $("<img>").attr("src", `${record.image}`);
								const divInter = $("<div class='interaction'>");
								const inputQuantity = $("<input class='quantity' min='1' autocomplete='off' step='any' type='number' name='quantity' value='' required>");
								let inputHiddenId = $("<input type='hidden' name='id'>").attr("value", `${record.id}`);
								// let inputHiddenName = $("<input type='hidden' id='goods-name' name='name'>").attr("value", `${record.name}`);
								// let inputHiddenPrice = $("<input type='hidden' id='goods-price' name='price'>").attr("value", `${record.price}`);
								const inputInCart = $("<input class='in-cart' type='submit' value='В корзину'>");
								const divEditIcon = $("<div class='edit-icon'>");
								const aEditButton = $("<a href='#popup' class='edit-button'>");
								const imgDataAction = $("<img src='./img/edit_icon.svg' alt='Описание картинки' data-action='edit' <?if(empty($_SESSION)) {echo "style='opacity:0.33'";}?>>");
								let aGoodsName = $("<a id='goods-name' class='goods-name'>").text(`${record.name}`);
								let span = $("<span id='goods-price'>").text(`${record.price} ₽`);
								const divResultForm = $("<div id='result_form'>");
								aEditButton.append(imgDataAction);
								divEditIcon.append(aEditButton);
								divInter.append(inputQuantity);
								divInter.append(inputHiddenId);
								// divInter.append(inputHiddenName);
								// divInter.append(inputHiddenPrice);
								divInter.append(inputInCart);
								divInter.append(divEditIcon);
								divProdCard.append(img);
								divProdCard.append(divInter);
								divProdCard.append(aGoodsName);
								divProdCard.append(span);
								form.append(divProdCard);
								form.append(divResultForm);
								$("div.products").append(form);
							});
							$("form.goods").on("submit", function() {
								$.ajax({
									url: 'add.php',
									method: 'POST',
									dataType: 'html',
									data: $(this).serialize(),
									success: function(data) {
										// console.log(data);
										$.ajax({
											url: 'counter.php',
											method: 'POST',
											dataType: 'JSON',
											success: function(response) {
												$("div.quantity-cart").attr("style", "visible");
												$("div.quantity-cart span").text(`${response.counter}`);
												// console.log($("input.quantity").val("1"));
											}
										})
										const id = $(this)[0].data.split("&")[1].split("=")[1];
										$("form#" + id + " input.quantity").val("");
										// console.log("form#" + id + " input.quantity");
									}
								})
								event.preventDefault();
							});
							const script = $("<script src='./scripts/script.js'>");
							$("div.popup").after(script);
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.error('Ошибка выполнения запроса: ' + textStatus, errorThrown);
						}
					});
				// $("form.goods").submit(function(event) {
				// 	$.ajax({
				// 		url: '#',
				// 		method: 'post',
				// 		dataType: 'html',
				// 		data: $(this).serialize(),
				// 		success: function(data) {
				// 		}
				// 	})
				// 	event.preventDefault();
				// });
				// $(".goods").submit(function(event) {
				// 	event.preventDefault();
				// 	console.log('stop')
				// });
				// $(".in-cart").click(function() {
				// 	$(".goods").off();
				// 	$(".goods").submit()
				// });
			</script>
         <main class="main">
            <h1>
               Новинки
            </h1>
            <div class="products">
            	<?php


            //    $query = $pdo->query('SELECT * FROM `goods`');
            //    while ($row = $query->fetch(PDO::FETCH_OBJ)){
            //       echo (
            //          "<form id=".$row->id." method='post' action='add.php'>
            //          <div class='product-card' id='productCard'>
            //             <img src=".$row->image.">
            //             <div class='interaction'>
            //                <input class='quantity' min='1' autocomplete='off'  step='any' type='number' name='quantity' required>
            //                <input type='hidden' value='".$row->id."' name='id'>");
                       
            //             echo ("<input class='in-cart' type='submit' value='В корзину'>");
                        
            //       echo ("
            //             </div>
            //             <a class='goods-name'>".$row->name."</a>
            //             <span>".$row->price." ₽</span>
            //          </div>
            //          </form>"
            //       );
            //    }
            	?>
            </div>
         </main>
	<div id="popup" class='popup'>
      <div class="popup__body">
         <div class="popup__content">
            <a href="#" class="popup__close close-popup">x</a>
            <div class="popup__title">Редактирование товара</div>
            <form class='popup-form' method="post" id="ajax_form" action="" autocomplete="off">
               <input class='popup-form-input' type="text" name="product-name" placeholder="Введите название товара" />
               <input class='popup-form-input ' type="number" name="product-price" placeholder="Введите цену товара" />
               <input class='popup-form-input send close-popup' data-action='button' type="button" id="btn" value="Отправить" />
           </form>
         </div>
      </div>
    </div>
	<!-- <script src="./scripts/script.js"></script> -->
	<script>
      window.addEventListener('click', function(event){
         if (event.target.dataset.action === 'edit'){
            console.log('edit')
            card = event.target.closest('.goods');
            console.log(card)
            good = card.querySelector('[data-good]');
            console.log(good)
         }
         if (event.target.dataset.action === 'button'){
            console.log(good.className)
            //console.log(good.className.getElementById('goods-name'))
            sendAjaxForm(`${good.className}`, good.querySelector('#goods-name'), good.querySelector('#goods-price'), 'ajax_form', 'file.php');
		}
      })

	  function sendAjaxToAdd(form){
		
		
	  }

      function sendAjaxForm(result_form, name, price, ajax_form, url) {
         $.ajax({
            url:     url, //url страницы (action_ajax_form.php)
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
                  result = $.parseJSON(response);
				  const id = $("form:has(a#goods-name:contains(" + name.innerText +"))").attr("id");
                  //result_form.getElementById('goods-name').text(result.name);
				  $(name).text(result.name);
                  $(price).text(result.price + ' ₽');
				  $.ajax({
					url: 'add.php',
					method: 'POST',
					dataType: 'HTML',
					data: {"id": id, "name": result.name, "price":result.price},
					success: console.log("send")
				  })
				//   console.log(id, result.name, result.price)
            },
            error: function(response) { // Данные не отправлены
                  $('#result_form').html('Ошибка. Данные не отправлены.');
            }
         });
      }
    </script>
</body>

</html>
