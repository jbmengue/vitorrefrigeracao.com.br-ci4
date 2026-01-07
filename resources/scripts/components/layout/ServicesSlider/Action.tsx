import { JSX } from 'react';

import { app } from '@/shared/constants/app';
import { TechnicalServices } from '@/shared/types';

interface Props {
  service: TechnicalServices;
}

type ActionRenderer = (service: TechnicalServices) => JSX.Element | null;

export const Action = ({ service }: Props): JSX.Element | null => {
  const getLabel = (service: TechnicalServices) => service.actionLabel?.trim() || 'Abra um chamado';

  const getVariant = (service: TechnicalServices) => service.actionVariant?.trim() || 'primary';

  const renderLink = (href: string, service: TechnicalServices) => (
    <a href={href} className={`btn-${getVariant(service)} mx-auto`}>
      {getLabel(service)}
    </a>
  );

  const actionRenderers: Record<string, ActionRenderer> = {
    open_ticket: (service) => renderLink(app.env.openTicketLink, service),
    link: (service) => (service.actionLink ? renderLink(service.actionLink, service) : null),
    whatsapp: () => null,
  };

  return actionRenderers[service.actionType ?? '']?.(service) ?? null;
};
