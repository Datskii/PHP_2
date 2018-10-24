<?php /** @var  \app\models\Product $model , $modelImg */ ?>

    <a href="/">Вернуться в каталог товаров.</a>

    <h1><?= $model->name ?></h1>
    <p><?= $model->description ?></p>
    <p>Цена: <?= $model->price ?></p>

<?php if (isset($_SESSION['user'])) : ?>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" style="margin-bottom: 36px">
        <input type="hidden" name="id" value="<?= $model->id ?>">
        <input type="submit" name="submitAddBasket" class="submit" value="Добавить в корзину">
    </form>
<?php endif; ?>

<?php foreach ($modelImg as $value): ?>
    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/images/big/<?= $value['img'] ?>" target="_blank"
       style="display: inline-block;">
        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/images/small/<?= $value['img'] ?>" alt="">
    </a>
<?php endforeach; ?>