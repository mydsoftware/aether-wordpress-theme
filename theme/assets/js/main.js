/**
 * اسکریپت اصلی تم Aether
 */
(function () {
  'use strict';

  const Aether = {
    init() {
      this.mobileMenu();
      this.stickyHeader();
      this.darkMode();
      this.searchToggle();
      this.smoothScroll();
    },

    mobileMenu() {
      const toggle = document.querySelector('[data-aether-toggle="mobile-menu"]');
      const menu = document.getElementById('aether-mobile-menu');
      if (!toggle || !menu) return;

      const open = () => {
        menu.hidden = false;
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => menu.classList.add('is-open'));
      };

      const close = () => {
        menu.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        setTimeout(() => { menu.hidden = true; }, 300);
      };

      toggle.addEventListener('click', open);
      menu.querySelectorAll('[data-aether-close="mobile-menu"]').forEach((el) => {
        el.addEventListener('click', close);
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('is-open')) {
          close();
        }
      });
    },

    stickyHeader() {
      const header = document.getElementById('aether-header');
      if (!header || !header.classList.contains('aether-header--sticky')) return;

      const onScroll = () => {
        if (window.pageYOffset > 100) {
          header.classList.add('is-scrolled');
        } else {
          header.classList.remove('is-scrolled');
        }
      };

      window.addEventListener('scroll', onScroll, { passive: true });
    },

    darkMode() {
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      mediaQuery.addEventListener('change', (e) => {
        const mode = window.aetherData?.darkMode || 'auto';
        if (mode === 'auto') {
          document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
        }
      });
    },

    searchToggle() {
      const toggle = document.querySelector('[data-aether-toggle="search"]');
      if (!toggle) return;
    },

    smoothScroll() {
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', function (e) {
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    },
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => Aether.init());
  } else {
    Aether.init();
  }

  window.Aether = Aether;
})();
