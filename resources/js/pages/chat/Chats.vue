<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  conversations: Array,
})
</script>

<template>
  <div>
    <h2>Your Conversations</h2>

    <div v-if="!conversations.length">
      No conversations yet.
    </div>

    <div v-for="c in conversations" :key="c.id">
      <Link :href="`/chat/${c.id}`">
        Chat with {{ c.seller.name }}
      </Link>
    </div>
  </div>
</template>