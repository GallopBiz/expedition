<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            .modal-overlay {
              position: fixed; inset: 0;
              background: rgba(30,40,70,0.3);
              backdrop-filter: blur(5px);
              z-index: 100; display: none;
              align-items: center; justify-content: center; padding: 20px;
            }
            .modal-overlay.open { display: flex; }
            .modal {
              background: var(--surface);
              border: 1px solid var(--border);
              border-radius: 16px;
              width: 100%; max-width: 800px; max-height: 92vh;
              overflow-y: auto;
              animation: slideUp 0.25s ease;
              box-shadow: 0 20px 60px rgba(0,0,0,0.14), 0 4px 16px rgba(0,0,0,0.07);
            }
            .modal::-webkit-scrollbar { width: 4px; }
            .modal::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }
            @keyframes slideUp {
              from { transform: translateY(24px); opacity: 0; }
              to   { transform: translateY(0);    opacity: 1; }
            }
            .modal-header {
              padding: 20px 28px;
              border-bottom: 1px solid var(--border);
              display: flex; align-items: center; justify-content: space-between;
              position: sticky; top: 0; background: var(--surface);
              z-index: 10; border-radius: 16px 16px 0 0;
            }
            .modal-title { font-family: 'Figtree', ui-sans-serif, sans-serif; font-size: 20px; font-weight: 700; color: var(--text); }
            .modal-close {
              width: 34px; height: 34px;
              background: var(--surface2); border: 1px solid var(--border);
              border-radius: 8px; cursor: pointer;
              display: flex; align-items: center; justify-content: center;
              color: var(--muted2); font-size: 16px; transition: all 0.15s;
            }
            .modal-close:hover { border-color: var(--warn); color: var(--warn); background: var(--warn-light); }
            .modal-body { padding: 24px 28px; }
            .field-group { margin-bottom: 0px; }
            .modal-footer {
              padding: 16px 28px; border-top: 1px solid var(--border);
              display: flex; gap: 12px; justify-content: flex-end;
              position: sticky; bottom: 0; background: var(--surface);
              border-radius: 0 0 16px 16px;
            }
            .btn-cancel {
              background: transparent; border: 1px solid var(--border2);
              color: var(--muted2); padding: 9px 22px; border-radius: 8px; cursor: pointer;
              font-family: 'Figtree', ui-sans-serif, sans-serif, monospace; font-size: 11px; letter-spacing: 1px;
              text-transform: uppercase; transition: all 0.15s;
            }
            .btn-cancel:hover { border-color: var(--muted2); color: var(--text); background: var(--surface2); }
            .btn-save {
              background: var(--accent); border: none; color: #fff;
              padding: 9px 26px; border-radius: 8px; cursor: pointer;
              font-family: 'Figtree', ui-sans-serif, sans-serif, monospace; font-size: 11px; font-weight: 500;
              letter-spacing: 1px; text-transform: uppercase; transition: all 0.2s;
              box-shadow: 0 2px 8px rgba(10,124,85,0.3);
            }
            .btn-save:hover { background: #0a9966; box-shadow: 0 4px 14px rgba(10,124,85,0.4); }
          :root {
            --bg: #f0f2f7;
            --surface: #ffffff;
            --surface2: #f5f7fb;
            --border: #dde1ec;
            --border2: #c8cedd;
            --accent: #0a7c55;
            --accent-light: #e6f5f0;
            --accent2: #1a6fb5;
            --warn: #c8470a;
            --text: #1a1e2e;
            --muted: #01426a;
            --muted2: #5a6278;
            --shadow: 0 1px 4px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
          }
          body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Figtree', ui-sans-serif, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            height: 100vh;
          }
          .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 13px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
            z-index: 50;
          }
          .topbar-logo {
            font-family: 'Figtree', ui-sans-serif, sans-serif;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: -0.5px;
            color: var(--accent);
          }
          .topbar-title {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 2px;
            text-transform: uppercase;
          }
          .topbar-badge {
            margin-left: auto;
            background: var(--accent-light);
            border: 1px solid rgba(10,124,85,0.25);
            color: var(--accent);
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 1px;
          }
        </style>

        
    @extends('layouts.app')

@section('content')

