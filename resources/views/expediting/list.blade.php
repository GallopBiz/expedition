<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Expediting — Work Packages</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --bg: #f0f2f8;
        --surface: #ffffff;
        --surface2: #f5f6fa;
        --border: #e0e4ef;
        --accent: #4f7cff;
        --accent2: #7c5cfc;
        --green: #12b981;
        --red: #ef4444;
        --yellow: #f59e0b;
        --text: #1a1f36;
        --muted: #8b92aa;
        --hover: #f0f4ff;
        --selected: #e8eeff;
    }
    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
    }
    /* ...rest of CSS from reference file... */
</style>
</head>
<body>

<main>
    <h1>Work Packages</h1>

    <!-- STATS -->
    <div class="stats">
        <div class="stat-card accent"><div class="val">6</div><div class="lbl">Total Packages</div></div>
        <div class="stat-card green"><div class="val">3</div><div class="lbl">On Time</div></div>
        <div class="stat-card red"><div class="val">2</div><div class="lbl">Delayed</div></div>
        <div class="stat-card"><div class="val">67%</div><div class="lbl">Avg. Design</div></div>
        <div class="stat-card"><div class="val">42%</div><div class="lbl">Avg. Manufacturing</div></div>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="search-wrap">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <input type="text" id="searchInput" placeholder="Search by ID, Name, PO…" oninput="filterTable()">
        </div>

        <select class="filter-select" id="statusFilter" onchange="filterTable()">
            <option value="">All Statuses</option>
            <option value="green">On Time</option>
            <option value="red">Delayed</option>
        </select>

        <select class="filter-select" id="nameFilter" onchange="filterTable()">
            <option value="">All Names</option>
            <option value="MV Switchgear">MV Switchgear</option>
            <option value="Schmidt">Schmidt</option>
            <option value="ID 123">ID 123</option>
            <option value="Aanand">Aanand</option>
        </select>

        <button class="btn btn-ghost" onclick="resetFilters()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M6 12h12M9 18h6"/></svg>
            Reset
        </button>

        <div class="spacer"></div>

        <button class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Work Package
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable('id')">ID <span class="sort"><svg width="8" height="5" viewBox="0 0 8 5"><path d="M0 5l4-5 4 5z" fill="currentColor"/></svg></span></th>
                    <th onclick="sortTable('name')">Name <span class="sort"><svg width="8" height="5" viewBox="0 0 8 5"><path d="M0 5l4-5 4 5z" fill="currentColor"/></svg></span></th>
                    <th>Purchase Order</th>
                    <th>Ordered</th>
                    <th>Design</th>
                    <th>Manufacturing</th>
                    <th>FAT</th>
                    <th>Delivered</th>
                    <th>On Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
        <div class="pagination">
            <span id="pageInfo">1–6 of 6</span>
            <div class="pag-btns">
                <button class="pag-btn" disabled>‹</button>
                <button class="pag-btn active">1</button>
                <button class="pag-btn" disabled>›</button>
            </div>
        </div>
    </div>
</main>

<script>
// ...JS from reference file...
</script>
</body>
</html>
