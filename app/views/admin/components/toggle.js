 const mobileMenuBtn = document.getElementById('mobile-menu-btn');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');

      mobileMenuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        overlay.classList.toggle('hidden');
      });

      overlay?.addEventListener('click', () => {
        sidebar.classList.add('hidden');
        overlay.classList.add('hidden');
      });