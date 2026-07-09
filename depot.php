<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Depot Air Bersih — Sistem Pemesanan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:        #0a0d12;
    --bg2:       #0f1318;
    --card:      #131820;
    --card2:     #181f28;
    --border:    rgba(255,255,255,0.07);
    --border2:   rgba(255,255,255,0.13);
    --cyan:      #00d4ff;
    --cyan2:     #00aacc;
    --cyan-dim:  rgba(0,212,255,0.1);
    --cyan-mid:  rgba(0,212,255,0.18);
    --text:      #e8edf3;
    --muted:     #6b7a8d;
    --muted2:    #4a5568;
    --success:   #34d399;
    --warn:      #fbbf24;
    --danger:    #f87171;
    --font-disp: 'Space Grotesk', system-ui, sans-serif;
    --font-body: 'Inter', system-ui, sans-serif;
    --r-sm:  6px;
    --r-md:  10px;
    --r-lg:  14px;
    --r-xl:  18px;
  }

  html { scroll-behavior: smooth; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: var(--font-body);
    font-size: 15px;
    line-height: 1.6;
    min-height: 100vh;
  }

  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-track { background: var(--bg); }
  ::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 99px; }

  nav {
    position: sticky; top: 0; z-index: 100;
    background: rgba(10,13,18,0.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 32px;
    display: flex; align-items: center; gap: 0;
    height: 60px;
  }
  .nav-brand {
    display: flex; align-items: center; gap: 10px;
    font-family: var(--font-disp); font-size: 17px; font-weight: 600;
    color: var(--text); text-decoration: none; margin-right: 32px;
    white-space: nowrap;
  }
  .nav-brand-icon {
    width: 34px; height: 34px; background: var(--cyan-mid);
    border: 1px solid rgba(0,212,255,0.3);
    border-radius: var(--r-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .nav-brand span { color: var(--cyan); }
  .nav-tabs { display: flex; gap: 2px; flex: 1; }
  .nav-tab {
    background: none; border: none; cursor: pointer;
    font-family: var(--font-body); font-size: 13px; font-weight: 500;
    color: var(--muted); padding: 8px 16px; border-radius: var(--r-md);
    transition: all 0.18s; display: flex; align-items: center; gap: 6px;
    white-space: nowrap;
  }
  .nav-tab:hover { color: var(--text); background: var(--card2); }
  .nav-tab.active { color: var(--cyan); background: var(--cyan-dim); }
  .nav-tab svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .nav-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }
  .badge-open {
    display: flex; align-items: center; gap: 5px;
    background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25);
    color: var(--success); font-size: 11px; padding: 4px 10px; border-radius: 99px;
  }
  .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--success); animation: pulse 2s infinite; }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
  .cart-nav-btn {
    position: relative; background: var(--card2); border: 1px solid var(--border2);
    color: var(--text); border-radius: var(--r-md); padding: 8px 14px;
    cursor: pointer; font-family: var(--font-body); font-size: 13px;
    display: flex; align-items: center; gap: 7px; transition: all 0.18s;
  }
  .cart-nav-btn:hover { border-color: var(--cyan); color: var(--cyan); }
  .cart-nav-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  #cart-nav-count {
    position: absolute; top: -6px; right: -6px;
    background: var(--cyan); color: #000; font-size: 10px; font-weight: 700;
    width: 18px; height: 18px; border-radius: 50%; display: none;
    align-items: center; justify-content: center;
  }
  #cart-nav-count.show { display: flex; }

  .hero {
    padding: 64px 32px 48px;
    max-width: 1100px; margin: 0 auto;
    display: grid; grid-template-columns: 1fr 420px; gap: 48px; align-items: center;
  }
  .hero-eyebrow {
    font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
    color: var(--cyan); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
  }
  .hero-eyebrow::before { content: ''; width: 20px; height: 1px; background: var(--cyan); }
  .hero h1 {
    font-family: var(--font-disp); font-size: clamp(32px, 4vw, 48px);
    font-weight: 700; line-height: 1.15; color: var(--text); margin-bottom: 16px;
  }
  .hero h1 em { color: var(--cyan); font-style: normal; }
  .hero p { color: var(--muted); font-size: 15px; line-height: 1.7; margin-bottom: 28px; max-width: 440px; }
  .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }
  .btn-primary {
    background: var(--cyan); color: #000; font-weight: 600; font-size: 14px;
    padding: 12px 24px; border-radius: var(--r-md); border: none; cursor: pointer;
    font-family: var(--font-body); transition: all 0.18s; display: inline-flex; align-items: center; gap: 8px;
  }
  .btn-primary:hover { background: var(--cyan2); transform: translateY(-1px); }
  .btn-outline {
    background: transparent; color: var(--text); font-weight: 500; font-size: 14px;
    padding: 12px 24px; border-radius: var(--r-md); border: 1px solid var(--border2);
    cursor: pointer; font-family: var(--font-body); transition: all 0.18s; display: inline-flex; align-items: center; gap: 8px;
  }
  .btn-outline:hover { border-color: var(--cyan); color: var(--cyan); }
  .hero-stats {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
  }
  .stat-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--r-lg); padding: 20px; text-align: center;
  }
  .stat-num {
    font-family: var(--font-disp); font-size: 26px; font-weight: 700;
    color: var(--cyan); display: block; margin-bottom: 4px;
  }
  .stat-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }

  .main { max-width: 1100px; margin: 0 auto; padding: 0 32px 80px; }

  .section-head { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
  .section-title {
    font-family: var(--font-disp); font-size: 20px; font-weight: 600; color: var(--text);
  }
  .section-title small { font-size: 13px; color: var(--muted); font-weight: 400; margin-left: 8px; font-family: var(--font-body); }

  .page { display: none; }
  .page.active { display: block; }

  .search-wrap {
    display: flex; align-items: center; gap: 10px;
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--r-lg); padding: 11px 16px; margin-bottom: 24px;
    transition: border-color 0.18s;
  }
  .search-wrap:focus-within { border-color: var(--cyan); }
  .search-wrap svg { width: 16px; height: 16px; stroke: var(--muted); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; }
  .search-wrap input {
    background: none; border: none; outline: none; color: var(--text);
    font-size: 14px; font-family: var(--font-body); flex: 1;
  }
  .search-wrap input::placeholder { color: var(--muted); }

  .filter-row { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
  .filter-chip {
    background: var(--card); border: 1px solid var(--border); color: var(--muted);
    font-size: 12px; padding: 6px 14px; border-radius: 99px; cursor: pointer;
    font-family: var(--font-body); transition: all 0.18s;
  }
  .filter-chip:hover, .filter-chip.active { background: var(--cyan-dim); border-color: rgba(0,212,255,0.4); color: var(--cyan); }

  .product-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 14px;
  }
  .product-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--r-xl); padding: 20px; cursor: pointer;
    transition: all 0.22s; position: relative; overflow: hidden;
    display: flex; flex-direction: column;
  }
  .product-card::after {
    content: ''; position: absolute; inset: 0;
    border-radius: var(--r-xl); border: 1px solid transparent;
    background: linear-gradient(135deg, rgba(0,212,255,0.15), transparent) border-box;
    -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: destination-out; mask-composite: exclude;
    opacity: 0; transition: opacity 0.22s;
    pointer-events: none;
  }
  .product-card:hover { transform: translateY(-3px); border-color: rgba(0,212,255,0.3); background: var(--card2); }
  .product-card:hover::after { opacity: 1; }
  .prod-icon { font-size: 36px; margin-bottom: 12px; display: block; }
  .prod-badge {
    position: absolute; top: 14px; right: 14px;
    font-size: 10px; padding: 3px 8px; border-radius: 99px;
  }
  .badge-ok { background: rgba(52,211,153,0.12); color: var(--success); border: 1px solid rgba(52,211,153,0.25); }
  .badge-low { background: rgba(251,191,36,0.12); color: var(--warn); border: 1px solid rgba(251,191,36,0.25); }
  .prod-name { font-family: var(--font-disp); font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 5px; }
  .prod-desc { font-size: 12px; color: var(--muted); line-height: 1.5; margin-bottom: 14px; flex: 1; }
  .prod-footer { display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1; }
  .prod-price { font-family: var(--font-disp); font-size: 16px; font-weight: 600; color: var(--cyan); }
  .prod-unit { font-size: 11px; color: var(--muted2); margin-left: 2px; }
  .add-to-cart {
    width: 32px; height: 32px; background: var(--cyan); border: none; border-radius: var(--r-md);
    color: #000; font-size: 20px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all 0.18s;
    line-height: 1; position: relative; z-index: 2;
  }
  .add-to-cart:hover { background: var(--cyan2); transform: scale(1.08); }

  .cart-layout { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
  .cart-empty-state {
    text-align: center; padding: 72px 0; grid-column: 1 / -1;
  }
  .cart-empty-state .empty-icon { font-size: 64px; margin-bottom: 16px; opacity: 0.3; display: block; }
  .cart-empty-state p { color: var(--muted); margin-bottom: 20px; }
  .cart-item-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-lg);
    padding: 16px 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 10px;
    transition: border-color 0.18s;
  }
  .cart-item-card:hover { border-color: var(--border2); }
  .ci-icon { font-size: 28px; flex-shrink: 0; }
  .ci-info { flex: 1; min-width: 0; }
  .ci-name { font-size: 14px; font-weight: 500; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .ci-price-unit { font-size: 12px; color: var(--muted); }
  .qty-ctrl { display: flex; align-items: center; gap: 10px; }
  .qty-btn {
    width: 30px; height: 30px; background: var(--card2); border: 1px solid var(--border2);
    color: var(--text); border-radius: var(--r-sm); cursor: pointer; font-size: 16px;
    display: flex; align-items: center; justify-content: center; transition: all 0.18s; flex-shrink: 0;
  }
  .qty-btn:hover { background: var(--cyan-dim); border-color: var(--cyan); color: var(--cyan); }
  .qty-num { font-family: var(--font-disp); font-size: 15px; font-weight: 600; color: var(--text); min-width: 22px; text-align: center; }
  .ci-total { font-family: var(--font-disp); font-size: 15px; font-weight: 600; color: var(--cyan); min-width: 80px; text-align: right; }
  .ci-remove {
    background: none; border: none; color: var(--muted2); cursor: pointer;
    width: 30px; height: 30px; border-radius: var(--r-sm); display: flex; align-items: center;
    justify-content: center; transition: all 0.18s; flex-shrink: 0;
  }
  .ci-remove:hover { background: rgba(248,113,113,0.12); color: var(--danger); }
  .ci-remove svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  .cart-summary-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl);
    padding: 24px; position: sticky; top: 80px;
  }
  .cs-title { font-family: var(--font-disp); font-size: 16px; font-weight: 600; color: var(--text); margin-bottom: 20px; }
  .cs-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; font-size: 13px; color: var(--muted); }
  .cs-divider { height: 1px; background: var(--border); margin: 10px 0; }
  .cs-total { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; }
  .cs-total-label { font-size: 15px; font-weight: 500; color: var(--text); }
  .cs-total-val { font-family: var(--font-disp); font-size: 22px; font-weight: 700; color: var(--cyan); }
  .promo-row { display: flex; gap: 8px; margin-bottom: 16px; }
  .promo-input {
    flex: 1; background: var(--card2); border: 1px solid var(--border); border-radius: var(--r-md);
    color: var(--text); font-size: 13px; padding: 9px 12px; outline: none; font-family: var(--font-body);
    transition: border-color 0.18s;
  }
  .promo-input:focus { border-color: var(--cyan); }
  .promo-input::placeholder { color: var(--muted); }
  .promo-btn {
    background: var(--card2); border: 1px solid var(--border2); color: var(--muted);
    font-size: 12px; padding: 9px 14px; border-radius: var(--r-md); cursor: pointer;
    font-family: var(--font-body); transition: all 0.18s;
  }
  .promo-btn:hover { border-color: var(--cyan); color: var(--cyan); }
  .checkout-btn {
    width: 100%; background: var(--cyan); color: #000; font-weight: 700; font-size: 14px;
    padding: 14px; border-radius: var(--r-lg); border: none; cursor: pointer;
    font-family: var(--font-disp); transition: all 0.18s; display: flex; align-items: center;
    justify-content: center; gap: 8px; margin-top: 4px;
  }
  .checkout-btn:hover { background: var(--cyan2); }
  .checkout-btn:disabled { opacity: 0.35; cursor: not-allowed; transform: none; }
  .checkout-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

  .order-layout { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }
  .form-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl); padding: 28px;
  }
  .form-card-title {
    font-family: var(--font-disp); font-size: 16px; font-weight: 600; color: var(--text);
    margin-bottom: 22px; display: flex; align-items: center; gap: 10px;
  }
  .form-card-title svg { width: 18px; height: 18px; stroke: var(--cyan); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .form-group { margin-bottom: 18px; }
  .form-label {
    display: block; font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: 0.8px; color: var(--muted); margin-bottom: 8px;
  }
  .form-input {
    width: 100%; background: var(--card2); border: 1px solid var(--border);
    border-radius: var(--r-md); padding: 11px 14px; color: var(--text);
    font-size: 14px; font-family: var(--font-body); outline: none; transition: border-color 0.18s;
    appearance: none; -webkit-appearance: none;
  }
  .form-input:focus { border-color: var(--cyan); }
  .form-input::placeholder { color: var(--muted2); }
  textarea.form-input { resize: vertical; min-height: 80px; }
  select.form-input { cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7a8d' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  .option-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .option-card {
    background: var(--card2); border: 1.5px solid var(--border); border-radius: var(--r-lg);
    padding: 14px; cursor: pointer; transition: all 0.18s; display: flex; align-items: flex-start; gap: 12px;
  }
  .option-card.selected { border-color: var(--cyan); background: var(--cyan-dim); }
  .option-card svg { width: 20px; height: 20px; stroke: var(--muted); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; flex-shrink: 0; margin-top: 1px; }
  .option-card.selected svg { stroke: var(--cyan); }
  .option-label { font-size: 13px; font-weight: 500; color: var(--text); display: block; margin-bottom: 2px; }
  .option-sub { font-size: 11px; color: var(--muted); }

  .order-confirm-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl);
    padding: 24px; position: sticky; top: 80px;
  }
  .oc-title { font-family: var(--font-disp); font-size: 16px; font-weight: 600; color: var(--text); margin-bottom: 16px; }
  .oc-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
  .oc-item:last-of-type { border-bottom: none; }
  .oc-item-name { color: var(--muted); }
  .oc-item-val { color: var(--text); font-weight: 500; }
  .oc-total-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 0 0; }
  .oc-total-label { font-size: 14px; color: var(--text); font-weight: 500; }
  .oc-total-val { font-family: var(--font-disp); font-size: 20px; font-weight: 700; color: var(--cyan); }
  .submit-btn {
    width: 100%; margin-top: 16px; background: var(--cyan); color: #000; font-weight: 700;
    font-size: 14px; padding: 14px; border-radius: var(--r-lg); border: none; cursor: pointer;
    font-family: var(--font-disp); transition: all 0.18s; display: flex;
    align-items: center; justify-content: center; gap: 8px;
  }
  .submit-btn:hover { background: var(--cyan2); }
  .submit-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

  .history-filter { display: flex; gap: 8px; margin-bottom: 20px; }
  .order-history-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl);
    padding: 20px 24px; margin-bottom: 12px; transition: border-color 0.18s;
  }
  .order-history-card:hover { border-color: var(--border2); }
  .oh-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; gap: 10px; flex-wrap: wrap; }
  .oh-id { font-family: var(--font-disp); font-size: 15px; font-weight: 600; color: var(--text); }
  .oh-time { font-size: 12px; color: var(--muted); margin-top: 2px; }
  .oh-customer { font-size: 13px; color: var(--muted); margin-top: 2px; }
  .status-pill {
    font-size: 11px; padding: 4px 12px; border-radius: 99px; font-weight: 500; white-space: nowrap;
  }
  .status-proses { background: rgba(251,191,36,0.12); color: var(--warn); border: 1px solid rgba(251,191,36,0.25); }
  .status-dikirim { background: rgba(0,212,255,0.1); color: var(--cyan); border: 1px solid rgba(0,212,255,0.25); }
  .status-selesai { background: rgba(52,211,153,0.1); color: var(--success); border: 1px solid rgba(52,211,153,0.25); }
  .oh-items {
    background: var(--bg2); border-radius: var(--r-md); padding: 10px 14px;
    font-size: 12px; color: var(--muted); margin-bottom: 12px; line-height: 1.6;
  }
  .oh-footer { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
  .oh-meta { display: flex; gap: 16px; flex-wrap: wrap; }
  .oh-meta-item { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 5px; }
  .oh-meta-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .oh-total { font-family: var(--font-disp); font-size: 16px; font-weight: 700; color: var(--cyan); }
  .oh-track { margin-top: 14px; border-top: 1px solid var(--border); padding-top: 14px; display: none; }
  .oh-track.open { display: block; }
  .track-step { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 10px; }
  .track-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--border2); flex-shrink: 0; margin-top: 4px; }
  .track-dot.done { background: var(--cyan); }
  .track-dot.active { background: var(--success); box-shadow: 0 0 6px rgba(52,211,153,0.5); }
  .track-text { font-size: 12px; color: var(--muted); }
  .track-text strong { color: var(--text); font-size: 13px; display: block; }
  .track-btn {
    background: none; border: 1px solid var(--border2); color: var(--muted); font-size: 12px;
    padding: 5px 12px; border-radius: var(--r-sm); cursor: pointer; font-family: var(--font-body);
    transition: all 0.18s;
  }
  .track-btn:hover { border-color: var(--cyan); color: var(--cyan); }
  .track-btn.danger:hover { border-color: var(--danger); color: var(--danger); }
  .empty-history { text-align: center; padding: 72px 0; }
  .empty-history .empty-icon { font-size: 56px; opacity: 0.3; display: block; margin-bottom: 16px; }
  .empty-history p { color: var(--muted); }

  #toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 9999;
    background: var(--card2); border: 1px solid rgba(52,211,153,0.35);
    border-radius: var(--r-lg); padding: 14px 20px;
    display: flex; align-items: center; gap: 10px;
    font-size: 13px; color: var(--text);
    transform: translateY(20px); opacity: 0;
    transition: all 0.28s cubic-bezier(.4,0,.2,1);
    pointer-events: none; max-width: 320px;
  }
  #toast.show { transform: translateY(0); opacity: 1; }
  #toast .toast-icon { color: var(--success); font-size: 18px; flex-shrink: 0; }
  #toast.error { border-color: rgba(248,113,113,0.35); }
  #toast.error .toast-icon { color: var(--danger); }

  .staff-login-btn {
    background: var(--card2); border: 1px solid var(--border2); color: var(--muted);
    border-radius: var(--r-md); padding: 8px 14px; cursor: pointer; font-family: var(--font-body);
    font-size: 13px; display: flex; align-items: center; gap: 7px; transition: all 0.18s;
  }
  .staff-login-btn:hover { border-color: var(--cyan); color: var(--cyan); }
  .user-chip { display: flex; align-items: center; gap: 10px; background: var(--card2); border: 1px solid var(--border2); border-radius: var(--r-md); padding: 6px 8px 6px 14px; }
  .user-chip-name { font-size: 13px; color: var(--text); font-weight: 500; white-space: nowrap; }
  .user-chip-role { font-size: 10px; color: var(--cyan); text-transform: uppercase; letter-spacing: 0.5px; display: block; }
  .logout-btn {
    background: var(--bg2); border: 1px solid var(--border2); color: var(--muted);
    border-radius: var(--r-sm); padding: 6px 12px; cursor: pointer; font-size: 12px;
    font-family: var(--font-body); transition: all 0.18s;
  }
  .logout-btn:hover { border-color: var(--danger); color: var(--danger); }

  .modal-overlay {
    position: fixed; inset: 0; z-index: 1000; background: rgba(5,7,10,0.72);
    backdrop-filter: blur(3px);
    display: none; align-items: center; justify-content: center; padding: 20px;
    opacity: 0; transition: opacity 0.2s;
  }
  .modal-overlay.show { display: flex; opacity: 1; }
  .modal-card {
    background: var(--card); border: 1px solid var(--border2); border-radius: var(--r-xl);
    padding: 28px; width: 100%; max-width: 380px;
    transform: translateY(10px); transition: transform 0.2s;
  }
  .modal-overlay.show .modal-card { transform: translateY(0); }
  .modal-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
  .modal-title { font-family: var(--font-disp); font-size: 17px; font-weight: 600; color: var(--text); }
  .modal-close {
    background: var(--card2); border: 1px solid var(--border2); color: var(--muted);
    width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 14px;
    display: flex; align-items: center; justify-content: center; transition: all 0.18s;
  }
  .modal-close:hover { border-color: var(--danger); color: var(--danger); }
  .modal-tabs { display: flex; gap: 6px; margin-bottom: 20px; background: var(--bg2); padding: 4px; border-radius: var(--r-md); }
  .modal-tab {
    flex: 1; background: none; border: none; cursor: pointer; color: var(--muted);
    font-size: 13px; font-weight: 500; padding: 8px; border-radius: var(--r-sm);
    font-family: var(--font-body); transition: all 0.18s;
  }
  .modal-tab.active { background: var(--cyan-dim); color: var(--cyan); }
  .login-hint { font-size: 11px; color: var(--muted2); margin: -8px 0 16px; }

  .admin-order-card {
    background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl);
    padding: 20px 24px; margin-bottom: 12px;
  }
  .admin-order-controls {
    display: flex; gap: 14px; align-items: flex-end; flex-wrap: wrap;
    border-top: 1px solid var(--border); margin-top: 12px; padding-top: 14px;
  }
  .admin-order-controls .form-group { margin: 0; min-width: 170px; flex: 1; }
  .table-wrap { background: var(--card); border: 1px solid var(--border); border-radius: var(--r-xl); overflow: hidden; }
  table.data-table { width: 100%; border-collapse: collapse; }
  table.data-table th {
    text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;
    color: var(--muted); font-weight: 600; padding: 14px 18px; background: var(--card2);
    border-bottom: 1px solid var(--border);
  }
  table.data-table td { padding: 14px 18px; font-size: 13px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
  table.data-table tr:last-child td { border-bottom: none; }
  table.data-table td.muted-cell { color: var(--muted); }
  .row-actions { display: flex; gap: 6px; }
  .icon-btn {
    background: var(--card2); border: 1px solid var(--border2); color: var(--muted);
    width: 30px; height: 30px; border-radius: var(--r-sm); cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; transition: all 0.18s; font-size: 14px;
  }
  .icon-btn:hover { border-color: var(--cyan); color: var(--cyan); }
  .icon-btn.danger:hover { border-color: var(--danger); color: var(--danger); }
  .status-toggle { font-size: 11px; padding: 3px 10px; border-radius: 99px; font-weight: 500; border: 1px solid; cursor: pointer; }
  .status-aktif { background: rgba(52,211,153,0.1); color: var(--success); border-color: rgba(52,211,153,0.25); }
  .status-nonaktif { background: rgba(248,113,113,0.1); color: var(--danger); border-color: rgba(248,113,113,0.25); }
  .report-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .kurir-addr { font-size: 12px; color: var(--muted); background: var(--bg2); border-radius: var(--r-md); padding: 10px 14px; margin: 8px 0 4px; line-height: 1.6; }

  @media (max-width: 900px) {
    .hero { grid-template-columns: 1fr; gap: 32px; }
    .cart-layout, .order-layout { grid-template-columns: 1fr; }
    .cart-summary-card, .order-confirm-card { position: static; }
    nav { padding: 0 16px; }
    .nav-brand-icon { display: none; }
    .hero { padding: 36px 20px 32px; }
    .main { padding: 0 20px 60px; }
    .report-grid { grid-template-columns: repeat(2, 1fr); }
    .table-wrap { overflow-x: auto; }
    table.data-table { min-width: 600px; }
  }
  @media (max-width: 600px) {
    .hero-stats { grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .stat-card { padding: 14px 10px; }
    .stat-num { font-size: 20px; }
    .product-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    .form-row { grid-template-columns: 1fr; }
    .option-grid { grid-template-columns: 1fr 1fr; }
    .hero h1 { font-size: 26px; }
    .nav-tab { padding: 8px 10px; font-size: 12px; }
    #toast { bottom: 16px; right: 16px; left: 16px; }
    .user-chip-name { display: none; }
    .report-grid { grid-template-columns: repeat(2, 1fr); }
  }
</style>
</head>
<body>

<nav>
  <a class="nav-brand" href="#" onclick="goHome();return false;">
    <div class="nav-brand-icon" aria-hidden="true">💧</div>
    Depot Air <span>Bersih</span>
  </a>

  <div class="nav-tabs" id="nav-tabs-customer">
    <button class="nav-tab active" data-page="produk" onclick="showPage('produk')">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 3 6.5 3 10c0 5.5 9 12 9 12s9-6.5 9-12c0-3.5-3.48-8-9-8z"/></svg>
      Produk
    </button>
    <button class="nav-tab" data-page="keranjang" onclick="showPage('keranjang')">
      <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Keranjang
    </button>
    <button class="nav-tab" data-page="pesan" onclick="showPage('pesan')">
      <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Pesan
    </button>
    <button class="nav-tab" data-page="riwayat" onclick="showPage('riwayat')">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Riwayat
    </button>
  </div>

  <div class="nav-tabs" id="nav-tabs-admin" style="display:none">
    <button class="nav-tab active" data-page="admin-pesanan" onclick="showPage('admin-pesanan')">
      <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Pesanan
    </button>
    <button class="nav-tab" data-page="admin-pelanggan" onclick="showPage('admin-pelanggan')">
      <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Pelanggan
    </button>
    <button class="nav-tab" data-page="admin-kurir" onclick="showPage('admin-kurir')">
      <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
      Kurir
    </button>
    <button class="nav-tab" data-page="admin-laporan" onclick="showPage('admin-laporan')">
      <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      Laporan
    </button>
  </div>

  <div class="nav-tabs" id="nav-tabs-kurir" style="display:none">
    <button class="nav-tab active" data-page="kurir-pengiriman" onclick="showPage('kurir-pengiriman')">
      <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
      Pengiriman
    </button>
  </div>

  <div class="nav-right">
    <div class="badge-open" id="badge-open" aria-label="Status depot: Buka">
      <span class="dot"></span> Buka 07.00–20.00
    </div>
    <button class="cart-nav-btn" id="cart-nav-btn" onclick="showPage('keranjang')" aria-label="Lihat keranjang">
      <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Keranjang
      <span id="cart-nav-count" aria-live="polite"></span>
    </button>
    <button class="staff-login-btn" id="customer-auth-btn" onclick="openCustomerAuthModal('masuk')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Masuk / Daftar
    </button>
    <div class="user-chip" id="customer-chip" style="display:none">
      <div>
        <span class="user-chip-role">Pelanggan</span>
        <span class="user-chip-name" id="customer-chip-name"></span>
      </div>
      <button class="logout-btn" onclick="logoutCustomer()">Keluar</button>
    </div>
    <button class="staff-login-btn" id="staff-login-btn" onclick="openStaffModal()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      Login Staf
    </button>
    <div class="user-chip" id="user-chip" style="display:none">
      <div>
        <span class="user-chip-role" id="user-chip-role"></span>
        <span class="user-chip-name" id="user-chip-name"></span>
      </div>
      <button class="logout-btn" onclick="exitRoleMode()">Keluar</button>
    </div>
  </div>
</nav>

<section class="hero" id="hero-section" aria-label="Selamat datang di Depot Air Bersih">
  <div class="hero-content">
    <div class="hero-eyebrow">Air Minum Isi Ulang</div>
    <h1>Air <em>Segar & Bersih</em><br>Langsung ke Pintu Anda</h1>
    <p>Proses reverse osmosis 7 tahap. Bebas bakteri. Rasa segar alami. Pengiriman cepat ke seluruh area kota dalam 1–2 jam.</p>
    <div class="hero-cta">
      <button class="btn-primary" onclick="showPage('produk')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2C6.48 2 3 6.5 3 10c0 5.5 9 12 9 12s9-6.5 9-12c0-3.5-3.48-8-9-8z"/></svg>
        Pesan Sekarang
      </button>
      <button class="btn-outline" onclick="showPage('riwayat')">Lihat Riwayat</button>
    </div>
  </div>
  <div class="hero-stats" role="list">
    <div class="stat-card" role="listitem">
      <span class="stat-num" aria-label="Lebih dari 5.000 pelanggan">5.000+</span>
      <span class="stat-label">Pelanggan</span>
    </div>
    <div class="stat-card" role="listitem">
      <span class="stat-num" aria-label="Pengiriman dalam 1 sampai 2 jam">1–2 Jam</span>
      <span class="stat-label">Pengiriman</span>
    </div>
    <div class="stat-card" role="listitem">
      <span class="stat-num" aria-label="7 tahap filtrasi">7 Tahap</span>
      <span class="stat-label">Filtrasi RO</span>
    </div>
  </div>
</section>

<main class="main">

  <div class="page active" id="page-produk">
    <div class="section-head">
      <h2 class="section-title">Produk Kami <small id="product-count"></small></h2>
    </div>
    <div class="search-wrap" role="search">
      <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="search-input" placeholder="Cari produk…" oninput="filterProducts()" aria-label="Cari produk">
    </div>
    <div class="filter-row" role="group" aria-label="Filter kategori">
      <button class="filter-chip active" onclick="filterCat(this,'semua')">Semua</button>
      <button class="filter-chip" onclick="filterCat(this,'galon')">Galon</button>
      <button class="filter-chip" onclick="filterCat(this,'kemasan')">Kemasan</button>
      <button class="filter-chip" onclick="filterCat(this,'layanan')">Layanan</button>
    </div>
    <div class="product-grid" id="product-grid" role="list" aria-label="Daftar produk"></div>
  </div>

  <div class="page" id="page-keranjang">
    <div class="section-head">
      <h2 class="section-title">Keranjang <small id="cart-count-label"></small></h2>
    </div>
    <div id="cart-content"></div>
  </div>

  <div class="page" id="page-pesan">
    <div class="section-head">
      <h2 class="section-title">Konfirmasi Pesanan</h2>
    </div>
    <div class="order-layout">
      <div>
        <div class="form-card" style="margin-bottom:16px">
          <div class="form-card-title">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Data Pemesan
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="f-nama">Nama Lengkap</label>
              <input type="text" class="form-input" id="f-nama" placeholder="Budi Santoso" autocomplete="name">
            </div>
            <div class="form-group">
              <label class="form-label" for="f-telp">No. Telepon</label>
              <input type="tel" class="form-input" id="f-telp" placeholder="08xx-xxxx-xxxx" autocomplete="tel">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-alamat">Alamat Lengkap</label>
            <textarea class="form-input" id="f-alamat" placeholder="Jl. Contoh No. 10, RT 02/RW 05, Kel. Batam Kota…" autocomplete="street-address"></textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="f-kecamatan">Kecamatan</label>
              <select class="form-input" id="f-kecamatan">
                <option value="">Pilih kecamatan…</option>
                <option>Batam Kota</option>
                <option>Sekupang</option>
                <option>Batu Aji</option>
                <option>Lubuk Baja</option>
                <option>Nongsa</option>
                <option>Sagulung</option>
                <option>Bengkong</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label" for="f-waktu">Waktu Pengiriman</label>
              <input type="time" class="form-input" id="f-waktu" value="10:00">
            </div>
          </div>
        </div>

        <div class="form-card" style="margin-bottom:16px">
          <div class="form-card-title">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            Metode Pengiriman
          </div>
          <div class="option-grid" id="delivery-opts">
            <div class="option-card selected" onclick="selectOpt('delivery','antar',this)" data-val="antar">
              <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
              <div><span class="option-label">Antar ke Rumah</span><span class="option-sub">+Rp 3.000 ongkir</span></div>
            </div>
            <div class="option-card" onclick="selectOpt('delivery','ambil',this)" data-val="ambil">
              <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="5" r="3"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
              <div><span class="option-label">Ambil Sendiri</span><span class="option-sub">Gratis · buka 07–20</span></div>
            </div>
          </div>
        </div>

        <div class="form-card" style="margin-bottom:16px">
          <div class="form-card-title">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Metode Pembayaran
          </div>
          <div class="option-grid" id="payment-opts" style="grid-template-columns: repeat(2, 1fr);">
            <div class="option-card selected" onclick="selectOpt('payment','tunai',this)" data-val="tunai">
              <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
              <div><span class="option-label">Tunai</span><span class="option-sub">Bayar saat terima</span></div>
            </div>
            <div class="option-card" onclick="selectOpt('payment','transfer',this)" data-val="transfer">
              <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
              <div><span class="option-label">Transfer</span><span class="option-sub">BCA / Mandiri</span></div>
            </div>
            <div class="option-card" onclick="selectOpt('payment','qris',this)" data-val="qris">
              <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3zM14 20h3"/></svg>
              <div><span class="option-label">QRIS</span><span class="option-sub">Scan & bayar</span></div>
            </div>
            <div class="option-card" onclick="selectOpt('payment','ewallet',this)" data-val="ewallet">
              <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
              <div><span class="option-label">E-Wallet</span><span class="option-sub">OVO / GoPay / Dana</span></div>
            </div>
          </div>
        </div>

        <div class="form-card">
          <div class="form-card-title">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Catatan Tambahan
          </div>
          <div class="form-group">
            <label class="form-label" for="f-catatan">Pesan untuk kurir (opsional)</label>
            <textarea class="form-input" id="f-catatan" placeholder="Misal: Taruh di depan pintu, jangan diketuk keras, dsb."></textarea>
          </div>
        </div>
      </div>

      <div class="order-confirm-card">
        <div class="oc-title">Ringkasan Pesanan</div>
        <div id="oc-items"></div>
        <div class="cs-divider"></div>
        <div id="oc-totals"></div>
        <button class="submit-btn" id="submit-btn" onclick="submitOrder()">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Konfirmasi Pesanan
        </button>
      </div>
    </div>
  </div>

  <div class="page" id="page-riwayat">
    <div class="section-head">
      <h2 class="section-title">Riwayat Pesanan</h2>
    </div>
    <div id="history-list"></div>
  </div>

  <div class="page" id="page-admin-pesanan">
    <div class="section-head">
      <h2 class="section-title">Kelola Pesanan <small id="admin-pesanan-count"></small></h2>
    </div>
    <div class="filter-row" role="group" aria-label="Filter status pesanan">
      <button class="filter-chip active" onclick="filterAdminOrders(this,'semua')">Semua</button>
      <button class="filter-chip" onclick="filterAdminOrders(this,'proses')">Diproses</button>
      <button class="filter-chip" onclick="filterAdminOrders(this,'dikirim')">Dikirim</button>
      <button class="filter-chip" onclick="filterAdminOrders(this,'selesai')">Selesai</button>
    </div>
    <div id="admin-pesanan-list"></div>
  </div>

  <div class="page" id="page-admin-pelanggan">
    <div class="section-head">
      <h2 class="section-title">Data Pelanggan <small id="admin-pelanggan-count"></small></h2>
      <button class="btn-primary" onclick="openCustomerModal()">+ Tambah Pelanggan</button>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Nama</th><th>Telepon</th><th>Alamat</th><th>Total Pesanan</th><th></th></tr></thead>
        <tbody id="admin-pelanggan-body"></tbody>
      </table>
    </div>
  </div>

  <div class="page" id="page-admin-kurir">
    <div class="section-head">
      <h2 class="section-title">Data Kurir <small id="admin-kurir-count"></small></h2>
      <button class="btn-primary" onclick="openKurirModal()">+ Tambah Kurir</button>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Nama</th><th>Username</th><th>Telepon</th><th>Status</th><th>Tugas Aktif</th><th></th></tr></thead>
        <tbody id="admin-kurir-body"></tbody>
      </table>
    </div>
  </div>

  <div class="page" id="page-admin-laporan">
    <div class="section-head">
      <h2 class="section-title">Laporan</h2>
    </div>
    <div id="admin-laporan-content"></div>
  </div>

  <div class="page" id="page-kurir-pengiriman">
    <div class="section-head">
      <h2 class="section-title">Daftar Pengiriman Saya <small id="kurir-pengiriman-count"></small></h2>
    </div>
    <div id="kurir-pengiriman-list"></div>
  </div>

</main>

<div class="modal-overlay" id="staff-modal-overlay" onclick="if(event.target===this) closeStaffModal()">
  <div class="modal-card">
    <div class="modal-head">
      <div class="modal-title">Login Staf</div>
      <button class="modal-close" onclick="closeStaffModal()" aria-label="Tutup">✕</button>
    </div>
    <div class="modal-tabs">
      <button class="modal-tab active" id="tab-btn-admin" onclick="switchLoginTab('admin')">Admin</button>
      <button class="modal-tab" id="tab-btn-kurir" onclick="switchLoginTab('kurir')">Kurir</button>
    </div>
    <div id="login-form-admin">
      <div class="form-group">
        <label class="form-label" for="admin-username">Username</label>
        <input type="text" class="form-input" id="admin-username" placeholder="admin">
      </div>
      <div class="form-group">
        <label class="form-label" for="admin-password">Password</label>
        <input type="password" class="form-input" id="admin-password" placeholder="••••••••">
      </div>
      <p class="login-hint">Demo: admin / admin123</p>
      <button class="btn-primary" style="width:100%;justify-content:center" onclick="loginAdmin()">Masuk sebagai Admin</button>
    </div>
    <div id="login-form-kurir" style="display:none">
      <div class="form-group">
        <label class="form-label" for="kurir-username">Username</label>
        <input type="text" class="form-input" id="kurir-username" placeholder="kurir1">
      </div>
      <div class="form-group">
        <label class="form-label" for="kurir-password">Password</label>
        <input type="password" class="form-input" id="kurir-password" placeholder="••••••••">
      </div>
      <p class="login-hint">Demo: kurir1 / kurir123</p>
      <button class="btn-primary" style="width:100%;justify-content:center" onclick="loginKurir()">Masuk sebagai Kurir</button>
    </div>
  </div>
</div>

<!-- CUSTOMER LOGIN / REGISTER MODAL -->
<div class="modal-overlay" id="customer-auth-modal-overlay" onclick="if(event.target===this) closeCustomerAuthModal()">
  <div class="modal-card">
    <div class="modal-head">
      <div class="modal-title">Akun Pelanggan</div>
      <button class="modal-close" onclick="closeCustomerAuthModal()" aria-label="Tutup">✕</button>
    </div>
    <div class="modal-tabs">
      <button class="modal-tab active" id="ca-tab-btn-masuk" onclick="switchCustomerAuthTab('masuk')">Masuk</button>
      <button class="modal-tab" id="ca-tab-btn-daftar" onclick="switchCustomerAuthTab('daftar')">Daftar</button>
    </div>
    <p style="font-size:12px;color:var(--muted);margin:-10px 0 18px;line-height:1.6">Masuk atau buat akun dulu untuk melanjutkan pemesanan dan melihat riwayat pesananmu.</p>

    <!-- MASUK -->
    <div id="ca-form-masuk">
      <div class="form-group">
        <label class="form-label" for="ca-login-telp">No. Telepon</label>
        <input type="tel" class="form-input" id="ca-login-telp" placeholder="08xx-xxxx-xxxx">
      </div>
      <div class="form-group">
        <label class="form-label" for="ca-login-password">Password</label>
        <input type="password" class="form-input" id="ca-login-password" placeholder="••••••••">
      </div>
      <p class="login-hint">Demo: 081234567892 / malina00</p>
      <button class="btn-primary" style="width:100%;justify-content:center" onclick="loginCustomer()">Masuk</button>
    </div>

    <!-- DAFTAR -->
    <div id="ca-form-daftar" style="display:none">
      <div class="form-group">
        <label class="form-label" for="ca-reg-nama">Nama Lengkap</label>
        <input type="text" class="form-input" id="ca-reg-nama" placeholder="Nama kamu">
      </div>
      <div class="form-group">
        <label class="form-label" for="ca-reg-telp">No. Telepon</label>
        <input type="tel" class="form-input" id="ca-reg-telp" placeholder="08xx-xxxx-xxxx">
      </div>
      <div class="form-group">
        <label class="form-label" for="ca-reg-alamat">Alamat</label>
        <textarea class="form-input" id="ca-reg-alamat" placeholder="Alamat pengiriman (opsional, bisa diisi nanti)"></textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="ca-reg-password">Password</label>
          <input type="password" class="form-input" id="ca-reg-password" placeholder="Min. 4 karakter">
        </div>
        <div class="form-group">
          <label class="form-label" for="ca-reg-confirm">Konfirmasi</label>
          <input type="password" class="form-input" id="ca-reg-confirm" placeholder="Ulangi password">
        </div>
      </div>
      <button class="btn-primary" style="width:100%;justify-content:center" onclick="registerCustomer()">Daftar & Masuk</button>
    </div>
  </div>
</div>

<div class="modal-overlay" id="customer-modal-overlay" onclick="if(event.target===this) closeCustomerModal()">
  <div class="modal-card">
    <div class="modal-head">
      <div class="modal-title" id="customer-modal-title">Tambah Pelanggan</div>
      <button class="modal-close" onclick="closeCustomerModal()" aria-label="Tutup">✕</button>
    </div>
    <div class="form-group">
      <label class="form-label" for="c-nama">Nama Lengkap</label>
      <input type="text" class="form-input" id="c-nama" placeholder="Nama pelanggan">
    </div>
    <div class="form-group">
      <label class="form-label" for="c-telp">No. Telepon</label>
      <input type="tel" class="form-input" id="c-telp" placeholder="08xx-xxxx-xxxx">
    </div>
    <div class="form-group">
      <label class="form-label" for="c-alamat">Alamat</label>
      <textarea class="form-input" id="c-alamat" placeholder="Alamat lengkap"></textarea>
    </div>
    <button class="btn-primary" style="width:100%;justify-content:center" onclick="saveCustomer()">Simpan</button>
  </div>
</div>

<div class="modal-overlay" id="kurir-modal-overlay" onclick="if(event.target===this) closeKurirModal()">
  <div class="modal-card">
    <div class="modal-head">
      <div class="modal-title" id="kurir-modal-title">Tambah Kurir</div>
      <button class="modal-close" onclick="closeKurirModal()" aria-label="Tutup">✕</button>
    </div>
    <div class="form-group">
      <label class="form-label" for="k-nama">Nama Lengkap</label>
      <input type="text" class="form-input" id="k-nama" placeholder="Nama kurir">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="k-username">Username</label>
        <input type="text" class="form-input" id="k-username" placeholder="kurir3">
      </div>
      <div class="form-group">
        <label class="form-label" for="k-password">Password</label>
        <input type="text" class="form-input" id="k-password" placeholder="kurir123">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label" for="k-telp">No. Telepon</label>
      <input type="tel" class="form-input" id="k-telp" placeholder="08xx-xxxx-xxxx">
    </div>
    <button class="btn-primary" style="width:100%;justify-content:center" onclick="saveKurir()">Simpan</button>
  </div>
</div>

<div id="toast" role="alert" aria-live="assertive">
  <span class="toast-icon" id="toast-icon" aria-hidden="true">✓</span>
  <span id="toast-msg"></span>
</div>

<script>
const PRODUCTS = [
  { id:1, icon:'💧', name:'Air Galon Isi Ulang', desc:'Air murni proses RO 7 tahap, segar dan bebas bakteri. Galon 19 liter.', price:5000, unit:'galon', cat:'galon', stock:'ok' },
  { id:2, icon:'🏷️', name:'Galon Kosong Baru', desc:'Galon HDPE food grade 19L, bebas BPA. Bisa dipakai berulang.', price:50000, unit:'pcs', cat:'layanan', stock:'ok' },
  { id:3, icon:'🔧', name:'Cuci & Steril Galon', desc:'Cuci luar-dalam + sterilisasi UV. Harga per galon.', price:3000, unit:'galon', cat:'layanan', stock:'ok' },
];

let cart = [];
let orders = [];
let deliveryMethod = 'antar';
let paymentMethod  = 'tunai';
let activeCategory = 'semua';

const ADMIN_ACCOUNTS = [
  { username: 'admin', password: '040601', name: 'Thariq Ridzwan' },
];
let COURIERS = [
  { id: 1, username: 'kurir1', password: '070396', name: 'Arga Samudra', phone: '0812-3456-7890', status: 'aktif' },
  { id: 2, username: 'kurir2', password: '110405', name: 'Farezi Syach', phone: '0813-9876-5432', status: 'aktif' },
];
let CUSTOMERS = [
  { id: 1, nama: 'Malina', telp: '081234567892', alamat: 'Jl. Tiban Riau No. 5, Batam Kota' },
  { id: 2, nama: 'Nurmalina', telp: '081111111111', alamat: 'Jl. Tiban Koperasi No. 12, Sekupang' },
];
let nextCourierId = 3;
let nextCustomerId = 3;
let currentUser = null;
let editingCustomerId = null;
let editingKurirId = null;
let adminOrderFilter = 'semua';

// ── AKUN LOGIN PELANGGAN ────────────────────────────────
let CUSTOMER_ACCOUNTS = [
  { id: 1, nama: 'Malina', telp: '081234567892', password: 'malina00', alamat: 'Jl. Tiban Riau No. 5, Batam Kota' },
];
let nextCustomerAccountId = 2;
let currentCustomer = null;
let pendingPage = null;

// ── RENDER PRODUCTS ────────────────────────────────────
function renderProducts(list) {
  const grid = document.getElementById('product-grid');
  document.getElementById('product-count').textContent = list.length + ' produk';
  if (!list.length) {
    grid.innerHTML = '<p style="color:var(--muted);font-size:14px;grid-column:1/-1;padding:40px 0;text-align:center">Produk tidak ditemukan.</p>';
    return;
  }
  grid.innerHTML = list.map(p => `
    <div class="product-card" role="listitem">
      <span class="prod-badge ${p.stock === 'ok' ? 'badge-ok' : 'badge-low'}">${p.stock === 'ok' ? 'Tersedia' : 'Terbatas'}</span>
      <span class="prod-icon" aria-hidden="true">${p.icon}</span>
      <div class="prod-name">${p.name}</div>
      <div class="prod-desc">${p.desc}</div>
      <div class="prod-footer">
        <div><span class="prod-price">Rp ${p.price.toLocaleString('id-ID')}</span><span class="prod-unit">/${p.unit}</span></div>
        <button class="add-to-cart" onclick="addToCart(${p.id})" aria-label="Tambah ${p.name} ke keranjang">+</button>
      </div>
    </div>
  `).join('');
}

function filterProducts() {
  const q = document.getElementById('search-input').value.toLowerCase();
  let list = PRODUCTS.filter(p => activeCategory === 'semua' || p.cat === activeCategory);
  if (q) list = list.filter(p => p.name.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
  renderProducts(list);
}

function filterCat(btn, cat) {
  activeCategory = cat;
  document.querySelectorAll('#page-produk .filter-chip').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  filterProducts();
}

// ── CART ───────────────────────────────────────────────
function addToCart(id) {
  const p = PRODUCTS.find(x => x.id === id);
  const ex = cart.find(x => x.id === id);
  if (ex) ex.qty++;
  else cart.push({ ...p, qty: 1 });
  updateCartBadge();
  toast(p.icon + ' ' + p.name + ' ditambahkan');
}

function changeQty(id, delta) {
  const idx = cart.findIndex(x => x.id === id);
  if (idx < 0) return;
  cart[idx].qty += delta;
  if (cart[idx].qty < 1) cart.splice(idx, 1);
  updateCartBadge();
  renderCart();
}

function removeFromCart(id) {
  cart = cart.filter(x => x.id !== id);
  updateCartBadge();
  renderCart();
}

function updateCartBadge() {
  const total = cart.reduce((a, b) => a + b.qty, 0);
  const el = document.getElementById('cart-nav-count');
  el.textContent = total;
  el.classList.toggle('show', total > 0);
  document.getElementById('cart-count-label').textContent = total ? total + ' item' : '';
}

function getSubtotal() { return cart.reduce((a, b) => a + b.price * b.qty, 0); }
function getOngkir()   { return deliveryMethod === 'antar' ? 3000 : 0; }
function getTotal()    { return getSubtotal() + getOngkir(); }

function renderCart() {
  const el = document.getElementById('cart-content');
  if (!cart.length) {
    el.innerHTML = `
      <div class="cart-empty-state">
        <span class="empty-icon" aria-hidden="true">🛒</span>
        <p>Keranjang kamu masih kosong.</p>
        <button class="btn-primary" onclick="showPage('produk')" style="margin:0 auto">
          Lihat Produk
        </button>
      </div>`;
    return;
  }
  const ongkir = getOngkir();
  const total  = getTotal();
  el.innerHTML = `
    <div class="cart-layout">
      <div>
        ${cart.map(item => `
          <div class="cart-item-card">
            <span class="ci-icon" aria-hidden="true">${item.icon}</span>
            <div class="ci-info">
              <div class="ci-name">${item.name}</div>
              <div class="ci-price-unit">Rp ${item.price.toLocaleString('id-ID')} / ${item.unit}</div>
            </div>
            <div class="qty-ctrl">
              <button class="qty-btn" onclick="changeQty(${item.id},-1)" aria-label="Kurangi ${item.name}">−</button>
              <span class="qty-num" aria-label="Jumlah: ${item.qty}">${item.qty}</span>
              <button class="qty-btn" onclick="changeQty(${item.id},1)" aria-label="Tambah ${item.name}">+</button>
            </div>
            <div class="ci-total">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</div>
            <button class="ci-remove" onclick="removeFromCart(${item.id})" aria-label="Hapus ${item.name}">
              <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        `).join('')}
      </div>
      <div class="cart-summary-card">
        <div class="cs-title">Ringkasan</div>
        <div class="cs-row"><span>Subtotal (${cart.reduce((a,b)=>a+b.qty,0)} item)</span><span>Rp ${getSubtotal().toLocaleString('id-ID')}</span></div>
        <div class="cs-row"><span>Ongkos kirim</span><span>${ongkir > 0 ? 'Rp ' + ongkir.toLocaleString('id-ID') : 'Gratis'}</span></div>
        <div class="cs-divider"></div>
        <div class="cs-total">
          <span class="cs-total-label">Total Bayar</span>
          <span class="cs-total-val">Rp ${total.toLocaleString('id-ID')}</span>
        </div>
        <div class="promo-row">
          <input type="text" class="promo-input" placeholder="Kode promo…" id="promo-field">
          <button class="promo-btn" onclick="applyPromo()">Pakai</button>
        </div>
        <button class="checkout-btn" onclick="showPage('pesan')">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          Lanjut ke Pemesanan
        </button>
      </div>
    </div>`;
}

function applyPromo() {
  const code = document.getElementById('promo-field').value.trim().toUpperCase();
  if (code === 'AIR10') toast('🎉 Promo AIR10 berhasil! Diskon Rp 1.000');
  else toast('Kode promo tidak valid.', true);
}

// ── ORDER FORM ─────────────────────────────────────────
function renderOrderSummary() {
  const itemsEl  = document.getElementById('oc-items');
  const totalsEl = document.getElementById('oc-totals');
  if (!itemsEl || !totalsEl) return;
  const ongkir = getOngkir();
  const total  = getTotal();
  const payLabels = { tunai:'Tunai', transfer:'Transfer Bank', qris:'QRIS', ewallet:'E-Wallet' };
  const delLabels = { antar:'Antar ke Rumah (+Rp 3.000)', ambil:'Ambil Sendiri (Gratis)' };
  itemsEl.innerHTML = cart.map(x => `
    <div class="oc-item">
      <span class="oc-item-name">${x.icon} ${x.name} ×${x.qty}</span>
      <span class="oc-item-val">Rp ${(x.price*x.qty).toLocaleString('id-ID')}</span>
    </div>`).join('') + (cart.length ? '' : '<p style="color:var(--muted);font-size:13px;">Keranjang kosong.</p>');
  totalsEl.innerHTML = `
    <div class="oc-item"><span class="oc-item-name">Pengiriman</span><span class="oc-item-val">${delLabels[deliveryMethod]}</span></div>
    <div class="oc-item"><span class="oc-item-name">Pembayaran</span><span class="oc-item-val">${payLabels[paymentMethod]}</span></div>
    <div class="oc-total-row">
      <span class="oc-total-label">Total</span>
      <span class="oc-total-val">Rp ${total.toLocaleString('id-ID')}</span>
    </div>`;
}

function selectOpt(type, val, el) {
  if (type === 'delivery') deliveryMethod = val;
  else paymentMethod = val;
  const container = el.closest('.option-grid, [id$="-opts"]');
  container.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  renderOrderSummary();
}

function submitOrder() {
  const nama   = document.getElementById('f-nama').value.trim();
  const telp   = document.getElementById('f-telp').value.trim();
  const alamat = document.getElementById('f-alamat').value.trim();
  if (!nama)   { toast('Nama lengkap wajib diisi.', true); document.getElementById('f-nama').focus(); return; }
  if (!telp)   { toast('No. telepon wajib diisi.', true);  document.getElementById('f-telp').focus(); return; }
  if (!alamat) { toast('Alamat pengiriman wajib diisi.', true); document.getElementById('f-alamat').focus(); return; }
  if (!cart.length) { toast('Keranjang kosong. Tambahkan produk dulu.', true); return; }

  const now = new Date();
  const id  = 'ORD-' + now.getTime().toString().slice(-7);
  const payLabels = { tunai:'Tunai', transfer:'Transfer Bank', qris:'QRIS', ewallet:'E-Wallet' };
  const delLabels = { antar:'Antar', ambil:'Ambil Sendiri' };

  orders.unshift({
    id, nama, telp, alamat,
    custId: currentCustomer ? currentCustomer.id : null,
    kecamatan: document.getElementById('f-kecamatan').value,
    waktu:  document.getElementById('f-waktu').value,
    catatan: document.getElementById('f-catatan').value,
    items:   [...cart],
    delivery: deliveryMethod,
    payment:  paymentMethod,
    payLabel: payLabels[paymentMethod],
    delLabel: delLabels[deliveryMethod],
    subtotal: getSubtotal(),
    ongkir:   getOngkir(),
    total:    getTotal(),
    status:   'proses',
    kurirId: null,
    kurirNama: null,
    time:     now.toLocaleString('id-ID', { day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit' }),
  });

  // Simpan otomatis sebagai data pelanggan bila nomor telepon belum tercatat
  if (!CUSTOMERS.find(c => c.telp === telp)) {
    CUSTOMERS.push({ id: nextCustomerId++, nama, telp, alamat });
  }
  // Perbarui alamat tersimpan di akun pelanggan bila diubah saat checkout
  if (currentCustomer) currentCustomer.alamat = alamat;

  cart = [];
  updateCartBadge();
  document.getElementById('f-catatan').value = '';
  document.getElementById('f-kecamatan').value = '';
  toast('✅ Pesanan ' + id + ' berhasil dikirim!');
  setTimeout(() => showPage('riwayat'), 900);
}

// ── HISTORY (PELANGGAN) ─────────────────────────────────
function renderHistory() {
  const el = document.getElementById('history-list');
  const mine = orders
    .map((o, idx) => ({ ...o, _idx: idx }))
    .filter(o => currentCustomer && o.custId === currentCustomer.id);
  if (!mine.length) {
    el.innerHTML = `<div class="empty-history"><span class="empty-icon" aria-hidden="true">📋</span><p>Belum ada pesanan. Mulai pesan sekarang!</p><br><button class="btn-primary" onclick="showPage('produk')" style="margin:0 auto">Pesan Sekarang</button></div>`;
    return;
  }
  const statusLabel = { proses:'Diproses', dikirim:'Dikirim', selesai:'Selesai' };
  el.innerHTML = mine.map(o => `
    <div class="order-history-card">
      <div class="oh-header">
        <div>
          <div class="oh-id">${o.id}</div>
          <div class="oh-time">${o.time}</div>
          <div class="oh-customer">${o.nama} · ${o.telp}</div>
        </div>
        <span class="status-pill status-${o.status}">${statusLabel[o.status]}</span>
      </div>
      <div class="oh-items">${o.items.map(x => x.icon + ' ' + x.name + ' ×' + x.qty).join('  ·  ')}</div>
      <div class="oh-footer">
        <div class="oh-meta">
          <span class="oh-meta-item">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            ${o.delLabel}${o.kurirNama ? ' · ' + o.kurirNama : ''}
          </span>
          <span class="oh-meta-item">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
            ${o.payLabel}
          </span>
        </div>
        <div class="oh-total">Rp ${o.total.toLocaleString('id-ID')}</div>
      </div>
      <div class="oh-track" id="track-${o._idx}">
        <div class="track-step"><span class="track-dot done"></span><div class="track-text"><strong>Pesanan diterima</strong>${o.time}</div></div>
        <div class="track-step"><span class="track-dot ${o.status !== 'proses' ? 'done' : ''}"></span><div class="track-text"><strong>Sedang diproses</strong>${o.status !== 'proses' ? 'Galon sedang disiapkan' : 'Menunggu konfirmasi'}</div></div>
        <div class="track-step"><span class="track-dot ${o.status === 'dikirim' ? 'active' : o.status === 'selesai' ? 'done' : ''}"></span><div class="track-text"><strong>Dalam pengiriman</strong>${o.status === 'dikirim' ? 'Kurir sedang menuju lokasi' : o.status === 'selesai' ? 'Telah dikirim' : '–'}</div></div>
        <div class="track-step"><span class="track-dot ${o.status === 'selesai' ? 'done' : ''}"></span><div class="track-text"><strong>Pesanan selesai</strong>${o.status === 'selesai' ? 'Diterima pelanggan' : '–'}</div></div>
      </div>
      <div style="margin-top:12px;border-top:1px solid var(--border);padding-top:12px;display:flex;gap:8px">
        <button class="track-btn" onclick="toggleTrack(${o._idx})">Lacak pesanan</button>
        <button class="track-btn" onclick="reorder(${o._idx})">Pesan lagi</button>
      </div>
    </div>`).join('');
}

function toggleTrack(i) {
  const el = document.getElementById('track-' + i);
  el.classList.toggle('open');
}

function reorder(i) {
  const o = orders[i];
  o.items.forEach(item => {
    const ex = cart.find(x => x.id === item.id);
    if (ex) ex.qty += item.qty;
    else cart.push({ ...item });
  });
  updateCartBadge();
  toast('Item dari ' + o.id + ' ditambahkan ke keranjang');
  showPage('keranjang');
}

// ── AUTH / STAFF LOGIN ──────────────────────────────────
function openStaffModal() {
  document.getElementById('staff-modal-overlay').classList.add('show');
}
function closeStaffModal() {
  document.getElementById('staff-modal-overlay').classList.remove('show');
  ['admin-username','admin-password','kurir-username','kurir-password'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
}
function switchLoginTab(role) {
  const isAdmin = role === 'admin';
  document.getElementById('tab-btn-admin').classList.toggle('active', isAdmin);
  document.getElementById('tab-btn-kurir').classList.toggle('active', !isAdmin);
  document.getElementById('login-form-admin').style.display = isAdmin ? 'block' : 'none';
  document.getElementById('login-form-kurir').style.display = isAdmin ? 'none' : 'block';
}

function loginAdmin() {
  const u = document.getElementById('admin-username').value.trim();
  const p = document.getElementById('admin-password').value;
  const acc = ADMIN_ACCOUNTS.find(a => a.username === u && a.password === p);
  if (!acc) { toast('Username atau password admin salah.', true); return; }
  enterRoleMode('admin', { name: acc.name, username: acc.username });
}

function loginKurir() {
  const u = document.getElementById('kurir-username').value.trim();
  const p = document.getElementById('kurir-password').value;
  const acc = COURIERS.find(a => a.username === u && a.password === p);
  if (!acc) { toast('Username atau password kurir salah.', true); return; }
  if (acc.status === 'nonaktif') { toast('Akun kurir ini sedang dinonaktifkan. Hubungi admin.', true); return; }
  enterRoleMode('kurir', { name: acc.name, username: acc.username, id: acc.id });
}

function enterRoleMode(role, user) {
  currentUser = { role, ...user };
  document.getElementById('hero-section').style.display = 'none';
  document.getElementById('nav-tabs-customer').style.display = 'none';
  document.getElementById('nav-tabs-admin').style.display = role === 'admin' ? 'flex' : 'none';
  document.getElementById('nav-tabs-kurir').style.display = role === 'kurir' ? 'flex' : 'none';
  document.getElementById('badge-open').style.display = 'none';
  document.getElementById('cart-nav-btn').style.display = 'none';
  document.getElementById('staff-login-btn').style.display = 'none';
  document.getElementById('customer-auth-btn').style.display = 'none';
  document.getElementById('customer-chip').style.display = 'none';
  document.getElementById('user-chip').style.display = 'flex';
  document.getElementById('user-chip-role').textContent = role === 'admin' ? 'Admin' : 'Kurir';
  document.getElementById('user-chip-name').textContent = user.name;
  closeStaffModal();
  if (role === 'admin') showPage('admin-pesanan'); else showPage('kurir-pengiriman');
  toast('Selamat datang, ' + user.name + '!');
}

function exitRoleMode() {
  currentUser = null;
  document.getElementById('hero-section').style.display = '';
  document.getElementById('nav-tabs-customer').style.display = 'flex';
  document.getElementById('nav-tabs-admin').style.display = 'none';
  document.getElementById('nav-tabs-kurir').style.display = 'none';
  document.getElementById('badge-open').style.display = 'flex';
  document.getElementById('cart-nav-btn').style.display = 'flex';
  document.getElementById('staff-login-btn').style.display = 'flex';
  document.getElementById('user-chip').style.display = 'none';
  document.getElementById('customer-auth-btn').style.display = currentCustomer ? 'none' : 'flex';
  document.getElementById('customer-chip').style.display = currentCustomer ? 'flex' : 'none';
  showPage('produk');
  toast('Berhasil keluar dari mode staf');
}

// ── AUTH / LOGIN & REGISTER PELANGGAN ───────────────────
function openCustomerAuthModal(tab) {
  switchCustomerAuthTab(tab || 'masuk');
  document.getElementById('customer-auth-modal-overlay').classList.add('show');
}
function closeCustomerAuthModal() {
  document.getElementById('customer-auth-modal-overlay').classList.remove('show');
  pendingPage = null;
}
function switchCustomerAuthTab(tab) {
  const isMasuk = tab === 'masuk';
  document.getElementById('ca-tab-btn-masuk').classList.toggle('active', isMasuk);
  document.getElementById('ca-tab-btn-daftar').classList.toggle('active', !isMasuk);
  document.getElementById('ca-form-masuk').style.display = isMasuk ? 'block' : 'none';
  document.getElementById('ca-form-daftar').style.display = isMasuk ? 'none' : 'block';
}

function loginCustomer() {
  const telp = document.getElementById('ca-login-telp').value.trim();
  const pass = document.getElementById('ca-login-password').value;
  if (!telp || !pass) { toast('No. telepon dan password wajib diisi.', true); return; }
  const acc = CUSTOMER_ACCOUNTS.find(c => c.telp === telp && c.password === pass);
  if (!acc) { toast('No. telepon atau password salah.', true); return; }
  setCurrentCustomer(acc);
  closeCustomerAuthModal();
  toast('Selamat datang kembali, ' + acc.nama + '!');
  const target = pendingPage || 'produk';
  pendingPage = null;
  showPage(target);
}

function registerCustomer() {
  const nama    = document.getElementById('ca-reg-nama').value.trim();
  const telp    = document.getElementById('ca-reg-telp').value.trim();
  const alamat  = document.getElementById('ca-reg-alamat').value.trim();
  const pass    = document.getElementById('ca-reg-password').value;
  const confirm = document.getElementById('ca-reg-confirm').value;
  if (!nama || !telp || !pass || !confirm) { toast('Nama, telepon, dan password wajib diisi.', true); return; }
  if (pass.length < 4) { toast('Password minimal 4 karakter.', true); return; }
  if (pass !== confirm) { toast('Konfirmasi password tidak cocok.', true); return; }
  if (CUSTOMER_ACCOUNTS.find(c => c.telp === telp)) { toast('Nomor telepon sudah terdaftar. Silakan masuk.', true); switchCustomerAuthTab('masuk'); return; }

  const acc = { id: nextCustomerAccountId++, nama, telp, password: pass, alamat };
  CUSTOMER_ACCOUNTS.push(acc);
  if (!CUSTOMERS.find(c => c.telp === telp)) {
    CUSTOMERS.push({ id: nextCustomerId++, nama, telp, alamat: alamat || '-' });
  }
  setCurrentCustomer(acc);
  closeCustomerAuthModal();
  toast('Akun berhasil dibuat. Selamat datang, ' + nama + '!');
  const target = pendingPage || 'produk';
  pendingPage = null;
  showPage(target);
}

function setCurrentCustomer(acc) {
  currentCustomer = acc;
  document.getElementById('customer-auth-btn').style.display = 'none';
  document.getElementById('customer-chip').style.display = 'flex';
  document.getElementById('customer-chip-name').textContent = acc.nama;
  document.getElementById('f-nama').value = acc.nama;
  document.getElementById('f-telp').value = acc.telp;
  document.getElementById('f-alamat').value = acc.alamat || '';
  ['ca-login-telp','ca-login-password','ca-reg-nama','ca-reg-telp','ca-reg-alamat','ca-reg-password','ca-reg-confirm'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
}

function logoutCustomer() {
  currentCustomer = null;
  document.getElementById('customer-auth-btn').style.display = 'flex';
  document.getElementById('customer-chip').style.display = 'none';
  ['f-nama','f-telp','f-alamat'].forEach(id => document.getElementById(id).value = '');
  showPage('produk');
  toast('Berhasil keluar dari akun');
}

function goHome() {
  if (currentUser?.role === 'admin') showPage('admin-pesanan');
  else if (currentUser?.role === 'kurir') showPage('kurir-pengiriman');
  else showPage('produk');
}

// ── ADMIN: KELOLA PESANAN ───────────────────────────────
function filterAdminOrders(btn, status) {
  adminOrderFilter = status;
  document.querySelectorAll('#page-admin-pesanan .filter-chip').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderAdminPesanan();
}

function renderAdminPesanan() {
  const el = document.getElementById('admin-pesanan-list');
  const statusLabel = { proses:'Diproses', dikirim:'Dikirim', selesai:'Selesai' };
  const list = orders
    .map((o, idx) => ({ ...o, _idx: idx }))
    .filter(o => adminOrderFilter === 'semua' || o.status === adminOrderFilter);
  document.getElementById('admin-pesanan-count').textContent = orders.length + ' total';
  if (!list.length) {
    el.innerHTML = `<div class="empty-history"><span class="empty-icon" aria-hidden="true">📦</span><p>Belum ada pesanan pada kategori ini.</p></div>`;
    return;
  }
  el.innerHTML = list.map(o => `
    <div class="admin-order-card">
      <div class="oh-header">
        <div>
          <div class="oh-id">${o.id}</div>
          <div class="oh-time">${o.time}</div>
          <div class="oh-customer">${o.nama} · ${o.telp}</div>
        </div>
        <span class="status-pill status-${o.status}">${statusLabel[o.status]}</span>
      </div>
      <div class="oh-items">${o.items.map(x => x.icon + ' ' + x.name + ' ×' + x.qty).join('  ·  ')}</div>
      <div class="oh-footer">
        <div class="oh-meta">
          <span class="oh-meta-item">${o.delLabel} · ${o.payLabel}</span>
        </div>
        <div class="oh-total">Rp ${o.total.toLocaleString('id-ID')}</div>
      </div>
      <div class="admin-order-controls">
        <div class="form-group">
          <label class="form-label">Ubah Status</label>
          <select class="form-input" onchange="adminSetStatus(${o._idx}, this.value)">
            <option value="proses" ${o.status==='proses'?'selected':''}>Diproses</option>
            <option value="dikirim" ${o.status==='dikirim'?'selected':''}>Dikirim</option>
            <option value="selesai" ${o.status==='selesai'?'selected':''}>Selesai</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tugaskan Kurir</label>
          <select class="form-input" onchange="adminAssignKurir(${o._idx}, this.value)">
            <option value="">Belum ditugaskan</option>
            ${COURIERS.map(k => `<option value="${k.id}" ${o.kurirId===k.id?'selected':''}>${k.name}</option>`).join('')}
          </select>
        </div>
        <button class="track-btn danger" onclick="adminDeleteOrder(${o._idx})">Hapus Pesanan</button>
      </div>
    </div>`).join('');
}

function adminSetStatus(i, val) {
  orders[i].status = val;
  renderAdminPesanan();
  toast('Status pesanan ' + orders[i].id + ' diperbarui');
}

function adminAssignKurir(i, val) {
  if (!val) {
    orders[i].kurirId = null;
    orders[i].kurirNama = null;
  } else {
    const k = COURIERS.find(c => c.id == val);
    orders[i].kurirId = k.id;
    orders[i].kurirNama = k.name;
  }
  renderAdminPesanan();
  toast('Kurir untuk ' + orders[i].id + ' diperbarui');
}

function adminDeleteOrder(i) {
  const id = orders[i].id;
  orders.splice(i, 1);
  renderAdminPesanan();
  toast('Pesanan ' + id + ' dihapus');
}

// ── ADMIN: KELOLA PELANGGAN ─────────────────────────────
function renderAdminPelanggan() {
  const body = document.getElementById('admin-pelanggan-body');
  document.getElementById('admin-pelanggan-count').textContent = CUSTOMERS.length + ' pelanggan';
  if (!CUSTOMERS.length) {
    body.innerHTML = `<tr><td colspan="5" style="text-align:center;color:var(--muted);padding:40px 0">Belum ada data pelanggan.</td></tr>`;
    return;
  }
  body.innerHTML = CUSTOMERS.map(c => {
    const totalPesanan = orders.filter(o => o.telp === c.telp).length;
    return `
    <tr>
      <td>${c.nama}</td>
      <td class="muted-cell">${c.telp}</td>
      <td class="muted-cell">${c.alamat}</td>
      <td>${totalPesanan}</td>
      <td>
        <div class="row-actions">
          <button class="icon-btn" onclick="openCustomerModal(${c.id})" aria-label="Edit ${c.nama}">✎</button>
          <button class="icon-btn danger" onclick="deleteCustomer(${c.id})" aria-label="Hapus ${c.nama}">🗑</button>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function openCustomerModal(id = null) {
  editingCustomerId = id;
  const c = id ? CUSTOMERS.find(x => x.id === id) : null;
  document.getElementById('customer-modal-title').textContent = id ? 'Edit Pelanggan' : 'Tambah Pelanggan';
  document.getElementById('c-nama').value = c ? c.nama : '';
  document.getElementById('c-telp').value = c ? c.telp : '';
  document.getElementById('c-alamat').value = c ? c.alamat : '';
  document.getElementById('customer-modal-overlay').classList.add('show');
}
function closeCustomerModal() {
  document.getElementById('customer-modal-overlay').classList.remove('show');
}
function saveCustomer() {
  const nama = document.getElementById('c-nama').value.trim();
  const telp = document.getElementById('c-telp').value.trim();
  const alamat = document.getElementById('c-alamat').value.trim();
  if (!nama || !telp || !alamat) { toast('Semua kolom wajib diisi.', true); return; }
  if (editingCustomerId) {
    const c = CUSTOMERS.find(x => x.id === editingCustomerId);
    c.nama = nama; c.telp = telp; c.alamat = alamat;
    toast('Data pelanggan diperbarui');
  } else {
    CUSTOMERS.push({ id: nextCustomerId++, nama, telp, alamat });
    toast('Pelanggan baru ditambahkan');
  }
  closeCustomerModal();
  renderAdminPelanggan();
}
function deleteCustomer(id) {
  CUSTOMERS = CUSTOMERS.filter(c => c.id !== id);
  renderAdminPelanggan();
  toast('Pelanggan dihapus');
}

// ── ADMIN: KELOLA KURIR ─────────────────────────────────
function renderAdminKurir() {
  const body = document.getElementById('admin-kurir-body');
  document.getElementById('admin-kurir-count').textContent = COURIERS.length + ' kurir';
  if (!COURIERS.length) {
    body.innerHTML = `<tr><td colspan="6" style="text-align:center;color:var(--muted);padding:40px 0">Belum ada data kurir.</td></tr>`;
    return;
  }
  body.innerHTML = COURIERS.map(k => {
    const tugasAktif = orders.filter(o => o.kurirId === k.id && o.status !== 'selesai').length;
    return `
    <tr>
      <td>${k.name}</td>
      <td class="muted-cell">${k.username}</td>
      <td class="muted-cell">${k.phone}</td>
      <td><button class="status-toggle status-${k.status}" onclick="toggleKurirStatus(${k.id})">${k.status === 'aktif' ? 'Aktif' : 'Nonaktif'}</button></td>
      <td>${tugasAktif} pengiriman</td>
      <td>
        <div class="row-actions">
          <button class="icon-btn" onclick="openKurirModal(${k.id})" aria-label="Edit ${k.name}">✎</button>
          <button class="icon-btn danger" onclick="deleteKurir(${k.id})" aria-label="Hapus ${k.name}">🗑</button>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function toggleKurirStatus(id) {
  const k = COURIERS.find(x => x.id === id);
  k.status = k.status === 'aktif' ? 'nonaktif' : 'aktif';
  renderAdminKurir();
  toast('Status ' + k.name + ' diubah menjadi ' + k.status);
}

function openKurirModal(id = null) {
  editingKurirId = id;
  const k = id ? COURIERS.find(x => x.id === id) : null;
  document.getElementById('kurir-modal-title').textContent = id ? 'Edit Kurir' : 'Tambah Kurir';
  document.getElementById('k-nama').value = k ? k.name : '';
  document.getElementById('k-username').value = k ? k.username : '';
  document.getElementById('k-password').value = k ? k.password : '';
  document.getElementById('k-telp').value = k ? k.phone : '';
  document.getElementById('kurir-modal-overlay').classList.add('show');
}
function closeKurirModal() {
  document.getElementById('kurir-modal-overlay').classList.remove('show');
}
function saveKurir() {
  const name = document.getElementById('k-nama').value.trim();
  const username = document.getElementById('k-username').value.trim();
  const password = document.getElementById('k-password').value.trim();
  const phone = document.getElementById('k-telp').value.trim();
  if (!name || !username || !password || !phone) { toast('Semua kolom wajib diisi.', true); return; }
  const dupe = COURIERS.find(k => k.username === username && k.id !== editingKurirId);
  if (dupe) { toast('Username kurir sudah digunakan.', true); return; }
  if (editingKurirId) {
    const k = COURIERS.find(x => x.id === editingKurirId);
    k.name = name; k.username = username; k.password = password; k.phone = phone;
    toast('Data kurir diperbarui');
  } else {
    COURIERS.push({ id: nextCourierId++, username, password, name, phone, status: 'aktif' });
    toast('Kurir baru ditambahkan');
  }
  closeKurirModal();
  renderAdminKurir();
}
function deleteKurir(id) {
  COURIERS = COURIERS.filter(k => k.id !== id);
  orders.forEach(o => { if (o.kurirId === id) { o.kurirId = null; o.kurirNama = null; } });
  renderAdminKurir();
  toast('Kurir dihapus');
}

// ── ADMIN: LAPORAN ──────────────────────────────────────
function renderAdminLaporan() {
  const el = document.getElementById('admin-laporan-content');
  const totalPesanan = orders.length;
  const totalPendapatan = orders.reduce((a, o) => a + o.total, 0);
  const cProses = orders.filter(o => o.status === 'proses').length;
  const cDikirim = orders.filter(o => o.status === 'dikirim').length;
  const cSelesai = orders.filter(o => o.status === 'selesai').length;

  const prodMap = {};
  orders.forEach(o => o.items.forEach(it => { prodMap[it.name] = (prodMap[it.name] || 0) + it.qty; }));
  const topProd = Object.entries(prodMap).sort((a, b) => b[1] - a[1]).slice(0, 5);

  const kurirMap = {};
  orders.forEach(o => { if (o.kurirNama) kurirMap[o.kurirNama] = (kurirMap[o.kurirNama] || 0) + 1; });
  const topKurir = Object.entries(kurirMap).sort((a, b) => b[1] - a[1]);

  el.innerHTML = `
    <div class="report-grid">
      <div class="stat-card"><span class="stat-num">${totalPesanan}</span><span class="stat-label">Total Pesanan</span></div>
      <div class="stat-card"><span class="stat-num" style="font-size:19px">Rp ${totalPendapatan.toLocaleString('id-ID')}</span><span class="stat-label">Total Pendapatan</span></div>
      <div class="stat-card"><span class="stat-num">${cProses}/${cDikirim}</span><span class="stat-label">Diproses / Dikirim</span></div>
      <div class="stat-card"><span class="stat-num">${cSelesai}</span><span class="stat-label">Selesai</span></div>
    </div>
    <div class="form-card" style="margin-bottom:16px">
      <div class="form-card-title">Produk Terlaris</div>
      ${topProd.length ? topProd.map(([name, qty], idx) => `
        <div class="oc-item"><span class="oc-item-name">${idx + 1}. ${name}</span><span class="oc-item-val">${qty} terjual</span></div>
      `).join('') : '<p style="color:var(--muted);font-size:13px">Belum ada data penjualan.</p>'}
    </div>
    <div class="form-card">
      <div class="form-card-title">Pengiriman per Kurir</div>
      ${topKurir.length ? topKurir.map(([name, count]) => `
        <div class="oc-item"><span class="oc-item-name">${name}</span><span class="oc-item-val">${count} pesanan</span></div>
      `).join('') : '<p style="color:var(--muted);font-size:13px">Belum ada pesanan yang ditugaskan ke kurir.</p>'}
    </div>`;
}

// ── KURIR: DAFTAR PENGIRIMAN ────────────────────────────
function renderKurirPengiriman() {
  const el = document.getElementById('kurir-pengiriman-list');
  if (!currentUser || currentUser.role !== 'kurir') return;
  const statusLabel = { proses:'Diproses', dikirim:'Dikirim', selesai:'Selesai' };
  const mine = orders
    .map((o, idx) => ({ ...o, _idx: idx }))
    .filter(o => o.kurirId === currentUser.id);
  document.getElementById('kurir-pengiriman-count').textContent = mine.length + ' pesanan';
  if (!mine.length) {
    el.innerHTML = `<div class="empty-history"><span class="empty-icon" aria-hidden="true">🚚</span><p>Belum ada pengiriman yang ditugaskan ke kamu.</p></div>`;
    return;
  }
  el.innerHTML = mine.map(o => `
    <div class="order-history-card">
      <div class="oh-header">
        <div>
          <div class="oh-id">${o.id}</div>
          <div class="oh-time">${o.time}</div>
          <div class="oh-customer">${o.nama} · ${o.telp}</div>
        </div>
        <span class="status-pill status-${o.status}">${statusLabel[o.status]}</span>
      </div>
      <div class="kurir-deliver-card">
        <div class="oh-items">${o.items.map(x => x.icon + ' ' + x.name + ' ×' + x.qty).join('  ·  ')}</div>
        <div class="kurir-addr">📍 ${o.alamat}${o.kecamatan ? ', Kec. ' + o.kecamatan : ''}</div>
      </div>
      <div class="oh-footer">
        <div class="oh-meta">
          <span class="oh-meta-item">${o.delLabel} · ${o.payLabel}</span>
        </div>
        <div class="oh-total">Rp ${o.total.toLocaleString('id-ID')}</div>
      </div>
      <div style="margin-top:12px;border-top:1px solid var(--border);padding-top:12px;display:flex;gap:8px;flex-wrap:wrap">
        ${o.status === 'proses' ? `<button class="btn-primary" style="padding:8px 16px;font-size:13px" onclick="kurirSetStatus(${o._idx},'dikirim')">Mulai Antar</button>` : ''}
        ${o.status === 'dikirim' ? `<button class="btn-primary" style="padding:8px 16px;font-size:13px" onclick="kurirSetStatus(${o._idx},'selesai')">Tandai Selesai</button>` : ''}
        ${o.status === 'selesai' ? `<span class="oh-meta-item" style="color:var(--success)">✓ Pengiriman selesai</span>` : ''}
      </div>
    </div>`).join('');
}

function kurirSetStatus(i, val) {
  orders[i].status = val;
  renderKurirPengiriman();
  toast(val === 'dikirim' ? 'Pengiriman dimulai' : 'Pesanan ditandai selesai');
}

// ── PAGE ROUTING ───────────────────────────────────────
function showPage(page) {
  // Pelanggan wajib masuk/daftar dulu sebelum memesan atau melihat riwayat
  if ((page === 'pesan' || page === 'riwayat') && !currentUser && !currentCustomer) {
    pendingPage = page;
    openCustomerAuthModal('masuk');
    toast(page === 'pesan' ? 'Masuk atau daftar dulu untuk melanjutkan pemesanan.' : 'Masuk atau daftar dulu untuk melihat riwayat pesananmu.', true);
    return;
  }
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('page-' + page).classList.add('active');
  const tabBtn = document.querySelector('[data-page="' + page + '"]');
  if (tabBtn) tabBtn.classList.add('active');
  if (page === 'keranjang')        renderCart();
  if (page === 'pesan')            renderOrderSummary();
  if (page === 'riwayat')          renderHistory();
  if (page === 'admin-pesanan')    renderAdminPesanan();
  if (page === 'admin-pelanggan')  renderAdminPelanggan();
  if (page === 'admin-kurir')      renderAdminKurir();
  if (page === 'admin-laporan')    renderAdminLaporan();
  if (page === 'kurir-pengiriman') renderKurirPengiriman();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ── TOAST ──────────────────────────────────────────────
let toastTimer;
function toast(msg, isError = false) {
  const el   = document.getElementById('toast');
  const icon = document.getElementById('toast-icon');
  const msgEl = document.getElementById('toast-msg');
  clearTimeout(toastTimer);
  icon.textContent = isError ? '✕' : '✓';
  msgEl.textContent = msg;
  el.classList.toggle('error', isError);
  el.classList.add('show');
  toastTimer = setTimeout(() => el.classList.remove('show'), 3000);
}

// ── INIT ───────────────────────────────────────────────
renderProducts(PRODUCTS);
</script>
</body>
</html>