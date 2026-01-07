<?php
function getLessons($module)
{
  if ($module) {
    $model = new \App\Models\LessonModel();
    return $model->findByModule($module);
  }

  return null;
}
?>
