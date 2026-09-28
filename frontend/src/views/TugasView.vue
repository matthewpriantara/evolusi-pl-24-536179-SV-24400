<template>
  <div class="tugas-page">
    <div class="header-section">
      <div>
        <h1 class="page-title">Daftar Tugas Praktikum</h1>
        <p class="page-subtitle">
          Data diambil langsung secara asinkron dari backend Laravel via endpoint:
          <code class="endpoint-code">{{ apiEndpoint }}</code>
        </p>
      </div>

      <div class="header-actions">
        <button class="btn btn-secondary" @click="fetchData" :disabled="loading">
          <span v-if="loading">⏳ Memuat...</span>
          <span v-else>🔄 Muat Ulang</span>
        </button>
      </div>
    </div>

    <!-- Alert Status Koneksi API -->
    <div v-if="errorMessage" class="alert alert-warning">
      <div class="alert-icon">⚠️</div>
      <div class="alert-content">
        <strong>Pemberitahuan Koneksi Backend:</strong>
        <p>{{ errorMessage }}</p>
        <small>Menampilkan data sampel lokal agar tampilan tetap dapat dinavigasi.</small>
      </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="summary-cards">
      <div class="summary-card">
        <span class="summary-count">{{ stats.total }}</span>
        <span class="summary-title">Total Tugas</span>
      </div>
      <div class="summary-card text-pending">
        <span class="summary-count">{{ stats.pending }}</span>
        <span class="summary-title">Menunggu</span>
      </div>
      <div class="summary-card text-progress">
        <span class="summary-count">{{ stats.in_progress }}</span>
        <span class="summary-title">Dikerjakan</span>
      </div>
      <div class="summary-card text-success">
        <span class="summary-count">{{ stats.selesai }}</span>
        <span class="summary-title">Selesai</span>
      </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
      <span class="filter-label">Filter Status:</span>
      <div class="filter-buttons">
        <button
          v-for="opt in filterOptions"
          :key="opt.value"
          class="filter-btn"
          :class="{ active: currentFilter === opt.value }"
          @click="currentFilter = opt.value"
        >
          {{ opt.label }}
        </button>
      </div>
    </div>

    <!-- Tabel Data Tugas -->
    <div class="table-container">
      <div v-if="loading && items.length === 0" class="loading-state">
        <p>Memuat data tugas dari server Laravel...</p>
      </div>

      <div v-else-if="filteredItems.length === 0" class="empty-state">
        <p>Tidak ada tugas dengan status yang dipilih.</p>
      </div>

      <table v-else class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Judul & Deskripsi</th>
            <th>Status</th>
            <th>Prioritas</th>
            <th>Batas Waktu (Deadline)</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tugas in filteredItems" :key="tugas.id">
            <td class="font-mono">#{{ tugas.id }}</td>
            <td>
              <div class="tugas-title">{{ tugas.judul }}</div>
              <div class="tugas-desc">{{ tugas.deskripsi || '-' }}</div>
            </td>
            <td>
              <span class="badge" :class="getStatusBadge(tugas.status).class">
                {{ getStatusBadge(tugas.status).label }}
              </span>
            </td>
            <td>
              <span class="priority-tag">{{ getPrioritasText(tugas.prioritas) }}</span>
            </td>
            <td>
              <span :class="{ 'text-danger': checkOverdue(tugas.deadline) }">
                {{ tugas.deadline || '-' }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import {
  formatStatusBadge,
  formatPrioritas,
  isOverdue,
  filterTugasByStatus,
  hitungStatistikTugas
} from '../utils/tugasHelper'

// Ambil URL API dari Environment Variable VITE_API_URL
const baseUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
const apiEndpoint = `${baseUrl}/tugas`

const items = ref([])
const loading = ref(false)
const errorMessage = ref('')
const currentFilter = ref('all')

const filterOptions = [
  { label: 'Semua', value: 'all' },
  { label: 'Menunggu', value: 'pending' },
  { label: 'Sedang Dikerjakan', value: 'in_progress' },
  { label: 'Selesai', value: 'selesai' }
]

// Fallback data jika backend server Laravel belum dinyalakan di laptop
const fallbackData = [
  {
    id: 1,
    judul: 'Implementasi Endpoint JSON Laravel',
    deskripsi: 'Menyediakan route GET /api/tugas dengan validasi dan resource controller',
    status: 'selesai',
    prioritas: 'tinggi',
    deadline: '2026-09-28'
  },
  {
    id: 2,
    judul: 'Inisialisasi Vue 3 SPA di folder frontend/',
    deskripsi: 'Membuat halaman router dan koneksi Axios menggunakan VITE_API_URL',
    status: 'in_progress',
    prioritas: 'tinggi',
    deadline: '2026-09-29'
  },
  {
    id: 3,
    judul: 'Pengujian Unit Vitest Frontend',
    deskripsi: 'Menulis unit test fungsi utilitas logika yang lulus tanpa backend berjalan',
    status: 'selesai',
    prioritas: 'sedang',
    deadline: '2026-09-30'
  },
  {
    id: 4,
    judul: 'Penyusunan Laporan Praktikum P4',
    deskripsi: 'Menyusun laporan PDF lengkap dengan 7 tangkapan layar pembuktian',
    status: 'pending',
    prioritas: 'sedang',
    deadline: '2026-10-02'
  }
]

const stats = computed(() => hitungStatistikTugas(items.value))
const filteredItems = computed(() => filterTugasByStatus(items.value, currentFilter.value))

function getStatusBadge(status) {
  return formatStatusBadge(status)
}

function getPrioritasText(prioritas) {
  return formatPrioritas(prioritas)
}

function checkOverdue(deadline) {
  return isOverdue(deadline)
}

async function fetchData() {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await axios.get(apiEndpoint, { timeout: 4000 })
    // Laravel index resource bisa berupa array atau objek response json
    if (Array.isArray(response.data)) {
      items.value = response.data
    } else if (response.data && Array.isArray(response.data.data)) {
      items.value = response.data.data
    } else {
      items.value = fallbackData
    }
  } catch (err) {
    console.warn('Gagal memuat data dari API, menggunakan fallback data:', err.message)
    errorMessage.value = `Gagal terhubung ke "${apiEndpoint}". Pastikan backend Laravel sedang berjalan (php artisan serve).`
    items.value = fallbackData
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.tugas-page {
  max-width: 1000px;
  margin: 0 auto;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}

.page-title {
  font-size: 1.85rem;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 6px;
}

.page-subtitle {
  color: #64748b;
  font-size: 0.95rem;
  margin: 0;
}

.endpoint-code {
  background: #f1f5f9;
  color: #0284c7;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 600;
}

.btn {
  display: inline-flex;
  align-items: center;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.9rem;
  cursor: pointer;
  border: none;
  transition: all 0.2s ease;
}

.btn-secondary {
  background: #ffffff;
  color: #334155;
  border: 1px solid #cbd5e1;
}

.btn-secondary:hover:not(:disabled) {
  background: #f8fafc;
  border-color: #94a3b8;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.alert {
  display: flex;
  gap: 12px;
  padding: 14px 18px;
  border-radius: 8px;
  margin-bottom: 24px;
  font-size: 0.9rem;
}

.alert-warning {
  background: #fefce8;
  border: 1px solid #fef08a;
  color: #854d0e;
}

.alert-icon {
  font-size: 1.25rem;
}

.alert-content p {
  margin: 4px 0 2px 0;
}

.alert-content small {
  color: #a16207;
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.summary-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 16px 20px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.summary-count {
  font-size: 1.75rem;
  font-weight: 800;
  color: #0f172a;
}

.summary-title {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 500;
}

.text-pending .summary-count { color: #d97706; }
.text-progress .summary-count { color: #2563eb; }
.text-success .summary-count { color: #16a34a; }

.filter-bar {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}

.filter-label {
  font-size: 0.85rem;
  font-weight: 600;
  color: #475569;
}

.filter-buttons {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.filter-btn {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 500;
  color: #475569;
  cursor: pointer;
  transition: all 0.15s ease;
}

.filter-btn:hover {
  background: #f8fafc;
  color: #0f172a;
}

.filter-btn.active {
  background: #2563eb;
  color: #ffffff;
  border-color: #2563eb;
}

.table-container {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.data-table th {
  background: #f8fafc;
  color: #475569;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 14px 18px;
  border-bottom: 1px solid #e2e8f0;
}

.data-table td {
  padding: 16px 18px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.9rem;
  color: #334155;
  vertical-align: middle;
}

.data-table tr:last-child td {
  border-bottom: none;
}

.data-table tr:hover {
  background: #f8fafc;
}

.tugas-title {
  font-weight: 600;
  color: #0f172a;
  margin-bottom: 4px;
}

.tugas-desc {
  font-size: 0.825rem;
  color: #64748b;
  line-height: 1.4;
}

.badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}

.badge-pending {
  background: #fef3c7;
  color: #b45309;
}

.badge-progress {
  background: #dbeafe;
  color: #1d4ed8;
}

.badge-success {
  background: #dcfce7;
  color: #15803d;
}

.badge-unknown {
  background: #f1f5f9;
  color: #64748b;
}

.priority-tag {
  font-weight: 600;
  font-size: 0.85rem;
  color: #475569;
}

.text-danger {
  color: #dc2626;
  font-weight: 600;
}

.font-mono {
  font-family: monospace;
  font-size: 0.85rem;
  color: #64748b;
}

.loading-state,
.empty-state {
  text-align: center;
  padding: 40px;
  color: #64748b;
}
</style>
