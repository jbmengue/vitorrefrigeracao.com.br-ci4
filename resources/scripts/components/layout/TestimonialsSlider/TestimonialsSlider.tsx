import type SwiperType from 'swiper';

import 'swiper/css';
import 'swiper/css/pagination';
import AOS from 'aos';
import { useEffect, useRef, useState } from 'react';
import { Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import { NavigationOptions } from 'swiper/types';

import { PostService } from '@/services/api/post';
import { app } from '@/shared/constants/app';
import { Post } from '@/shared/types';

const TestimonialSlider = () => {
  const [posts, setPosts] = useState<Post[]>([]);
  const swiperRef = useRef<SwiperType | null>(null);
  const prevRef = useRef<HTMLButtonElement | null>(null);
  const nextRef = useRef<HTMLButtonElement | null>(null);

  useEffect(() => {
    (async () => {
      const data = await PostService.getByType('testimonial');
      setPosts(data);
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
  }, [posts]);

  return (
    <div className="relative min-h-[420px]">
      <Swiper
        modules={[Pagination]}
        spaceBetween={24}
        grabCursor={true}
        pagination={{
          clickable: true,
        }}
        slidesPerView={4.5}
        breakpoints={{
          0: {
            slidesPerView: 1,
          },
          480: {
            slidesPerView: 1,
          },
          640: {
            slidesPerView: 2.2,
          },
          1024: {
            slidesPerView: 2.5,
          },
          1100: {
            slidesPerView: 3.5,
          },
          1580: {
            slidesPerView: 4.5,
          },
        }}
        className="swiper-testimonials !px-2 !pt-4 !pb-20"
      >
        {posts.map((post) => {
          return (
            <SwiperSlide key={post.id} className="!h-auto">
              <div className="relative h-full w-full rounded-2xl bg-gray-100 px-8 pt-10 pb-20">
                <span className="absolute top-2 left-10 text-9xl font-bold">“</span>
                <div className="border-primary mx-auto flex h-23 w-23 items-center justify-center rounded-[50%] border-4 bg-white">
                  <img
                    alt={`Depoimento: ${post.title}`}
                    title={`Depoimento: ${post.title}`}
                    src={app.assets.images(`logos/${post.reference}/colorful.png`)}
                    width={56}
                    height={56}
                    loading="lazy"
                    decoding="async"
                    className="h-14 w-14 object-contain"
                  />
                </div>
                <div className="px-15 pt-8 text-center">
                  <h3 className="text-dark text-center text-xl capitalize">{post.title}</h3>
                  <div>
                    <p className="m-0">&quot;{post.content}&quot;</p>
                  </div>
                </div>
                <div className="absolute bottom-10 left-0 w-full">
                  <img
                    alt=""
                    title=""
                    src={app.assets.images('stars.png')}
                    width={90}
                    height={16}
                    loading="lazy"
                    decoding="async"
                    className="mx-auto"
                  />
                </div>
              </div>
            </SwiperSlide>
          );
        })}
      </Swiper>
    </div>
  );
};

export default TestimonialSlider;
