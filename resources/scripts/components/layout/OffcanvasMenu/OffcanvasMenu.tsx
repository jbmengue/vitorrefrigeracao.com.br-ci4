import { useState, useEffect } from 'react';

import { useEscapeToClose } from '@/shared/hooks/useEscapeToClose';

const OffcanvasMenu = () => {
  const [open, setOpen] = useState(false);
  const offcanvas = document.getElementById('navbarOffcanvas');

  const showMenu = () => {
    setOpen(true);
    if (offcanvas) {
      offcanvas.classList.add('max-xl:translate-x-0');
      offcanvas.classList.remove('max-xl:translate-x-full');
    }
  };

  const hideMenu = () => {
    setOpen(false);
    if (offcanvas) {
      offcanvas.classList.remove('max-xl:translate-x-0');
      offcanvas.classList.add('max-xl:translate-x-full');
    }
  };

  const handleOverlayClick = () => {
    hideMenu();
  };

  useEffect(() => {
    const btn = document.getElementById('navbarOffcanvasToggle');
    if (!btn) return;
    btn.addEventListener('click', showMenu);
    return () => {
      btn.removeEventListener('click', showMenu);
    };
  }, []);

  useEscapeToClose(() => hideMenu());

  return (
    <>
      {open && (
        <div
          className="fixed inset-0 z-40 bg-black/75"
          onClick={handleOverlayClick}
          aria-label="Fechar menu"
        />
      )}
    </>
  );
};

export default OffcanvasMenu;
