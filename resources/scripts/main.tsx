import '../css/app.css';
import 'aos/dist/aos.css';
import AOS from 'aos';
import React from 'react';

import { refreshAosStabilized } from '@/shared/utils/aosRefresh';
import mountIslands from '@/shared/utils/mountIslands';

const OffcanvasMenu = React.lazy(() => import('@/components/layout/OffcanvasMenu'));
const ServicesSlider = React.lazy(() => import('@/components/layout/ServicesSlider'));
const TestimonialSlider = React.lazy(() => import('@/components/layout/TestimonialsSlider'));

AOS.init({
  duration: 700,
  easing: 'ease-out',
  once: true,
  offset: 80,
  disableMutationObserver: false,
});

mountIslands([
  {
    selectorCreate: {
      class: ['overlay-offcanvas-menu'],
    },
    Component: OffcanvasMenu,
  },
  {
    selector: '.services-slider',
    Component: ServicesSlider,
  },
  {
    selector: '.testimonials-slider',
    Component: TestimonialSlider,
  },
]);

refreshAosStabilized();
