import axios from 'axios';

import { app } from '@/shared/constants/app';

const baseAPI = app.env.apiUrl;
const apiAuthorizationKey = app.env.apiAuthorizationKey;

if (!baseAPI) {
  throw new Error('[env] Missing VITE_API_URL');
}

if (!apiAuthorizationKey) {
  throw new Error('[env] Missing VITE_API_AUTHORIZATION_KEY');
}

export const api = axios.create({
  baseURL: baseAPI,
  headers: {
    'Content-Type': 'application/json',
    'X-Api-Authorization': apiAuthorizationKey,
  },
});
