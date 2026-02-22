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
  list.innerHTML = equipments.map((eq, i) => `
    <div class="equipment-row" onclick="openModal(${i})">
      <div class="eq-name"><div class="eq-status-dot dot-${eq.status}"></div>${eq.name}</div>
      <div class="progress-cell"><div class="progress-label">${eq.design}%</div><div class="progress-bar"><div class="progress-fill green" style="width:${eq.design}%"></div></div></div>
      <div class="progress-cell"><div class="progress-label">${eq.material}%</div><div class="progress-bar"><div class="progress-fill blue" style="width:${eq.material}%"></div></div></div>
      <div class="progress-cell"><div class="progress-label">${eq.fab}%</div><div class="progress-bar"><div class="progress-fill warn" style="width:${eq.fab}%"></div></div></div>
      <div class="progress-cell"><div class="progress-label">${eq.fat}%</div><div class="progress-bar"><div class="progress-fill silver" style="width:${eq.fat}%"></div></div></div>
    </div>
  `).join('');
  updateGauges();
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
  if (currentIndex >= 0) equipments[currentIndex] = data; else equipments.push(data);
  renderEquipments();
  closeModal();
}
function toggleCheck(el) { el.classList.toggle('checked'); }
renderEquipments();
