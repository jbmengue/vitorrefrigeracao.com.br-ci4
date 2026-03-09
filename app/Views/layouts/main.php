<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?= layout_snippet("head") ?>
</head>
<body class="<?= esc(str_replace("/", "-", $page)) ?>">
    <div id="root">
        <?php layout("header"); ?>

        <main>
            <?= $this->renderSection("content") ?>
            <?= component('testimonials') ?>
        </main>

        <?php layout("footer"); ?>

        <?= layout_snippet("scripts") ?>
    </div>
</body>
</html>
