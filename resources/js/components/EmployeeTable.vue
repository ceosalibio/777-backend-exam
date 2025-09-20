<template>
  <div>
    <v-btn color="primary" class="mb-4" @click="dialog = true">
      Add Employee
    </v-btn>

    <!-- Employee Table -->
    <v-data-table
      :headers="headers"
      :items="employees"
      class="elevation-1"
    >
      <!-- <template #item.actions="{ item }">
        <v-btn icon="mdi-pencil" @click="editEmployee(item)" />
        <v-btn icon="mdi-delete" color="red" @click="deleteEmployee(item.id)" />
      </template> -->
    </v-data-table>

    <!-- Dialog for Add/Edit -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>{{ form.id ? 'Edit Employee' : 'Add Employee' }}</v-card-title>
        <v-card-text>
          <v-text-field v-model="form.name" label="Name" />
          <v-select
            v-model="form.position"
            :items="['Manager', 'Web Developer', 'Web Designer']"
            label="Position"
          />
        </v-card-text>
        <v-card-actions>
          <v-btn text @click="dialog = false">Cancel</v-btn>
          <v-btn color="primary" @click="saveEmployee">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const headers = [
  { text: 'Name', value: 'name' },
  { text: 'Position', value: 'position' },
  { text: 'Actions', value: 'actions', sortable: false },
]

const employees = ref([])
const dialog = ref(false)
const form = ref({ id: null, name: '', position: '' })

const fetchEmployees = async () => {
  const { data } = await axios.get('/api/employees')
  employees.value = data
}

const saveEmployee = async () => {
  if (form.value.id) {
    await axios.put(`/api/employees/${form.value.id}`, form.value)
  } else {
    await axios.post('/api/employees', form.value)
  }
  dialog.value = false
  form.value = { id: null, name: '', position: '' }
  fetchEmployees()
}

const editEmployee = (emp) => {
  form.value = { ...emp }
  dialog.value = true
}

const deleteEmployee = async (id) => {
  await axios.delete(`/api/employees/${id}`)
  fetchEmployees()
}

onMounted(fetchEmployees)
</script>
