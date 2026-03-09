<?php

namespace App\Controllers;

use App\Entities\PostsServices;
use App\Models\PostsServicesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends BaseController
{
  private ?PostsServicesModel $postsServicesModel = null;

  public function service(string $group, string $slug): string
  {
    $service = $this->getServiceOrFail($group, $slug);

    return $this->render(array_merge(
      [
        'page' => 'service',
        'group' => $group,
        'post' => $service,
        'service' => $service,
      ],
      $this->buildMetaTagsFromService($service),
    ));
  }

  private function getServiceOrFail(string $group, string $slug): PostsServices
  {
    $service = $this->postsServicesModel()->findBySlug(
      slug: $slug,
      group: $this->mapRouteGroupToDbGroup($group),
    );

    if ($service === null) {
      throw PageNotFoundException::forPageNotFound();
    }

    return $service;
  }

  private function mapRouteGroupToDbGroup(string $group): string
  {
    return match ($group) {
      'assistencia-tecnica' => 'technical-assistance',
      'autorizada' => 'authorized',
      default => throw PageNotFoundException::forPageNotFound(),
    };
  }

  private function buildMetaTagsFromService(PostsServices $service): array
  {
    $meta = [
      'metaTitle' => $this->appConfig->name . ' - ' . (string) ($service->title ?? ''),
      'metaDescription' => (string) ($service->subtitle ?? ''),
    ];

    $imageName = trim((string) ($service->imageName ?? ''));

    if ($imageName !== '') {
      $image = rtrim($this->appConfig->upload, '/') . '/images/thumb/' . $imageName;

      $meta['metaImage'] = $image;

      if (is_file($image)) {
        $imageSize = @getimagesize($image);

        if ($imageSize !== false) {
          [$imageWidth, $imageHeight, $imageType] = $imageSize;
          $meta['metaImageWidth'] = $imageWidth;
          $meta['metaImageWidht'] = $imageWidth;
          $meta['metaImageHeight'] = $imageHeight;
          $meta['metaImageType'] = image_type_to_mime_type($imageType);
        }
      }
    }

    return $meta;
  }

  private function postsServicesModel(): PostsServicesModel
  {
    if ($this->postsServicesModel === null) {
      $this->postsServicesModel = new PostsServicesModel();
    }

    return $this->postsServicesModel;
  }
}