<style>
  .field-group-label {
    font-size: 9px;
    letter-spacing: 2px;
    color: var(--muted);
    text-transform: uppercase;
    margin-bottom: 11px;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .field-group-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }
  .toggles-row { display: flex; gap: 16px; flex-wrap: wrap; margin-top: 12px; }
  .toggle-item { display: flex; flex-direction: column; align-items: center; gap: 5px; }
  .toggle-item span { font-size: 9px; color: var(--muted); letter-spacing: 1px; text-transform: uppercase; }
  .toggle {
    width: 36px; height: 20px; background: #403d3d99;
    border-radius: 10px; cursor: pointer; position: relative;
    transition: background 0.2s; border: none;
    display: flex; align-items: center;
  }
  .toggle::after {
    content: ''; position: absolute;
    width: 14px; height: 14px; background: white; border-radius: 50%;
    top: 3px; left: 3px; transition: transform 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
  }
  .toggle.on::after { transform: translateX(16px); }
  .toggle.on { background: var(--accent); }
  .toggle.on { background: #01426a; }
/* =========================
   EXPEDITION UI (SCOPED)
   ========================= */
.expedition-app {
  --bg: #f0f2f7;
  --surface: #ffffff;
  --surface2: #f5f7fb;
  --border: #dde1ec;
  --border2: #c8cedd;
  --accent: #0a7c55;
  --accent-light: #e6f5f0;
  --accent2: #1a6fb5;
  --warn: #c8470a;
  --text: #1a1e2e;
  --muted: #01426a;
  --muted2: #5a6278;
  --shadow: 0 1px 4px rgba(0,0,0,0.08);
  font-family: 'Figtree', ui-sans-serif, sans-serif;
  background: var(--bg);
  min-height: 100vh;
}

/* reset */
.expedition-app * {
  box-sizing: border-box;
}

/* TOP BAR */
.expedition-app .topbar {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 14px 32px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.topbar-logo {
  font-family: 'Figtree', ui-sans-serif, sans-serif;
  font-weight: 800;
  color: var(--accent);
}
.topbar-title {
  font-size: 11px;
  letter-spacing: 2px;
  color: var(--muted);
  text-transform: uppercase;
}
.topbar-badge {
  margin-left: auto;
  font-size: 11px;
  padding: 4px 12px;
  border-radius: 20px;
  background: var(--accent-light);
  color: var(--accent);
}

/* OVERALL */
.overall-section {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
}
.overall-header {
  padding: 14px 32px;
  display: flex;
  justify-content: space-between;
  cursor: pointer;
}
.overall-body {
  display: none;
}
.overall-body.open {
  display: block;
}

/* MAIN LAYOUT */
.main {
  display: grid;
  grid-template-columns: 400px 1fr;
  min-height: calc(100vh - 120px);
}

/* LEFT PANEL */
.left-panel {
  background: var(--surface);
  border-right: 1px solid var(--border);
  padding-bottom: 40px;
}
.panel-header {
  padding: 18px 28px;
  border-bottom: 1px solid var(--border);
}
.field-group {
  padding: 16px 28px;
  border-bottom: 1px solid var(--border);
}
.field-label {
  font-size: 11px;
  text-transform: uppercase;
  color: var(--muted);
}
.field-value {
  width: 100%;
  margin-top: 4px;
  padding: 6px 12px;
  border-radius: 7px;
  border: 1px solid var(--border);
  background: var(--surface2);
}

/* RIGHT PANEL */
.right-panel {
    .equipment-header {
      padding: 18px 28px 13px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: var(--surface);
      position: sticky; top: 0; z-index: 5;
      box-shadow: var(--shadow-sm);
    }
    .equipment-header h2 {
      font-family: 'Figtree', ui-sans-serif, sans-serif;
      font-size: 12px; font-weight: 700;
      letter-spacing: 2px; text-transform: uppercase;
      color: var(--muted2);
      display: flex; align-items: center; gap: 8px;
    }
    .equipment-table-wrap { padding: 0 28px 28px; flex: 1; }
    .col-headers {
      display: grid;
      grid-template-columns: 200px 1fr 1fr 1fr 1fr;
      gap: 8px; padding: 12px 10px 9px;
      border-bottom: 1px solid var(--border);
      position: sticky; top: 57px; background: var(--bg); z-index: 4;
    }
    .col-headers span { font-size: 9px; color: var(--muted); letter-spacing: 2px; text-transform: uppercase; }
    .equipment-row {
      display: grid;
      grid-template-columns: 200px 1fr 1fr 1fr 1fr;
      gap: 8px; align-items: center; cursor: pointer;
      border-radius: 8px; padding: 10px;
      margin: 3px -10px;
      transition: background 0.15s, box-shadow 0.15s;
      border: 1px solid transparent;
    }
    .equipment-row:hover {
      background: var(--surface); border-color: var(--border); box-shadow: var(--shadow-sm);
    }
    .eq-name { font-size: 12.5px; color: var(--text); display: flex; align-items: center; gap: 8px; font-weight: 500; }
    .eq-status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .dot-green  { background: var(--accent); box-shadow: 0 0 5px rgba(10,124,85,0.4); }
    .dot-orange { background: var(--warn);   box-shadow: 0 0 5px rgba(200,71,10,0.4); }
    .dot-gray   { background: var(--muted); }
    .progress-cell { display: flex; flex-direction: column; gap: 4px; }
    .progress-label { font-size: 11px; color: var(--muted2); font-weight: 500; }
    .progress-bar { height: 5px; background: var(--border); border-radius: 3px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 3px; transition: width 0.8s ease; }
    .progress-fill.green  { background: var(--accent); }
    .progress-fill.blue   { background: var(--accent2); }
    .progress-fill.warn   { background: var(--warn); }
    .progress-fill.silver { background: var(--muted); }
  background: var(--bg);
}
.equipment-header {
  padding: 18px 28px;
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex;
  justify-content: space-between;
}
.add-btn {
  padding: 8px 16px;
  border-radius: 6px;
  border: 1px solid var(--accent);
  background: var(--accent-light);
  color: var(--accent);
  cursor: pointer;
}
.equipment-row {
  display: grid;
  grid-template-columns: 200px repeat(4,1fr);
  padding: 10px;
  margin: 6px 18px;
  background: var(--surface);
  border-radius: 8px;
  cursor: pointer;
}

/* MODAL */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.3);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.modal-overlay.open {
  display: flex;
}
.modal {
  background: var(--surface);
  width: 900px;
  max-width: 95%;
  border-radius: 16px;
}
.modal-header,
.modal-footer {
  padding: 16px 24px;
  border-bottom: 1px solid var(--border);
}
.modal-footer {
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}
.modal-body {
  padding: 24px;
}
  .main {
    display: grid;
    grid-template-columns: 400px 1fr;
    flex: 1;
    overflow: hidden;
  }
  .left-panel {
    background: var(--surface);
    border-right: 1px solid var(--border);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 120px);
    position: sticky;
    top: 64px;
    min-width: 0;
    z-index: 2;
  }
  .left-panel::-webkit-scrollbar { width: 4px; }
  .left-panel::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }
  .panel-header {
    padding: 18px 28px 13px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--surface);
    position: sticky; top: 0; z-index: 5;
  }
  .panel-header h2 {
    font-family: 'Figtree', ui-sans-serif, sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted2);
  }
  .panel-dot { width: 6px; height: 6px; background: var(--accent); border-radius: 50%; }
  .field-group { padding: 16px 28px; border-bottom: 1px solid var(--border); }
  .field-label { font-size: 11px; letter-spacing: 1px; color: var(--muted); text-transform: uppercase; margin-bottom: 5px; }
  .field-value {
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 7px;
    padding: 6px 13px;
    font-size: 12.5px;
    color: var(--text);
    width: 100%;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: 'Figtree', ui-sans-serif, sans-serif;
    box-shadow: var(--shadow-sm);
  }
  .field-value:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(10,124,85,0.1);
    background: #fff;
  }
  select.field-value {
    cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%238892a4' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 13px center; padding-right: 34px;
  }
  .right-panel {
    background: var(--bg);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
  }
  .right-panel::-webkit-scrollbar { width: 4px; }
  .right-panel::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }
  .equipment-header {
    padding: 18px 28px 13px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--surface);
    position: sticky; top: 0; z-index: 5;
    box-shadow: var(--shadow-sm);
  }
  .equipment-header h2 {
    font-family: 'Figtree', ui-sans-serif, sans-serif;
    font-size: 12px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--muted2);
    display: flex; align-items: center; gap: 8px;
  }
  .add-btn {
    background: var(--accent-light);
    border: 1px solid rgba(10,124,85,0.3);
    color: var(--accent); font-size: 11px;
    padding: 8px 18px; border-radius: 7px; cursor: pointer;
    font-family: 'Figtree', ui-sans-serif, sans-serif; letter-spacing: 1px;
    transition: all 0.2s; text-transform: uppercase; font-weight: 500;
  }
  .add-btn:hover { background: rgba(10,124,85,0.15); box-shadow: 0 2px 10px rgba(10,124,85,0.15); }
  .equipment-table-wrap { padding: 0 28px 28px; flex: 1; }
  .equipment-row {
    display: grid;
    grid-template-columns: 200px 1fr 1fr 1fr 1fr;
    gap: 8px; align-items: center; cursor: pointer;
    border-radius: 8px; padding: 10px;
    margin: 3px -10px;
    transition: background 0.15s, box-shadow 0.15s;
    border: 1px solid transparent;
  }
  .equipment-row:hover {
    background: var(--surface); border-color: var(--border); box-shadow: var(--shadow-sm);
  }
  
  .accordion-item {
  border-bottom: 1px solid var(--border);
}

