import { TechnicalServices } from '@/shared/types';

import { api } from '../api';

export async function getTechnicalServices(): Promise<TechnicalServices[]> {
  const { data } = await api.get<TechnicalServices[]>('/technical-services');
  return data;
}
