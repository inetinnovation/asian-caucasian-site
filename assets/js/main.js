// ─── NAV SCROLL ───
const nav = document.getElementById('main-nav');
if (nav) {
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
    const bt = document.getElementById('back-top');
    if (bt) bt.classList.toggle('show', window.scrollY > 400);
  }, { passive: true });
}

// ─── MOBILE NAV ───
const navToggle = document.getElementById('nav-toggle');
const navLinks  = document.getElementById('nav-links');
if (navToggle && navLinks) {
  navToggle.addEventListener('click', () => navLinks.classList.toggle('open'));
}
function closeNav() { if (navLinks) navLinks.classList.remove('open'); }
window.closeNav = closeNav;

// ─── SCROLL REVEAL ───
const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
if (revealEls.length) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });
  revealEls.forEach(el => observer.observe(el));
}

// ─── HERO IMMEDIATE REVEAL ───
window.addEventListener('load', () => {
  document.querySelectorAll('#hero .reveal').forEach(el => {
    setTimeout(() => el.classList.add('visible'), 100);
  });
});

// ─── AUDIO PLAYER ───
(function() {
  const listEl = document.getElementById('track-list');
  if (!listEl) return;

  const tracks = Array.isArray(window.acTracks) ? window.acTracks : [];
  const albumNames = (window.acAlbumNames && typeof window.acAlbumNames === 'object') ? window.acAlbumNames : {};

  if (!tracks.length) {
    listEl.innerHTML = '<li class="track-item" style="opacity:0.6">No tracks yet. Add some in the WordPress admin under Tracks.</li>';
    return;
  }

  const audio = new Audio();
  audio.volume = 0.8;
  audio.preload = "none";
  let current = -1;
  let filtered = [...tracks];
  let activeFilter = "all";

  const playBtn     = document.getElementById('play-btn');
  const prevBtn     = document.getElementById('prev-btn');
  const nextBtn     = document.getElementById('next-btn');
  const npTitle     = document.getElementById('np-title');
  const npAlbum     = document.getElementById('np-album');
  const timeCur     = document.getElementById('time-current');
  const timeTotal   = document.getElementById('time-total');
  const progressBar = document.getElementById('progress-bar');
  const progressFill= document.getElementById('progress-fill');
  const volSlider   = document.getElementById('vol-slider');
  const iconPlay    = playBtn ? playBtn.querySelector('.icon-play') : null;
  const iconPause   = playBtn ? playBtn.querySelector('.icon-pause') : null;

  function fmt(s) {
    if (isNaN(s)) return '0:00';
    const m = Math.floor(s / 60);
    const sec = Math.floor(s % 60);
    return m + ':' + (sec < 10 ? '0' : '') + sec;
  }

  function renderList() {
    listEl.innerHTML = '';
    filtered.forEach((t, i) => {
      const li = document.createElement('li');
      li.className = 'track-item' + (tracks.indexOf(t) === current ? ' active' : '');
      const albumLabel = albumNames[t.album] || '';
      li.innerHTML =
        '<span class="track-num"><span class="num-text">' + (i + 1) + '</span><svg class="num-play" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></span>' +
        '<span class="track-name"></span>' +
        '<span class="track-album-tag"></span>' +
        '<span class="track-duration" data-src=""></span>';
      li.querySelector('.track-name').textContent = t.title;
      li.querySelector('.track-album-tag').textContent = albumLabel;
      li.querySelector('.track-duration').dataset.src = t.file;
      li.addEventListener('click', () => loadTrack(tracks.indexOf(t), true));
      listEl.appendChild(li);
    });
    listEl.querySelectorAll('.track-duration[data-src]').forEach(el => {
      const a = new Audio();
      a.preload = 'metadata';
      a.src = el.dataset.src;
      a.addEventListener('loadedmetadata', () => { el.textContent = fmt(a.duration); });
    });
  }

  function loadTrack(idx, autoplay) {
    current = idx;
    const t = tracks[current];
    audio.src = t.file;
    if (npTitle) npTitle.textContent = t.title;
    if (npAlbum) npAlbum.textContent = albumNames[t.album] || '';
    updateActive();
    if (autoplay) audio.play();
  }

  function updateActive() {
    listEl.querySelectorAll('.track-item').forEach((li, i) => {
      li.classList.toggle('active', tracks.indexOf(filtered[i]) === current);
    });
    updatePlayIcon();
  }

  function updatePlayIcon() {
    if (!iconPlay || !iconPause) return;
    const playing = !audio.paused;
    iconPlay.style.display = playing ? 'none' : '';
    iconPause.style.display = playing ? '' : 'none';
  }

  if (playBtn) playBtn.addEventListener('click', () => {
    if (current < 0) { loadTrack(tracks.indexOf(filtered[0]), true); return; }
    audio.paused ? audio.play() : audio.pause();
  });

  if (prevBtn) prevBtn.addEventListener('click', () => {
    if (current < 0) return;
    const fi = filtered.indexOf(tracks[current]);
    const prev = fi > 0 ? tracks.indexOf(filtered[fi - 1]) : tracks.indexOf(filtered[filtered.length - 1]);
    loadTrack(prev, !audio.paused);
  });

  if (nextBtn) nextBtn.addEventListener('click', () => {
    if (current < 0) return;
    const fi = filtered.indexOf(tracks[current]);
    const next = fi < filtered.length - 1 ? tracks.indexOf(filtered[fi + 1]) : tracks.indexOf(filtered[0]);
    loadTrack(next, !audio.paused);
  });

  audio.addEventListener('timeupdate', () => {
    if (timeCur) timeCur.textContent = fmt(audio.currentTime);
    if (progressFill && audio.duration) {
      progressFill.style.width = (audio.currentTime / audio.duration * 100) + '%';
    }
  });
  audio.addEventListener('loadedmetadata', () => { if (timeTotal) timeTotal.textContent = fmt(audio.duration); });
  audio.addEventListener('ended', () => { if (nextBtn) nextBtn.click(); });
  audio.addEventListener('play', updatePlayIcon);
  audio.addEventListener('pause', updatePlayIcon);

  if (progressBar) progressBar.addEventListener('click', (e) => {
    if (!audio.duration) return;
    audio.currentTime = (e.offsetX / progressBar.offsetWidth) * audio.duration;
  });

  if (volSlider) volSlider.addEventListener('input', () => { audio.volume = volSlider.value; });

  document.querySelectorAll('.album-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.album-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      activeFilter = tab.dataset.filter;
      filtered = activeFilter === 'all' ? [...tracks] : tracks.filter(t => t.album === activeFilter);
      renderList();
    });
  });

  renderList();
})();
