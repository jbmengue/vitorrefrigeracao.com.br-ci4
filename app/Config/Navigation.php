<?php

namespace Config;

use App\ValueObjects\Navigation\NavItem;
use CodeIgniter\Config\BaseConfig;

class Navigation extends BaseConfig
{
    public array $items;
    private \App\Models\TechnicalServicesModel $technicalServicesModel;

    public function __construct()
    {
        parent::__construct();

        $this->technicalServicesModel = new \App\Models\TechnicalServicesModel();
        $this->buildNavigationItems();
    }

    private function mapRowsToNavItems(
        array $rows,
        ?string $keyPrefix = null,
        string $defaultLabel = 'Sem título',
        string $defaultRoute = '/',
    ): array {
        return array_map(
            static function (object $row) use (
                $keyPrefix,
                $defaultLabel,
                $defaultRoute
            ): NavItem {
                $keyRaw = $row->name ?? $row->id ?? null;
                $label  = $row->label_menu ?? $row->label ?? $defaultLabel;
                $route  = $row->uri ?? $defaultRoute;

                $key = (string) ($keyRaw ?? $label);

                if ($keyPrefix) {
                    $key = $keyPrefix . $key;
                }

                return new NavItem(
                    key: $key,
                    label: (string) $label,
                    route: (string) $route,
                );
            },
            $rows
        );
    }

    private function buildChildrenFromDb(string $menuKey): array {
        return $this->mapRowsToNavItems(
            rows: $this->technicalServicesModel->onlyActive()->byShowInMenu($menuKey)->getTechnicalServices()
        );
    }

    private function buildNavigationItems(): void {
        $this->items = [
            new NavItem(
                key: 'technical-assistance',
                label: 'Assistencia Técnica',
                shortLabel: 'Ass. Técnica',
                route: '/',
                children: $this->buildChildrenFromDb('technical-assistance'),
            ),
            new NavItem(
                key: 'authorized',
                label: 'Serviços Autorizados',
                shortLabel: 'Autorizadas',
                route: '/quem-somos',
                children: $this->buildChildrenFromDb('authorized'),
            ),
            new NavItem(
                key: 'installations',
                label: 'Instalações',
                route: '/servicos',
                children: [
                    new NavItem(
                        key: 'maintenance-contract-condominiums',
                        label: 'Instalação de aquecedores',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/instal-aquecedor',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de ar condicionado',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/instalacao/',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de eletrodomésticos',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/instalacao-eletrodomesticos/',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de TV',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/instalacao-tv',
                    ),
                ],
            ),
            new NavItem(
                key: 'cleaning',
                label: 'Limpeza',
                route: '#',
                children: [
                    new NavItem(
                        key: 'maintenance-contract-condominiums',
                        label: 'Limpeza de ar split',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/limpeza-ar-split/',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Laudo de limpeza',
                        route: 'https://vitorrefrigeracao.com.br/site/qualidade-do-ar/',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Qualidade do ar',
                        route: 'https://vitorrefrigeracao.com.br/site/qualidade-do-ar/',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Limpeza de Equipamentos',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/limpeza-equipamentos',
                    ),
                ],
            ),
            new NavItem(
                key: 'air-conditioning',
                label: 'Ar condicionado',
                route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
            ),
            new NavItem(
                key: 'gas-heaters',
                label: 'Aquecedores à gás',
                shortLabel: 'Aquecedores',
                route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
            ),
            new NavItem(
                key: 'parts',
                label: 'Peças',
                route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
            ),
            new NavItem(
                key: 'contracts',
                label: 'Contratos',
                route: '/contato',
                children: [
                    new NavItem(
                        key: 'maintenance-contract-condominiums',
                        label: 'Contrato de manutenção para condomínios',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/condominios',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Contrato de manutenção PMOC',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/contratos-de-manutencao',
                    ),
                ],
            ),
            new NavItem(
                key: 'equipment',
                label: 'Equipamentos',
                route: '#',
                children: [
                    new NavItem(
                        key: 'equipment-01',
                        label: 'Câmaras frigoríficas',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/camaras-frigorificas',
                    ),
                    new NavItem(
                        key: 'equipment-02',
                        label: 'Projetos comerciais',
                        route: 'https://vitorrefrigeracao.com.br/site/servicos/projetos-comerciais/',
                    ),
                    new NavItem(
                        key: 'equipment-03',
                        label: 'Loja virtual',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'equipment-04',
                        label: 'Catálogos',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                ]
            ),
            new NavItem(
                key: 'commercial-refrigeration-gastronomy-equipment',
                label: 'Refrigeração comercial e equipamentos de gastronomia',
                route: '#',
                children: [
                    new NavItem(
                        key: 'self-services-visa-coolers',
                        label: 'Autosserviços e visa coolers',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'dry-refrigerated-counters',
                        label: 'Balcões secos e refrigerados',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'industrial-kitchen-line',
                        label: 'Linha cozinha industrial',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'butcher-shop-line',
                        label: 'Linha açougue',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'bakery-bakery-line',
                        label: 'Linha padaria e panificação',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'commercial-mini-chambers-refrigerators',
                        label: 'Mini-câmaras e geladeiras comerciais',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'display-gondolas',
                        label: 'Gondolas expositores',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'refrigerated-islands-freezers',
                        label: 'Ilhas refrigeradas e freezers',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                    new NavItem(
                        key: 'dry-and-heated-display-cases',
                        label: 'Vitrines secas e aquecidas',
                        route: 'https://www.mercadolivre.com.br/pagina/multipartspoa',
                    ),
                ],
            ),
            new NavItem(
                key: 'vrf',
                label: 'VRF',
                route: 'https://vitorrefrigeracao.com.br/site/servicos/solucao-vrf/',
            ),
            new NavItem(
                key: 'equipment-rental-air-quality',
                label: 'Qualidade do ar',
                route: 'https://vitorrefrigeracao.com.br/site/qualidade-do-ar/',
            ),
        ];
    }
}
