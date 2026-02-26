<script setup lang="ts">
defineProps<{ active: string }>()
defineEmits(['change'])
</script>

<template>
  <div class="categories-section">
    <h3>Categories</h3>

    <div class="category-filters">
      <button
        v-for="c in ['all','electronics','fashion','sports','home','accessories']"
        :key="c"
        class="category-filter"
        :class="{ active: active === c }"
        @click="$emit('change', c)"
      >
        {{ c.charAt(0).toUpperCase() + c.slice(1) }}
      </button>
    </div>
  </div>
</template>
