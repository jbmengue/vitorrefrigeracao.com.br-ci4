import AOS from 'aos';

export function refreshAosStabilized(): void {
  requestAnimationFrame(() => AOS.refresh());
  window.setTimeout(() => AOS.refreshHard(), 120);
  window.addEventListener(
    'load',
    () => {
      AOS.refreshHard();
    },
    { once: true }
  );
}
