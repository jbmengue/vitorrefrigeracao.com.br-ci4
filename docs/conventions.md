# Conventions

This document defines required naming and organization conventions for CodeIgniter views, scripts, and CSS.

## CodeIgniter

- Use `index.php` as the entry file for each page in `app/Views/pages/<page>/index.php`.
- Keep page-specific blocks in `app/Views/pages/<page>/sections/`.
- Keep reusable layout fragments in `app/Views/layouts/snippets/`.
- Use `sections` only for blocks tied to a single page.
- Use `snippets` for fragments reused across layouts or multiple pages.

## Scripts

- Use `index.ts` as the entry script in each folder/module under `resources/scripts/...`.
- Prefer folder imports (resolving to `index.ts`) over direct file imports when applicable.

## CSS

- Use `index.css` as the entry stylesheet in each folder/module under `resources/css/...`.
- Keep folder-level style entry points consistent with the same `index.*` convention used in scripts and views.
