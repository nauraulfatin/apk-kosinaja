{{-- resources/views/partials/chat-widget.blade.php --}}
<style>
  .kw, .kw * { box-sizing: border-box; }
  .kw {
    --kw-dark: #1F3A2C;
    --kw-mid: #284535;
    --kw-cta: #5F8568;
    --kw-light: #7CA385;
    --kw-cream: #F5F4F0;
    --kw-cream-2: #EEF4EF;
    --kw-text: #1c2b22;
    --kw-muted: #6b7f70;
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 9999;
    font-family: inherit;
  }

  /* Tombol pembuka */
  .kw-fab {
    width: 58px; height: 58px;
    border: 0; border-radius: 50%;
    background: var(--kw-mid);
    color: #fff;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 20px rgba(31, 58, 44, .35);
    transition: background .2s, transform .2s;
  }
  .kw-fab:hover { background: var(--kw-cta); transform: scale(1.05); }
  .kw-fab:focus-visible, .kw-btn:focus-visible, .kw-chip:focus-visible,
  .kw-input:focus-visible { outline: 3px solid var(--kw-light); outline-offset: 2px; }
  .kw-fab svg { width: 26px; height: 26px; }
  .kw.is-open .kw-fab { display: none; }

  /* Jendela */
  .kw-panel {
    display: none;
    flex-direction: column;
    width: 370px;
    height: 540px;
    max-height: calc(100vh - 40px);
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 16px 48px rgba(31, 58, 44, .28);
    border: 1px solid #dfe8e1;
  }
  .kw.is-open .kw-panel { display: flex; animation: kw-pop .22s ease-out; }
  @keyframes kw-pop { from { opacity: 0; transform: translateY(12px) scale(.97); } to { opacity: 1; transform: none; } }

  /* Header */
  .kw-head {
    background: var(--kw-mid);
    color: #fff;
    padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
  }
  .kw-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--kw-cta);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .kw-avatar svg { width: 20px; height: 20px; }
  .kw-title { font-weight: 700; font-size: .98rem; line-height: 1.2; }
  .kw-sub { font-size: .76rem; color: #c9dccd; display: flex; align-items: center; gap: 6px; margin-top: 2px; }
  .kw-dot { width: 7px; height: 7px; border-radius: 50%; background: #8fe0a3; }
  .kw-head-actions { margin-left: auto; display: flex; gap: 4px; }
  .kw-btn {
    width: 32px; height: 32px; border: 0; border-radius: 8px;
    background: transparent; color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
  }
  .kw-btn:hover { background: rgba(255, 255, 255, .14); }
  .kw-btn svg { width: 18px; height: 18px; }

  /* Pesan */
  .kw-body {
    flex: 1;
    overflow-y: auto;
    padding: 16px 14px;
    background: var(--kw-cream);
    display: flex; flex-direction: column; gap: 10px;
    scroll-behavior: smooth;
  }
  .kw-msg {
    max-width: 85%;
    padding: 10px 13px;
    font-size: .9rem;
    line-height: 1.5;
    white-space: pre-wrap;
    word-wrap: break-word;
    color: var(--kw-text);
  }
  .kw-msg.bot {
    align-self: flex-start;
    background: #fff;
    border: 1px solid #e3ebe5;
    border-radius: 14px 14px 14px 4px;
  }
  .kw-msg.user {
    align-self: flex-end;
    background: var(--kw-cta);
    color: #fff;
    border-radius: 14px 14px 4px 14px;
  }
  .kw-msg.error {
    background: #fdf1ef; border-color: #f0c9c3; color: #8a2f22;
  }
  .kw-msg a { color: var(--kw-mid); font-weight: 600; }
  .kw-msg.user a { color: #fff; }

  /* Saran cepat */
  .kw-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 2px; }
  .kw-chip {
    border: 1px solid var(--kw-cta);
    background: #fff;
    color: var(--kw-mid);
    padding: 7px 12px;
    border-radius: 999px;
    font-size: .8rem;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s, color .15s;
  }
  .kw-chip:hover { background: var(--kw-cta); color: #fff; }

  /* Indikator mengetik */
  .kw-typing { display: inline-flex; gap: 4px; padding: 14px 16px; }
  .kw-typing span {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--kw-light);
    animation: kw-bounce 1.1s infinite ease-in-out;
  }
  .kw-typing span:nth-child(2) { animation-delay: .15s; }
  .kw-typing span:nth-child(3) { animation-delay: .3s; }
  @keyframes kw-bounce { 0%, 80%, 100% { transform: translateY(0); opacity: .5; } 40% { transform: translateY(-5px); opacity: 1; } }

  /* Input */
  .kw-form {
    display: flex; gap: 8px; align-items: flex-end;
    padding: 10px 12px;
    background: #fff;
    border-top: 1px solid #e3ebe5;
  }
  .kw-input {
    flex: 1;
    resize: none;
    border: 1px solid #cfdcd2;
    border-radius: 12px;
    padding: 10px 12px;
    font: inherit;
    font-size: .9rem;
    line-height: 1.4;
    max-height: 96px;
    background: var(--kw-cream-2);
    color: var(--kw-text);
  }
  .kw-input::placeholder { color: var(--kw-muted); }
  .kw-send {
    width: 40px; height: 40px; flex-shrink: 0;
    border: 0; border-radius: 12px;
    background: var(--kw-mid); color: #fff; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
  }
  .kw-send:hover:not(:disabled) { background: var(--kw-cta); }
  .kw-send:disabled { opacity: .5; cursor: not-allowed; }
  .kw-send svg { width: 18px; height: 18px; }
  .kw-foot { text-align: center; font-size: .68rem; color: var(--kw-muted); padding: 0 12px 8px; background: #fff; }

  /* Mobile */
  @media (max-width: 480px) {
    .kw { right: 12px; bottom: 12px; }
    .kw.is-open { right: 0; bottom: 0; left: 0; }
    .kw-panel { width: 100%; height: 100dvh; max-height: 100dvh; border-radius: 0; border: 0; }
  }
  @media (prefers-reduced-motion: reduce) {
    .kw-panel, .kw-typing span { animation: none !important; }
    .kw-body { scroll-behavior: auto; }
  }
</style>

<div class="kw" id="kw" aria-live="polite">
  <button class="kw-fab" id="kw-open" type="button" aria-label="Buka asisten KosinAja">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12Z"/></svg>
  </button>

  <section class="kw-panel" id="kw-panel" role="dialog" aria-label="Asisten KosinAja">
    <header class="kw-head">
      <div class="kw-avatar">
        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11 12 4l9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-5h4v5"/></svg>
      </div>
      <div>
        <div class="kw-title">Asisten KosinAja!</div>
        <div class="kw-sub"><span class="kw-dot"></span>Siap bantu cari kos</div>
      </div>
      <div class="kw-head-actions">
        <button class="kw-btn" id="kw-reset" type="button" aria-label="Mulai percakapan baru" title="Percakapan baru">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
        </button>
        <button class="kw-btn" id="kw-close" type="button" aria-label="Tutup asisten">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>
      </div>
    </header>

    <div class="kw-body" id="kw-body"></div>

    <form class="kw-form" id="kw-form" autocomplete="off">
      <textarea class="kw-input" id="kw-input" rows="1" maxlength="500" placeholder="Tulis pertanyaanmu..." aria-label="Pesan"></textarea>
      <button class="kw-send" id="kw-send" type="submit" aria-label="Kirim pesan">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4 20-7Z"/></svg>
      </button>
    </form>
    <div class="kw-foot">Jawaban AI bisa keliru. Cek detail di halaman kos.</div>
  </section>
</div>

<script>
(function () {
  const root   = document.getElementById('kw');
  const body   = document.getElementById('kw-body');
  const form   = document.getElementById('kw-form');
  const input  = document.getElementById('kw-input');
  const sendBt = document.getElementById('kw-send');
  const SUGGESTIONS = [
    'Cari kos di Jakarta bawah 2 juta',
    'Kos dengan AC dan wifi',
    'Kos paling murah',
  ];
  const GREETING = 'Halo! Aku asisten KosinAja!. Ceritakan kos seperti apa yang kamu cari: lokasi, budget, atau fasilitas.';

  let history = [];
  let busy = false;

  function scrollDown() { body.scrollTop = body.scrollHeight; }

  // Teks aman: escape HTML, lalu ubah **tebal** dan URL jadi link
  function format(text) {
    const esc = text.replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
    return esc
      .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
      .replace(/(https?:\/\/[^\s<]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>');
  }

  function addMsg(text, who, extra) {
    const el = document.createElement('div');
    el.className = 'kw-msg ' + who + (extra ? ' ' + extra : '');
    el.innerHTML = format(text);
    body.appendChild(el);
    scrollDown();
    return el;
  }

  function addChips() {
    const wrap = document.createElement('div');
    wrap.className = 'kw-chips';
    wrap.id = 'kw-chips';
    SUGGESTIONS.forEach(s => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'kw-chip';
      b.textContent = s;
      b.addEventListener('click', () => kirim(s));
      wrap.appendChild(b);
    });
    body.appendChild(wrap);
  }

  function showTyping() {
    const el = document.createElement('div');
    el.className = 'kw-msg bot kw-typing';
    el.id = 'kw-typing';
    el.setAttribute('aria-label', 'Asisten sedang mengetik');
    el.innerHTML = '<span></span><span></span><span></span>';
    body.appendChild(el);
    scrollDown();
  }
  function hideTyping() {
    const el = document.getElementById('kw-typing');
    if (el) el.remove();
  }

  function setBusy(v) {
    busy = v;
    sendBt.disabled = v;
    input.disabled = v;
    if (!v) input.focus();
  }

  function mulai() {
    body.innerHTML = '';
    history = [];
    addMsg(GREETING, 'bot');
    addChips();
  }

  async function kirim(pesan) {
    pesan = (pesan || '').trim();
    if (!pesan || busy) return;

    const chips = document.getElementById('kw-chips');
    if (chips) chips.remove();

    addMsg(pesan, 'user');
    input.value = '';
    input.style.height = 'auto';
    setBusy(true);
    showTyping();

    try {
      const res = await fetch('/asisten/tanya', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ message: pesan, history }),
      });

      hideTyping();

      if (res.status === 429) {
        addMsg('Terlalu banyak pesan. Tunggu sebentar lalu coba lagi.', 'bot', 'error');
      } else if (res.status === 419) {
        addMsg('Sesi habis. Muat ulang halaman lalu coba lagi.', 'bot', 'error');
      } else if (!res.ok) {
        addMsg('Pesan belum terkirim. Coba lagi sebentar.', 'bot', 'error');
      } else {
        const data = await res.json();
        addMsg(data.reply, 'bot');
        history.push({ role: 'user', content: pesan });
        history.push({ role: 'assistant', content: data.reply });
        // batasi riwayat sesuai validasi server (maks 20 item)
        if (history.length > 20) history = history.slice(-20);
      }
    } catch (e) {
      hideTyping();
      addMsg('Koneksi bermasalah. Periksa internet kamu lalu coba lagi.', 'bot', 'error');
    } finally {
      setBusy(false);
    }
  }

  // Buka / tutup
  function buka() {
    root.classList.add('is-open');
    if (!body.children.length) mulai();
    setTimeout(() => input.focus(), 50);
  }
  function tutup() {
    root.classList.remove('is-open');
    document.getElementById('kw-open').focus();
  }
  document.getElementById('kw-open').addEventListener('click', buka);
  document.getElementById('kw-close').addEventListener('click', tutup);
  document.getElementById('kw-reset').addEventListener('click', () => { if (!busy) mulai(); });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && root.classList.contains('is-open')) tutup();
  });

  // Kirim: submit form, Enter kirim, Shift+Enter baris baru
  form.addEventListener('submit', e => { e.preventDefault(); kirim(input.value); });
  input.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); kirim(input.value); }
  });
  input.addEventListener('input', () => {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 96) + 'px';
  });
})();
</script>