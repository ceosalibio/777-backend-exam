<template>
  <v-container class="fill-height d-flex align-center justify-center">
    <v-card width="420">
      <v-card-title>Login</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="submit">
          <v-text-field v-model="username" label="Username" required />
          <v-text-field v-model="password" label="Password" type="password" required />
            <div  class="d-flex justify-center">
            <v-btn :loading="loading" color="primary" type="submit">Login</v-btn>
            </div>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const username = ref('')
const password = ref('')
const loading = ref(false)
const router = useRouter()

const submit = async () => {
  loading.value = true
  try {
    const { data } = await axios.post('/api/login', { username: username.value, password: password.value })
    localStorage.setItem('token', data.token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${data.token}`
    // optionally store user info
    localStorage.setItem('user', JSON.stringify(data.user))
    router.push('/employees')
  } catch (e) {
    alert('Invalid credentials')
  } finally {
    loading.value = false
  }
}
</script>
