<?php require_once 'header.php'; ?>

<div class="container-cart">
    <div class="page_title">
        <h1>Корзина</h1>
    </div>
    <?php if ($_SESSION['cart']) : ?>
        <div class="table_wrap">
            <!-- <form method="post" action="" class="product-cart-all"> -->
            <? foreach($_SESSION['cart'] as $key => $product):?>

            <form method="post" action="" class="product-cart">
                <div class="product">
                    <div class="product_name"><?= $product['tovName'] ?></div>
                    <div class="product_content">
                        <div class="fabr">Производитель: <?= $product['fabr'] ?></div>
                        <div class="ost">В наличии: <?= $product['ost'] ?> шт.</div>
                        <div class="price"><?= trim_zero($product['pricerozn']) ?> &#8381<span> x <?= $product['qty']; ?> шт.</span></div>
                        <div class="stepper_and_update">
                            <div class="stepper stepper-cart stepper--style-2 js-spinner">
                                <input type="number" id="id<?= $key ?>" min="1" max="<?= $product['ost'] ?>" step="1" value="<?= $product['qty']; ?>" class="stepper__input" name="qty_cart">
                                <div class="stepper__controls">
                                    <button type="submit" spinner-button="up" name="addtocart">+</button>
                                    <button type="submit" spinner-button="down" name="addtocart">−</button>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="regid" value="<?= $product['regid'] ?>">
                                <input type="hidden" name="branchid" value="<?= $product['branchid'] ?>">
                                <input type="hidden" name="pricerozn" value="<?= $product['pricerozn'] ?>">
                                <input type="hidden" name="ost" value="<?= $product['ost'] ?>">
                                <button type="submit" name="addtocart" class="updatecart">&#8635</button>
                            </div>

                        </div>

                        <div class="price-cart"><?= $product['pricerozn'] * $product['qty']; ?> &#8381
                        </div>
                        <div class="product_to_cart">
                            <button type="submit" name="del-cart-product" class="del-cart-product">&times</button>
                        </div>
                    </div>
                    <div class="fabr">Аптека: <?= $product['branch'] ?></div>
                </div>
            </form>

            <?endforeach;?>
            <form method="post" action="" class="product-cart-all">
                <div class="total_sum">Общая сумма заказа: <?= trim_zero($_SESSION['total_sum']) ?> &#8381</div>

                <div class="del-order">
                    <div class="del-order-btn">
                        <input type="submit" class="product_to_cart_btn delete-cart-btn" name="delete-cart" value="Очистить корзину" />
                    </div>
                    <!-- <div class="product_to_cart_btn order-cart-btn btn_big_text del-order-btn"> -->
                        <a href="<?= PATH ?>order/" alt="Оформить заказ" class="product_to_cart_btn order-cart-btn btn_big_text del-order-btn">Оформить заказ</a>
                    <!-- </div> -->
                </div>

            </form>

        <?php else : // если товаров нет 
        ?>
            <div class="cart_empty_wraper">
                <div class="cart_empty_img">
                    <a href="<?= PATH ?>catalog/" class="header__logo">
                        <img src="<?= PATH ?>views/img/add.png" alt="">
                    </a>
                </div>
                <div class="cart_empty">
                    <div class="cart_empty_text">Ваша корзина пуста</div>
                    <div class="product_to_cart_btn btn_big_text"><a href="<?= PATH ?>catalog/" alt="Каталог" class="to_catalog">В каталог</a></div>
                </div>
            </div>
        <?php endif; // конец условия проверки корзины 
        ?>
        </div>
</div>
<?php require_once 'footer.php'; ?>