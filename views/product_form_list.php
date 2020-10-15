<form action="" method="post">
    <div class="product">
        <div class="product_name"><a href='<?= PATH ?>product/<?= $product[0]['alias'] ?>?branchid=<?= $product[0]['branchid'] ?>&pricerozn=<?= $product[0]['pricerozn'] ?>&ost=<?= $product[0]['ost'] ?>'><?= $product[0]['tovName'] ?></a></div>
        <div class="product_content">
            <div class="fabr">Производитель: <?= $product[0]['fabr'] ?></div>
            <!-- <div class="ost">В наличии: <?= $product[0]['ost'] ?> шт.</div> -->
            <div class="price price_from">
                <a href='<?= PATH ?>product/<?= $product[0]['alias'] ?>?branchid=<?= $product[0]['branchid'] ?>&pricerozn=<?= $product[0]['pricerozn'] ?>&ost=<?= $product[0]['ost'] ?>' class="price_from">от <?= trim_zero($product[0]['pricerozn']) ?> &#8381</a>
            </div>
            <!-- <div class="stepper stepper--style-2 js-spinner">
                <input type="number" min="1" max="<?= $product[0]['ost'] ?>" step="1" value="1" class="stepper__input" name="qty">
                <div class="stepper__controls">
                    <button type="button" spinner-button="up">+</button>
                    <button type="button" spinner-button="down">−</button>
                </div>
            </div> -->
            <div class="product_to_cart">
                <input type="hidden" name="regid" value="<?= $product[0]['regid'] ?>">
                <input type="hidden" name="branchid" value="<?= $product[0]['branchid'] ?>">
                <input type="hidden" name="pricerozn" value="<?= $product[0]['pricerozn'] ?>">
                <input type="hidden" name="ost" value="<?= $product[0]['ost'] ?>">
                <!-- <button type="submit" name="addtocart" class="product_to_cart_btn _catalog_btn" id="cartfix">В корзину</button> -->
                <!-- <div class="product_to_cart_btn order-cart-btn btn_big_text del-order-btn"> -->
                <a href='<?= PATH ?>product/<?= $product[0]['alias'] ?>?branchid=<?= $product[0]['branchid'] ?>&pricerozn=<?= $product[0]['pricerozn'] ?>&ost=<?= $product[0]['ost'] ?>' class="price_from product_to_cart_btn order-cart-btn btn_big_text del-order-btn btn-ost">Посмотреть наличие</a>
                <!-- </div> -->
            </div>
        </div>
        <!-- <div class="fabr">Аптека: <?= $product[0]['branch'] ?></div> -->
    </div>
</form>