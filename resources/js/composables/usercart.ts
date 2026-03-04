import { ref, computed } from 'vue'
import type { Product } from '../types/Product'
const cart = ref<{ product: Product; quantity: number }[]>([])

export function useCart() {
  function load() {
    const saved = localStorage.getItem('cart')
    cart.value = saved ? JSON.parse(saved) : []
  }

  function save() {
    localStorage.setItem('cart', JSON.stringify(cart.value))
  }

  function add(product: Product) {
    const existing = cart.value.find(i => i.product.id === product.id)
    if (existing) existing.quantity++
    else cart.value.push({ product, quantity: 1 })
    save()
  }

  function remove(id: number) {
    cart.value = cart.value.filter(i => i.product.id !== id)
    save()
  }

  function update(id: number, change: number) {
    const item = cart.value.find(i => i.product.id === id)
    if (!item) return
    item.quantity += change
    if (item.quantity <= 0) remove(id)
    save()
  }

  // ⭐ THIS IS THE IMPORTANT PART
  const count = computed(() =>
    cart.value.reduce((sum, item) => sum + item.quantity, 0)
  )

  function clear() {
    cart.value = []
    localStorage.removeItem('cart')
  }

  return { cart, load, add, remove, update, count, clear }
}
