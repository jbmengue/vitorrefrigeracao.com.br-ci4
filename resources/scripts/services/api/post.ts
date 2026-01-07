import { Post } from '@/shared/types';

import { api } from '../api';

export class PostService {
  private static readonly route = 'post';

  static async getByType(type: string): Promise<Post[]> {
    const { data } = await api.get<Post[]>(`/${this.route}`, {
      params: { type },
    });

    return data;
  }
}
