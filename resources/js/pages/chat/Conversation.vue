<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  conversation: Object,
  messages: Array,
})

const text = ref('')

function send() {
  if (!text.value.trim()) return

  router.post(`/chat/${props.conversation.id}/message`, {
    message: text.value,
  })

  text.value = ''
}
</script>

<template>
  <div>
    <h2>Conversation</h2>

    <div v-for="m in messages" :key="m.id">
      <p>
        <strong>{{ m.sender_type }}:</strong> {{ m.message }}
      </p>
    </div>

    <form @submit.prevent="send">
      <input v-model="text" placeholder="Type message..." />
      <button type="submit">Send</button>
    </form>
  </div>
</template>