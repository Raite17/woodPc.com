<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <?=$breadCrumbs;?>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--start-single-->
<div class="single contact">
    <div class="container">
        <div class="single-main">
            <div class="col-md-9 single-main-left">
                <div class="sngl-top">
                    <div class="col-md-5 single-top-left">
                        <div class="flexslider">
                            <ul class="slides">
                                <li data-thumb="images/<?= $product->img?>">
                                    <div class="thumb-image">
                                        <img src="images/<?= $product->img?>" data-imagezoom="true" class="img-responsive" alt=""/>
                                    </div>
                                </li>
                                <?php if($galleries):?>
                                    <?php foreach ($galleries as $gallery):?>
                                    <li data-thumb="images/<?= $gallery->img?>">
                                        <div class="thumb-image">
                                            <img src="images/<?= $gallery->img?>" data-imagezoom="true" class="img-responsive" alt=""/>
                                        </div>
                                    </li>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    $currency = \woodpc\App::$app->getProperty('currency');
                    $category = \woodpc\App::$app->getProperty('categories');
                    ?>
                    <div class="col-md-7 single-top-right">
                        <div class="single-para simpleCart_shelfItem">
                            <h2><?= $product->title; ?></h2>
                            <h5 class="item_price"><?= $currency['symbol_left'] ?><?= $product->price * $currency['value']; ?><?= $currency['symbol_right'] ?></h5>
                            <p><?= $product->content ?></p>
                            <ul class="tag-men">
                                <li><span>Категория:</span>
                                    <span class="category">
                                        <a href="category/<?= $category[$product->category_id]['alias'];?>"><?= $category[$product->category_id]['title'];?></a>
                                    </span>
                                </li>
                            </ul>
                            <div class="quantity">
                                <input style="" type="number" size="4" class="form-control" name="quantity" min="1" step="1" value="1">
                            </div>
                            <a id="productAdd" data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>" class="add-cart add-to-cart item_add">Добавить в корзину</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="tabs">
                    <ul class="menu_drop">
                        <li class="item1"><a href="#"><img src="images/arrow.png" alt="">Описание товара</a>
                            <ul>
                                <li class="subitem1">
                                    <a href="#"><?= $product->content;?></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php if($related): ?>
                    <div class="latestproducts">
                        <div class="product-one">
                            <h3>С этим товаром также покупают:</h3>
                            <?php foreach($related as $item): ?>
                                <div class="col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$item['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img'];?>" alt="" /></a>
                                        <div class="product-bottom">
                                            <h3><a href="product/<?=$item['alias'];?>"><?=$item['title'];?></a></h3>
                                            <p>Explore Now</p>
                                            <h4>
                                                <a class="item_add add-to-cart-link" href="cart/add?id=<?=$item['id'];?>" data-id="<?=$item['id'];?>"><i></i></a>
                                                <span class="item_price"><?= $currency['symbol_left'];?><?=$item['price'] * $currency['value'];?><?=$currency['symbol_right'];?></span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($recentlyViewed): ?>
                    <div class="latestproducts">
                        <div class="product-one">
                            <h3>Недавно просмотренные:</h3>
                            <?php foreach($recentlyViewed as $item): ?>
                                <div class="col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$item['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img'];?>" alt="" /></a>
                                        <div class="product-bottom">
                                            <h3><a href="product/<?=$item['alias'];?>"><?=$item['title'];?></a></h3>
                                            <p>Explore Now</p>
                                            <h4>
                                                <a class="item_add add-to-cart-link" href="cart/add?id=<?=$item['id'];?>" data-id="<?=$item['id'];?>"><i></i></a>
                                                <span class="item_price"><?=$currency['symbol_left'];?><?=$item['price'] * $currency['value'];?><?=$currency['symbol_right'];?></span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--end-single-->