export interface TechnicalServices {
  id: number;
  title: string;
  description: string;
  tagline: string;
  fileName: string | null;
  actionType?: 'open_ticket' | 'link' | 'whatsapp';
  actionVariant?: 'primary' | 'secondary';
  actionLabel?: string;
  actionLink?: string;
}
