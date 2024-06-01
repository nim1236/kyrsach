<?php
// Открываем лог-файл для добавления записи
$log_file = 'server_logs.txt';
$log_message = date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
file_put_contents($log_file, $log_message, FILE_APPEND);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Закуписька</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .product {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin: 10px;
      width: 200px;
    }

    .product img {
      max-width: 100px;
      max-height: 100px;
      display: block;
      margin: 0 auto 10px;
    }

    .cart {
      position: fixed;
      top: 0;
      right: 0;
      width: 300px;
      background-color: #f9f9f9;
      padding: 20px;
      border-left: 1px solid #ccc;
      border: 2px solid black;
      display: none;
    }

    .cart h2 {
      margin-top: 0;
    }

    .cart-item {
      margin-bottom: 10px;
    }

    button {
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #555;
    }

    .close-button {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: transparent;
      border: none;
      font-size: 20px;
      cursor: pointer;
      color: black;
    }

    .add-product-button {
      display: block;
      margin: 20px auto;
    }

    .cart-summary {
      margin-top: 20px;
    }

    .header-buttons {
      display: flex;
      gap: 10px;
    }

    .header-title {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .cart-count {
      position: relative;
      top: -10px;
      right: 10px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
      display: inline-block;
    }

    /* Новый стиль для поля комментариев */
    .comment-container {
      position: relative;
      margin-top: 20px;
      right: 10px;
    }

    .comment-container textarea {
      width: 100%;
      height: 80px;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      resize: none;
    }

    .placeholder {
      position: absolute;
      top: 10px;
      left: 15px;
      color: #999;
      pointer-events: none;
      transition: 0.2s;
    }

    .comment-container textarea:focus + .placeholder,
    .comment-container textarea:not(:placeholder-shown) + .placeholder {
      opacity: 0;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-title">
      <h1>Закуписька<?php session_start(); require_once("db.php"); $name = $_SESSION['name']; echo ", $name!"; ?></h1>
    </div>
    <div class="header-buttons">
      <button onclick="showCart()">Корзина<span id="cart-count" class="cart-count" style="display: none;">0</span></button>
      <button onclick="gotoHistory()">История</button>
      <button onclick="gotoHistory2()">История2</button>
      <button onclick="logout()">Выход</button>
      
    </div>
  </header>
  <form action="zakaz.php" method="post" id="checkout-form">
    <button class="add-product-button" onclick="showProduct()" type="button">Показать товар</button>

    <div class="container" id="products-container">
      <div class="product" style="display: none;">
        <img src="" alt="Product Image">
        <p>0 руб</p>
        <button onclick="addToCart('Товар', 0)" type="button">Добавить в корзину</button>
      </div>
    </div>

    <div id="cart" class="cart">
      <button onclick="closeCart()" class="close-button" type="button">&times;</button>
      <h2>Корзина</h2>
      <div id="cart-items"></div>
      <div class="cart-summary">
        <p>Общее количество товаров: <span id="total-items">0</span></p>
        <p>Общая сумма: <span id="total-price">0</span> руб</p>
      </div>

      <div class="comment-container">
        <textarea name="comment" id="comment" maxlength="255" placeholder=" "></textarea>
        <span class="placeholder">Комментарий (не более 255 символов)</span>
      </div>

      <input type="hidden" name="total_items" id="hidden-total-items">
      <input type="hidden" name="total_price" id="hidden-total-price">

      <button type="submit">Оформить заказ</button>
      <button type="button" onclick="clearCart()">Очистить корзину</button>
    </div>
  </form>

  <script>
    const productsContainer = document.getElementById('products-container');
    const cart = document.getElementById('cart');
    const cartItems = document.getElementById('cart-items');
    const totalItemsElem = document.getElementById('total-items');
    const totalPriceElem = document.getElementById('total-price');
    const cartCountElem = document.getElementById('cart-count');
    const commentElem = document.getElementById('comment');

    const hiddenTotalItems = document.getElementById('hidden-total-items');
    const hiddenTotalPrice = document.getElementById('hidden-total-price');

    const folders = {
      'Zel': ['zel1.jpg', 'zel2.jpg', 'zel3.jpg', 'zel4.jpg'],
      'Mech': ['mech1.jpg', 'mech2.jpg', 'mech3.jpg', 'mech4.jpg', 'mech5.jpg', 'mech6.jpg', 'mech7.jpg', 'mech8.jpg']
    };

    let totalItems = 0;
    let totalPrice = 0;

    document.addEventListener('DOMContentLoaded', () => {
      loadCartState();
    });

    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function getRandomProduct() {
      const folderNames = Object.keys(folders);
      const randomFolder = folderNames[getRandomInt(0, folderNames.length - 1)];
      const images = folders[randomFolder];
      const randomImage = images[getRandomInt(0, images.length - 1)];
      const randomPrice = getRandomInt(10, 100);
      
      return {
        image: `${randomFolder}/${randomImage}`,
        price: randomPrice
      };
    }

    function showProduct() {
      const product = getRandomProduct();
      const productTemplate = document.querySelector('.product');
      const productElem = productTemplate.cloneNode(true);
      productElem.style.display = 'block';
      productElem.querySelector('img').src = product.image;
      productElem.querySelector('p').innerText = `${product.price} руб`;
      productElem.querySelector('button').setAttribute('onclick', `addToCart('Товар', ${product.price})`);
      productsContainer.insertBefore(productElem, productsContainer.firstChild);
    }

    function closeCart() {
      cart.style.display = 'none';
    }

    function addToCart(name, price) {
      const cartItem = document.createElement('div');
      cartItem.classList.add('cart-item');
      cartItem.innerHTML = `${name} - ${price} руб`;
      cartItems.appendChild(cartItem);
      totalItems++;
      totalPrice += price;
      updateCartTotal();
      updateCartCount();
      
      saveCartState();
    }

    function updateCartTotal() {
      totalItemsElem.innerText = totalItems;
      totalPriceElem.innerText = totalPrice;
      hiddenTotalItems.value = totalItems;
      hiddenTotalPrice.value = totalPrice;
    }

    function updateCartCount() {
      if (totalItems > 0) {
        cartCountElem.style.display = 'inline';
        cartCountElem.innerText = totalItems;
      } else {
        cartCountElem.style.display = 'none';
      }
    }

    function showCart() {
      cart.style.display = 'block';
    }

    function clearCart() {
      cartItems.innerHTML = '';
      totalItems = 0;
      totalPrice = 0;
      updateCartTotal();
      updateCartCount();
      commentElem.value = '';
      localStorage.removeItem('cartState');
      localStorage.removeItem('cartComment');
    }

    function logout() {
    clearCart();
    window.location.href = 'clear_log.php';
}

    function gotoHistory() {
      window.location.href = 'istori.php';
    }

    function gotoHistory2() {
        window.location.href = 'istori2.php';
    }

    function saveCartState() {
      const cartState = {
        items: Array.from(cartItems.children).map(item => item.innerText),
        totalItems: totalItems,
        totalPrice: totalPrice,
        comment: commentElem.value
      };
      localStorage.setItem('cartState', JSON.stringify(cartState));
    }

    function loadCartState() {
      const savedCartState = localStorage.getItem('cartState');
      if (savedCartState) {
        const cartState = JSON.parse(savedCartState);
        cartState.items.forEach(itemText => {
          const cartItem = document.createElement('div');
          cartItem.classList.add('cart-item');
          cartItem.innerText = itemText;
          cartItems.appendChild(cartItem);
        });
        totalItems = cartState.totalItems;
        totalPrice = cartState.totalPrice;
        updateCartTotal();
        updateCartCount();
        commentElem.value = cartState.comment || '';
      }
    }
  </script>
</body>
</html>