document.addEventListener('DOMContentLoaded', function () {
  var book = document.querySelector('.book');
  if (!book) return;

  var pages = book.querySelectorAll('.book-page');
  var total = pages.length;
  var current = 0;

  var prevBtn = book.querySelector('.btn-prev');
  var nextBtn = book.querySelector('.btn-next');
  var currentEl = book.querySelector('.current');
  var totalEl = book.querySelector('.total');
  if (totalEl) totalEl.textContent = total;

  var animating = false;

  function setVisible(index) {
    pages.forEach(function (p, i) {
      p.style.display = (i === index) ? 'block' : 'none';
      p.setAttribute('aria-hidden', (i === index) ? 'false' : 'true');
      p.style.transform = 'none';
    });
    current = index;
    if (currentEl) currentEl.textContent = (current + 1);
  }

  function updateUrlForPage(index) {
    try {
      var pageNum = index + 1;
      var u = new URL(window.location.href);
      u.searchParams.set('page', pageNum);
      history.replaceState({page: pageNum}, '', u.toString());
    } catch (e) {
      // fallback: set hash
      location.hash = 'page=' + (index + 1);
    }
  }

  function flipTo(nextIndex, direction) {
    if (animating) return;
    if (nextIndex < 0) nextIndex = total - 1;
    if (nextIndex >= total) nextIndex = 0;
    if (nextIndex === current) return;
    animating = true;
    var from = pages[current];
    var to = pages[nextIndex];

    // prepare
    to.style.display = 'block';
    to.style.transform = (direction === 'next') ? 'rotateY(180deg)' : 'rotateY(-180deg)';
    to.setAttribute('aria-hidden', 'false');

    // trigger reflow
    void to.offsetWidth;

    // animate
    if (direction === 'next') {
      from.style.transform = 'rotateY(-180deg)';
      to.style.transform = 'rotateY(0deg)';
    } else {
      from.style.transform = 'rotateY(180deg)';
      to.style.transform = 'rotateY(0deg)';
    }

    // disable controls
    if (prevBtn) prevBtn.disabled = true;
    if (nextBtn) nextBtn.disabled = true;

    // after animation
    setTimeout(function () {
      pages.forEach(function (p, i) {
        if (i !== nextIndex) {
          p.style.display = 'none';
          p.setAttribute('aria-hidden', 'true');
          p.style.transform = 'none';
        }
      });
      current = nextIndex;
      if (currentEl) currentEl.textContent = (current + 1);
      animating = false;
      if (prevBtn) prevBtn.disabled = false;
      if (nextBtn) nextBtn.disabled = false;
      // update URL to reflect current page
      updateUrlForPage(current);
    }, 720); // slightly longer than CSS transition
  }

  prevBtn && prevBtn.addEventListener('click', function () { flipTo(current - 1, 'prev'); });
  nextBtn && nextBtn.addEventListener('click', function () { flipTo(current + 1, 'next'); });

  // Keyboard support (use flipTo)
  document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft') flipTo(current - 1, 'prev');
    if (e.key === 'ArrowRight') flipTo(current + 1, 'next');
  });

  // Touch support (simple swipe)
  var startX = null;
  book.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; });
  book.addEventListener('touchend', function (e) {
    if (startX === null) return;
    var endX = e.changedTouches[0].clientX;
    var diff = endX - startX;
    if (diff > 40) flipTo(current - 1, 'prev');
    if (diff < -40) flipTo(current + 1, 'next');
    startX = null;
  });



  // initialize
  // determine initial page from URL (?page= or #page= or #5)
  function readPageFromUrl() {
    try {
      var u = new URL(window.location.href);
      var p = u.searchParams.get('page');
      if (p) return Math.max(0, Math.min(total - 1, parseInt(p, 10) - 1));
    } catch (e) {}
    // fallback: hash
    if (location.hash) {
      var h = location.hash.replace(/^#/, '');
      var m = h.match(/page=(\d+)/);
      if (m) return Math.max(0, Math.min(total - 1, parseInt(m[1], 10) - 1));
      var m2 = h.match(/^(\d+)$/);
      if (m2) return Math.max(0, Math.min(total - 1, parseInt(m2[1], 10) - 1));
    }
    return 0;
  }

  var initial = readPageFromUrl();
  setVisible(initial);
  updateUrlForPage(initial);

  // handle back/forward
  window.addEventListener('popstate', function (e) {
    var idx = 0;
    try {
      var u = new URL(window.location.href);
      var p = u.searchParams.get('page');
      if (p) idx = Math.max(0, Math.min(total - 1, parseInt(p, 10) - 1));
    } catch (err) {
      if (location.hash) {
        var m = location.hash.replace(/^#/, '').match(/page=(\d+)/);
        if (m) idx = Math.max(0, Math.min(total - 1, parseInt(m[1], 10) - 1));
      }
    }
    setVisible(idx);
  });

  // Pager links: wire clicks to flipTo; support ctrl/cmd or middle click to open dedicated page in modal
  var pagerLinks = document.querySelectorAll('.pager-link');
  pagerLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      var page = parseInt(link.getAttribute('data-page'), 10) - 1;
      // middle click or ctrl/cmd => open dedicated page in new tab
      if (e.ctrlKey || e.metaKey || e.button === 1) {
        // allow default behaviour (link navigation)
        return;
      }
      e.preventDefault();
      // If user holds Shift, open in modal instead of flipping
      if (e.shiftKey) {
        // open modal via AJAX
        var idLink = link.getAttribute('href').replace(/^.*show\//, '');
        var url = '/livredor/show/' + page + '?ajax=1';
        fetch(url, { credentials: 'same-origin' }).then(function(r){ return r.text(); }).then(function(html){
          var modal = document.getElementById('livredor-modal');
          if (!modal) return;
          modal.querySelector('.livredor-modal-content').innerHTML = html;
          modal.style.display = 'flex';
          history.pushState({modal:true}, '', '/livredor?page=' + (page + 1));
        });
        return;
      }
      flipTo(page, (page > current) ? 'next' : 'prev');
    });
  });

  // update active pager link
  function refreshPager() {
    pagerLinks.forEach(function(link) {
      link.classList.toggle('active', (parseInt(link.getAttribute('data-page'), 10) - 1) === current);
    });
  }
  // call refreshPager when visible changes (hook into setVisible/flipTo)
  var originalSetVisible = setVisible;
  setVisible = function(index) {
    originalSetVisible(index);
    try { updateUrlForPage(index); } catch(e) {}
    refreshPager();
  };
});
