<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h1>Кабинет пользователя</h1>
            <h3>Привет, <?php echo $user['name']; ?></h3>
            <ul>
                <?php if ($user['role'] === 'admin'): ?>
                <li><a href="/admin/index">Администрирование сайта</a></li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
