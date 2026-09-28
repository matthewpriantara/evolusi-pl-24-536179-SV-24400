<template>
  <div class="app-layout">
    <header class="navbar">
      <div class="nav-container">
        <router-link to="/" class="brand">
          <div class="brand-icon">📋</div>
          <div class="brand-text">
            <span class="brand-title">TaskManager</span>
            <span class="brand-sub">KEPL Vue 3 SPA</span>
          </div>
        </router-link>

        <nav class="nav-links">
          <router-link to="/" class="nav-link" active-class="active">
            Beranda
          </router-link>
          <router-link to="/tugas" class="nav-link" active-class="active">
            Daftar Tugas
          </router-link>
        </nav>
      </div>
    </header>

    <main class="main-content">
      <router-view />
    </main>

    <footer class="footer">
      <div class="footer-container">
        <p>
          Praktikum Konstruksi & Evolusi Perangkat Lunak (KEPL) &bull;
          <strong>Matthew Hayunaji Priantara</strong> (24/536179/SV/24400)
        </p>
        <p class="footer-sub">
          Vue 3 + Vite + Vue Router + Vitest + GitHub Actions CI/CD
        </p>
      </div>
    </footer>
  </div>
</template>

<style>
/* Reset & Global Styling */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
  background-color: #f8fafc;
  color: #1e293b;
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
}

.app-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.navbar {
  background: #ffffff;
  border-bottom: 1px solid #e2e8f0;
  position: sticky;
  top: 0;
  z-index: 50;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
}

.nav-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 24px;
  height: 68px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  text-decoration: none;
}

.brand-icon {
  font-size: 1.75rem;
  background: #eff6ff;
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-title {
  font-size: 1.15rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
}

.brand-sub {
  font-size: 0.75rem;
  color: #2563eb;
  font-weight: 600;
  letter-spacing: 0.5px;
}

.nav-links {
  display: flex;
  gap: 8px;
}

.nav-link {
  text-decoration: none;
  color: #475569;
  font-weight: 600;
  font-size: 0.95rem;
  padding: 8px 16px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.nav-link:hover {
  color: #0f172a;
  background: #f1f5f9;
}

.nav-link.active {
  color: #2563eb;
  background: #eff6ff;
}

.main-content {
  flex: 1;
  max-width: 1100px;
  width: 100%;
  margin: 0 auto;
  padding: 32px 24px;
}

.footer {
  background: #ffffff;
  border-top: 1px solid #e2e8f0;
  padding: 24px;
  text-align: center;
  font-size: 0.875rem;
  color: #64748b;
  margin-top: auto;
}

.footer-container p {
  margin-bottom: 4px;
}

.footer-sub {
  font-size: 0.8rem;
  color: #94a3b8;
}
</style>
