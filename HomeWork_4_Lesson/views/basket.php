<?php /** @var  \app\models\Basket $model */ ?>

    <a href="/">Вернуться в каталог товаров.</a>

    <h1>Корзина</h1>

<?php if (isset($_SESSION['user'])) : ?>
    <?php if ($model == null) : ?>

        <p>Корзина пуста, начните ваши покупки.</p>

    <?php else: ?>
        <?php foreach ($model as $value): ?>
            <div class="itemBasket">
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                    - <?= $value->name ?>:
                    <input type="hidden" name="id_prod" value="<?= $value->id_prod ?>">
                    <div style="margin: 0 12px; display: inline-block;">
                        <input type="submit" name="submitRemoveBasket" class="submit" value="-">
                        &nbsp;<?= $value->amount ?>&nbsp;
                        <input type="submit" name="submitAddBasket" class="submit" value="+">
                    </div>
                    <?= $value->price * $value->amount ?> руб.
                </form>
            </div>
        <?php endforeach; ?>
        <p style="font-weight: bold">Общая сумма: <?= $value ?> руб.</p>

        <hr>

        <h2>Информация для заказа.</h2>

        <form action="http://<?= $_SERVER['HTTP_HOST'] ?>/orders" method="post">
            <label for="address">Адрес доставки</label>
            <input type="text" name="address" id="address" value="" required>
            <input type="hidden" name="totalPriceBasket" value="<?= $value ?>">
            <input type="submit" name="submitAddOrder" class="submit" value="Оформить заказ">
        </form>
    <?php endif; ?>

<?php else: ?>
    <p>Эту страницу могу просматривать только зарегистрированные пользователи.</p>
<?php endif; ?>