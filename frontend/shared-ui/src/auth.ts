import type { SessionUser, UserRole } from './types'

const sessionKey = 'laundry-desk-session'

const demoUsers: Record<UserRole, SessionUser> = {
  platform_admin: { id: 'adm-001', name: 'Nadia Amalia', email: 'admin@laundrydesk.test', role: 'platform_admin' },
  store_admin: { id: 'sto-001', name: 'Aris Ganteng', email: 'toko@laundrydesk.test', role: 'store_admin', storeName: 'Laundry Desk Kemang' },
  customer: { id: 'cus-001', name: 'Dimas Pratama', email: 'pelanggan@laundrydesk.test', role: 'customer' },
}

export function signInAs(role: UserRole): SessionUser {
  const user = demoUsers[role]
  localStorage.setItem(sessionKey, JSON.stringify(user))
  return user
}

export function currentSession(): SessionUser | null {
  const raw = localStorage.getItem(sessionKey)
  if (!raw) return null
  try { return JSON.parse(raw) as SessionUser } catch { return null }
}

export function signOut() { localStorage.removeItem(sessionKey) }

export function roleHome(role: UserRole) {
  return role === 'customer' ? '/pelanggan' : '/admin'
}
