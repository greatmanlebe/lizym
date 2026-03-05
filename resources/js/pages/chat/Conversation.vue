<script setup>
import { ref, onMounted, nextTick, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'
const props = defineProps({
  conversation: Object,
  messages: Array,
})

// Detect logged‑in user (buyer or seller)
const page = usePage()
const authUser = page.props.auth.buyer ?? page.props.auth.seller

const text = ref('')

// Auto-scroll function
function scrollToBottom() {
  nextTick(() => {
    const el = document.querySelector('.chat-messages')
    if (el) el.scrollTop = el.scrollHeight
  })
}

function send() {
  if (!text.value.trim()) return

  router.post(`/chat/${props.conversation.id}/message`, {
    message: text.value,
  }, {
    onSuccess: () => {
      text.value = ''
      scrollToBottom()
    }
  })
}

// Auto-scroll on page load
onMounted(() => {
  scrollToBottom()

  // Auto-refresh messages every 2 seconds
  setInterval(() => {
    router.reload({ only: ['messages'] })
  }, 2000)
})

// Auto-scroll when messages update
watch(() => props.messages.length, () => {
  scrollToBottom()
})
</script>

<template>
  <AppLayout>
  <div class="chat-container">

    <!-- Header -->
    <div class="chat-header">
      <h2>Conversation</h2>
    </div>

    <!-- Messages -->
    <div class="chat-messages">
      <div
        v-for="m in messages"
        :key="m.id"
        class="message-row"
        :class="{
          'me': m.sender_id === authUser.id,
          'them': m.sender_id !== authUser.id
        }"
      >
        <div class="message-bubble">
          <p class="message-text">{{ m.message }}</p>
        </div>
      </div>
    </div>

    <!-- Input -->
    <form class="chat-input" @submit.prevent="send">
      <input
        v-model="text"
        placeholder="Send a chat..."
        class="input-field"
      />
      <button type="submit" class="send-btn">Send</button>
    </form>

  </div>
  </AppLayout>
</template>

<style>
.chat-container {
  display: flex;
  flex-direction: column;
  height: 85vh;
  max-width: 700px;
  margin: 0 auto;
  border: 1px solid #ddd;
  border-radius: 10px;
  background: #fff;
}

/* Header */
.chat-header {
  padding: 15px;
  border-bottom: 1px solid #ddd;
  background: #f8f8f8;
  text-align: center;
  font-weight: bold;
}

/* Messages area */
.chat-messages {
  flex: 1;
  padding: 15px;
  overflow-y: auto;
  background: #f2f2f2;
}

/* Message rows */
.message-row {
  display: flex;
  margin-bottom: 12px;
}

.message-row.me {
  justify-content: flex-end;
}

.message-row.them {
  justify-content: flex-start;
}

/* Message bubble */
.message-bubble {
  max-width: 70%;
  padding: 10px 14px;
  border-radius: 18px;
  font-size: 14px;
  line-height: 1.4;
}

/* Snapchat-style: YOUR messages (right, purple) */
.message-row.me .message-bubble {
  background: #7c3aed;
  color: white;
  border-bottom-right-radius: 4px;
}

/* Their messages (left, white) */
.message-row.them .message-bubble {
  background: #ffffff;
  color: #333;
  border-bottom-left-radius: 4px;
  border: 1px solid #e5e5e5;
}

/* Input area */
.chat-input {
  display: flex;
  padding: 10px;
  border-top: 1px solid #ddd;
  background: #fff;
}

.input-field {
  flex: 1;
  padding: 10px;
  border-radius: 20px;
  border: 1px solid #ccc;
  outline: none;
}

.send-btn {
  margin-left: 10px;
  padding: 10px 18px;
  background: #7c3aed;
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
}
</style>