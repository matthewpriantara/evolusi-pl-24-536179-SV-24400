import { describe, it, expect } from 'vitest'
import {
  formatStatusBadge,
  formatPrioritas,
  isOverdue,
  filterTugasByStatus,
  hitungStatistikTugas
} from '../tugasHelper'

describe('tugasHelper - Unit Tests Logika Frontend', () => {
  it('harus memformat status badge tugas dengan label dan class yang benar', () => {
    const pending = formatStatusBadge('pending')
    expect(pending.label).toBe('Menunggu')
    expect(pending.class).toBe('badge-pending')

    const progress = formatStatusBadge('in_progress')
    expect(progress.label).toBe('Sedang Dikerjakan')
    expect(progress.class).toBe('badge-progress')

    const selesai = formatStatusBadge('selesai')
    expect(selesai.label).toBe('Selesai')
    expect(selesai.class).toBe('badge-success')

    const fallback = formatStatusBadge('invalid')
    expect(fallback.label).toBe('Tidak Diketahui')
  })

  it('harus memformat tingkat prioritas tugas dengan tepat', () => {
    expect(formatPrioritas('tinggi')).toBe('Tinggi')
    expect(formatPrioritas('sedang')).toBe('Sedang')
    expect(formatPrioritas('rendah')).toBe('Rendah')
    expect(formatPrioritas('unknown')).toBe('Biasa')
  })

  it('harus mendeteksi apakah deadline tugas sudah lewat (overdue)', () => {
    const today = new Date('2026-09-28')
    expect(isOverdue('2026-09-20', today)).toBe(true)
    expect(isOverdue('2026-10-15', today)).toBe(false)
    expect(isOverdue(null, today)).toBe(false)
  })

  it('harus memfilter daftar tugas berdasarkan status', () => {
    const list = [
      { id: 1, judul: 'Desain UI', status: 'pending' },
      { id: 2, judul: 'Setup CI/CD', status: 'selesai' },
      { id: 3, judul: 'Unit Testing', status: 'pending' }
    ]

    expect(filterTugasByStatus(list, 'pending').length).toBe(2)
    expect(filterTugasByStatus(list, 'selesai').length).toBe(1)
    expect(filterTugasByStatus(list, 'all').length).toBe(3)
  })

  it('harus menghitung ringkasan statistik tugas secara akurat', () => {
    const list = [
      { id: 1, status: 'pending' },
      { id: 2, status: 'in_progress' },
      { id: 3, status: 'selesai' },
      { id: 4, status: 'pending' }
    ]

    const stats = hitungStatistikTugas(list)
    expect(stats.total).toBe(4)
    expect(stats.pending).toBe(2)
    expect(stats.in_progress).toBe(1)
    expect(stats.selesai).toBe(1)
  })
})