.accordion-trigger {
  width: 100%;
  background: none;
  border: none;
  padding: 14px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
}

.accordion-trigger:hover {
  background: var(--surface2);
}

.accordion-trigger-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.accordion-trigger h2 {
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--muted2);
}

.accordion-arrow {
  width: 22px;
  height: 22px;
  border: 1px solid var(--border2);
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  background: var(--surface2);
  transition: transform 0.25s, background 0.15s;
}

.accordion-trigger.open .accordion-arrow {
  transform: rotate(180deg);
  background: var(--accent-light);
  border-color: rgba(10,124,85,0.3);
  color: var(--accent);
}

.accordion-body {
  display: none;
}

.accordion-body.open {
  display: block;
}

/* DELIVERY TRACKING */
.dt-legend {
  display:flex;
  gap:12px;
  padding:8px 10px;
  margin:10px;
  background:var(--surface2);
  border:1px solid var(--border);
  border-radius:8px;
  font-size:10px;
  text-transform:uppercase;
}
.dt-legend i {
  width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:5px;
}
.dt-legend .ok { background:#16a34a }
.dt-legend .risk { background:#facc15 }
.dt-legend .late { background:#dc2626 }
.dt-legend .none { background:#94a3b8 }

.dt-toolbar {
  display:flex;
  align-items:center;
  gap:8px;
  padding:0 10px 10px;
}
.dt-toolbar input {
  flex:1;
  padding:6px 10px;
  border:1px solid var(--border);
  border-radius:8px;
  font-size:12px;
}

.dt-filters button {
  padding:6px 10px;
  font-size:11px;
  border-radius:999px;
  border:1px solid var(--border);
  background:#fff;
  cursor:pointer;
}
.dt-filters button.active {
  background:#0a7c55;
  color:#fff;
  border-color:#0a7c55;
}

.dt-count {
  font-size:11px;
  color:var(--muted2);
  margin-left:auto;
}

.dt-table {
  margin:0 10px 12px;
  border:1px solid var(--border);
  border-radius:10px;
  overflow:hidden;
}

.dt-head, .dt-row {
  display:grid;
  grid-template-columns: 1.2fr repeat(5,1fr) 20px;
  font-size:11px;
}
.dt-head {
  background:var(--surface2);
  font-weight:600;
  padding:6px 8px;
}
.dt-row {
  padding:6px 8px;
  border-top:1px solid var(--border);
  align-items:center;
}
.dt-row .dot {
  width:8px;height:8px;border-radius:50%;
}
.dt-row.ok .dot { background:#16a34a }
.dt-row.risk .dot { background:#facc15 }
.dt-row.late .dot { background:#dc2626 }
.dt-row.none .dot { background:#94a3b8 }
</style>

<div class="font-sans expedition-app">

 

  <!-- OVERALL -->
  <!-- OVERALL PROGRESS — full-width collapsible -->
        <div class="overall-section">
          <div class="overall-header" onclick="toggleOverall()">
            <div class="overall-header-left">
              
              <h2 style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted2);margin:0;">Overall Progress</h2>
            </div>
            <div class="collapse-btn" style="display:flex;align-items:center;gap:6px;font-size:11px;color:var(--muted);letter-spacing:1px;text-transform:uppercase;">
              <span id="collapseLabel">Show</span>
              <span id="collapseArrow" class="collapse-arrow" style="width:22px;height:22px;border:1px solid var(--border2);border-radius:5px;display:flex;align-items:center;justify-content:center;color:var(--muted2);font-size:10px;transition:transform 0.25s,background 0.15s;background:var(--surface2);">▲</span>
            </div>
          </div>
          <div class="overall-body" id="overallBody">
            <div class="gauges-strip" style="display:flex;gap:14px;padding:18px 32px 22px;border-top:1px solid var(--border);">
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill green" id="ringDesign" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="89.97" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--accent);"/><text class="gauge-number" id="gaugeDesignNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">41%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Design Status</div>
                  <div class="gauge-value green" id="gaugeDesign" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--accent);">41%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill blue" id="ringMaterial" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="91.99" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--accent2);"/><text class="gauge-number" id="gaugeMaterialNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">39%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Material Status</div>
                  <div class="gauge-value blue" id="gaugeMaterial" style="font-family:'Syne',sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--accent2);">39%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill warn" id="ringFab" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="93.5" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--warn);"/><text class="gauge-number" id="gaugeFabNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">38%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Fabrication Status</div>
                  <div class="gauge-value warn" id="gaugeFab" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--warn);">38%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill silver" id="ringFat" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="107.07" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--muted);"/><text class="gauge-number" id="gaugeFatNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">29%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">FAT Status</div>
                  <div class="gauge-value silver" id="gaugeFat" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--muted2);">29%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill shipment" id="ringShipment" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="120" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:#2563eb;"/><text class="gauge-number" id="gaugeShipmentNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">0%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Ready for Shipment</div>
                  <div class="gauge-value shipment" id="gaugeShipment" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:#2563eb;">0%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill delivered" id="ringDelivered" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="130" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:#01426a;"/><text class="gauge-number" id="gaugeDeliveredNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">0%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Delivered</div>
                  <div class="gauge-value delivered" id="gaugeDelivered" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:#01426a;">0%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script>
        let overallOpen = false;
        function toggleOverall() {
          overallOpen = !overallOpen;
          document.getElementById('overallBody').classList.toggle('open', overallOpen);
          document.getElementById('collapseArrow').classList.toggle('open', overallOpen);
          document.getElementById('collapseLabel').textContent = overallOpen ? 'Hide' : 'Show';
        }
        </script>

  <!-- MAIN -->
  <div class="main">
    <!-- LEFT: WORK PACKAGE DETAILS -->
    <div class="left-panel">
      <!-- ACCORDION: GENERAL INFO -->
      <div class="accordion-item" id="work-package-accordion">
        <button class="accordion-trigger" onclick="toggleAccordion(this)">
          <div class="accordion-trigger-left">
            <div class="panel-dot" style="background:#2563eb"></div>
            <h2>Work Package</h2>
          </div>
          <div class="accordion-arrow">▼</div>
        </button>
        <div class="accordion-body">
          <div class="field-group">
            <div class="field-label">Work Package No.</div>
            <input class="field-value" type="text" placeholder="Identifier" name="identifier">
          </div>
          <div class="field-group">
            <div class="field-label">Work Package Name</div>
            <input class="field-value" type="text" placeholder="Work Package Name" name="work_package_name">
          </div>
          <div class="field-group">
            <div class="field-label">PO Number</div>
            <input class="field-value" type="text" placeholder="PO Number" name="po_number">
          </div>
          <div class="field-group">
            <div class="field-label">Expediting Category</div>
            <select class="field-value" name="expediting_category">
              <option value="">Select Category</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
            </select>
          </div>
          <div class="field-group">
            <div class="field-label">Supplier</div>
            <select class="field-value" name="supplier">
              <option value="">Select Supplier</option>
              @foreach(\App\Models\ExpeditingForm::distinct()->orderBy('supplier')->pluck('supplier') as $supplier)
                @if($supplier)
                  <option value="{{ $supplier }}">{{ $supplier }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="field-group">
            <div class="field-label">Order Date</div>
            <input class="field-value" type="date" placeholder="Order Date" name="order_date">
          </div>
          <div class="field-group">
            <div class="field-label">Forecast Delivery to Site</div>
            <input class="field-value" type="date" placeholder="Forecast Delivery to Site" name="forecast_delivery_to_site">
          </div>
          <div class="field-group">
            <div class="field-label">Incoterms</div>
            <select class="field-value" name="incoterms">
              <option value="">No Select</option>
              <option value="Not Available">Not Available</option>
              <option value="DAP">DAP</option>
            </select>
          </div>
          <div class="field-group">
            <div class="field-label">Exyte Procurement Contract Manager</div>
            <input class="field-value" type="text" placeholder="Exyte Procurement Contract Manager" name="exyte_procurement_contract_manager">
          </div>
          <div class="field-group">
            <div class="field-label">Customer Procurement Contact</div>
            <input class="field-value" type="text" placeholder="Customer Procurement Contact" name="customer_procurement_contact">
          </div>
          <div class="field-group">
            <div class="field-label">Technical Workpackage Owner</div>
            <input class="field-value" type="text" placeholder="Technical Workpackage Owner" name="technical_workpackage_owner">
          </div>
          <div class="field-group">
            <div class="field-label">Expediting Contact</div>
            <input class="field-value" type="text" placeholder="Expediting Contact" name="expediting_contact">
          </div>
          <div class="field-group">
            <div class="field-label">Workstream/Building</div>
            <input class="field-value" type="text" placeholder="Workstream/Building" name="workstream_building">
          </div>
          <div class="field-group" style="margin-top:24px;">
            <div class="field-label" style="margin-bottom:8px;">MILESTONES <hr style="margin:0 0 8px 0; border: none; border-top: 1px solid #e0e0e0;"/></div>
            <div style="display: flex; gap: 24px; flex-wrap: wrap; align-items: center;">
              <label style="display:flex; flex-direction:column; align-items:center; font-size:12px; color:#3b3b3b;">
                <span style="margin-bottom:4px;">COMPLETED</span>
                <input type="checkbox" name="milestones[]" value="Completed" class="toggle-switch" style="display:none;">
                <span class="custom-toggle"></span>
              </label>
              <label style="display:flex; flex-direction:column; align-items:center; font-size:12px; color:#3b3b3b;">
                <span style="margin-bottom:4px;">LLI</span>
                <input type="checkbox" name="milestones[]" value="LLI" class="toggle-switch" style="display:none;">
                <span class="custom-toggle"></span>
              </label>
              <label style="display:flex; flex-direction:column; align-items:center; font-size:12px; color:#3b3b3b;">
                <span style="margin-bottom:4px;">CONTRACT</span>
                <input type="checkbox" name="milestones[]" value="Contract" class="toggle-switch" style="display:none;">
                <span class="custom-toggle"></span>
              </label>
              <label style="display:flex; flex-direction:column; align-items:center; font-size:12px; color:#3b3b3b;">
                <span style="margin-bottom:4px;">KICK OFF</span>
                <input type="checkbox" name="milestones[]" value="Kick Off" class="toggle-switch" style="display:none;">
                <span class="custom-toggle"></span>
              </label>
            </div>
          </div>
          <style>
            .custom-toggle {
              display: inline-block;
              width: 40px;
              height: 22px;
              background: #e5e7eb; /* light grey */
              border-radius: 22px;
              position: relative;
              transition: background 0.2s;
              cursor: pointer;
            }
            .custom-toggle:before {
              content: '';
              position: absolute;
              left: 3px;
              top: 3px;
              width: 16px;
              height: 16px;
              background: #fff;
              border-radius: 50%;
              transition: transform 0.2s;
            }
            input.toggle-switch:checked + .custom-toggle {
              background: #01426a; /* on color */
            }
            input.toggle-switch:checked + .custom-toggle:before {
              transform: translateX(18px);
            }
          </style>
          <div class="field-group" style="text-align:right; margin-top:12px;">
            <button id="saveWorkPackage" class="btn btn-primary">Save Work Package</button>
          </div>
        </div>
      </div>

      <!-- ACCORDION: CONTACTS -->
      <div class="accordion-item">
        <button class="accordion-trigger" onclick="toggleAccordion(this)">
          <div class="accordion-trigger-left">
            <div class="panel-dot" style="background:var(--accent2);"></div>
            <h2>Contacts</h2>
          </div>
          <div class="accordion-arrow">▼</div>
        </button>
        <div class="accordion-body">
          <!-- Empty for now -->
        </div>
      </div>

      <!-- ACCORDION: MILESTONES -->
      <div class="accordion-item">
        <button class="accordion-trigger" onclick="toggleAccordion(this)">
          <div class="accordion-trigger-left">
            <div class="panel-dot" style="background:var(--warn);"></div>
            <h2>Milestones</h2>
          </div>
          <div class="accordion-arrow">▼</div>
        </button>
        <div class="accordion-body">
          <!-- Empty for now -->
        </div>
	  <!-- DELIVERY TRACKING -->
<div class="accordion-item">
  <button class="accordion-trigger" onclick="toggleAccordion(this)">
    <div class="accordion-trigger-left">
      <div class="panel-dot" style="background:#2563eb"></div>
      <h2>Delivery Tracking</h2>
    </div>
    <div class="accordion-arrow">▼</div>
  </button>

  <div class="accordion-body">

    <!-- STATUS LEGEND -->
    <div class="dt-legend">
      <span><i class="ok"></i> On Time</span>
      <span><i class="risk"></i> At Risk</span>
      <span><i class="late"></i> Late</span>
      <span><i class="none"></i> No Date</span>
    </div>

    <!-- FILTER BAR -->
    <div class="dt-toolbar">
      <input type="text" placeholder="Search tag..." oninput="dtFilter(this.value)">
      <div class="dt-filters">
        <button class="active" onclick="dtSetFilter('all', this)">All</button>
        <button onclick="dtSetFilter('late', this)">Late</button>
        <button onclick="dtSetFilter('risk', this)">Risk</button>
        <button onclick="dtSetFilter('ok', this)">OK</button>
      </div>
      <div class="dt-count"><span id="dtCount">0</span>/<span id="dtTotal">0</span></div>
    </div>

    <!-- TABLE -->
    <div class="dt-table">
      <div class="dt-head">
        <span>Tag</span>
        <span>Mfg St</span>
        <span>Mfg End</span>
        <span>Contract</span>
        <span>Est</span>
        <span>Needed</span>
        <span></span>
      </div>

      <div id="dtBody"></div>
    </div>

  </div>
</div>
    </div>
    
  </div>
  <!-- RIGHT: EQUIPMENT LIST -->
    <div class="right-panel">
      <div class="equipment-header">
        <h2><span class="panel-dot" style="margin-right:8px;"></span>Equipment</h2>
        <button class="add-btn" onclick="openModal()">+ Add Equipment</button>
      </div>
      <div class="equipment-table-wrap">
        <div class="col-headers">
          <span>Type / Tag</span>
          <span>Design Status</span>
          <span>Material Status</span>
          <span>Fabrication</span>
          <span>FAT Status</span>
        </div>
        <div class="equipment-row" onclick="openModal()">
          <div class="eq-name"><span class="eq-status-dot dot-green"></span>RAHU 6801</div>
          <div class="progress-cell">
            <span class="progress-label">29%</span>
            <div class="progress-bar"><div class="progress-fill green" style="width:29%"></div></div>
          </div>
          <div class="progress-cell">
            <span class="progress-label">60%</span>
            <div class="progress-bar"><div class="progress-fill blue" style="width:60%"></div></div>
          </div>
          <div class="progress-cell">
            <span class="progress-label">90%</span>
            <div class="progress-bar"><div class="progress-fill warn" style="width:90%"></div></div>
          </div>
          <div class="progress-cell">
            <span class="progress-label">73%</span>
            <div class="progress-bar"><div class="progress-fill silver" style="width:73%"></div></div>
          </div>
        </div>
        <!-- Add more equipment rows here as needed -->
      </div>
    </div>

  <!-- MODAL -->

<!-- MODAL (EXACT FROM HTML REFERENCE) -->
<style>
  .modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.45);
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s;
  }
  .modal-overlay.active { display: flex; }
  .modal {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    width: 800px;
    max-width: 98vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: modalIn 0.2s;
  }
  @keyframes modalIn { from { transform: translateY(40px); opacity: 0; } to { transform: none; opacity: 1; } }
  .modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 24px 32px 0 32px;
    background: #fff;
  }
  .modal-eyebrow {
    font-size: 12px;
    color: #888;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 2px;
  }
  .modal-title {
    font-size: 22px;
    font-weight: 700;
    color: #222;
    margin-bottom: 0;
  }
  .modal-close {
    font-size: 22px;
    color: #888;
    cursor: pointer;
    margin-left: 16px;
    transition: color 0.15s;
  }
  .modal-close:hover { color: #e74c3c; }
  .modal-body {
    padding: 18px 32px 0 32px;
    overflow-y: auto;
  }
  .modal-section {
    margin-bottom: 22px;
  }
  .modal-section-title {
    font-size: 14px;
    font-weight: 600;
    color: #2d6cdf;
    margin-bottom: 10px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .modal-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
  }
  .modal-grid.three { grid-template-columns: 1fr 1fr 1fr; }
  .modal-grid.full { grid-template-columns: 1fr; }
  .modal-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .modal-field label {
    font-size: 13px;
    color: #555;
    font-weight: 500;
    margin-bottom: 2px;
  }
  .modal-field input,
  .modal-field select,
  .modal-field textarea {
    font-size: 15px;
    padding: 7px 10px;
    border: 1px solid #d3d3d3;
    border-radius: 5px;
    background: #fafbfc;
    color: #222;
    outline: none;
    transition: border 0.15s;
  }
  .modal-field input:focus,
  .modal-field select:focus,
  .modal-field textarea:focus {
    border: 1.5px solid #2d6cdf;
    background: #fff;
  }
  .modal-field textarea {
    min-height: 38px;
    resize: vertical;
  }
  .progress-inputs {
    display: flex;
    gap: 18px;
    margin-top: 6px;
  }
  .progress-input-card {
    flex: 1;
    background: #f6f8fa;
    border-radius: 7px;
    padding: 10px 12px 12px 12px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
  }
  .progress-input-card label {
    font-size: 12px;
    color: #666;
    font-weight: 500;
    margin-bottom: 0;
  }
  .pct-val {
    font-size: 15px;
    font-weight: 600;
    color: #2d6cdf;
    margin-bottom: 2px;
  }
  .progress-input-card input[type=range] {
    width: 100%;
    margin-top: 2px;
  }
  .modal-checkboxes {
    display: flex;
    gap: 18px;
    margin-top: 8px;
    flex-wrap: wrap;
  }
  .check-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 14px;
    color: #444;
    cursor: pointer;
    user-select: none;
    padding: 4px 10px 4px 4px;
    border-radius: 5px;
    transition: background 0.13s;
    position: relative;
  }
  .check-item input[type=checkbox] {
    display: none;
  }
  .check-box {
    width: 18px;
    height: 18px;
    border: 2px solid #bfc9d8;
    border-radius: 4px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    color: #2d6cdf;
    margin-right: 2px;
    transition: border 0.13s, background 0.13s;
  }
  .check-box::after {
    content: '✓';
    opacity: 1;
    transition: opacity 0.13s;
  }
  .check-item.checked .check-box {
    background: #2d6cdf;
    border-color: #2d6cdf;
    color: #fff;
  }
  .check-item.checked .check-box::after {
    opacity: 1;
  }
  .check-box > span, .check-box > svg, .check-box > i {
    display: none;
  }
  .check-item.checked {
    background: #eaf2fd;
  }
  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 18px 32px 22px 32px;
    background: #fff;
    border-top: 1px solid #f0f0f0;
  }
  .btn-cancel {
    background: #fff;
    color: #2d6cdf;
    border: 1.5px solid #2d6cdf;
    border-radius: 6px;
    padding: 7px 22px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.13s, color 0.13s;
  }
  .btn-cancel:hover {
    background: #f0f6ff;
  }
  .btn-save {
    background: #2d6cdf;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 7px 22px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.13s;
  }
  .btn-save:hover {
    background: #1b4e9b;
  }
  /* Highlight for invalid date fields */
  .highlight-warning {
    border: 2px solid #c8470a !important;
    background: #fff3e6 !important;
    color: #c8470a !important;
    transition: border 0.2s, background 0.2s;
  }
