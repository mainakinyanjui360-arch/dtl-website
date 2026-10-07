import { defineStore } from 'pinia';
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

export const useProductStore = defineStore('cart', () => {
  // Load cart and currency from local storage if available
  const storedCart = localStorage.getItem('dignity_cart');
  const storedCurrency = localStorage.getItem('dignity_currency') || 'USD';
  
  const cart = ref(storedCart ? JSON.parse(storedCart) : []);
  const selectedCurrency = ref(storedCurrency);
  const isCartOpen = ref(false);

  // Watch cart changes and save to local storage
  watch(cart, (newCart) => {
    localStorage.setItem('dignity_cart', JSON.stringify(newCart));
  }, { deep: true });

  // Watch currency changes
  watch(selectedCurrency, (newCurrency) => {
    localStorage.setItem('dignity_currency', newCurrency);
  });

  // Toggle currency helper
  function toggleCurrency() {
    selectedCurrency.value = selectedCurrency.value === 'USD' ? 'KES' : 'USD';
  }

  // Formatting Helper
  function formatPrice(usdPrice) {
    const page = usePage();
    const rate = page.props.globalSettings?.exchange_rate_usd_to_kes || 130;
    
    if (selectedCurrency.value === 'KES') {
      return 'KSH ' + (parseFloat(usdPrice) * rate).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
    return '$' + parseFloat(usdPrice).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  // Getters
  const cartTotalUSD = computed(() => {
    return cart.value.reduce((total, item) => total + (item.price * item.quantity), 0);
  });

  const formattedCartTotal = computed(() => {
    return formatPrice(cartTotalUSD.value);
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
    selectedCurrency,
    isCartOpen,
    cartTotalUSD,
    formattedCartTotal,
    cartItemCount,
    toggleCurrency,
    formatPrice,
    addToCart,
    removeFromCart,
    updateQuantity
  };
});
