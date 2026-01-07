<?php
if (!function_exists("vite_is_dev")) {
    function vite_is_dev(): bool
    {
        return env("CI_ENVIRONMENT") !== "production";
    }
}

if (!function_exists("vite_dev_server")) {
    function vite_dev_server(): string
    {
        return "http://localhost:5173";
    }
}

/**
 * Carrega a entry (dev direto com preamble; prod via manifest).
 */
if (!function_exists("vite_entry")) {
    function vite_entry(string $entry = "resources/scripts/main.tsx"): string
    {
        // AMBIENTE DE DESENVOLVIMENTO
        if (vite_is_dev()) {
            $dev = rtrim(vite_dev_server(), "/");

            // Preamble do React Refresh (recomendado quando o HTML não é servido pelo Vite)
            $reactRefresh = <<<'HTML'
<script type="module">
    import RefreshRuntime from "%DEV%/@react-refresh";
    RefreshRuntime.injectIntoGlobalHook(window);
    window.$RefreshReg$ = () => {};
    window.$RefreshSig$ = () => (type) => type;
    window.__vite_plugin_react_preamble_installed__ = true;
</script>
HTML;
            $reactRefresh = str_replace('%DEV%', $dev, $reactRefresh);

            // Cliente do Vite (HMR)
            $viteClient = '<script type="module" src="' . $dev . '/@vite/client"></script>';

            // Entry principal
            $entryScript = '<script type="module" src="' . $dev . '/' . ltrim($entry, '/') . '"></script>';

            return $reactRefresh . "\n" . $viteClient . "\n" . $entryScript;
        }

        // AMBIENTE DE PRODUÇÃO
        $manifestPath = FCPATH . "assets/manifest.json";
        if (!is_file($manifestPath)) {
            return "<!-- vite manifest not found -->";
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $key = $entry;

        if (!isset($manifest[$key])) {
            foreach ($manifest as $k => $item) {
                if (str_ends_with($k, basename($entry))) {
                    $key = $k;
                    break;
                }
            }
            if (!isset($manifest[$key])) {
                return "<!-- vite entry not found in manifest -->";
            }
        }

        $tags = [];

        if (!empty($manifest[$key]["css"])) {
            foreach ($manifest[$key]["css"] as $css) {
                $tags[] = '<link rel="stylesheet" href="/assets/' . ltrim($css, "/") . '">';
            }
        }

        if (!empty($manifest[$key]["file"])) {
            $tags[] = '<script type="module" src="/assets/' . ltrim($manifest[$key]["file"], "/") . '"></script>';
        }

        return implode("\n", $tags);
    }
}
