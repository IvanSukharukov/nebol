<form action="" method="post">
    <div class="product">
        <!-- <div class="product_name"><a href='<?= PATH ?>product/<?= $product['alias'] ?>?branchid=<?= $product['branchid'] ?>&pricerozn=<?= $product['pricerozn'] ?>&ost=<?= $product['ost'] ?>'><?= $product['tovName'] ?></a></div> -->
        <div class="product_content">
            <div class="fabr">Производитель: <?= $product['fabr'] ?></div>
            <div class="ost">В наличии: <?= $product['ost'] ?> шт.</div>
            <div class="price"><?= trim_zero($product['pricerozn']) ?> &#8381</div>
            <div class="stepper stepper--style-2 js-spinner">
                <input type="number" min="1" max="<?= $product['ost'] ?>" step="1" value="1" class="stepper__input" name="qty">
                <div class="stepper__controls">
                    <button type="button" spinner-button="up">+</button>
                    <button type="button" spinner-button="down">−</button>
                </div>
            </div>
            <div class="product_to_cart">
                <input type="hidden" name="regid" value="<?= $product['regid'] ?>">
                <input type="hidden" name="branchid" value="<?= $product['branchid'] ?>">
                <input type="hidden" name="pricerozn" value="<?= $product['pricerozn'] ?>">
                <input type="hidden" name="ost" value="<?= $product['ost'] ?>">
                <button type="submit" name="addtocart" class="product_to_cart_btn _catalog_btn" id="">В корзину</button>
                
                <!-- <button type="submit" name="addtocart" class="product_to_cart_btn _catalog_btn" id=""><?php //if (empty($_SESSIN['cart'])) echo "<a href=\"#zatemnenie\">" ?>В корзину<?php //if (empty($_SESSIN['cart'])) echo "</a>" ?></button> -->
            </div>
        </div>
        <div class="fabr address-product">Аптека: <?= $product['branch'] ?></div>
    </div>
</form>