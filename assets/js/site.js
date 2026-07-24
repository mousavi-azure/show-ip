(() => {
  'use strict';

  const $ = (id) => document.getElementById(id);
  const LANG = window.APP_LANG === 'en' ? 'en' : 'fa';
  const I18N = window.APP_I18N || {};
  const T = (key, fallback) => I18N[key] || fallback || key;
  const NUM_LOCALE = LANG === 'en' ? 'en-US' : 'fa-IR';
  const fmt = (n, ...args) => {
    let i = 0;
    return n.replace(/%s/g, () => args[i++]);
  };

  function escapeHtml(str) {
    return String(str)
      .replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;').replaceAll("'", '&#039;');
  }

  function renderAlert(type, message) {
    return `<div class="alert alert-${type}" role="alert"><span>${escapeHtml(message)}</span></div>`;
  }

  /* ---------- Subnet calculator ---------- */
  async function calculateIP(ip, subnet) {
    const resp = await fetch('ip_calculator.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'ip=' + encodeURIComponent(ip) + '&subnet=' + encodeURIComponent(subnet) + '&lang=' + encodeURIComponent(LANG)
    });
    const text = await resp.text();
    let data;
    try { data = JSON.parse(text); } catch { throw new Error(T('Calc Invalid Response')); }
    if (!resp.ok || !data.ok) throw new Error(data.error || T('Calc Generic Error'));
    return data.result;
  }

  function renderCalcTable(r) {
    const rows = [
      [T('Calc Network Address'), r.network_address],
      [T('Calc Broadcast Address'), r.broadcast_address],
      [T('Calc First Usable'), r.first_usable],
      [T('Calc Last Usable'), r.last_usable],
      [T('Calc Subnet Mask'), r.subnet_mask],
      [T('Calc CIDR'), r.cidr],
      [T('Calc Total Addresses'), r.total_addresses],
      [T('Calc Usable Hosts'), r.usable_hosts],
      [T('Calc Host Bits'), r.host_bits],
    ];
    const tbody = rows.map(([k, v]) =>
      `<tr><th scope="row">${escapeHtml(k)}</th><td dir="ltr">${escapeHtml(String(v))}</td></tr>`
    ).join('');
    return `<table class="calc-table"><tbody>${tbody}</tbody></table>`;
  }

  function initCalculator() {
    const form = $('ipCalcForm');
    const out = $('ipCalcResult');
    if (!form || !out) return;
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const ip = $('ipAddress')?.value?.trim() || '';
      const subnet = $('subnet')?.value?.trim() || '';
      if (!ip || !subnet) {
        out.innerHTML = renderAlert('danger', T('Calc Missing Fields'));
        return;
      }
      out.innerHTML = `<div class="spinner" role="status" aria-label="${escapeHtml(T('Calculating'))}"></div>`;
      try {
        out.innerHTML = renderCalcTable(await calculateIP(ip, subnet));
      } catch (err) {
        out.innerHTML = renderAlert('danger', err?.message || T('Calc Generic Error'));
      }
    });
  }

  /* ---------- Theme toggle (light default, optional dark) ---------- */
  function initTheme() {
    const btn = $('themeToggle');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      if (isDark) {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
      }
    });
  }

  /* ---------- Local self-hosted world map + geolocation ---------- */
  function placeMarker(el, lat, lon) {
    if (!el) return;
    const left = ((lon + 180) / 360) * 100;
    const top = ((90 - lat) / 180) * 100;
    el.style.left = left + '%';
    el.style.top = top + '%';
  }

  function initMap() {
    const widget = $('mapWidget');
    const geoBtn = $('geoBtn');
    const gpsMarker = $('gpsMarker');
    const gpsLegend = $('gpsLegend');
    const status = $('geoStatus');
    if (!widget || !geoBtn) return;

    const setStatus = (msg, isError) => {
      if (!status) return;
      if (!msg) { status.hidden = true; status.textContent = ''; return; }
      status.hidden = false;
      status.textContent = msg;
      status.classList.toggle('error', !!isError);
    };

    if (!('geolocation' in navigator)) {
      geoBtn.disabled = true;
      geoBtn.title = T('Geolocation Not Supported');
      return;
    }

    geoBtn.addEventListener('click', () => {
      geoBtn.disabled = true;
      setStatus(T('Locating'), false);
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          const { latitude, longitude, accuracy } = pos.coords;
          placeMarker(gpsMarker, latitude, longitude);
          gpsMarker.hidden = false;
          if (gpsLegend) gpsLegend.hidden = false;
          const acc = Math.round(accuracy || 0);
          setStatus(fmt(T('Accuracy Message'), acc.toLocaleString(NUM_LOCALE)), false);
          gpsMarker.title = fmt(T('Precise Location Title'), String(acc));
          geoBtn.disabled = false;
        },
        (err) => {
          const messages = {
            1: T('Permission Denied'),
            2: T('Position Unavailable'),
            3: T('Position Timeout'),
          };
          setStatus(messages[err.code] || T('Location Error'), true);
          geoBtn.disabled = false;
        },
        { enableHighAccuracy: true, timeout: 12000, maximumAge: 60000 }
      );
    });
  }

  /* ---------- Live local clock ---------- */
  function initClock() {
    const el = $('localTime');
    if (!el || !el.dataset.time) return;
    let t = new Date(el.dataset.time);
    if (isNaN(t.getTime())) return;
    const pad = (n) => String(n).padStart(2, '0');
    setInterval(() => {
      t = new Date(t.getTime() + 1000);
      el.textContent = `${pad(t.getHours())}:${pad(t.getMinutes())}:${pad(t.getSeconds())}`;
    }, 1000);
  }

  /* ---------- Copy IP ---------- */
  function showToast(msg) {
    let toast = document.querySelector('.copy-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.className = 'copy-toast';
      document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2000);
  }

  function initCopy() {
    const btn = $('copyIpBtn');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const ip = btn.dataset.ip || '';
      navigator.clipboard?.writeText(ip)
        .then(() => showToast(T('IP Copied')))
        .catch(() => {});
    });
  }

  function initCopyButtons() {
    document.querySelectorAll('[data-copy]').forEach((el) => {
      if (el.tagName !== 'BUTTON') return;
      el.addEventListener('click', () => {
        navigator.clipboard?.writeText(el.dataset.copy || '')
          .then(() => showToast(T('Copied')))
          .catch(() => {});
      });
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initCalculator();
    initMap();
    initClock();
    initCopy();
    initCopyButtons();
  });
})();
