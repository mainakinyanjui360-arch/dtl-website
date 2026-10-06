import { defineStore } from 'pinia';
import { ref, computed, watch } from 'vue';

export const useProductStore = defineStore('cart', () => {
  // Load cart from local storage if available
  const storedCart = localStorage.getItem('dignity_cart');
  const cart = ref(storedCart ? JSON.parse(storedCart) : []);

  // Watch cart changes and save to local storage
  watch(cart, (newCart) => {
    localStorage.setItem('dignity_cart', JSON.stringify(newCart));
  }, { deep: true });

  // Getters
  const cartTotal = computed(() => {
    return cart.value.reduce((total, item) => total + (item.price * item.quantity), 0);
  });

  const cartItemCount = computed(() => {
    return cart.value.reduce((count, item) => count + item.quantity, 0);
  });

  // Actions
  function addToCart(product) {
    const existing = cart.value.find(item => item.id === product.id);
    if (existing) {
      existing.quantity++;
    } else {
      cart.value.push({ ...product, quantity: 1 });
    }
  }

  function removeFromCart(productId) {
    cart.value = cart.value.filter(item => item.id !== productId);
  }

  function updateQuantity(productId, quantity) {
    const item = cart.value.find(item => item.id === productId);
    if (item && quantity > 0) {
      item.quantity = quantity;
    }
  }

  return {
    cart,
    cartTotal,
    cartItemCount,
    addToCart,
    removeFromCart,
    updateQuantity
  };
});
