<?php
if (isset($externalJSHead) && is_array($externalJSHead)):
  foreach ($externalJSHead as $js): ?>
        <script type="text/javascript" src="<?= $js ?>"></script>
    <?php endforeach;
endif;

if (isset($JSHead) && is_array($JSHead)):
  foreach ($JSHead as $js): ?>
        <script type="text/javascript">
            <?= $js ?>
        </script>
    <?php endforeach;
endif;
