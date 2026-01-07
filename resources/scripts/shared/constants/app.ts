type AppAssets = Readonly<{
  baseUrl: string;
  imagesBaseUrl: string;
  uploadsBaseUrl: string;

  images: (path: string) => string;
  uploads: (path: string) => string;
  asset: (path: string) => string;
}>;

type AppConfig = Readonly<{
  env: Readonly<{
    apiUrl: string;
    apiAuthorizationKey: string;
    openTicketLink: string;
  }>;
  assets: AppAssets;
}>;

function requireEnv(name: keyof ImportMetaEnv): string {
  const value = import.meta.env[name].trim();
  if (typeof value !== 'string' || value === '') {
    throw new Error(`[env] Missing ${name}`);
  }

  return value.trim();
}

function normalizeBaseUrl(url: string): string {
  return url.endsWith('/') ? url.slice(0, -1) : url;
}

function joinUrl(base: string, path: string): string {
  const b = normalizeBaseUrl(base);
  const p = path.startsWith('/') ? path : `/${path}`;
  return `${b}${p}`;
}

const apiUrl = normalizeBaseUrl(requireEnv('VITE_API_URL'));

const assetsBaseUrl = normalizeBaseUrl(requireEnv('VITE_BASE_ASSETS'));
const imagesBaseUrl = normalizeBaseUrl(requireEnv('VITE_BASE_IMAGES'));
const uploadsBaseUrl = normalizeBaseUrl(requireEnv('VITE_BASE_UPLOADS'));

export const app: AppConfig = Object.freeze({
  env: Object.freeze({
    apiUrl,
    apiAuthorizationKey: requireEnv('VITE_API_AUTHORIZATION_KEY'),
    openTicketLink: requireEnv('VITE_OPEN_TICKET_LINK'),
  }),
  assets: Object.freeze({
    baseUrl: assetsBaseUrl,
    imagesBaseUrl,
    uploadsBaseUrl,

    asset: (path: string) => joinUrl(assetsBaseUrl, path),
    images: (path: string) => joinUrl(imagesBaseUrl, path),
    uploads: (path: string) => joinUrl(uploadsBaseUrl, path),
  }),
});
