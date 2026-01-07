<?= $this->extend("layouts/main") ?>
<?= $this->section("content") ?>
<?= $this->include("pages/" . $page . "/index") ?>
<?= $this->endSection() ?>
