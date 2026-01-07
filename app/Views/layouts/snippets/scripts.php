<?php
if (isset($externalJS) && is_array($externalJS)):
  foreach ($externalJS as $js): ?>
        <script type="text/javascript" src="<?= $js ?>" defer></script>
<?php endforeach;
endif; ?>

<?php if (isset($scriptJS) && is_array($scriptJS)):
  foreach ($scriptJS as $js): ?>
        <script type="text/javascript" defer>
            <?= $js ?>
        </script>
<?php endforeach;
endif; ?>

<?= vite_entry("resources/scripts/main.tsx") ?>
