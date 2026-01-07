<?php

namespace App\Cells\About;

use CodeIgniter\View\Cells\Cell;

class About extends Cell
{
  public array $highlights;
  protected string $view = 'views/about';

  public function mount(): void
  {
    $this->highlights = array_map(
      static fn(array $item) => (object) $item,
      [
        [
          'icon' => 'whatsapp',
          'title' => 'Agilidade',
          'text' => [
            'Atendimento 24h via whats.',
            'Mais de 40 equipes em campo.'
          ]
        ],
        [
          'icon' => 'settings',
          'title' => 'Peças Originais',
          'text' => [
            'Peças à pronta entrega direto do fabricante.'
          ]
        ],
        [
          'icon' => 'trusted',
          'title' => 'Garantia',
          'text' => [
            'Somos credenciados pelos fabricantes, ou seja, sua garantia é preservada.'
          ]
        ],
      ]
    );
  }
}
