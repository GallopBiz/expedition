<style>
      .dt-table {
        margin:0 10px 12px;
        border:1px solid var(--border);
        border-radius:10px;
        overflow:hidden;
      }
      .dt-head, .dt-row {
        display:grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 40px;
        font-size:11px;
      }
      .dt-head span, .dt-row span {
        padding-left: 5px;
        padding-right: 5px;
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
      .dt-row.late .dot { background:#dc2626 }
      .dt-row.none .dot { background:#94a3b8 }
    </style>
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
  grid-template-columns: 1.2fr repeat(4,1fr) 20px;
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
          <div class="overall-body open" id="overallBody">
            <div class="gauges-strip" style="display:flex;gap:14px;padding:18px 32px 22px;border-top:1px solid var(--border);">
              @php
                $count = $equipments->count() ?: 1;
                $avgDesign = round($equipments->avg('design'));
                $avgMaterial = round($equipments->avg('material'));
                $avgFab = round($equipments->avg('fab'));
                $avgFat = round($equipments->avg('fat'));
                $avgDelivered = round($equipments->avg('delivered'));
              @endphp
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill green" id="ringDesign" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($avgDesign/100)*150.8 }}" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--accent);"/><text class="gauge-number" id="gaugeDesignNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">{{ $avgDesign }}%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Design Status</div>
                  <div class="gauge-value green" id="gaugeDesign" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--accent);">{{ $avgDesign }}%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill blue" id="ringMaterial" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($avgMaterial/100)*150.8 }}" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--accent2);"/><text class="gauge-number" id="gaugeMaterialNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">{{ $avgMaterial }}%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Material Status</div>
                  <div class="gauge-value blue" id="gaugeMaterial" style="font-family:'Syne',sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--accent2);">{{ $avgMaterial }}%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill warn" id="ringFab" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($avgFab/100)*150.8 }}" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:var(--warn);"/><text class="gauge-number" id="gaugeFabNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">{{ $avgFab }}%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Fabrication Status</div>
                  <div class="gauge-value warn" id="gaugeFab" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--warn);">{{ $avgFab }}%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill shipment" id="ringShipment" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($avgFat/100)*150.8 }}" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:#2563eb;"/><text class="gauge-number" id="gaugeShipmentNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">{{ $avgFat }}%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">FAT Status</div>
                  <div class="gauge-value silver" id="gaugeFat" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:var(--muted2);">{{ $avgFat }}%</div>
                  <div class="gauge-sub" style="font-size:10px;color:var(--muted);">Avg all equipment</div>
                </div>
              </div>
              <div class="gauge-card" style="flex:1;background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;align-items:center;gap:14px;box-shadow:var(--shadow-sm);">
                <div class="gauge-ring">
                  <svg width="60" height="60"><circle class="track" cx="30" cy="30" r="24" style="fill:none;stroke:var(--border);stroke-width:5;"/><circle class="fill delivered" id="ringDelivered" cx="30" cy="30" r="24" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($avgDelivered/100)*150.8 }}" style="fill:none;stroke-width:5;stroke-linecap:round;stroke:#01426a;"/><text class="gauge-number" id="gaugeDeliveredNum" x="30" y="36" text-anchor="middle" style="font-size:12px;font-weight:500;color:var(--text);">{{ $avgDelivered }}%</text></svg>
                </div>
                <div>
                  <div class="gauge-title" style="font-size:9px;color:var(--muted);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px;">Delivered</div>
                  <div class="gauge-value delivered" id="gaugeDelivered" style="font-family:'Figtree', ui-sans-serif, sans-serif;font-size:20px;font-weight:700;line-height:1;margin-bottom:3px;color:#01426a;">{{ $avgDelivered }}%</div>
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
            <input class="field-value" type="text" placeholder="Work Package No." name="work_package_no" value="{{ $context->work_package_no ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Work Package Name</div>
            <input class="field-value" type="text" placeholder="Work Package Name" name="workpackage_name" value="{{ $context->workpackage_name ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">PO Number</div>
            <input class="field-value" type="text" placeholder="PO Number" name="po_number" value="{{ $context->po_number ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Expediting Category</div>
            <select class="field-value" name="expediting_category">
              <option value="">Select Category</option>
              <option value="Low" {{ ($context->expediting_category ?? '') == 'Low' ? 'selected' : '' }}>Low</option>
              <option value="Medium" {{ ($context->expediting_category ?? '') == 'Medium' ? 'selected' : '' }}>Medium</option>
              <option value="High" {{ ($context->expediting_category ?? '') == 'High' ? 'selected' : '' }}>High</option>
            </select>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                const catSelect = document.querySelector('select[name="expediting_category"]');
                function updateCategoryColor() {
                  catSelect.classList.remove('cat-low', 'cat-medium', 'cat-high');
                  if (catSelect.value === 'Low') catSelect.classList.add('cat-low');
                  else if (catSelect.value === 'Medium') catSelect.classList.add('cat-medium');
                  else if (catSelect.value === 'High') catSelect.classList.add('cat-high');
                }
                catSelect.addEventListener('change', updateCategoryColor);
                updateCategoryColor();
              });
            </script>
            <style>
              .cat-low { background: #d1fae5 !important; }
              .cat-medium { background: #fef9c3 !important; }
              .cat-high { background: #fecaca !important; }
            </style>
          </div>
          <div class="field-group">
            <div class="field-label">Supplier</div>
            <select class="field-value" name="supplier">
              <option value="">Select Supplier</option>
              @foreach(\App\Models\ExpeditingForm::distinct()->orderBy('supplier')->pluck('supplier') as $supplier)
                @if($supplier)
                  <option value="{{ $supplier }}" {{ ($context->supplier ?? '') == $supplier ? 'selected' : '' }}>{{ $supplier }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="field-group">
            <div class="field-label">Order Date</div>
            <input class="field-value" type="date" placeholder="Order Date" name="order_date" value="{{ $context->order_date ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Forecast Delivery to Site</div>
            <input class="field-value" type="date" placeholder="Forecast Delivery to Site" name="forecast_delivery_to_site" value="{{ $context->forecast_delivery_to_site ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Incoterms</div>
            <select class="field-value" name="incoterms">
              <option value="">No Select</option>
              <option value="Not Available" {{ ($context->incoterms ?? '') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
              <option value="DAP" {{ ($context->incoterms ?? '') == 'DAP' ? 'selected' : '' }}>DAP</option>
            </select>
          </div>
          <div class="field-group">
            <div class="field-label">Exyte Procurement Contract Manager</div>
            <input class="field-value" type="text" placeholder="Exyte Procurement Contract Manager" name="exyte_procurement_contract_manager" value="{{ $context->exyte_procurement_contract_manager ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Customer Procurement Contact</div>
            <input class="field-value" type="text" placeholder="Customer Procurement Contact" name="customer_procurement_contact" value="{{ $context->customer_procurement_contact ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Technical Workpackage Owner</div>
            <input class="field-value" type="text" placeholder="Technical Workpackage Owner" name="technical_workpackage_owner" value="{{ $context->technical_workpackage_owner ?? '' }}">
          </div>
          <div class="field-group">
            <div class="field-label">Expediting Contact</div>
            <input class="field-value" type="text" placeholder="Expediting Contact" name="expediting_contact" value="{{ $context->expediting_contact ?? '' }}">
            <input type="hidden" name="executions[0][expediting_contact]" id="exec_expediting_contact">
          </div>
          <div class="field-group">
            <div class="field-label">Workstream/Building</div>
            <input class="field-value" type="text" placeholder="Workstream/Building" name="workstream_building" value="{{ $context->workstream_building ?? '' }}">
            <input type="hidden" name="executions[0][workstream_building]" id="exec_workstream_building">
          </div>
          <div style="display:none;">
            <input type="hidden" name="executions[0][work_package]" id="exec_work_package">
          </div>
          <div style="display:none;">
            <input type="hidden" name="ajaxform" value="1">
          </div>
          <div class="field-group" style="margin-top:24px;">
            <div class="field-label" style="margin-bottom:8px;">MILESTONES <hr style="margin:0 0 8px 0; border: none; border-top: 1px solid #e0e0e0;"/></div>
            <div style="display: flex; gap: 24px; flex-wrap: wrap; align-items: center;">
              <label style="display:flex; flex-direction:column; align-items:center; font-size:12px; color:#3b3b3b;">
                {{-- <span style="margin-bottom:4px;">COMPLETED</span>
                <input type="checkbox" name="milestones[]" value="Completed" class="toggle-switch" style="display:none;">
                <span class="custom-toggle"></span> --}}
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
            <script>
            let workPackageSaved = false;
            document.addEventListener('DOMContentLoaded', function() {
              const btn = document.getElementById('saveWorkPackage');
              btn.addEventListener('click', function() {
                if (workPackageSaved) return;
                // Autofill executions fields from visible fields
                const parent = btn.closest('.accordion-body');
                document.getElementById('exec_work_package').value = parent.querySelector('input[name="workpackage_name"]').value;
                document.getElementById('exec_workstream_building').value = parent.querySelector('input[name="workstream_building"]').value;
                document.getElementById('exec_expediting_contact').value = parent.querySelector('input[name="expediting_contact"]').value;
                var formData = new FormData();
                parent.querySelectorAll('input, select').forEach(el => {
                  if (el.type === 'checkbox') {
                    if (!el.checked) return;
                  }
                  // Handle multiple values for checkboxes
                  if (el.type === 'checkbox' && el.name.endsWith('[]')) {
                    formData.append(el.name, el.value);
                  } else {
                    formData.append(el.name, el.value);
                  }
                });
                fetch('http://127.0.0.1:8000/expediting-forms', {
                  method: 'POST',
                  headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                  },
                  body: formData
                })
                .then(res => res.json())
                .then(resp => {
                  if (resp.success && resp.context_id) {
                    workPackageSaved = true;
                    btn.textContent = 'Update Work Package';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');
                    // Update URL to edit mode with context_id
                    const url = new URL(window.location.href);
                    url.searchParams.set('context_id', resp.context_id);
                    url.searchParams.set('edit', '1');
                    window.history.replaceState({}, '', url);
                  } else if (resp.errors) {
                    alert('Error: ' + (Array.isArray(resp.errors) ? resp.errors.join('\n') : JSON.stringify(resp.errors)));
                  } else {
                    alert('Failed to save work package.');
                  }
                })
                .catch(() => {
                  alert('Failed to save work package.');
                });
              });
            });
            </script>
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
      <span><i class="late"></i> Late</span>
    </div>

    <!-- FILTER BAR -->
    <div class="dt-toolbar">
      <input type="text" id="dtSearch" placeholder="Search tag..." oninput="dtFilter()">
      <div class="dt-filters">
        <button class="active" id="dtAllBtn" onclick="dtSetFilter('all', this)">All</button>
        <button id="dtLateBtn" onclick="dtSetFilter('late', this)">Late</button>
        <button id="dtOkBtn" onclick="dtSetFilter('ok', this)">OK</button>
      </div>
      <div class="dt-count"><span id="dtCount">0</span>/<span id="dtTotal">0</span></div>
    </div>

    <!-- TABLE -->
    <div class="dt-table">
      <div class="dt-head">
        <span>Tag</span>
        <span>Contractual</span>
        <span>Actual</span>
        <span>FAT Date</span>
        <span>On Time</span>
      </div>
      <div id="dtBody">
        @php
          $contextId = request()->query('context_id');
          $equipments = \App\Models\ExpeditingEquipment::where('context_id', $contextId)->get();
        @endphp
        <script>
          let dtFilterStatus = 'all';
          function dtSetFilter(status, btn) {
            dtFilterStatus = status;
            document.querySelectorAll('.dt-filters button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            dtFilter();
          }
          function dtFilter() {
            const search = document.getElementById('dtSearch').value.toLowerCase();
            const rows = Array.from(document.querySelectorAll('#dtBody .dt-row'));
            let count = 0;
            rows.forEach(row => {
              const tag = row.querySelector('span').textContent.toLowerCase();
              const status = row.classList.contains('ok') ? 'ok' : row.classList.contains('late') ? 'late' : 'none';
              const show = (dtFilterStatus === 'all' || status === dtFilterStatus) && tag.includes(search);
              row.style.display = show ? '' : 'none';
              if (show) count++;
            });
            document.getElementById('dtCount').textContent = count;
            document.getElementById('dtTotal').textContent = rows.length;
          }
          document.addEventListener('DOMContentLoaded', dtFilter);
        </script>
        @php
        $count = 0;
        @endphp
        @forelse($equipments as $equipment)
          @php
            $fatDate = $equipment->fatdate ? strtotime($equipment->fatdate) : null;
            $contractual = $equipment->contractualdate ? strtotime($equipment->contractualdate) : null;
            $actual = $equipment->actualdate ? strtotime($equipment->actualdate) : null;
            $onTime = ($fatDate && $contractual && $actual && $fatDate <= $contractual && $fatDate <= $actual);
            $status = 'none';
            if ($onTime) $status = 'ok';
            else if ($fatDate && $contractual && $actual && ($fatDate > $contractual || $fatDate > $actual)) $status = 'late';
            $count++;
          @endphp
          <div class="dt-row {{ $status }}">
            <span>{{ $equipment->name ?? $equipment->tag ?? '—' }}</span>
            <span>{{ $equipment->contractualdate ? date('d-M-Y', strtotime($equipment->contractualdate)) : '—' }}</span>
            <span>{{ $equipment->actualdate ? date('d-M-Y', strtotime($equipment->actualdate)) : '—' }}</span>
            <span>{{ $equipment->fatdate ? date('d-M-Y', strtotime($equipment->fatdate)) : '—' }}</span>
            <span style="display:flex;justify-content:center;align-items:center;height:100%;"><div class="dot"></div></span>
          </div>
        @empty
          <div style="padding:20px;color:#888;">No equipment found for this context.</div>
        @endforelse
      </div>
      
    </div>

  </div>

	  <!-- CALENDAR & COMMENTS ACCORDION -->
      <div class="accordion-item">
        <button class="accordion-trigger" onclick="toggleAccordion(this)">
          <div class="accordion-trigger-left">
            <div class="panel-dot" style="background:#7c3aed;"></div>
            <h2>Calendar &amp; Comments</h2>
          </div>
          <div class="accordion-arrow">▼</div>
        </button>
        <div class="accordion-body">
          <style>
            /* Calendar styles (same as your provided code) */
            .cal-card { padding: 16px 20px 12px; background: var(--surface); }
            .cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
            .cal-nav { width: 26px; height: 26px; border: 1px solid var(--border2); border-radius: 6px; background: var(--surface2); color: var(--muted2); font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; font-family: 'Figtree', ui-sans-serif, sans-serif; line-height: 1; }
            .cal-nav:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
            .cal-month-label { font-size: 13px; font-weight: 700; color: var(--text); letter-spacing: -.2px; font-family: 'Figtree', ui-sans-serif, sans-serif; }
            .cal-year-label { font-size: 11px; color: var(--muted2); font-weight: 400; margin-left: 5px; }
            .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
            .cal-dow { text-align: center; font-size: 9px; font-weight: 700; color: var(--muted2); letter-spacing: 1px; text-transform: uppercase; padding-bottom: 6px; }
            .cal-dow:nth-child(6), .cal-dow:nth-child(7) { color: var(--border2); }
            #cal-days { display: contents; }
            .cal-day { aspect-ratio: 1; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: all .15s; gap: 2px; border: 1px solid transparent; }
            .cal-day-num { font-size: 11px; font-weight: 600; color: var(--text); line-height: 1; font-family: 'Figtree', ui-sans-serif, sans-serif; }
            .cal-day:hover:not(.cal-day-other) { background: var(--accent-light); border-color: rgba(10,124,85,.2); }
            .cal-day:hover:not(.cal-day-other) .cal-day-num { color: var(--accent); }
            .cal-day.cal-day-today { background: var(--accent); border-color: var(--accent); box-shadow: 0 2px 6px rgba(10,124,85,.3); }
            .cal-day.cal-day-today .cal-day-num { color: #fff; font-weight: 700; font-size: 12px; }
            .cal-day.cal-day-today:hover { background: #0a9966; }
            .cal-day.cal-day-selected:not(.cal-day-today) { background: var(--surface2); border-color: var(--accent); box-shadow: 0 0 0 2px rgba(10,124,85,.12); }
            .cal-day.cal-day-selected:not(.cal-day-today) .cal-day-num { color: var(--accent); font-weight: 700; }
            .cal-day.cal-day-other { cursor: default; pointer-events: none; }
            .cal-day.cal-day-other .cal-day-num { color: var(--border2); }
            .cal-day.cal-day-weekend:not(.cal-day-today):not(.cal-day-selected) .cal-day-num { color: var(--muted2); }
            .cal-day-dots { display: flex; gap: 2px; align-items: center; justify-content: center; min-height: 4px; }
            .cal-evt-dot { width: 3px; height: 3px; border-radius: 50%; flex-shrink: 0; }
            .cal-evt-dot.Inspection { background: #7c3aed; }
            .cal-evt-dot.Material\ Planning { background: #0284c7; }
            .cal-evt-dot.Fabrication\ Planning { background: var(--warn); }
            .cal-panel { border-top: 1px solid var(--border); background: var(--surface); }
            .cal-placeholder { padding: 12px 20px; font-size: 11px; color: var(--muted2); font-style: italic; text-align: center; border-bottom: 1px solid var(--border); background: var(--surface2); }
            .cal-date-banner { padding: 9px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: none; }
            .cal-date-banner-text { font-size: 12px; font-weight: 700; color: var(--text); font-family: 'Figtree', ui-sans-serif, sans-serif; }
            .cal-date-banner-sub { font-size: 10px; color: var(--muted2); margin-top: 1px; letter-spacing: .5px; }
            .cal-cat-tabs { display: flex; border-bottom: 2px solid var(--border); }
            .cal-cat-tab { flex: 1; padding: 8px 4px; font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border: none; background: none; cursor: pointer; color: var(--muted2); font-family: 'Figtree', ui-sans-serif, sans-serif; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all .15s; display: flex; flex-direction: column; align-items: center; gap: 3px; }
            .cal-cat-tab:hover { background: var(--surface2); color: var(--text); }
            .cal-tab-dot { width: 6px; height: 6px; border-radius: 50%; opacity: .35; transition: opacity .15s; }
            .cal-cat-tab.active .cal-tab-dot { opacity: 1; }
            .cal-cat-tab[data-cat="Inspection"].active { color: #7c3aed; border-bottom-color: #7c3aed; }
            .cal-cat-tab[data-cat="Material Planning"].active { color: #0284c7; border-bottom-color: #0284c7; }
            .cal-cat-tab[data-cat="Fabrication Planning"].active { color: var(--warn); border-bottom-color: var(--warn); }
            .cal-cat-tab[data-cat="Inspection"] .cal-tab-dot { background: #7c3aed; }
            .cal-cat-tab[data-cat="Material Planning"] .cal-tab-dot { background: #0284c7; }
            .cal-cat-tab[data-cat="Fabrication Planning"] .cal-tab-dot { background: var(--warn); }
            .cal-existing-comment { padding: 9px 12px; border-radius: 7px; margin-bottom: 10px; font-size: 12px; line-height: 1.5; color: var(--text); border: 1px solid; position: relative; display: none; }
            .cal-existing-comment.Inspection { background: #f5f3ff; border-color: #ddd6fe; }
            .cal-existing-comment.Material\ Planning { background: #f0f9ff; border-color: #bae6fd; }
            .cal-existing-comment.Fabrication\ Planning { background: #fff7ed; border-color: #fed7aa; }
            .cal-existing-meta { font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 4px; }
            .cal-existing-meta.Inspection { color: #7c3aed; }
            .cal-existing-meta.Material\ Planning { color: #0284c7; }
            .cal-existing-meta.Fabrication\ Planning { color: var(--warn); }
            .cal-existing-del { position: absolute; top: 7px; right: 8px; background: none; border: none; color: var(--border2); cursor: pointer; font-size: 15px; line-height: 1; padding: 0; transition: color .15s; }
            .cal-existing-del:hover { color: var(--warn); }
            .cal-comment-area { padding: 10px 20px 14px; }
            .cal-input-label { font-size: 11px; letter-spacing: 1px; color: var(--muted); text-transform: uppercase; margin-bottom: 5px; display: block; }
            .cal-textarea { background: var(--surface2); border: 1px solid var(--border); border-radius: 7px; padding: 7px 12px; font-size: 12px; color: var(--text); width: 100%; outline: none; transition: border-color .2s, box-shadow .2s; font-family: 'Figtree', ui-sans-serif, sans-serif; box-shadow: 0 1px 3px rgba(0,0,0,.06); resize: none; height: 68px; line-height: 1.5; }
            .cal-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(10,124,85,.1); background: #fff; }
            .cal-textarea[data-cat="Inspection"]:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,.08); }
            .cal-textarea[data-cat="Material Planning"]:focus { border-color: #0284c7; box-shadow: 0 0 0 3px rgba(2,132,199,.08); }
            .cal-textarea[data-cat="Fabrication Planning"]:focus { border-color: var(--warn); box-shadow: 0 0 0 3px rgba(200,71,10,.08); }
            .cal-save-row { display: flex; align-items: center; justify-content: space-between; margin-top: 7px; }
            .cal-char-count { font-size: 10px; color: var(--border2); }
            .cal-save-btn { border: none; border-radius: 7px; padding: 6px 18px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; font-family: 'Figtree', ui-sans-serif, sans-serif; color: #fff; transition: all .2s; }
            .cal-save-btn.Inspection { background: #7c3aed; box-shadow: 0 2px 6px rgba(124,58,237,.25); }
            .cal-save-btn.Material\ Planning { background: #0284c7; box-shadow: 0 2px 6px rgba(2,132,199,.25); }
            .cal-save-btn.Fabrication\ Planning { background: var(--warn); box-shadow: 0 2px 6px rgba(200,71,10,.25); }
            .cal-save-btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
            .cal-timeline-section { border-top: 1px solid var(--border); padding: 12px 20px 18px; background: var(--surface2); }
            .cal-timeline-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
            .cal-timeline-title { font-size: 9px; letter-spacing: 2px; color: var(--muted); text-transform: uppercase; font-weight: 700; display: flex; align-items: center; gap: 5px; }
            .cal-timeline-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }
            .cal-filter-pills { display: flex; gap: 4px; }
            .cal-filter-pill { padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 700; border: 1px solid var(--border2); background: none; color: var(--muted2); cursor: pointer; font-family: 'Figtree', ui-sans-serif, sans-serif; transition: all .15s; letter-spacing: .3px; }
            .cal-filter-pill.active { background: var(--muted2); border-color: var(--muted2); color: #fff; }
            .cal-filter-pill[data-f="Inspection"].active { background: #7c3aed; border-color: #7c3aed; }
            .cal-filter-pill[data-f="Material Planning"].active { background: #0284c7; border-color: #0284c7; }
            .cal-filter-pill[data-f="Fabrication Planning"].active { background: var(--warn); border-color: var(--warn); }
            .cal-tl-empty { font-size: 11px; color: var(--border2); font-style: italic; text-align: center; padding: 12px 0; }
            .cal-tl-item { display: flex; gap: 10px; align-items: flex-start; padding: 7px 0; border-bottom: 1px solid var(--border); cursor: pointer; transition: background .12s; }
            .cal-tl-item:last-child { border-bottom: none; }
            .cal-tl-item:hover { background: rgba(10,124,85,.03); }
            .cal-tl-left { display: flex; flex-direction: column; align-items: center; gap: 1px; flex-shrink: 0; width: 32px; }
            .cal-tl-date-d { font-size: 15px; font-weight: 800; color: var(--text); line-height: 1; font-family: 'Figtree', ui-sans-serif, sans-serif; }
            .cal-tl-date-m { font-size: 9px; font-weight: 700; color: var(--muted2); letter-spacing: 1px; text-transform: uppercase; }
            .cal-tl-dot { width: 9px; height: 9px; border-radius: 50%; border: 2px solid var(--surface2); flex-shrink: 0; margin-top: 3px; }
            .cal-tl-dot.Inspection { background: #7c3aed; box-shadow: 0 0 0 2px rgba(124,58,237,.15); }
            .cal-tl-dot.Material\ Planning { background: #0284c7; box-shadow: 0 0 0 2px rgba(2,132,199,.15); }
            .cal-tl-dot.Fabrication\ Planning { background: var(--warn); box-shadow: 0 0 0 2px rgba(200,71,10,.15); }
            .cal-tl-content { flex: 1; min-width: 0; padding-top: 1px; }
            .cal-tl-cat { font-size: 9px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1px; }
            .cal-tl-cat.Inspection { color: #7c3aed; }
            .cal-tl-cat.Material\ Planning { color: #0284c7; }
            .cal-tl-cat.Fabrication\ Planning { color: var(--warn); }
            .cal-tl-text { font-size: 11.5px; color: var(--text); line-height: 1.4; word-break: break-word; }
            .cal-tl-past .cal-tl-date-d, .cal-tl-past .cal-tl-date-m, .cal-tl-past .cal-tl-text { opacity: .4; }
          </style>
          <div class="cal-card">
            <div class="cal-header">
              <button class="cal-nav" onclick="calMove(-1)">‹</button>
              <div>
                <span class="cal-month-label" id="cal-month-label"></span>
                <span class="cal-year-label"  id="cal-year-label"></span>
              </div>
              <button class="cal-nav" onclick="calMove(1)">›</button>
            </div>
            <div class="cal-grid">
              <div class="cal-dow">Mo</div>
              <div class="cal-dow">Tu</div>
              <div class="cal-dow">We</div>
              <div class="cal-dow">Th</div>
              <div class="cal-dow">Fr</div>
              <div class="cal-dow">Sa</div>
              <div class="cal-dow">Su</div>
              <div id="cal-days"></div>
            </div>
          </div>
          <div class="cal-panel">
            <div class="cal-placeholder" id="cal-placeholder">↑ Click a date to add or view a comment</div>
            <div id="cal-date-content" style="display:none;">
              <div class="cal-date-banner" id="cal-date-banner">
                <div class="cal-date-banner-text" id="cal-date-banner-text"></div>
                <div class="cal-date-banner-sub"  id="cal-date-banner-sub"></div>
              </div>
              <div class="cal-cat-tabs">
                <button class="cal-cat-tab active" data-cat="Inspection" onclick="calSwitchCat(this)"><div class="cal-tab-dot"></div>Inspection</button>
                <button class="cal-cat-tab" data-cat="Material Planning" onclick="calSwitchCat(this)"><div class="cal-tab-dot"></div>Material</button>
                <button class="cal-cat-tab" data-cat="Fabrication Planning" onclick="calSwitchCat(this)"><div class="cal-tab-dot"></div>Fabrication</button>
              </div>
              <div class="cal-comment-area">
                <div class="cal-existing-comment" id="cal-existing-comment">
                  <div class="cal-existing-meta" id="cal-existing-meta"></div>
                  <div id="cal-existing-text"></div>
                  <button class="cal-existing-del" onclick="calDeleteComment()" title="Delete">×</button>
                </div>
                <label class="cal-input-label" id="cal-input-label">Add comment</label>
                <textarea class="cal-textarea" id="cal-textarea" placeholder="Type your comment…" oninput="calCharCount(this)"></textarea>
                <div class="cal-save-row">
                  <span class="cal-char-count" id="cal-char-count">0 / 300</span>
                  <button class="cal-save-btn Inspection" id="cal-save-btn" onclick="calSaveComment()">Save</button>
                </div>
              </div>
            </div>
          </div>
          <div class="cal-timeline-section">
            <div class="cal-timeline-header">
              <span class="cal-timeline-title">All Comments</span>
              <div class="cal-filter-pills">
                <button class="cal-filter-pill active" data-f="all" onclick="calFilterTl(this)">All</button>
                <button class="cal-filter-pill" data-f="Inspection" onclick="calFilterTl(this)">Insp.</button>
                <button class="cal-filter-pill" data-f="Material Planning" onclick="calFilterTl(this)">Mat.</button>
                <button class="cal-filter-pill" data-f="Fabrication Planning" onclick="calFilterTl(this)">Fab.</button>
              </div>
            </div>
            <div id="cal-timeline"></div>
          </div>
          <script>
            (function () {
              var CAL_TODAY   = new Date();
              var calCursor   = new Date(CAL_TODAY.getFullYear(), CAL_TODAY.getMonth(), 1);
              var calSel      = null;
              var calActiveCat  = 'Inspection';
              var calTlFilter   = 'all';
              var calComments   = {};
              var CY = CAL_TODAY.getFullYear(), CM = CAL_TODAY.getMonth() + 1;
              function seed(d, cat, txt) {
                var k = iso(CY, CM, d);
                if (!calComments[k]) calComments[k] = {};
                calComments[k][cat] = txt;
              }
              seed(5,  'Inspection',           'Witness test at ABB factory');
              seed(12, 'Material Planning',    'Steel delivery confirmation');
              seed(12, 'Fabrication Planning', 'Start panel assembly, shift A');
              seed(20, 'Inspection',           'Pre-FAT checklist review');
              function iso(y, m, d) { return y + '-' + pad(m) + '-' + pad(d); }
              function pad(n) { return String(n).padStart(2, '0'); }
              function todayStr() { return iso(CAL_TODAY.getFullYear(), CAL_TODAY.getMonth() + 1, CAL_TODAY.getDate()); }
              function calRender() {
                var MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                var y = calCursor.getFullYear(), m = calCursor.getMonth();
                document.getElementById('cal-month-label').textContent = MONTHS[m];
                document.getElementById('cal-year-label').textContent  = y;
                var firstDow   = new Date(y, m, 1).getDay();
                var offset     = firstDow === 0 ? 6 : firstDow - 1;
                var daysInMo   = new Date(y, m + 1, 0).getDate();
                var daysInPrev = new Date(y, m, 0).getDate();
                var today      = todayStr();
                var cont       = document.getElementById('cal-days');
                cont.innerHTML = '';
                var cells = [];
                for (var i = offset - 1; i >= 0; i--)
                  cells.push({ day: daysInPrev - i, own: false, ds: null });
                for (var d = 1; d <= daysInMo; d++)
                  cells.push({ day: d, own: true, ds: iso(y, m + 1, d) });
                while (cells.length % 7 !== 0)
                  cells.push({ day: cells.length - offset - daysInMo + 1, own: false, ds: null });
                cells.forEach(function (cell, idx) {
                  var el  = document.createElement('div');
                  var cls = ['cal-day'];
                  if (!cell.own)                           cls.push('cal-day-other');
                  if (idx % 7 >= 5 && cell.own)           cls.push('cal-day-weekend');
                  if (cell.ds === today)                   cls.push('cal-day-today');
                  if (cell.ds === calSel && cell.own)      cls.push('cal-day-selected');
                  el.className = cls.join(' ');
                  var num = document.createElement('div');
                  num.className   = 'cal-day-num';
                  num.textContent = cell.day;
                  el.appendChild(num);
                  var dotRow = document.createElement('div');
                  dotRow.className = 'cal-day-dots';
                  if (cell.ds && calComments[cell.ds]) {
                    Object.keys(calComments[cell.ds]).slice(0, 3).forEach(function (cat) {
                      var dot = document.createElement('div');
                      dot.className = 'cal-evt-dot ' + cat;
                      dotRow.appendChild(dot);
                    });
                  }
                  el.appendChild(dotRow);
                  if (cell.own && cell.ds) {
                    el.onclick = (function (ds) { return function () { calSelectDay(ds); }; })(cell.ds);
                  }
                  cont.appendChild(el);
                });
              }
              function calSelectDay(ds) {
                calSel = ds;
                calRender();
                var d      = new Date(ds);
                var isToday = ds === todayStr();
                var weekday = d.toLocaleDateString('en-GB', { weekday: 'long' });
                var daymon  = d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long' });
                document.getElementById('cal-date-banner-text').textContent = weekday + ', ' + daymon;
                document.getElementById('cal-date-banner-sub').textContent  = isToday ? 'Today' : d.getFullYear();
                document.getElementById('cal-placeholder').style.display    = 'none';
                document.getElementById('cal-date-content').style.display   = 'block';
                document.getElementById('cal-date-banner').style.display    = 'block';
                calRefreshCommentArea();
              }
              window.calSwitchCat = function (btn) {
                document.querySelectorAll('.cal-cat-tab').forEach(function (b) {
                  b.classList.remove('active');
                });
                btn.classList.add('active');
                calActiveCat = btn.dataset.cat;
                calRefreshCommentArea();
              };
              function calRefreshCommentArea() {
                if (!calSel) return;
                var cat      = calActiveCat;
                var existing = calComments[calSel] && calComments[calSel][cat] ? calComments[calSel][cat] : null;
                var exEl     = document.getElementById('cal-existing-comment');
                var inLabel  = document.getElementById('cal-input-label');
                var ta       = document.getElementById('cal-textarea');
                var saveBtn  = document.getElementById('cal-save-btn');
                var meta     = document.getElementById('cal-existing-meta');
                var exText   = document.getElementById('cal-existing-text');
                ta.setAttribute('data-cat', cat);
                saveBtn.className = 'cal-save-btn ' + cat;
                if (existing) {
                  exEl.className      = 'cal-existing-comment ' + cat;
                  exEl.style.display  = 'block';
                  meta.className      = 'cal-existing-meta ' + cat;
                  meta.textContent    = cat;
                  exText.textContent  = existing;
                  inLabel.textContent = 'Update comment';
                  ta.value            = existing;
                } else {
                  exEl.style.display  = 'none';
                  inLabel.textContent = 'Add comment';
                  ta.value            = '';
                }
                document.getElementById('cal-char-count').textContent = ta.value.length + ' / 300';
              }
              window.calCharCount = function (ta) {
                ta.value = ta.value.slice(0, 300);
                document.getElementById('cal-char-count').textContent = ta.value.length + ' / 300';
              };
              window.calSaveComment = function () {
                if (!calSel) return;
                var text = document.getElementById('cal-textarea').value.trim();
                if (!text) { document.getElementById('cal-textarea').focus(); return; }
                if (!calComments[calSel]) calComments[calSel] = {};
                calComments[calSel][calActiveCat] = text;
                calRender();
                calRefreshCommentArea();
                calRenderTimeline();
              };
              window.calDeleteComment = function () {
                if (!calSel || !calComments[calSel]) return;
                delete calComments[calSel][calActiveCat];
                if (Object.keys(calComments[calSel]).length === 0) delete calComments[calSel];
                calRender();
                calRefreshCommentArea();
                calRenderTimeline();
              };
              window.calMove = function (dir) {
                calCursor = new Date(calCursor.getFullYear(), calCursor.getMonth() + dir, 1);
                calRender();
              };
              window.calFilterTl = function (btn) {
                calTlFilter = btn.dataset.f;
                document.querySelectorAll('.cal-filter-pill').forEach(function (b) {
                  b.classList.remove('active');
                });
                btn.classList.add('active');
                calRenderTimeline();
              };
              function calRenderTimeline() {
                var el    = document.getElementById('cal-timeline');
                var today = todayStr();
                var all   = [];
                Object.keys(calComments).forEach(function (ds) {
                  Object.keys(calComments[ds]).forEach(function (cat) {
                    all.push({ ds: ds, cat: cat, text: calComments[ds][cat] });
                  });
                });
                all.sort(function (a, b) { return a.ds.localeCompare(b.ds); });
                var filtered = calTlFilter === 'all' ? all : all.filter(function (e) { return e.cat === calTlFilter; });
                if (!filtered.length) {
                  el.innerHTML = '<div class="cal-tl-empty">No comments yet</div>';
                  return;
                }
                el.innerHTML = filtered.map(function (ev) {
                  var d      = new Date(ev.ds);
                  var isPast = ev.ds < today;
                  return '<div class="cal-tl-item' + (isPast ? ' cal-tl-past' : '') + '" onclick="calSelectDay(\'' + ev.ds + '\')">' + '<div class="cal-tl-left">' + '<div class="cal-tl-date-d">' + d.getDate() + '</div>' + '<div class="cal-tl-date-m">' + d.toLocaleDateString('en-GB', { month: 'short' }) + '</div>' + '</div>' + '<div class="cal-tl-dot ' + ev.cat + '"></div>' + '<div class="cal-tl-content">' + '<div class="cal-tl-cat ' + ev.cat + '">' + ev.cat + '</div>' + '<div class="cal-tl-text">' + ev.text + '</div>' + '</div>' + '</div>';
                }).join('');
              }
              document.addEventListener('DOMContentLoaded', function () {
                calRender();
                calRenderTimeline();
              });
              window.calSelectDay = calSelectDay;
            })();
          </script>
        </div>
      </div>
    </div>
    
    
  </div>
  <!-- RIGHT: EQUIPMENT LIST -->
    <div class="right-panel">
      <div class="equipment-header">
        <h2><span class="panel-dot" style="margin-right:8px;"></span>Equipment</h2>
        <div class="equipment-btn-row">
          <!-- Email button temporarily removed -->
          <button class="add-btn" onclick="openModal()" @if(!request('context_id')) disabled style="opacity:0.5;cursor:not-allowed;" @endif>+ Add Equipment</button>
        </div>
        <style>
          .equipment-btn-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
          }
        </style>
            <style>
              .btn.btn-email {
                background: linear-gradient(90deg,#2563eb,#1d4ed8);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 600;
                padding: 10px 28px;
                margin-right: 12px;
                box-shadow: 0 2px 8px rgba(37,99,235,0.12);
                transition: background 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
              }
              .btn.btn-email:hover {
                background: linear-gradient(90deg,#1d4ed8,#2563eb);
              }
              .btn.btn-add-equipment {
                background: linear-gradient(90deg,#0a7c55,#16a34a);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 15px;
                font-weight: 600;
                padding: 10px 28px;
                box-shadow: 0 2px 8px rgba(10,124,85,0.12);
                transition: background 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
              }
              .btn.btn-add-equipment:hover {
                background: linear-gradient(90deg,#16a34a,#0a7c55);
              }
            </style>
        <!-- Email Confirmation Modal -->
        <div id="emailConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
          <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm text-center border-t-8 border-green-600 relative animate-fade-in">
            <div class="flex flex-col items-center mb-4">
              <div id="emailConfirmText" class="text-gray-900 font-bold text-lg mb-1"></div>
              <div class="text-gray-600 text-base mb-4">Are you sure you want to send this expediting form link to the supplier?</div>
            </div>
            <div class="flex justify-center gap-4 mt-2">
              <button id="emailConfirmYes" class="px-6 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold shadow hover:from-green-600 hover:to-green-800 transition">Yes, Send Email</button>
              <button id="emailConfirmNo" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 font-semibold shadow hover:bg-gray-300 transition">Cancel</button>
            </div>
            <button id="emailConfirmClose" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
          </div>
        </div>
        <style>
        @keyframes fade-in {
          from { opacity: 0; transform: translateY(20px); }
          to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease; }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
          let modal = document.getElementById('emailConfirmModal');
          let confirmText = document.getElementById('emailConfirmText');
          let yesBtn = document.getElementById('emailConfirmYes');
          let noBtn = document.getElementById('emailConfirmNo');
          let closeBtn = document.getElementById('emailConfirmClose');
          let formToSubmit = null;
          document.querySelectorAll('.email-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
              e.preventDefault();
              formToSubmit = btn.closest('form');
              let supplierName = formToSubmit.querySelector('.supplier-name').value;
              confirmText.innerHTML = '<span class="text-green-700">Send email to <b>' + supplierName + '</b>?</span>';
              modal.classList.remove('hidden');
            });
          });
          yesBtn.addEventListener('click', function() {
            if (formToSubmit) formToSubmit.submit();
            modal.classList.add('hidden');
          });
          noBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
          });
          closeBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
          });
        });
        </script>
      </div>
      @if(request('context_id'))
      <div class="equipment-table-wrap">
        <div class="col-headers">
          <span>Type / Tag</span>
          <span>Design Status</span>
          <span>Material Status</span>
          <span>Fabrication</span>
          <span>FAT Status</span>
        </div>
        @php
          $contextId = request()->query('context_id');
          $filteredEquipments = $equipments->where('context_id', $contextId);
        @endphp
        @forelse($filteredEquipments as $equipment)
          <div class="equipment-row" style="cursor:pointer;" onclick='openModal(@json($equipment))'>
            <div class="eq-name"><div class="eq-status-dot dot-green"></div>{{ $equipment->name ?? $equipment->tag ?? '—' }}</div>
            <div class="progress-cell"><div class="progress-label">{{ $equipment->design ?? 0 }}%</div><div class="progress-bar"><div class="progress-fill green" style="width:{{ $equipment->design ?? 0 }}%"></div></div></div>
            <div class="progress-cell"><div class="progress-label">{{ $equipment->material ?? 0 }}%</div><div class="progress-bar"><div class="progress-fill blue" style="width:{{ $equipment->material ?? 0 }}%"></div></div></div>
            <div class="progress-cell"><div class="progress-label">{{ $equipment->fab ?? 0 }}%</div><div class="progress-bar"><div class="progress-fill warn" style="width:{{ $equipment->fab ?? 0 }}%"></div></div></div>
            <div class="progress-cell"><div class="progress-label">{{ $equipment->fat ?? 0 }}%</div><div class="progress-bar"><div class="progress-fill silver" style="width:{{ $equipment->fat ?? 0 }}%"></div></div></div>
          </div>
        @empty
          <div style="padding:20px;color:#888;">No equipment found for this context.</div>
        @endforelse
      </div>
      @endif
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
      .dt-row span { font-size:14px; white-space:nowrap; }
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
          var overlay = document.getElementById('modalOverlay');
          overlay.classList.add('active');
          overlay.style.display = 'flex';
          // Support both index and object for backward compatibility
          if (typeof equipment === 'number' && window.equipments && Array.isArray(window.equipments)) {
            equipment = window.equipments[equipment];
          }
          if (equipment) {
            const safe = (v, def) => (v === null || v === undefined ? def : v);
            document.getElementById('modalTitle').textContent = safe(equipment.name, 'Equipment');
            document.getElementById('eq-name').value = safe(equipment.name, '');
            document.getElementById('eq-subsupplier').value = safe(equipment.subsupplier, '');
            document.getElementById('eq-qty').value = safe(equipment.qty, '');
            document.getElementById('eq-place').value = safe(equipment.place, '');
            document.getElementById('eq-orderstatus').value = safe(equipment.order_status || equipment.orderstatus, '');
            document.getElementById('eq-drawing').value = safe(equipment.drawing, '');
            document.getElementById('eq-scope').value = safe(equipment.scope, '');
            document.getElementById('eq-design').value = safe(equipment.design, 0);
            document.getElementById('designVal').textContent = safe(equipment.design, 0) + '%';
            document.getElementById('eq-material').value = safe(equipment.material, 0);
            document.getElementById('materialVal').textContent = safe(equipment.material, 0) + '%';
            document.getElementById('eq-fab').value = safe(equipment.fab, 0);
            document.getElementById('fabVal').textContent = safe(equipment.fab, 0) + '%';
            document.getElementById('eq-fat').value = safe(equipment.fat, 0);
            document.getElementById('fatVal').textContent = safe(equipment.fat, 0) + '%';
            document.getElementById('eq-start').value = safe(equipment.start, '');
            document.getElementById('eq-end').value = safe(equipment.end, '');
            document.getElementById('eq-duration').value = safe(equipment.duration, '');
            document.getElementById('eq-fatdate').value = safe(equipment.fatdate, '');
            document.getElementById('eq-contractualdate').value = safe(equipment.contractualdate, '');
            document.getElementById('eq-actualdate').value = safe(equipment.actualdate, '');
            document.getElementById('eq-openpoints').value = safe(equipment.openpoints, '');
            document.getElementById('eq-remarks').value = safe(equipment.remarks, '');
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
          // Gather equipment data from modal fields
          const data = {
            expediting_form_id: (new URLSearchParams(window.location.search)).get('context_id'),
            name: document.getElementById('eq-name').value.trim() || 'Unnamed',
            design: parseInt(document.getElementById('eq-design').value) || 0,
            material: parseInt(document.getElementById('eq-material').value) || 0,
            fab: parseInt(document.getElementById('eq-fab').value) || 0,
            fat: parseInt(document.getElementById('eq-fat').value) || 0,
            subsupplier: document.getElementById('eq-subsupplier').value,
            qty: parseInt(document.getElementById('eq-qty').value) || 1,
            place: document.getElementById('eq-place').value,
            order_status: document.getElementById('eq-orderstatus').value,
            drawing: document.getElementById('eq-drawing').value,
            scope: document.getElementById('eq-scope').value,
            start: document.getElementById('eq-start').value,
            end: document.getElementById('eq-end').value,
            duration: parseInt(document.getElementById('eq-duration').value) || null,
            fatdate: document.getElementById('eq-fatdate').value,
            contractualdate: document.getElementById('eq-contractualdate').value,
            actualdate: document.getElementById('eq-actualdate').value,
            openpoints: document.getElementById('eq-openpoints').value,
            remarks: document.getElementById('eq-remarks').value,
            checks: Array.from(document.querySelectorAll('.modal-checkboxes .check-item')).map(item => item.classList.contains('checked')),
          };
          // Add context_id from URL
          const urlParams = new URLSearchParams(window.location.search);
          const contextId = urlParams.get('context_id');
          if (contextId) {
            data.context_id = contextId;
          }
          // CSRF token from meta tag
          const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          fetch('/expediting-equipments', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf,
              'Accept': 'application/json',
            },
            body: JSON.stringify(data)
          })
          .then(response => {
            if (!response.ok) throw new Error('Failed to save equipment');
            return response.json();
          })
          .then(result => {
            closeModal();
            // Optionally refresh equipment list or show success
            alert('Equipment saved successfully!');
          })
          .catch(err => {
            alert('Error saving equipment: ' + err.message);
          });
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


@endsection