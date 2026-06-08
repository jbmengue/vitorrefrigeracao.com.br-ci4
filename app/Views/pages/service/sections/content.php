<?php
if (render_content_if_exists($post->content ?? null, 'service', [
    'group' => $group ?? null,
    'post' => $post,
  ], 'content')) {
  return;
}
?>
<section class="mb-25">
  <div class="layout-container commercial-content">
    <?= $post->content ?>
  </div>
</section>