</style>
<div class="modal-overlay" id="modalOverlay" onclick="closeOnBg(event)">
  <div class="modal" id="modal">
    <div class="modal-header">
      <div>
        <div class="modal-eyebrow">Equipment Detail</div>
        <div class="modal-title" id="modalTitle">Equipment</div>
      </div>
      <div class="modal-close" onclick="closeModal()">✕</div>
    </div>
    <div class="modal-body">
      <div class="modal-section">
        <div class="modal-section-title">General Information</div>
        <div class="modal-grid">
          <div class="modal-field"><label>Equipment Name / Tag</label><input type="text" id="eq-name" placeholder="e.g. RAHU 6801"></div>
          <div class="modal-field"><label>Sub Supplier</label><input type="text" id="eq-subsupplier" placeholder="Supplier name"></div>
          <div class="modal-field"><label>Quantity</label><input type="number" id="eq-qty" placeholder="1"></div>
          <div class="modal-field"><label>Place of Manufacturing</label><input type="text" id="eq-place" placeholder="City, Country"></div>
          <div class="modal-field">
            <label>Order Status</label>
            <select id="eq-orderstatus">
              <option value="">— Select —</option>
              <option>Ordered</option><option>In Production</option><option>Quality Check</option>
              <option>Ready for Shipment</option><option>Shipped</option><option>Delivered</option>
            </select>
          </div>
          <div class="modal-field">
            <label>Drawing Approval</label>
            <select id="eq-drawing">
              <option value="">— Select —</option>
              <option>Pending</option><option>Submitted</option><option>Approved</option>
              <option>Approved with Comments</option><option>Rejected</option>
            </select>
          </div>
        </div>
        <div class="modal-grid full" style="margin-top:12px;">
          <div class="modal-field"><label>Detailed Scope of Delivery</label><textarea id="eq-scope" placeholder="Describe the scope of delivery..."></textarea></div>
        </div>
      </div>
      <div class="modal-section">
        <div class="modal-section-title">Progress Status</div>
        <div class="progress-inputs">
          <div class="progress-input-card">
            <label>Design Status</label>
            <div class="pct-val" id="designVal">0%</div>
            <input type="range" min="0" max="100" value="0" id="eq-design"
              oninput="document.getElementById('designVal').textContent=this.value+'%'">
          </div>
          <div class="progress-input-card">
            <label>Material Status</label>
            <div class="pct-val" id="materialVal">0%</div>
            <input type="range" min="0" max="100" value="0" id="eq-material"
              oninput="document.getElementById('materialVal').textContent=this.value+'%'">
          </div>
          <div class="progress-input-card">
            <label>Fabrication Status</label>
            <div class="pct-val" id="fabVal">0%</div>
            <input type="range" min="0" max="100" value="0" id="eq-fab"
              oninput="document.getElementById('fabVal').textContent=this.value+'%'">
          </div>
          <div class="progress-input-card">
            <label>FAT Status</label>
            <div class="pct-val" id="fatVal">0%</div>
            <input type="range" min="0" max="100" value="0" id="eq-fat"
              oninput="document.getElementById('fatVal').textContent=this.value+'%'">
          </div>
        </div>
      </div>
      <div class="modal-section">
        <div class="modal-section-title">Key Dates</div>
        <div class="modal-grid three">
          <div class="modal-field"><label>Start of Manufacturing</label><input type="date" id="eq-start" name="start_of_manufacturing"></div>
          <div class="modal-field"><label>End of Manufacturing</label><input type="date" id="eq-end" name="end_of_manufacturing"></div>
          <div class="modal-field"><label>FAT Date</label><input type="date" id="eq-fatdate" name="fat_date"></div>
          <div class="modal-field"><label>Contractual Delivery to Site</label><input type="date" id="eq-contractualdate" name="contractual_delivery_to_site"></div>
          <div class="modal-field"><label>Actual Delivery (Supplier)</label><input type="date" id="eq-actualdate" name="actual_delivery_supplier"></div>
          <div class="modal-field"><label>Needed Delivery to Site (CM/Scheduling)</label><input type="date" id="eq-neededsite" name="needed_delivery_to_site"></div>
          <div class="modal-field"><label>Manufacturing Duration (weeks)</label><input type="number" id="eq-duration" placeholder="0"></div>
          <div class="modal-field" style="grid-column: 1 / -1; margin-top: 2px;">
            <div id="fatdate-warning" style="display:none; color:#c8470a; background:#fff3e6; border:1px solid #c8470a; border-radius:5px; padding:7px 12px; font-size:13px; font-weight:500;">
              <span style="font-weight:700;">Warning:</span> FAT Date is after Actual Delivery (Supplier). Please check the dates.
            </div>
          </div>
        </div>
      </div>
      <div class="modal-section">
        <div class="modal-section-title">Logistics & Milestones</div>
        <div class="modal-checkboxes">
          <div class="check-item" onclick="toggleCheck(this)"><input type="checkbox" autocomplete="off"><div class="check-box"></div><span>Ready for Shipment</span></div>
          <div class="check-item" onclick="toggleCheck(this)"><input type="checkbox" autocomplete="off"><div class="check-box"></div><span>Storage at Supplier</span></div>
          <div class="check-item" onclick="toggleCheck(this)"><input type="checkbox" autocomplete="off"><div class="check-box"></div><span>Delivered</span></div>
        </div>
      </div>
      <div class="modal-section">
        <div class="modal-section-title">Remarks & Open Points</div>
        <div class="modal-grid full">
          <div class="modal-field"><label>Exyte Technical Discussion / Open Points in Clarification with Supplier</label><textarea id="eq-openpoints" placeholder="List any open technical discussions or clarification points..." style="min-height:68px;"></textarea></div>
          <div class="modal-field" style="margin-top:0;"><label>Delivery Remarks</label><textarea id="eq-remarks" placeholder="Any remarks regarding delivery conditions, delays, or notes..." style="min-height:68px;"></textarea></div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <script>
        function openModal(equipment) {
          document.getElementById('modalOverlay').classList.add('active');
          // Populate modal fields if equipment data is provided
          if (equipment) {
            document.getElementById('modalTitle').textContent = equipment.name || 'Equipment';
            document.getElementById('eq-name').value = equipment.name || '';
            document.getElementById('eq-subsupplier').value = equipment.subsupplier || '';
            document.getElementById('eq-qty').value = equipment.qty || '';
            document.getElementById('eq-place').value = equipment.place || '';
            document.getElementById('eq-orderstatus').value = equipment.orderstatus || '';
            document.getElementById('eq-drawing').value = equipment.drawing || '';
            document.getElementById('eq-scope').value = equipment.scope || '';
            document.getElementById('eq-design').value = equipment.design || 0;
            document.getElementById('designVal').textContent = (equipment.design || 0) + '%';
            document.getElementById('eq-material').value = equipment.material || 0;
            document.getElementById('materialVal').textContent = (equipment.material || 0) + '%';
            document.getElementById('eq-fab').value = equipment.fab || 0;
            document.getElementById('fabVal').textContent = (equipment.fab || 0) + '%';
            document.getElementById('eq-fat').value = equipment.fat || 0;
            document.getElementById('fatVal').textContent = (equipment.fat || 0) + '%';
            document.getElementById('eq-start').value = equipment.start || '';
            document.getElementById('eq-end').value = equipment.end || '';
            document.getElementById('eq-duration').value = equipment.duration || '';
            document.getElementById('eq-fatdate').value = equipment.fatdate || '';
            document.getElementById('eq-contractualdate').value = equipment.contractualdate || '';
            document.getElementById('eq-actualdate').value = equipment.actualdate || '';
            document.getElementById('eq-openpoints').value = equipment.openpoints || '';
            document.getElementById('eq-remarks').value = equipment.remarks || '';
            // Checkboxes
            let checks = document.querySelectorAll('.modal-checkboxes .check-item');
            checks.forEach((item, idx) => {
              if (equipment.checks && equipment.checks[idx]) {
                item.classList.add('checked');
                item.querySelector('input[type=checkbox]').checked = true;
              } else {
                item.classList.remove('checked');
                item.querySelector('input[type=checkbox]').checked = false;
              }
            });
          }
        }
        function closeModal() {
          document.getElementById('modalOverlay').classList.remove('active');
        }
        function closeOnBg(e) {
          if (e.target.id === 'modalOverlay') closeModal();
        }
        function toggleCheck(el) {
          el.classList.toggle('checked');
          let cb = el.querySelector('input[type=checkbox]');
          cb.checked = !cb.checked;
        }
        function saveEquipment() {
          // Implement save logic as needed
          closeModal();
        }
        // --- FAT Date vs Actual Delivery Validation ---
        function validateFatVsActual() {
          const fatInput = document.getElementById('eq-fatdate');
          const actualInput = document.getElementById('eq-actualdate');
          const warning = document.getElementById('fatdate-warning');
          if (!fatInput || !actualInput || !warning) return;
          const fatVal = fatInput.value;
          const actualVal = actualInput.value;
          // Remove previous highlight
          fatInput.classList.remove('highlight-warning');
          actualInput.classList.remove('highlight-warning');
          warning.style.display = 'none';
          if (fatVal && actualVal && fatVal > actualVal) {
            fatInput.classList.add('highlight-warning');
            actualInput.classList.add('highlight-warning');
            warning.style.display = 'block';
          }
        }
        // Attach listeners
        document.addEventListener('DOMContentLoaded', function() {
          const fatInput = document.getElementById('eq-fatdate');
          const actualInput = document.getElementById('eq-actualdate');
          if (fatInput && actualInput) {
            fatInput.addEventListener('input', validateFatVsActual);
            actualInput.addEventListener('input', validateFatVsActual);
          }
        });
      </script>
      <button class="btn-cancel" onclick="closeModal()">Cancel</button>
      <button class="btn-save" onclick="saveEquipment()">Save Equipment</button>
    </div>
  </div>
