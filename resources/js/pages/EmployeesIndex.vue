<template>
  <v-container>
    <v-row class="mb-4">
      <v-col><h2>Employees</h2></v-col>
      <v-col class="d-flex justify-end">
        <v-btn color="primary" @click="openForm()">Add Employee</v-btn>
        <v-btn class="ml-3" color="error" @click="logout">Logout</v-btn>
      </v-col>
    </v-row>

    <!-- <v-data-table :headers="headers" :items="employees" class="elevation-1">
      <template #item.actions="{ item }">
        <v-btn small icon @click="edit(item)"><v-icon>mdi-pencil</v-icon></v-btn>
        <v-btn small icon color="red" @click="remove(item)"><v-icon>mdi-delete</v-icon></v-btn>
      </template>
    </v-data-table> -->

    <v-table>
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(employee, index) in employees" :key="employee.id">
                <td>{{ index + 1 }}</td>
                <td>{{ employee.first_name }}</td>
                <td>{{ employee.last_name }}</td>
                <td>{{ employee.position }}</td>
                <td>{{ new Date(employee.created_at).toLocaleDateString() }}</td>
                <td>
                    <v-btn small color="warning" @click="edit(employee)">Edit</v-btn>
                    <v-btn small color="red" @click="remove(employee)">Delete</v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>



    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>{{ form.id ? 'Edit Employee' : 'Add Employee' }}</v-card-title>
        <v-card-text>
          <v-form ref="formRef" @submit.prevent="save">
            <v-text-field v-model="form.first_name" label="First Name" required />
            <v-text-field v-model="form.last_name" label="Last Name" required />
            <!-- Manager-only select -->
            <div v-if="isManager">
              <v-select v-model="form.position" :items="positions" label="Position" required />
            </div>
            <div v-else>
              <v-text-field v-model="form.position" label="Position" :readonly="true" />
            </div>
            <!-- <v-text-field v-model="form.email" label="Email" />
            <v-textarea v-model="form.notes" label="Notes" /> -->
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn text @click="dialog=false">Cancel</v-btn>
          <v-btn color="primary" @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const employees = ref([])
const dialog = ref(false)
const form = ref({ id: null, name: '', position: '', email: '', notes: '' })
const formRef = ref(null)
const positions = ['Manager','Web Developer','Web Designer']
 

const user = JSON.parse(localStorage.getItem('user') || '{}')
const isManager = user.role === 'Manager'

onMounted(() => {
  const token = localStorage.getItem('token')
  if (token) axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  fetch()
})

const fetch = async () => {
  try {
    const { data } = await axios.get('/api/employees')
    employees.value = data
  } catch (e) {
    if (e.response && e.response.status === 401) router.push('/login')
  }
}

const openForm = () => {
  form.value = { id: null, name: '', position: isManager ? '' : user.role, email: '', notes: '' }
  dialog.value = true
}

const save = async () => {
  try {
    if (form.value.id) {
      await axios.put(`/api/employees/${form.value.id}`, form.value)
    } else {
      await axios.post('/api/employees', form.value)
    }
    dialog.value = false
    fetch()
  } catch (e) {
    alert(e.response?.data?.message || 'Error')
  }
}

const edit = (item) => {
  form.value = { ...item }
  // non-managers must not modify position: populate but hide select; UI will not allow change
  if (!isManager) form.value.position = user.role
  dialog.value = true
}

const remove = async (item) => {
  if (!confirm('Delete this employee?')) return
  try {
    await axios.delete(`/api/employees/${item.id}`)
    fetch()
  } catch (e) {
    alert(e.response?.data?.message || 'Error')
  }
}

const logout = async () => {
  await axios.post('/api/logout')
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  delete axios.defaults.headers.common['Authorization']
  router.push('/login')
}
</script>
