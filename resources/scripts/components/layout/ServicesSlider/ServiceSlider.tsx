import type SwiperType from 'swiper';

import 'swiper/css';
import { IconChevronLeft, IconChevronRight } from '@tabler/icons-react';
import AOS from 'aos';
import { useEffect, useRef, useState } from 'react';
import { Navigation } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import { NavigationOptions } from 'swiper/types';

import { getTechnicalServices } from '@/services/api/technical-services';
import { app } from '@/shared/constants/app';
import { TechnicalServices } from '@/shared/types';

import { Action } from './';

const ServicesSlider = () => {
  const [services, setServices] = useState<TechnicalServices[]>([]);
  const swiperRef = useRef<SwiperType | null>(null);
  const prevRef = useRef<HTMLButtonElement | null>(null);
  const nextRef = useRef<HTMLButtonElement | null>(null);

  useEffect(() => {
    (async () => {
      const data = await getTechnicalServices();
      setServices(data);
    })();
  }, []);

  useEffect(() => {
    const swiper = swiperRef.current;
    if (!swiper) return;
    if (!prevRef.current || !nextRef.current) return;

    const nav = swiper.params.navigation;
    const navOptions: NavigationOptions = typeof nav === 'object' && nav ? nav : {};

    navOptions.prevEl = prevRef.current;
    navOptions.nextEl = nextRef.current;

    swiper.params.navigation = navOptions;

    swiper.navigation.destroy();
    swiper.navigation.init();
    swiper.navigation.update();
    AOS.refreshHard();
  }, [services]);

  return (
    <div className="relative min-h-[540px]">
      <Swiper
        modules={[Navigation]}
        spaceBetween={25}
        slidesPerView={3.5}
        onSwiper={(swiper) => {
          swiperRef.current = swiper;
        }}
        breakpoints={{
          0: {
            slidesPerView: 1,
            spaceBetween: 14,
          },
          480: {
            slidesPerView: 1,
            spaceBetween: 16,
          },
          640: {
            slidesPerView: 2.2,
            spaceBetween: 18,
          },
          1024: {
            slidesPerView: 3.5,
            spaceBetween: 22,
          },
          1280: {
            slidesPerView: 3.7,
            spaceBetween: 25,
          },
        }}
        className="!px-2 !py-4"
      >
        {services.map((service) => {
          return (
            <SwiperSlide key={service.id} className="!h-auto">
              <div className="relative h-full w-full rounded-2xl bg-white/50 px-8 pt-6 pb-20 shadow-[-4px_-5px_9px_rgba(0,0,0,0.15)] transition-transform duration-700 hover:scale-102">
                <img
                  alt={`Serviços: ${service.title}`}
                  title={`Serviços: ${service.title}`}
                  src={app.assets.uploads(`/images/large/${service.fileName}`)}
                  loading="lazy"
                  decoding="async"
                  className="aspect-[5/4] w-full rounded-2xl object-cover"
                />
                <div className="px-5 py-8 text-center">
                  <h3 className="text-primary m-0 text-center text-2xl/7 capitalize">
                    {service.title}
                  </h3>
                  <span className="my-2 block text-base">{service.description}</span>
                  <span className="block text-sm text-gray-500">{service.tagline}</span>
                </div>
                <div className="absolute bottom-10 left-0 w-full px-5 xl:px-25">
                  <Action service={service} />
                </div>
              </div>
            </SwiperSlide>
          );
        })}
      </Swiper>

      <div className="flex items-center justify-center gap-x-2 pt-10 pb-20">
        <button
          ref={prevRef}
          type="button"
          aria-label="Anterior"
          className="flex h-10 w-10 items-center justify-center rounded-[50%] bg-black text-5xl/1 text-white"
        >
          <IconChevronLeft stroke={2} />
        </button>

        <button
          ref={nextRef}
          type="button"
          aria-label="Próximo"
          className="flex h-10 w-10 items-center justify-center rounded-[50%] bg-black text-5xl/1 text-white"
        >
          <IconChevronRight stroke={2} />
        </button>
      </div>
    </div>
  );
};

export default ServicesSlider;
