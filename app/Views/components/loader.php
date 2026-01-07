<?php
$_label = !$label ? "Aguarde" : $label; ?>
<div class="loading-content">
    <div class="loading-wrapper d-flex justify-content-center align-items-center">
        <div class="loading-pulse ">
            <img src="<?= base_url("assets/images/loading.png") ?>" alt="" srcset="">
        </div>
        <div class="loading-label">
            <?= $_label ?><br />
            <small class="regular"></small>
        </div>
    </div>
</div>