<div class="horizontal-motion bg-white py-1 text-xl text-primary font-bold" style="--motion-duration: <?= $motionDurationInSeconds ?>s;">
  <div class="track">
    <?php
    for ($group = 0; $group < $motionGroupNumber; $group++): ?>
      <div class="flex gap-x-25 pr-50 items-center" <?= $group > 0 ? 'aria-hidden="true"' : '' ?>>
        <?php
        foreach ($brands as $key => $brand):
          $alt = esc($brand->relationshipLabel() . ': ' . $brand->title);
        ?>
          <div class="item flex h-[120px] w-[250px] items-center justify-center">
            <img alt="<?= $alt ?>" title="<?= $alt ?>" src="<?= esc(assets('images', "logos/{$brand->name}/colorful.png")) ?>" width="250" height="120" loading="lazy" decoding="async" class="max-h-full max-w-full object-contain" />
          </div>
        <?php endforeach; ?>
      </div>
    <?php endfor; ?>
  </div>
</div>