</div>

<script>
function toggleOverall() {
  const body = document.getElementById('overallBody');
  const label = document.getElementById('overallLabel');
  body.classList.toggle('open');
  label.innerText = body.classList.contains('open') ? 'Hide' : 'Show';
}

</script>
</script>
<script>
function toggleAccordion(trigger) {
  const leftPanel = trigger.closest('.left-panel');
  const triggers = leftPanel.querySelectorAll('.accordion-trigger');
  const bodies = leftPanel.querySelectorAll('.accordion-body');
  const isOpen = trigger.classList.contains('open');
  if (isOpen) {
    // If already open, close it
    trigger.classList.remove('open');
    const body = trigger.nextElementSibling;
    if (body) body.classList.remove('open');
  } else {
    // Close all, then open clicked
    triggers.forEach(t => t.classList.remove('open'));
    bodies.forEach(b => b.classList.remove('open'));
    trigger.classList.add('open');
    const body = trigger.nextElementSibling;
    if (body) body.classList.add('open');
  }
}
</script>
<script>
const deliveryEquipment = [
  {
    tag: 'RAHU 6801',
    contractual: '2026-03-01',
    estimated:   '2026-03-18',
    fatDate:     '2026-02-28',
  },
  {
    tag: 'RAHU 6802',
    contractual: '2026-04-10',
    estimated:   '2026-04-08',
    fatDate:     '2026-03-20',
  },
  {
    tag: 'RAHU 6803',
    contractual: '2026-05-01',
    estimated:   '2026-05-03',
    fatDate:     '2026-04-25',
  },
  {
    tag: 'RAHU 6804',
    contractual: '2026-05-20',
    estimated:   null,
    fatDate:     null,
  },
];

