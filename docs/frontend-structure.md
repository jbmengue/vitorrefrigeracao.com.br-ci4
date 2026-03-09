# Frontend Structure

This document describes the project frontend organization under `resources/scripts` and `resources/css`.

## Scripts Structure (`resources/scripts`)

```text
resources/scripts
├── components/         # UI components for layout and interactive blocks
│   ├── layout/         # Structural and section-level components
│   └── ui/             # Generic reusable UI components
├── pages/              # Page-specific scripts
├── plugins/            # Third-party plugin integrations/adapters
├── services/           # API access and communication logic
└── shared/             # Reusable cross-project code
    ├── constants/      # Shared constants
    ├── hooks/          # Reusable React hooks
    ├── types/          # Shared TypeScript types
    └── utils/          # Generic utility helpers
```

## CSS Structure (`resources/css`)

```text
resources/css
├── base/               # Global base styles
├── theme/              # Theme variables and design defaults
├── components/         # Component-level styling
│   ├── layout/         # Layout-specific styles
│   └── ui/             # Reusable UI styles (buttons, motions, etc.)
├── utilities/          # Utility classes and helpers
├── icons/              # Icon font and icon styles
└── vendor/             # Third-party library styles
```

## Views Structure (`app/Views`)

```text
app/Views
├── layouts/
│   └── snippets/       # Reusable layout partials (head, scripts, brand, etc.)
└── pages/
    └── <page>/
        ├── index.php   # Page entry view
        └── sections/   # Page-specific sections/blocks
```
