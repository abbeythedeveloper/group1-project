# 📚 PHP Online Library — Group 1

## 🏫 Project Title
**Online Library Book Tracker**

---

## 🎯 Objective (Short)
Build a **PHP + MySQL web app** to manage book borrowing and returns — featuring search, form-based CRUD operations (POST/GET), reporting (overdue tracking and CSV export), and a responsive **Tailwind CSS UI**.

---

## 🧠 Project Goal (Detailed)

This collaborative PHP web application enables library staff to:

- ➕ Add, ✏️ Edit, and ❌ Remove books using POST forms.  
- 👥 Register and manage borrowers.  
- 🔁 Record borrow and return transactions.  
- 🔎 Search for books and borrowers via GET query parameters.  
- 📊 Track available vs borrowed copies and list overdue books.  
- 📤 Export reports (CSV) and generate printable tables.  
- 💅 Deliver a clean, modular, and Tailwind-styled interface.

The project will be **modular** (separate PHP components), **well-documented**, and include:
- a `.sql` export of the database,
- screenshots,
- and a short presentation demo.

---

## 👥 Group Members & Assigned Responsibilities

Each member has a dedicated module to implement and integrate.  
Sections are titled by **Name**, subtitled as **Tasks**, and include file/module ownership with integration instructions.

---

### 1️⃣ Ogundiran, Abiodun — *Project Lead & Integrator*
#### 🧩 Tasks
- Serve as overall project coordinator.
- Create and maintain:
  - `config.php` (DB credentials, env, helper functions)
  - `index.php` (dashboard/homepage)
  - `includes/header.php` & `includes/footer.php`
- Integrate all modules and test routing.
- Prepare final README and SQL export.

#### 🗂️ Files / Code Blocks
- `config.php` — handles database connection (`mysqli`) and reusable `query()` helper.  
- `index.php` — main dashboard linking all sections.  
- `includes/header.php` / `includes/footer.php` — site layout.

#### 🔗 How to Link
All pages must include:
```php
require_once __DIR__.'/config.php';
require 'includes/header.php';
// content...
require 'includes/footer.php';