function deliveryStatus(item) {
  if (!item.estimated) return { color:'#c8cedd', label:'No Date' };
  const est = new Date(item.estimated);
  const con = new Date(item.contractual);
  const diff = Math.round((est - con) / 86400000);
  if (diff > 7) return { color:'#dc2626', label:`Late ${diff}d` };
  if (diff > 0) return { color:'#f59e0b', label:`+${diff}d Risk` };
  return { color:'#16a34a', label:'On Time' };
}

function fmt(d) {
  if (!d) return '—';
  return new Date(d).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'2-digit' });
}

function renderDeliveryCards() {
  const el = document.getElementById('delivery-list');
  if (!el) return;

  el.innerHTML = deliveryEquipment.map(item => {
    const st = deliveryStatus(item);
    return `
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:10px;box-shadow:var(--shadow-sm);">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 12px;background:var(--surface2);border-bottom:1px solid var(--border);">
          <div style="display:flex;align-items:center;gap:7px;">
            <div style="width:6px;height:6px;border-radius:50%;background:${st.color};"></div>
            <strong style="font-size:12px;">${item.tag}</strong>
          </div>
          <span style="font-size:10px;font-weight:700;color:${st.color};text-transform:uppercase;">
            ${st.label}
          </span>
        </div>
        <div style="padding:8px 12px;font-size:11px;">
          <div>Contractual: <strong>${fmt(item.contractual)}</strong></div>
          <div>Estimated: <strong>${fmt(item.estimated)}</strong></div>
          ${item.fatDate ? `<div>FAT: <strong>${fmt(item.fatDate)}</strong></div>` : ''}
        </div>
      </div>
    `;
  }).join('');
}

