<?php if (!empty($products)): ?>
        <?php $currency = \woodpc\App::$app->getProperty('currency'); ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 product-left p-left">
                <div class="product-main simpleCart_shelfItem">
                    <a href="product/<?= $product->alias; ?>" class="mask"><img
                                class="img-responsive zoom-img" src="images/<?= $product->img; ?>"
                                alt=""/></a>
                    <div class="product-bottom">
                        <h3><?= $product->title; ?></h3>
                        <p>Explore Now</p>
                        <h4>
                            <a data-id="<?= $product->id; ?>" class="add-to-cart"
                               href="cart/add?id=<?= $product->id; ?>"><i></i></a> <span
                                    class=" item_price"><?= $currency['symbol_left']; ?><?= $product->price * $currency['value']; ?><?= $currency['symbol_right']; ?></span>
                        </h4>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
        <div class="text-center">
            <p>(<?= count($products) ?> товара(ов) из <?= $countTotal; ?>)</p>
            <?php if ($pagination->countPages > 1): ?>
                <?= $pagination ?>
            <?php endif; ?>
        </div>
<?php else: ?>
    <h3>Товары не найдены........</h3>
<?php endif; ?>
