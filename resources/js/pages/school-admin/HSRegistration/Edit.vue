<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3'
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import Button from '@/components/ui/button/Button.vue'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import { HSRegistration, BreadcrumbItem } from '@/types'

const props = defineProps<{
  registration: HSRegistration
}>()

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'HS Registrations', href: '/school-admin/hs-registrations' },
  { title: 'Edit HS Registration', href: `/school-admin/hs-registrations/${props.registration.id}/edit` },
]

const form = useForm({
  name: props.registration.name || '',
  dob: props.registration.dob || '',
  gender: props.registration.gender || '',
  contact_number: props.registration.contact_number || '',
  email: props.registration.email || '',
  last_school: props.registration.last_school || '',
  pre_borad_percentage: props.registration.pre_borad_percentage || '',
  stream: props.registration.stream || '',
  pen_number: props.registration.pen_number || '',
  apaar_id: props.registration.apaar_id || '',
  father_name: props.registration.father_name || '',
  mother_name: props.registration.mother_name || '',
  parents_contact_number: props.registration.parents_contact_number || '',
  whatsapp: props.registration.whatsapp || '',
  address: props.registration.address || '',
  reason_of_interest: props.registration.reason_of_interest || '',
  reference_number: props.registration.reference_number || '',
})

const submit = () => {
  form.put(`/school-admin/hs-registrations/${props.registration.id}`, {
    onSuccess: () => {
      // success message handled by flash
    },
  })
}
</script>

<template>
  <Head title="Edit HS Registration" />
  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 max-w-4xl mx-auto">
      <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Edit HS Registration</h1>
        <Link :href="`/school-admin/hs-registrations/${registration.id}`">
          <Button variant="outline">Back to Details</Button>
        </Link>
      </div>

      <form @submit.prevent="submit" class="bg-white p-6 rounded-lg shadow space-y-8">
        <!-- Student Information -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded">Student Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
              <Label for="name">Applicant Name</Label>
              <Input id="name" v-model="form.name" required />
              <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
            </div>
            <div class="space-y-1">
              <Label for="dob">Date of Birth</Label>
              <Input type="date" id="dob" v-model="form.dob" required />
              <div v-if="form.errors.dob" class="text-sm text-red-500">{{ form.errors.dob }}</div>
            </div>
            <div class="space-y-1">
              <Label for="gender">Gender</Label>
              <Select v-model="form.gender" required>
                <SelectTrigger>
                  <SelectValue placeholder="Select Gender" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="Male">Male</SelectItem>
                  <SelectItem value="Female">Female</SelectItem>
                  <SelectItem value="Others">Others</SelectItem>
                </SelectContent>
              </Select>
              <div v-if="form.errors.gender" class="text-sm text-red-500">{{ form.errors.gender }}</div>
            </div>
            <div class="space-y-1">
              <Label for="email">Email</Label>
              <Input id="email" v-model="form.email" type="email" />
              <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
            </div>
            <div class="space-y-1">
              <Label for="contact_number">Contact Number</Label>
              <Input id="contact_number" v-model="form.contact_number" required />
              <div v-if="form.errors.contact_number" class="text-sm text-red-500">{{ form.errors.contact_number }}</div>
            </div>
          </div>
        </div>

        <!-- Academic Information -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded">Academic Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
              <Label for="last_school">Last School Name</Label>
              <Input id="last_school" v-model="form.last_school" required />
              <div v-if="form.errors.last_school" class="text-sm text-red-500">{{ form.errors.last_school }}</div>
            </div>
            <div class="space-y-1">
              <Label for="pre_borad_percentage">Pre-Board Percentage</Label>
              <Input id="pre_borad_percentage" v-model="form.pre_borad_percentage" type="number" />
              <div v-if="form.errors.pre_borad_percentage" class="text-sm text-red-500">{{ form.errors.pre_borad_percentage }}</div>
            </div>
            <div class="space-y-1">
              <Label for="stream">Stream Applied</Label>
              <Select v-model="form.stream">
                <SelectTrigger>
                  <SelectValue placeholder="Select Stream" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="Arts">Arts</SelectItem>
                  <SelectItem value="Commerce">Commerce</SelectItem>
                  <SelectItem value="Science">Science</SelectItem>
                </SelectContent>
              </Select>
              <div v-if="form.errors.stream" class="text-sm text-red-500">{{ form.errors.stream }}</div>
            </div>
            <div class="space-y-1">
              <Label for="pen_number">PEN Number</Label>
              <Input id="pen_number" v-model="form.pen_number" />
              <div v-if="form.errors.pen_number" class="text-sm text-red-500">{{ form.errors.pen_number }}</div>
            </div>
            <div class="space-y-1">
              <Label for="apaar_id">APAAR ID</Label>
              <Input id="apaar_id" v-model="form.apaar_id" />
              <div v-if="form.errors.apaar_id" class="text-sm text-red-500">{{ form.errors.apaar_id }}</div>
            </div>
          </div>
        </div>

        <!-- Parent Information -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded">Parent Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
              <Label for="father_name">Father's Name</Label>
              <Input id="father_name" v-model="form.father_name" required />
              <div v-if="form.errors.father_name" class="text-sm text-red-500">{{ form.errors.father_name }}</div>
            </div>
            <div class="space-y-1">
              <Label for="mother_name">Mother's Name</Label>
              <Input id="mother_name" v-model="form.mother_name" required />
              <div v-if="form.errors.mother_name" class="text-sm text-red-500">{{ form.errors.mother_name }}</div>
            </div>
            <div class="space-y-1">
              <Label for="parents_contact_number">Parent's Contact Number</Label>
              <Input id="parents_contact_number" v-model="form.parents_contact_number" required />
              <div v-if="form.errors.parents_contact_number" class="text-sm text-red-500">{{ form.errors.parents_contact_number }}</div>
            </div>
            <div class="space-y-1">
              <Label for="whatsapp">WhatsApp</Label>
              <Input id="whatsapp" v-model="form.whatsapp" />
              <div v-if="form.errors.whatsapp" class="text-sm text-red-500">{{ form.errors.whatsapp }}</div>
            </div>
          </div>
        </div>

        <!-- Address -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded">Address Details</h3>
          <div class="space-y-1">
            <Label for="address">Address</Label>
            <Input id="address" v-model="form.address" required />
            <div v-if="form.errors.address" class="text-sm text-red-500">{{ form.errors.address }}</div>
          </div>
        </div>

        <!-- Reason -->
        <div class="space-y-4">
          <h3 class="text-lg font-semibold text-white bg-slate-500 p-2 rounded">Other Information</h3>
          <div class="space-y-1">
            <Label for="reason_of_interest">Why ARPS?</Label>
            <Textarea id="reason_of_interest" v-model="form.reason_of_interest" required />
            <div v-if="form.errors.reason_of_interest" class="text-sm text-red-500">{{ form.errors.reason_of_interest }}</div>
          </div>
          <div class="space-y-1">
            <Label for="reference_number">Payment Reference Number</Label>
            <Input id="reference_number" v-model="form.reference_number" required />
            <div v-if="form.errors.reference_number" class="text-sm text-red-500">{{ form.errors.reference_number }}</div>
          </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end space-x-4 pt-6 border-t font-semibold">
          <Link :href="`/school-admin/hs-registrations/${registration.id}`">
            <Button type="button" variant="outline">Cancel</Button>
          </Link>
          <Button type="submit" :disabled="form.processing">
            {{ form.processing ? 'Updating...' : 'Update Registration' }}
          </Button>
        </div>
      </form>
    </div>
  </SchoolAdminLayout>
</template>
