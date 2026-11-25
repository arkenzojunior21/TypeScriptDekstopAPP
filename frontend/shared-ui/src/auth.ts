import type { SessionUser, UserRole } from './types'

const sessionKey = 'laundry-desk-session'
const tokenKey = 'laundry-desk-token'
const apiBase = import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api'

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

type ApiLogin = { token: string; user: { id: number; name: string; email: string; role: UserRole; store?: { id: number; name: string } | null } }

export async function signInWithApi(email: string, password: string, deviceName: string): Promise<SessionUser> {
  const response = await fetch(`${apiBase}/auth/login`, { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json' }, body: JSON.stringify({ email, password, device_name: deviceName }) })
  const data = await response.json() as ApiLogin | { message?: string; errors?: Record<string, string[]> }
  if (!response.ok || !('token' in data)) {
    const error = data as { message?: string; errors?: Record<string, string[]> }
    throw new Error(Object.values(error.errors ?? {}).flat()[0] ?? error.message ?? 'Login gagal.')
  }
  const session: SessionUser = { id: String(data.user.id), name: data.user.name, email: data.user.email, role: data.user.role, storeName: data.user.store?.name, storeId: data.user.store?.id }
  localStorage.setItem(tokenKey, data.token)
  localStorage.setItem(sessionKey, JSON.stringify(session))
  return session
}

export function currentSession(): SessionUser | null {
  const raw = localStorage.getItem(sessionKey)
  if (!raw) return null
  try { return JSON.parse(raw) as SessionUser } catch { return null }
}

export function authToken() { return localStorage.getItem(tokenKey) }

export async function apiGet<T>(path: string): Promise<T> {
  const response = await fetch(`${apiBase}${path}`, { headers: { Accept: 'application/json', Authorization: `Bearer ${authToken() ?? ''}` } })
  if (!response.ok) throw new Error('Data tidak dapat dimuat dari server.')
  return response.json() as Promise<T>
}

export async function apiRequest<T>(path: string, method: 'POST' | 'PATCH', body: unknown): Promise<T> {
  const response = await fetch(`${apiBase}${path}`, { method, headers: { Accept: 'application/json', 'Content-Type': 'application/json', Authorization: `Bearer ${authToken() ?? ''}` }, body: JSON.stringify(body) })
  const data = await response.json() as T | { message?: string; errors?: Record<string, string[]> }
  if (!response.ok) {
    const error = data as { message?: string; errors?: Record<string, string[]> }
    throw new Error(Object.values(error.errors ?? {}).flat()[0] ?? error.message ?? 'Permintaan gagal diproses.')
  }
  return data as T
}
export function signOut() { localStorage.removeItem(sessionKey); localStorage.removeItem(tokenKey) }

export function roleHome(role: UserRole) {
  return role === 'customer' ? '/pelanggan' : '/admin'
}
