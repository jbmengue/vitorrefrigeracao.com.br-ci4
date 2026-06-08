<?php

if (! function_exists('layout')) {
    function layout(string $file, array $data = [], string $dir = ''): void
    {
        if ($file === '') {
            return;
        }

        $dir  = trim($dir, '/');
        $path = 'layouts/' . ($dir !== '' ? $dir . '/_' : '_') . $file;

        echo view($path, $data, ['saveData' => false]);
    }
}

if (! function_exists('layout_snippet')) {
    function layout_snippet(string|array $file, array $data = [], string $dir = ''): void {

        if ($file === '' || $file === []) {
            return;
        }

        $dir = trim($dir, '/');

        if (is_array($file)) {
            foreach ($file as $snippet) {
                if ($snippet === '') {
                    continue;
                }
                $snippetData = isset($data[$snippet]) && is_array($data[$snippet])
                    ? $data[$snippet]
                    : $data;

                layout_snippet($snippet, $snippetData, $dir);
            }
            return;
        }
        $path = 'layouts/snippets/' . ($dir !== '' ? $dir . '/' : '') . $file;
        echo view($path, $data, ['saveData' => false]);
    }
}


if (! function_exists('component')) {
    function component(string $file, array $data = [], string $dir = ''): void
    {
        if ($file === '') {
            return;
        }

        $dir  = trim($dir, '/');
        $path = 'components/' . ($dir !== '' ? $dir . '/' : '') . $file;

        echo view($path, $data, ['saveData' => false]);
    }
}


if (! function_exists('section')) {
    function section(string $page, string $section, array $data = [], string $dir = ''): void
    {
        if ($section === '') {
            return;
        }

        $dir  = trim($dir, '/');
        $path = 'pages/' . $page . '/sections/' . ($dir !== '' ? $dir . '/' : '') . $section;

        echo view($path, $data, ['saveData' => false]);
    }
}

if (! function_exists('render_content_if_exists')) {
    function render_content_if_exists(
        ?string $content,
        string $type,
        array $data = [],
        string $dir = '',
    ): bool
    {
        $content = trim((string) $content);
        $type = trim($type);
        $dir = trim($dir, '/');

        if ($content === '') {
            return true;
        }

        $prefix = 'view:' . $type . ':';

        if (! str_starts_with($content, $prefix)) {
            return false;
        }

        $identifier = trim(substr($content, strlen($prefix)));

        $isValidToken = static fn (string $value): bool => preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value) === 1;
        $isValidDir = static fn (string $value): bool => $value === ''
            || preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*(?:\/[a-z0-9]+(?:-[a-z0-9]+)*)*$/', $value) === 1;

        if (! $isValidToken($type) || ! $isValidToken($identifier) || ! $isValidDir($dir)) {
            return true;
        }

        $relativePath = 'pages/' . $type . '/sections/' . ($dir !== '' ? $dir . '/' : '') . $identifier;
        $viewFile = APPPATH . 'Views/' . $relativePath . '.php';

        if (! is_file($viewFile)) {
            return true;
        }

        section($type, $identifier, $data, $dir);

        return true;
    }
}

if (! function_exists('sections')) {
    function sections(string $page, array $sections = [], array $data = [], string $dir = ''): void
    {
        $dir = trim($dir, '/');

        foreach ($sections as $section) {
            section($page, $section, $data[$section] ?? [], $dir);
        }
    }
}

if (! function_exists('cached_cell')) {
    function cached_cell(string $cell, array $data = [], int $ttl = 300): string
    {
        return view_cell(
            $cell,
            $data,
            ENVIRONMENT === 'production' ? $ttl : 0
        );
    }
}
