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

  // TOC links: jump to page
  var tocLinks = document.querySelectorAll('.toc-link');
  tocLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var target = parseInt(link.getAttribute('data-target-page'), 10) - 1;
      if (isNaN(target)) return;
      var dir = (target > current) ? 'next' : 'prev';
      flipTo(target, dir);
    });
  });

  // initialize
  setVisible(0);
});
