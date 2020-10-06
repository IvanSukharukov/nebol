<?php require_once 'header.php'; ?>
<div class="container">
    <div class="page_title">
        <h1>Оформление заказа</h1>
    </div>
    <div class="container-order">

        <?php if (isset($_SESSION['order']['res'])) : ?>
            <div><?= $_SESSION['order']['res'] ?></div>
    </div>
<?php elseif (empty($_SESSION['cart'])) : ?>
    <div class="product_to_cart_btn btn_big_text btn-no-order"><a href="<?= PATH ?>catalog/" alt="Каталог" class="to_catalog btn-no-order">В каталог</a></div>
</div>

<?php else : ?>
    <div class="order_details">
        <form method="post" action="">


            <div class="order_details__name">
                <div class="order_details__title">Ваше имя и фамилия: <span>*</span></div>
                <input type="text" id="no-enter" name="name" value="<?= $_SESSION['order']['name'] ?>" required>
            </div>
            <div class="order_details__phone">
                <div class="order_details__title">Ваш номер телефона: <span>*</span></div>
                <input type="tel" id="order_phone" name="phone" value="<?= $_SESSION['order']['phone'] ?>" placeholder="+7(___) ___-__-__" required>
            </div>
            <div class="order_details__email">
                <div class="order_details__title">Ваш e-mail:</div>
                <input type="text" id="no-enter" name="email" value="<?= $_SESSION['order']['email'] ?>">
            </div>
            <div class="order_details__address">
                <div class="order_details__title">Если нужна доставка - укажите адрес:</div>
                <input type="text" id="no-enter" name="address" value="<?= $_SESSION['order']['addres'] ?>" placeholder="Доставка от 200 &#8381">
            </div>
            <div class="order_details__note">
                <div class="order_details__title">Примечание:</div>
                <textarea id="no-enter" name="prim"><?= $_SESSION['order']['prim'] ?></textarea>
            </div>
            <div class="personal-data">
                <input type="checkbox" required checked> Я согласен на <a href="<?= PATH ?>page/policy/">обработку персональных данных</a>
            </div>

            <input type="submit" class="product_to_cart_btn btn_big_text btn_center" name="order" value="Заказать">
        </form>
    </div>

    <div class="cart-details">
        <div class="cart-details__header">
            <div class="cart-details__header__title">Ваш заказ:</div>
            <div class="product_to_cart_btn cart-details__header__btn"><a href="<?= PATH ?>cart/" alt="Изменить заказ">Изменить заказ</a></div>
        </div>


        <? foreach($_SESSION['cart'] as $regid => $product):?>
        <div class="cart-details-body">
            <div class="cart-details-body__tovname"><?= $product['tovName']; ?></div>
            <div class="cart-details-body__price"><?= trim_zero($product['pricerozn']); ?> &#8381 x <?= $product['qty']; ?> шт.</div>
            <div class="cart-details-body__sum"><?= $product['pricerozn'] * $product['qty']; ?> &#8381</div>
        </div>
        <?endforeach;?>
        <div class="cart-details-body__total_sum">Общая сумма заказа: <?= $_SESSION['total_sum'] ?> &#8381</div>
    </div>
    </div>
    </div>
<?php endif; ?>
<?php
unset($_SESSION['order']);
?>

<?php require_once 'footer.php'; ?>