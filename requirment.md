# Expedition – Module & Functionality List

This README tracks the main modules and key functionalities (menus) for the Expedition expediting system. Each item will be checked off as implemented.

---

## Modules & Menus

### 1. Authentication & User Management
- [x] Login / Logout (Breeze, login is default page)
- [x] Registration (Breeze)
- [x] Role-based Access (Manager, Expeditor, Supplier)
### 1a. User Management (Manager Only)
- [x] Manager can view all users (card layout)
- [x] Manager can create new users (card layout)

### 2. Work Package Management
- [ ] Create Work Package
- [ ] Edit/View Work Package
- [ ] Work Package Master Data (ID, Supplier, PO, etc.)
- [ ] Scope & Planning Fields
- [ ] Status Tracking (Draft, In Expediting, Complete)

### 3. Supplier Collaboration
- [ ] Secure Supplier Link Generation
- [ ] Supplier Form (Editable Fields Only)
- [ ] Supplier File Uploads (Visit Reports)

### 4. Master Data Management
- [ ] Supplier Master
- [ ] Incoterms Master
- [ ] Expediting Categories Master
- [ ] Workstreams/Buildings Master
- [ ] Contacts Master

### 5. Expediting Workflow
- [ ] Expediting Status Change (auto on supplier submit)
- [ ] Milestone Tracking
- [ ] Visit Scheduling & Observations
- [ ] Risk Escalation

### 6. Reporting & Dashboards
- [ ] Work Package Status Dashboard
- [ ] Supplier Performance Dashboard
- [ ] Manufacturing Progress Tracking
- [ ] FAT Schedule Compliance
- [ ] Delivery Risk Heatmap
- [ ] Standard & Custom Reports

### 7. Data Reuse & Pre-Population
- [ ] Suggest Existing Values (Suppliers, Contacts, etc.)
- [ ] Pre-populate Forms

### 8. Audit & Security
- [ ] Audit Trail for Changes
- [ ] Secure Supplier Access

---

- [x] Initial Project Setup
- [x] Breeze Auth with Blade
- [x] README with Modules (this file)
- [x] Role column in users table
- [x] Default users for each role (seeded)
- [x] Role-based middleware (Laravel 12+)
- [x] Manager-only user management UI (card layout)

---

Update this file as modules and features are implemented.