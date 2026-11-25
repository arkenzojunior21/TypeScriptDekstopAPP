export type UserRole = 'platform_admin' | 'store_admin' | 'customer'

export type SessionUser = {
  id: string
  name: string
  email: string
  role: UserRole
  storeName?: string
}

export const roleLabel: Record<UserRole, string> = {
  platform_admin: 'Platform Admin',
  store_admin: 'Admin Toko',
  customer: 'Pelanggan',
}