document.addEventListener('DOMContentLoaded', renderDeliveryCards);
</script>

<script>
const dtData = [
  { tag:'UPS 6812', mfgS:'01 Oct', mfgE:'22 Feb', con:'14 Mar', est:'14 Mar', need:'21 Mar', status:'ok' },
  { tag:'PDB 6813', mfgS:'04 Oct', mfgE:'04 Dec', con:'27 Dec', est:'28 Dec', need:'03 Jan', status:'risk' },
  { tag:'ATS 6814', mfgS:'07 Oct', mfgE:'14 Dec', con:'09 Jan', est:'11 Jan', need:'—', status:'risk' },
  { tag:'RAHU 6816', mfgS:'13 Oct', mfgE:'03 Jan', con:'04 Feb', est:'08 Feb', need:'—', status:'late' },
];

let dtFilterStatus = 'all';

function renderDT(search = '') {
  search = typeof search === 'string' ? search : '';
  const body = document.getElementById('dtBody');
  const rows = dtData.filter(r => {
    const tag = typeof r.tag === 'string' ? r.tag : (typeof r.name === 'string' ? r.name : '');
    return (dtFilterStatus === 'all' || r.status === dtFilterStatus) &&
      tag.toLowerCase().includes(search.toLowerCase());
  });
  document.getElementById('dtCount').textContent = rows.length;
  document.getElementById('dtTotal').textContent = dtData.length;
  body.innerHTML = rows.map(r => `
    <div class="dt-row ${r.status}">
      <strong>${typeof r.tag === 'string' ? r.tag : (typeof r.name === 'string' ? r.name : '')}</strong>
      <span>${r.mfgS || ''}</span>
      <span>${r.mfgE || ''}</span>
      <span>${r.con || ''}</span>
      <span>${r.est || ''}</span>
      <span>${r.need || ''}</span>
      <div class="dot"></div>
    </div>
  `).join('');
}

function dtFilter(val) {
  renderDT(val);
}

function dtSetFilter(status, btn) {
  dtFilterStatus = status;
  document.querySelectorAll('.dt-filters button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderDT();
}

document.addEventListener('DOMContentLoaded', renderDT);
</script>
@endsection