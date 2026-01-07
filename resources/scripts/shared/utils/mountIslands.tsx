import React, { Suspense } from 'react';
import { createRoot, Root } from 'react-dom/client';

type CreateElementConfig = {
  element?: keyof HTMLElementTagNameMap;
  id?: string;
  class?: string[];
  attributes?: Record<string, string>;
  insertBefore?: boolean;
};

type BaseIslandConfig<Props extends object = Record<string, unknown>> = {
  Component: React.FC<Props> | React.LazyExoticComponent<React.FC<Props>>;
  propsGetter?: (el: Element) => object;
  suspenseFallback?: React.ReactNode;
};

type Island<Props extends object = Record<string, unknown>> =
  | ({
      selector: string;
      selectorCreate?: never;
    } & BaseIslandConfig<Props>)
  | ({
      selector?: never;
      selectorCreate: CreateElementConfig;
    } & BaseIslandConfig<Props>);

const createDOMElementFromConfig = (config: CreateElementConfig): HTMLElement => {
  const el = document.createElement(config.element || 'div');

  if (config.id) el.id = config.id;
  if (config.class) el.className = config.class.join(' ');
  if (config.attributes) {
    Object.entries(config.attributes).forEach(([key, value]) => {
      el.setAttribute(key, value);
    });
  }

  if (config.insertBefore) {
    document.body.insertBefore(el, document.body.firstChild);
  } else {
    document.body.appendChild(el);
  }

  return el;
};

const mountIslands = (islands: Island[]) => {
  islands.forEach(({ selector, selectorCreate, Component, propsGetter, suspenseFallback }) => {
    const elements: Element[] = [];
    if (selector) {
      elements.push(...document.querySelectorAll(selector));
    }
    if (selectorCreate) {
      const createdElement = createDOMElementFromConfig(selectorCreate);
      elements.push(createdElement);
    }

    elements.forEach((container) => {
      const props = propsGetter ? propsGetter(container) : {};
      const root: Root = createRoot(container);

      root.render(
        <Suspense fallback={suspenseFallback || null}>
          <Component {...props} />
        </Suspense>
      );

      const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          mutation.removedNodes.forEach((node) => {
            if (node === container) {
              root.unmount();
              observer.disconnect();
            }
          });
        });
      });

      if (container.parentNode) {
        observer.observe(container.parentNode, { childList: true });
      }
    });
  });
};

export default mountIslands;
