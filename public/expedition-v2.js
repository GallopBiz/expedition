// Expedition V2 Reference JS
let equipments = [
  { name:'RAHU 6801',   design:29,  material:60,  fab:90,  fat:73, status:'green',  orderStatus:'In Production',      drawing:'Approved',  qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'TAG 12.5',    design:100, material:100, fab:100, fat:54, status:'green',  orderStatus:'Ready for Shipment', drawing:'Approved',  qty:2, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[true,false,false]  },
  { name:'Equip 12.5',  design:100, material:50,  fab:50,  fat:50, status:'orange', orderStatus:'In Production',      drawing:'Submitted', qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'Pump',        design:0,   material:0,   fab:0,   fat:0,  status:'gray',   orderStatus:'Ordered',            drawing:'Pending',   qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'Equipment 1', design:100, material:100, fab:61,  fat:57, status:'green',  orderStatus:'In Production',      drawing:'Approved',  qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'Equipment 2', design:0,   material:0,   fab:0,   fat:0,  status:'gray',   orderStatus:'Ordered',            drawing:'Pending',   qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'Equipment 3', design:0,   material:0,   fab:0,   fat:0,  status:'gray',   orderStatus:'Ordered',            drawing:'Pending',   qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
  { name:'Equipment 4', design:0,   material:0,   fab:0,   fat:0,  status:'gray',   orderStatus:'Ordered',            drawing:'Pending',   qty:1, subsupplier:'', place:'', scope:'', start:'', end:'', duration:'', fatdate:'', contractualdate:'', actualdate:'', openpoints:'', remarks:'', checks:[false,false,false] },
];
let currentIndex = -1;
let overallOpen = false;
function toggleOverall() {
  overallOpen = !overallOpen;
  document.getElementById('overallBody').classList.toggle('open', overallOpen);
  document.getElementById('collapseArrow').classList.toggle('open', overallOpen);
  document.getElementById('collapseLabel').textContent = overallOpen ? 'Hide' : 'Show';
}
function renderEquipments() {
  const list = document.getElementById('equipmentList');
  if (!equipments.length) {
    list.innerHTML = '<div class="empty-state">No equipment added yet.<br>Click "+ Add Equipment" to begin.</div>';
    return;
  }
  list.innerHTML = equipments.map((eq, i) => {
    const eqData = encodeURIComponent(JSON.stringify(eq));
    return `
      <div class="equipment-row" style="cursor:pointer;" onclick='openModalObj("${eqData}")'>
        <div class="eq-name"><div class="eq-status-dot dot-${eq.status}"></div>${eq.name}</div>
        <div class="progress-cell"><div class="progress-label">${eq.design}%</div><div class="progress-bar"><div class="progress-fill green" style="width:${eq.design}%"></div></div></div>
        <div class="progress-cell"><div class="progress-label">${eq.material}%</div><div class="progress-bar"><div class="progress-fill blue" style="width:${eq.material}%"></div></div></div>
        <div class="progress-cell"><div class="progress-label">${eq.fab}%</div><div class="progress-bar"><div class="progress-fill warn" style="width:${eq.fab}%"></div></div></div>
        <div class="progress-cell"><div class="progress-label">${eq.fat}%</div><div class="progress-bar"><div class="progress-fill silver" style="width:${eq.fat}%"></div></div></div>
      </div>
    `;
  }).join('');
  updateGauges();
}

// Global function to handle object popup
window.openModalObj = function(eqStr) {
  const eq = JSON.parse(decodeURIComponent(eqStr));
  // Find index if needed
  const idx = equipments.findIndex(e => e.name === eq.name);
  currentIndex = idx;
  document.getElementById('modalTitle').textContent        = eq ? eq.name : 'New Equipment';
  document.getElementById('eq-name').value                 = eq ? eq.name : '';
  document.getElementById('eq-subsupplier').value          = eq ? eq.subsupplier : '';
  document.getElementById('eq-qty').value                  = eq ? eq.qty : '';
  document.getElementById('eq-place').value                = eq ? eq.place : '';
  document.getElementById('eq-orderstatus').value          = eq ? eq.orderStatus : '';
  document.getElementById('eq-drawing').value              = eq ? eq.drawing : '';
  document.getElementById('eq-scope').value                = eq ? eq.scope : '';
  document.getElementById('eq-start').value                = eq ? eq.start : '';
  document.getElementById('eq-end').value                  = eq ? eq.end : '';
  document.getElementById('eq-duration').value             = eq ? eq.duration : '';
  document.getElementById('eq-fatdate').value              = eq ? eq.fatdate : '';
  document.getElementById('eq-contractualdate').value      = eq ? eq.contractualdate : '';
  document.getElementById('eq-actualdate').value           = eq ? eq.actualdate : '';
  document.getElementById('eq-openpoints').value           = eq ? eq.openpoints : '';
  document.getElementById('eq-remarks').value              = eq ? eq.remarks : '';
  const sl = (id, vid, v) => { document.getElementById(id).value=v; document.getElementById(vid).textContent=v+'%'; };
  sl('eq-design',   'designVal',   eq ? eq.design   : 0);
  sl('eq-material', 'materialVal', eq ? eq.material : 0);
  sl('eq-fab',      'fabVal',      eq ? eq.fab      : 0);
  sl('eq-fat',      'fatVal',      eq ? eq.fat      : 0);
  document.querySelectorAll('.check-item').forEach((item,i) => item.classList.toggle('checked', eq ? !!eq.checks[i] : false));
  document.getElementById('modalOverlay').classList.add('open');
  document.getElementById('modal').scrollTop = 0;
}
function updateGauges() {
  if (!equipments.length) return;
  const avg = k => Math.round(equipments.reduce((s,e) => s+e[k], 0) / equipments.length);
  const d=avg('design'), m=avg('material'), f=avg('fab'), fat=avg('fat');
  const r=24, circ=2*Math.PI*r;
  const set = (numId, valId, ringId, pct) => {
    document.getElementById(numId).textContent = pct+'%';
    document.getElementById(valId).textContent  = pct+'%';
    document.getElementById(ringId).setAttribute('stroke-dashoffset', circ*(1-pct/100));
  };
  set('gaugeDesignNum',   'gaugeDesign',   'ringDesign',   d);
  set('gaugeMaterialNum', 'gaugeMaterial', 'ringMaterial', m);
  set('gaugeFabNum',      'gaugeFab',      'ringFab',      f);
  set('gaugeFatNum',      'gaugeFat',      'ringFat',      fat);
}
function openModal(idx) {
  currentIndex = idx;
  const eq = idx >= 0 ? equipments[idx] : null;
  document.getElementById('modalTitle').textContent        = eq ? eq.name : 'New Equipment';
  document.getElementById('eq-name').value                 = eq ? eq.name : '';
  document.getElementById('eq-subsupplier').value          = eq ? eq.subsupplier : '';
  document.getElementById('eq-qty').value                  = eq ? eq.qty : '';
  document.getElementById('eq-place').value                = eq ? eq.place : '';
  document.getElementById('eq-orderstatus').value          = eq ? eq.orderStatus : '';
  document.getElementById('eq-drawing').value              = eq ? eq.drawing : '';
  document.getElementById('eq-scope').value                = eq ? eq.scope : '';
  document.getElementById('eq-start').value                = eq ? eq.start : '';
  document.getElementById('eq-end').value                  = eq ? eq.end : '';
  document.getElementById('eq-duration').value             = eq ? eq.duration : '';
  document.getElementById('eq-fatdate').value              = eq ? eq.fatdate : '';
  document.getElementById('eq-contractualdate').value      = eq ? eq.contractualdate : '';
  document.getElementById('eq-actualdate').value           = eq ? eq.actualdate : '';
  document.getElementById('eq-openpoints').value           = eq ? eq.openpoints : '';
  document.getElementById('eq-remarks').value              = eq ? eq.remarks : '';
  const sl = (id, vid, v) => { document.getElementById(id).value=v; document.getElementById(vid).textContent=v+'%'; };
  sl('eq-design',   'designVal',   eq ? eq.design   : 0);
  sl('eq-material', 'materialVal', eq ? eq.material : 0);
  sl('eq-fab',      'fabVal',      eq ? eq.fab      : 0);
  sl('eq-fat',      'fatVal',      eq ? eq.fat      : 0);
  document.querySelectorAll('.check-item').forEach((item,i) => item.classList.toggle('checked', eq ? !!eq.checks[i] : false));
  document.getElementById('modalOverlay').classList.add('open');
  document.getElementById('modal').scrollTop = 0;
}
function closeModal() { document.getElementById('modalOverlay').classList.remove('open'); }
function closeOnBg(e) { if (e.target===document.getElementById('modalOverlay')) closeModal(); }
function saveEquipment() {
  const name     = document.getElementById('eq-name').value.trim() || 'Unnamed';
  const design   = parseInt(document.getElementById('eq-design').value);
  const material = parseInt(document.getElementById('eq-material').value);
  const fab      = parseInt(document.getElementById('eq-fab').value);
  const fat      = parseInt(document.getElementById('eq-fat').value);
  const avg      = (design+material+fab+fat)/4;
  const status   = avg===0 ? 'gray' : avg<60 ? 'orange' : 'green';
  const checks   = [];
  document.querySelectorAll('.check-item').forEach(item => checks.push(item.classList.contains('checked')));
  const data = { name, design, material, fab, fat, status, checks,
    subsupplier: document.getElementById('eq-subsupplier').value,
    qty: document.getElementById('eq-qty').value || 1,
    place: document.getElementById('eq-place').value,
    orderStatus: document.getElementById('eq-orderstatus').value,
    drawing: document.getElementById('eq-drawing').value,
    scope: document.getElementById('eq-scope').value,
    start: document.getElementById('eq-start').value,
    end: document.getElementById('eq-end').value,
    duration: document.getElementById('eq-duration').value,
    fatdate: document.getElementById('eq-fatdate').value,
    contractualdate: document.getElementById('eq-contractualdate').value,
    actualdate: document.getElementById('eq-actualdate').value,
    openpoints: document.getElementById('eq-openpoints').value,
    remarks: document.getElementById('eq-remarks').value,
  };
  // Add context_id from URL
  const urlParams = new URLSearchParams(window.location.search);
  const contextId = urlParams.get('context_id');
  if (contextId) {
    data.context_id = contextId;
  }
  let isUpdate = currentIndex >= 0;
  if (isUpdate) equipments[currentIndex] = data; else equipments.push(data);
  renderEquipments();
  closeModal();
  showSavePopup(isUpdate ? 'Data updated successfully!' : 'Data saved successfully!');
}

// Custom popup for save/update success
function showSavePopup(message) {
  let popup = document.getElementById('saveSuccessPopup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'saveSuccessPopup';
    popup.style.position = 'fixed';
    popup.style.top = '30px';
    popup.style.left = '50%';
    popup.style.transform = 'translateX(-50%)';
    popup.style.background = '#16a34a';
    popup.style.color = '#fff';
    popup.style.padding = '14px 32px';
    popup.style.borderRadius = '8px';
    popup.style.fontSize = '16px';
    popup.style.fontWeight = 'bold';
    popup.style.boxShadow = '0 2px 12px rgba(0,0,0,0.15)';
    popup.style.zIndex = '9999';
    popup.style.opacity = '0';
    popup.style.transition = 'opacity 0.3s';
    document.body.appendChild(popup);
  }
  popup.textContent = message;
  popup.style.opacity = '1';
  setTimeout(() => { popup.style.opacity = '0'; }, 1800);
}
function toggleCheck(el) { el.classList.toggle('checked'); }
renderEquipments();

// Data Table
const dtData = equipments;
let dtFilterStatus = 'all';
function renderDT(search='') {
  if (typeof search !== 'string') search = '';
  const body = document.getElementById('dtBody');
  const rows = dtData.filter(r =>
    (dtFilterStatus === 'all' || r.status === dtFilterStatus) &&
    r.tag.toLowerCase().includes(search.toLowerCase())
  );

  document.getElementById('dtCount').textContent = rows.length;
  document.getElementById('dtTotal').textContent = dtData.length;

  body.innerHTML = rows.map(r => `
    <div class="dt-row ${r.status}">
      <strong>${r.tag}</strong>
      <span>${r.mfgS}</span>
      <span>${r.mfgE}</span>
      <span>${r.con}</span>
      <span>${r.est}</span>
      <span>${r.need}</span>
      <div class="dot"></div>
    </div>
  `).join('');
}
function dtSetFilter(status, btn) {
  dtFilterStatus = status;
  document.querySelectorAll('.dt-filters button').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderDT(''); // Always call with string
}
document.addEventListener('DOMContentLoaded', function() { renderDT(''); });
}
