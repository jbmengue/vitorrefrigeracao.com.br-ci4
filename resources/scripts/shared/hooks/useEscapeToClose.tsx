import { useEffect } from 'react';

export function useEscapeToClose(onClose: () => void, isActive = true) {
  useEffect(() => {
    if (!isActive) return;

    const handleEsc = (e: KeyboardEvent) => {
      if (e.key === 'Escape') {
        onClose();
      }
    };

    document.addEventListener('keydown', handleEsc);
    return () => document.removeEventListener('keydown', handleEsc);
  }, [onClose, isActive]);
}
