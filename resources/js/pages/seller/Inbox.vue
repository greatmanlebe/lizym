<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/main.vue'

const props = defineProps({
  conversations: Array,
  buyer: Object // Add buyer prop
})
</script>

<template>
  <AppLayout>
  <div class="inbox-container">
    <h2 class="inbox-title">{{ $t('inbox.title') }}</h2>

    <div v-if="!conversations || conversations.length === 0" class="inbox-empty">
      {{ $t('inbox.empty') }}
    </div>

    <!-- Conversation list -->
    <div
      v-for="c in conversations"
      :key="c.id"
      class="inbox-item"
    >
      <Link :href="`/chat/${c.id}`" class="inbox-link">
        <!-- Avatar Circle -->
        <div class="inbox-avatar">
          {{ c.buyer?.name?.charAt(0)?.toUpperCase() ?? '?' }}
        </div>

        <!-- Text Content -->
        <div class="inbox-text">
          <div class="inbox-name">
            {{ c.buyer?.name ?? 'Unknown buyer' }}
          </div>

          <div class="inbox-preview">
            {{ c.last_message?.message ?? 'No messages yet' }}
          </div>
        </div>

        <!-- Timestamp -->
        <div class="inbox-time">
          {{ new Date(c.updated_at).toLocaleDateString() }}
        </div>
      </Link>
    </div>

  </div>
</AppLayout>
</template>

<style>
.inbox-container {
  max-width: 800px;
  margin: 30px auto;
  padding: 24px;
  background: #ffffff;
  border-radius: 10px;
  border: 1px solid #e2e2e2;
  box-shadow: 0 4px 10px rgba(0,0,0,0.03);
  box-sizing: border-box;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

.inbox-title {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 20px;
}

.inbox-empty {
  padding: 30px;
  text-align: center;
  color: #777;
  border-radius: 8px;
  background: #f7f7f7;
  border: 1px solid #e5e5e5;
}

/* Conversation item */
.inbox-item {
  margin-bottom: 10px;
}

.inbox-link {
  display: flex;
  align-items: center;
  padding: 12px 14px;
  text-decoration: none;
  color: inherit;
  border-radius: 10px;
  border: 1px solid #e2e2e2;
  background: #ffffff;
  transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.05s ease;
}

.inbox-link:hover {
  background: #f5f5f5;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  transform: translateY(-1px);
}

/* Avatar */
.inbox-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #2563eb;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 18px;
  margin-right: 14px;
}

/* Text block */
.inbox-text {
  flex: 1;
  min-width: 0;
}

.inbox-name {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 3px;
}

.inbox-preview {
  font-size: 13px;
  color: #666666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Time */
.inbox-time {
  font-size: 11px;
  color: #999999;
  margin-left: 10px;
  white-space: nowrap;
}
</style>