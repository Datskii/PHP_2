<?php /** @var  \app\models\Product $model */ ?>

<h1>Каталог товаров</h1>

<div class="catalog">

    <?php foreach ($model as $value): ?>
        <div class="item">
            <a href="index.php?a=card&id=<?= $value->id ?>">
                <?php if ($value->img != ''): ?>
                    <img src="./images/small/<?= $value->img ?>" alt="">
                <?php else: ?>
                    <div class="plug">Фото отсутствует</div>
                <?php endif; ?>
            </a>
            <a href="index.php?a=card&id=<?= $value->id ?>">
                <p><?= $value->name ?></p>
            </a>
            <p>Цена <?= $value->price ?> руб.</p>

            <?php if (isset($_SESSION['user'])) : ?>
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                    <input type="hidden" name="id_prod" value="<?= $value->id ?>">
                    <input type="submit" name="submitAddBasket" class="submit" value="Добавить в корзину">
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>