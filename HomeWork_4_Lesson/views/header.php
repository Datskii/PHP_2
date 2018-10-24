<header>
    <div class="shop_name">Shop_basket</div>
    <div>

        <?php if (isset($_SESSION['user'])) : ?>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/basket" class="link_button">
                <button>Корзина
                    <?php if (AMOUNT_BASKET > 0) : ?>
                        (<?= AMOUNT_BASKET ?>)
                    <?php endif; ?>
                </button>
            </a>

            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/user" class="link_button">
                <button>Личная страница</button>
            </a>

            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/orders" class="link_button">
                <button>Заказы</button>
            </a>

            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/admin" class="link_button">
                <button>Админка</button>
            </a>

            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" style="display: inline-block;">
                <input type="submit" name="logout" value="Выйти" style="width: auto;">
            </form>
        <?php else: ?>
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/user/login" class="link_button">
                <button>Войти</button>
            </a>

            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/user/register" class="link_button">
                <button>Регистрация</button>
            </a>
        <?php endif; ?>

    </div>
</header>