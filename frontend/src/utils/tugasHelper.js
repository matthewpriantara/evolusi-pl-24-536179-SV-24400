/**
 * Modul utilitas logika data tugas untuk aplikasi Vue 3
 * Diuji secara terisolasi tanpa memerlukan server backend berjalan.
 */

// 1. Memformat status tugas dengan label dan class styling
export function formatStatusBadge(status) {
  const map = {
    pending: { label: 'Menunggu', class: 'badge-pending' },
    in_progress: { label: 'Sedang Dikerjakan', class: 'badge-progress' },
    selesai: { label: 'Selesai', class: 'badge-success' }
  }
  return map[status] || { label: 'Tidak Diketahui', class: 'badge-unknown' }
}

// 2. Memformat prioritas tugas
export function formatPrioritas(prioritas) {
  const map = {
    rendah: 'Rendah',
    sedang: 'Sedang',
    tinggi: 'Tinggi'
  }
  return map[prioritas] || 'Biasa'
}

// 3. Menghitung apakah deadline tugas sudah terlewat (overdue)
export function isOverdue(deadlineDate, referenceDate = new Date()) {
  if (!deadlineDate) return false
  const deadline = new Date(deadlineDate)
  return deadline.getTime() < new Date(referenceDate).getTime()
}

// 4. Memfilter daftar tugas berdasarkan status
export function filterTugasByStatus(listTugas, filterStatus) {
  if (!Array.isArray(listTugas)) return []
  if (!filterStatus || filterStatus === 'all') return listTugas
  return listTugas.filter(tugas => tugas.status === filterStatus)
}

// 5. Menghitung ringkasan statistik tugas
export function hitungStatistikTugas(listTugas) {
  if (!Array.isArray(listTugas)) {
    return { total: 0, pending: 0, in_progress: 0, selesai: 0 }
  }
  return {
    total: listTugas.length,
    pending: listTugas.filter(t => t.status === 'pending').length,
    in_progress: listTugas.filter(t => t.status === 'in_progress').length,
    selesai: listTugas.filter(t => t.status === 'selesai').length
  }
}
