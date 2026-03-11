<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  documents: Array
})

const form = useForm({
  type: '',
  file: null
})

function submit() {
  form.post('/seller/documents', {
    forceFormData: true
  })
}
</script>

<template>
  <div class="container">

    <h2>Upload Your Documents</h2>

    <form @submit.prevent="submit" class="upload-form">

      <label>Document Type</label>
      <input v-model="form.type" type="text" placeholder="e.g. ID Card, License" />

      <label>Choose File</label>
      <input type="file" @change="e => form.file = e.target.files[0]" />

      <button type="submit">Upload</button>
    </form>

    <h3>Your Uploaded Documents</h3>

    <table>
      <thead>
        <tr>
          <th>Type</th>
          <th>File</th>
          <th>Status</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="doc in documents" :key="doc.id">
          <td>{{ doc.type }}</td>
          <td>
            <a :href="`/storage/${doc.file_path}`" target="_blank">View</a>
          </td>
          <td>{{ doc.status }}</td>
        </tr>
      </tbody>
    </table>

  </div>
</template>