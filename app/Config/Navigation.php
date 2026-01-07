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
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de ar condicionado',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de eletrodomésticos',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Instalação de TV',
                        route: '/contato',
                    ),
                ],
            ),
            new NavItem(
                key: 'cleaning',
                label: 'Limpeza',
                route: '/contato',
                children: [
                    new NavItem(
                        key: 'maintenance-contract-condominiums',
                        label: 'Limpeza de ar split',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Laudo de limpeza',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Qualidade do ar',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Limpeza de Equipamentos',
                        route: '/contato',
                    ),
                ],
            ),
            new NavItem(
                key: 'air-conditioning',
                label: 'Ar condicionado',
                route: '/contato',
            ),
            new NavItem(
                key: 'gas-heaters',
                label: 'Aquecedores à gás',
                shortLabel: 'Aquecedores',
                route: '/contato',
            ),
            new NavItem(
                key: 'parts',
                label: 'Peças',
                route: '/contato',
            ),
            new NavItem(
                key: 'contracts',
                label: 'Contratos',
                route: '/contato',
                children: [
                    new NavItem(
                        key: 'maintenance-contract-condominiums',
                        label: 'Contrato de manutenção para condomínios',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'pmoc',
                        label: 'Contrato de manutenção PMOC',
                        route: '/contato',
                    ),
                ],
            ),
            new NavItem(
                key: 'equipment',
                label: 'Equipamentos',
                route: '/contato',
            ),
            new NavItem(
                key: 'commercial-refrigeration-gastronomy-equipment',
                label: 'Refrigeração comercial e equipamentos de gastronomia',
                route: '/contato',
                children: [
                    new NavItem(
                        key: 'commercial-refrigeration-gastronomy-equipment-equipment-rental',
                        label: 'Locação de equipamentos',
                        route: '/servicos/locacao',
                    ),
                    new NavItem(
                        key: 'self-services-visa-coolers',
                        label: 'Autosserviços e visa coolers',
                        route: '/servicos/administracao',
                    ),
                    new NavItem(
                        key: 'dry-refrigerated-counters',
                        label: 'Balcões secos e refrigerados',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'industrial-kitchen-line',
                        label: 'Linha cozinha industrial',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'butcher-shop-line',
                        label: 'Linha açougue',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'bakery-bakery-line',
                        label: 'Linha padaria e panificação',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'commercial-mini-chambers-refrigerators',
                        label: 'Mini-câmaras e geladeiras comerciais',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'display-gondolas',
                        label: 'Gondolas expositores',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'refrigerated-islands-freezers',
                        label: 'Ilhas refrigeradas e freezers',
                        route: '/servicos/consultoria',
                    ),
                    new NavItem(
                        key: 'dry-and-heated-display-cases',
                        label: 'Vitrines secas e aquecidas',
                        route: '/servicos/consultoria',
                    ),
                ],
            ),
            new NavItem(
                key: 'gondolas',
                label: 'Gondolas',
                route: '/contato',
            ),
            new NavItem(
                key: 'vrf',
                label: 'VRF',
                route: '/contato',
            ),
            new NavItem(
                key: 'tailor-made-commercial-projects',
                label: 'Projetos comerciais sob medida',
                route: '/contato',
            ),
            new NavItem(
                key: 'equipment-rental',
                label: 'Locação de equipamentos',
                route: '/contato',
                children: [
                    new NavItem(
                        key: 'equipment-rental-vrf',
                        label: 'VRF',
                        route: '/contato',
                    ),
                    new NavItem(
                        key: 'equipment-rental-air-quality',
                        label: 'Qualidade do ar',
                        route: '/contato',
                    ),
                ],
            ),
        ];
    }
}
