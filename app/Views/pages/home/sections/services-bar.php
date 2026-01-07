<div class="horizontal-motion bg-black py-1 text-xl text-primary font-bold" style="--motion-duration: 25s;">
  <div class="track">
    <?php for ($group = 0; $group < 2; $group++): ?>
      <div class="flex gap-x-50 pr-50" <?= $group === 1 ? 'aria-hidden="true"' : '' ?>>
        <?php for ($item = 0; $item < $count; $item++): ?>
          <div class="item"><?= esc($text) ?></div>
        <?php endfor; ?>
      </div>
    <?php endfor; ?>
  </div>
</div>