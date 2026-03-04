<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  conversations: Array
})
</script>

<template>
  <div class="p-6">
    <h2 class="text-xl font-bold mb-4">Buyer Messages</h2>

    <!-- No conversations -->
    <div v-if="!conversations || conversations.length === 0">
      No conversations yet.
    </div>

    <!-- Conversation list -->
    <div v-for="c in conversations" :key="c.id" class="mb-3">
      <Link :href="`/chat/${c.id}`" class="block p-3 border rounded hover:bg-gray-100">

        <!-- Safe access -->
        <div class="font-semibold">
          Buyer: {{ c.buyer?.name ?? 'Unknown buyer' }}
        </div>

        <div class="text-sm text-gray-600">
          Conversation #{{ c.id }}
        </div>

      </Link>
    </div>
  </div>
</template>