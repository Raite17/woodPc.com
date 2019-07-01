<div class="bnr" id="home">
    <div id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li>
                <img src="images/titan-x.jpg" alt=""/>
            </li>
            <li>
                <img src="images/rtx-2080.jpg" alt=""/>
            </li>
            <li>
                <img src="images/gtx-pc.jpg" alt=""/>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
<?php if ($brands): ?>
    <div class="about">
        <h1 class="text-center">Бренды</h1> <br>
        <div class="container">
            <div class="about-top grid-1">
                <?php foreach ($brands as $brand): ?>
                    <div class="col-md-4 about-left">
                        <figure>
                            <img class="img-responsive" src="images/<?= $brand->logo; ?>" alt="<?= $brand->logo; ?>"/>
                        </figure>
                    </div>
                <?php endforeach; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($hits): ?>
<?php $currency = \woodpc\App::$app->getProperty('currency');?>
    <div class="product">
        <div class="container">
            <div class="product-top">
                <div class="product-one">
                    <h2 class="text-center">Хиты продаж!</h2> <br>
                    <?php foreach ($hits as $hit) :?>
                    <div class="col-md-3 product-left">
                        <div class="product-main simpleCart_shelfItem">
                            <a href="product/<?= $hit->alias;?>" class="mask">
                                <img class="img-responsive zoom-img" src="images/<?= $hit->img;?>" alt=""/>
                            </a>
                            <div class="product-bottom">
                                <h3><?= $hit->title;?> </h3>
                                <p>Explore Now</p>
                                <h4>
                                    <a class="add-to-cart" href="cart/add?id=<?=$hit->id;?>"><i></i></a>
                                    <span class="item_price"><?= $currency['symbol_left']?><?= $hit->price * $currency['value'];?><?= $currency['symbol_right']?></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>