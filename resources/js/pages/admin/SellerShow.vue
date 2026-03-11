<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AppLayout from '@/layouts/main.vue'
const { t } = useI18n()

const seller = usePage().props.seller
const documents = usePage().props.documents

// Approve
const approveForm = useForm({})
const approve = () => {
  approveForm.post(`/admin/sellers/${seller.slug}/approve`)
}

// Reject
const rejectForm = useForm({})
const reject = () => {
  rejectForm.post(`/admin/sellers/${seller.slug}/reject`)
}

// Set Level
const levelForm = useForm({
  level: seller.certification_status
})

const setLevel = () => {
  levelForm.post(`/admin/sellers/${seller.slug}/set-level`)
}
</script>

<template>
<AppLayout>

  <div class="container" >

    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">
      Seller Profile
    </h1>

    <div style="border:1px solid #ddd; padding:1rem; border-radius:8px; margin-bottom:2rem;">
      <p><strong>Name:</strong> {{ seller.name }}</p>
      <p><strong>Email:</strong> {{ seller.email }}</p>
      <p><strong>Phone:</strong> {{ seller.number }}</p>
      <p><strong>Location:</strong> {{ seller.location }}</p>
      <p><strong>Status:</strong> {{ seller.certification_status }}</p>
    </div>

    <h2 style="font-size: 1.5rem; margin-bottom: .5rem;">Documents</h2>

        <div v-if="documents.length > 0" class="documents-grid">
        <div
            v-for="doc in documents"
            :key="doc.id"
            class="document-card"
        >
            <a :href="`/${doc.file_path}`" target="_blank">
            <img
                :src="`/${doc.file_path}`"
                alt="Document"
                class="document-thumb"
            />
            </a>

            <p class="doc-type">{{ doc.type }}</p>
            <p class="doc-status">{{ doc.status }}</p>
        </div>
        </div>


    <p v-else>No documents uploaded.</p>

    <hr style="margin:2rem 0;">

    <h2 style="font-size: 1.5rem; margin-bottom: .5rem;">Certification Actions</h2>

    <div style="display:flex; gap:1rem; margin-bottom:1.5rem;">
      <button @click="approve" class="btn btn-success">Approve</button>
      <button @click="reject" class="btn btn-danger">Reject</button>
    </div>

    <div style="margin-bottom:1rem;">
      <label><strong>Set Certification Level:</strong></label>
      <select v-model="levelForm.level" style="margin-left:1rem;">
        <option value="verified">Verified</option>
        <option value="gold">Gold</option>
        <option value="platinum">Platinum</option>
      </select>
    </div>

    <button @click="setLevel" class="btn btn-primary">
      Save Level
    </button>

  </div>
  </AppLayout>
</template>
<style>
.documents-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 1rem;
}

.document-card {
  background: white;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  text-align: center;
}

.document-thumb {
  width: 100%;
  height: 120px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: .5rem;
}

.doc-type {
  font-weight: bold;
  margin-bottom: .25rem;
}

.doc-status {
  color: #6b7280;
  font-size: .9rem;
}
</style>