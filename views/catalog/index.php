<?php include ROOT . '/views/layouts/header.php';?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Каталог</h2>
                    <div class="panel-group category-products">

                        <?php foreach($categories as $categoryItem):?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="/category/<?=$categoryItem['id'];?>"><?=$categoryItem['name'];?></a>
                                    </h4>
                                </div>
                            </div>
                        <?php endforeach;?>

                    </div>

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Последние товары</h2>

                    <?php foreach($lastProducts as $lastProduct):?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="/template/images/home/product4.jpg" alt="" />
                                        <h2>$<?=$lastProduct['price'];?></h2>
                                        <p>
                                            <a href="/product/<?=$lastProduct['id'];?>">
                                                <?=$lastProduct['name'];?>
                                            </a>
                                        </p>
                                        <a href="<?=$lastProduct['id'];?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                    </div>
                                    <?php if ($lastProduct['is_new']):?>
                                        <img src="/template/images/home/new.png" class="new" alt="" />
                                    <?php endif;?>
<!--                                    <div class="product-overlay">-->
<!--                                        <div class="overlay-content">-->
<!--                                            <h2>$--><?//=$lastProduct['price'];?><!--</h2>-->
<!--                                            <p>-->
<!--                                                <a href="/product/--><?//=$lastProduct['id'];?><!--">-->
<!--                                                    --><?//=$lastProduct['name'];?>
<!--                                                </a>-->
<!--                                            </p>-->
<!--                                            <a href="--><?//=$lastProduct['id'];?><!--" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>

<!--                    <ul class="pagination">-->
<!--                        <li><a href="">&lt;</a></li>-->
<!--                        <li class="active"><a href="">1</a></li>-->
<!--                        <li><a href="">2</a></li>-->
<!--                        <li><a href="">3</a></li>-->
<!--                        <li><a href="">3</a></li>-->
<!--                        <li><a href="">&gt;</a></li>-->
<!--                    </ul>-->
                </div><!--features_items-->
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php';?>
