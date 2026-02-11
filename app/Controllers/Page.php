<?php

namespace App\Controllers;

class Page extends BaseController
{
  public function News()
  {
    return view(
      "layout/content",
      array_merge(
        [
          "page" => "news",
        ],
        $this->setMetaTagsPost(2, "news"),
      ),
    );
  }

  public function contact()
  {
    return view("layout/content", ["page" => "contact"]);
  }

  private function setMetaTagsPost($segment, $type): array
  {
    $slug = service("uri")->getSegment($segment);
    if (null == $slug) {
      return [];
    }

    $postModel = new \App\Models\PostModel();
    $post = $postModel->metaTagData($type, $slug);
    if (null != $post) {
      $image = $this->appConfig->upload . "/images/thumb/" . $post->metaImage;
      [$imageWidth, $imageHeight, $imageType] = getimagesize($image);
      return [
        "metaTitle" => $this->appConfig->name . " - " . $post->metaTitle,
        "metaDescription" => $post->metaDescription,
        "metaImage" => $image,
        "metaImageWidht" => $imageWidth,
        "metaImageHeight" => $imageHeight,
        "metaImageType" => image_type_to_mime_type($imageType),
      ];
    }
    return [];
  }
}
