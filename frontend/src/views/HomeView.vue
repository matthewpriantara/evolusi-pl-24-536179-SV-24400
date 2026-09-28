<template>
  <div class="home-container">
    <div class="hero-section">
      <div class="hero-badge">Tugas Praktikum 4 - KEPL</div>
      <h1 class="hero-title">Sistem Manajemen Tugas Terintegrasi</h1>
      <p class="hero-subtitle">
        Aplikasi antarmuka Vue 3 SPA yang terhubung ke Backend Laravel melalui REST API dengan pipeline CI/CD otomatis.
      </p>

      <div class="action-buttons">
        <router-link to="/tugas" class="btn btn-primary">
          Lihat Daftar Tugas &rarr;
        </router-link>
        <a href="#info" class="btn btn-outline">
          Informasi Praktikan
        </a>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">⚡</div>
        <div class="stat-content">
          <h3>Vite + Vue 3</h3>
          <p>Frontend SPA modern dengan kinerja build ultra-cepat dan Vue Router 4.</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">🔄</div>
        <div class="stat-content">
          <h3>REST API Laravel</h3>
          <p>Endpoint JSON dinamis dengan integrasi environment <code>VITE_API_URL</code>.</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">🛡️</div>
        <div class="stat-content">
          <h3>CI/CD Pipeline</h3>
          <p>Alur 4 job (Lint, Test Vitest, Build, Deploy) di GitHub Actions.</p>
        </div>
      </div>
    </div>

    <div id="info" class="info-card">
      <h2>Informasi Praktikan & Lingkungan</h2>
      <div class="info-grid">
        <div class="info-item">
          <span class="info-label">Nama Mahasiswa</span>
          <span class="info-value">Matthew Hayunaji Priantara</span>
        </div>
        <div class="info-item">
          <span class="info-label">NIM</span>
          <span class="info-value">24/536179/SV/24400</span>
        </div>
        <div class="info-item">
          <span class="info-label">Mata Kuliah</span>
          <span class="info-value">Konstruksi & Evolusi Perangkat Lunak (KEPL)</span>
        </div>
        <div class="info-item">
          <span class="info-label">API Endpoint URL</span>
          <span class="info-value font-mono">{{ apiUrl }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
</script>

<style scoped>
.home-container {
  max-width: 1000px;
  margin: 0 auto;
}

.hero-section {
  text-align: center;
  padding: 40px 20px 50px;
}

.hero-badge {
  display: inline-block;
  background: #e0f2fe;
  color: #0369a1;
  font-weight: 600;
  font-size: 0.85rem;
  padding: 6px 16px;
  border-radius: 9999px;
  margin-bottom: 20px;
  letter-spacing: 0.5px;
}

.hero-title {
  font-size: 2.5rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
  margin-bottom: 16px;
}

.hero-subtitle {
  font-size: 1.15rem;
  color: #64748b;
  max-width: 680px;
  margin: 0 auto 32px;
  line-height: 1.6;
}

.action-buttons {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
}

.btn {
  display: inline-flex;
  align-items: center;
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  font-size: 1rem;
  transition: all 0.2s ease;
}

.btn-primary {
  background: #2563eb;
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.btn-primary:hover {
  background: #1d4ed8;
  transform: translateY(-2px);
}

.btn-outline {
  background: #ffffff;
  color: #334155;
  border: 1px solid #cbd5e1;
}

.btn-outline:hover {
  background: #f8fafc;
  border-color: #94a3b8;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 24px;
  display: flex;
  gap: 16px;
  align-items: flex-start;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.stat-icon {
  font-size: 2rem;
  background: #f1f5f9;
  width: 52px;
  height: 52px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-content h3 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 6px 0;
}

.stat-content p {
  font-size: 0.9rem;
  color: #64748b;
  margin: 0;
  line-height: 1.5;
}

.stat-content code {
  background: #f1f5f9;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 0.85rem;
  color: #2563eb;
}

.info-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 28px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.info-card h2 {
  font-size: 1.25rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 20px;
  border-bottom: 1px solid #f1f5f9;
  padding-bottom: 12px;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.info-label {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 500;
}

.info-value {
  font-size: 1rem;
  color: #0f172a;
  font-weight: 600;
}

.font-mono {
  font-family: monospace;
  color: #0284c7;
}
</style>
