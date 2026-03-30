<script setup lang="ts">
import { useForm, Head, Link } from '@inertiajs/vue3'
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue'
import Input from '@/components/ui/input/Input.vue'
import Label from '@/components/ui/label/Label.vue'
import { Button } from '@/components/ui/button'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { ref } from 'vue'

interface Props {
  registration: Record<string, any>
}

const props = defineProps<Props>()

const breadcrumbs = [
  { title: 'Dashboard', href: '/school-admin/dashboard' },
  { title: 'Registrations', href: '/school-admin/registrations' },
  { title: 'Edit Registration', href: '#' },
]

const form = useForm({
  admission_for: props.registration.admission_for || '',
  applicant_name: props.registration.applicant_name || '',
  dob: props.registration.dob || '',
  gender: props.registration.gender || '',
  blood_group: props.registration.blood_group || '',
  only_child: props.registration.only_child || '',
  social_category: props.registration.social_category || '',
  nationality: props.registration.nationality || '',
  bpl: props.registration.bpl || '',
  cwsn: props.registration.cwsn || '',
  aadhaar_no: props.registration.aadhaar_no || '',
  udise_no: props.registration.udise_no || '',
  pen_no: props.registration.pen_no || '',
  email: props.registration.email || '',
  present_class: props.registration.present_class || '',
  present_school_name: props.registration.present_school_name || '',
  present_school_address: props.registration.present_school_address || '',
  admission_sought_for_class: props.registration.admission_sought_for_class || '',
  
  total_subjects: props.registration.total_subjects || '',
  total_marks_obtained: props.registration.total_marks_obtained || '',
  full_marks: props.registration.full_marks || '',

  parents_category_b: props.registration.parents_category_b || '',
  father_name: props.registration.father_name || '',
  father_occupation: props.registration.father_occupation || '',
  father_phone: props.registration.father_phone || '',
  mother_name: props.registration.mother_name || '',
  mother_occupation: props.registration.mother_occupation || '',
  mother_phone: props.registration.mother_phone || '',
  annual_income: props.registration.annual_income || '',

  c_street_area_locality: props.registration.c_street_area_locality || '',
  c_village_town: props.registration.c_village_town || '',
  c_post_office: props.registration.c_post_office || '',
  c_pin_code: props.registration.c_pin_code || '',
  c_house_no: props.registration.c_house_no || '',
  c_state: props.registration.c_state || '',
  c_district: props.registration.c_district || '',

  p_street_area_locality: props.registration.p_street_area_locality || '',
  p_village_town: props.registration.p_village_town || '',
  p_post_office: props.registration.p_post_office || '',
  p_pin_code: props.registration.p_pin_code || '',
  p_house_no: props.registration.p_house_no || '',
  p_state: props.registration.p_state || '',
  p_district: props.registration.p_district || '',

  reference_number: props.registration.reference_number || '',
})

const submit = () => {
  form.put(`/school-admin/registrations/${props.registration.id}`, {
    preserveState: true,
    onSuccess: () => {
      // Logic after successful update if needed
    },
  })
}

const sameAddressRef = ref(false);
const toggleSameAddress = () => {
  sameAddressRef.value = !sameAddressRef.value;
  if (sameAddressRef.value) {
    form.p_district = form.c_district;
    form.p_house_no = form.c_house_no;
    form.p_pin_code = form.c_pin_code;
    form.p_post_office = form.c_post_office;
    form.p_state = form.c_state;
    form.p_street_area_locality = form.c_street_area_locality;
    form.p_village_town = form.c_village_town;
  }
}
</script>

<template>
  <Head title="Edit Registration" />
  <SchoolAdminLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <form @submit.prevent="submit" class="space-y-8">
          <h1 class="text-2xl font-bold text-gray-800 border-b pb-4">EDIT STUDENT REGISTRATION</h1>

          <div class="space-y-6">
            <!-- STUDENT’S INFORMATION -->
            <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded">STUDENT’S INFORMATION</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="space-y-1">
                <Label for="admission_for">Admission For *</Label>
                <Select id="admission_for" v-model="form.admission_for">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Option" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Day Scholar">Day Scholar</SelectItem>
                      <SelectItem value="Boarding">Boarding</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <div class="text-sm text-red-500" v-if="form.errors.admission_for">{{ form.errors.admission_for }}</div>
              </div>

              <div class="space-y-1">
                <Label for="applicant_name">Applicant Name *</Label>
                <Input id="applicant_name" v-model="form.applicant_name" required />
                <div class="text-sm text-red-500" v-if="form.errors.applicant_name">{{ form.errors.applicant_name }}</div>
              </div>

              <div class="space-y-1">
                <Label for="dob">Date of Birth *</Label>
                <Input type="date" id="dob" v-model="form.dob" required />
                <div class="text-sm text-red-500" v-if="form.errors.dob">{{ form.errors.dob }}</div>
              </div>

              <div class="space-y-1">
                <Label for="gender">Gender *</Label>
                <Select id="gender" v-model="form.gender">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Gender" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Male">Male</SelectItem>
                      <SelectItem value="Female">Female</SelectItem>
                      <SelectItem value="Others">Others</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <div class="text-sm text-red-500" v-if="form.errors.gender">{{ form.errors.gender }}</div>
              </div>

              <div class="space-y-1">
                <Label for="blood_group">Blood Group</Label>
                <Select id="blood_group" v-model="form.blood_group">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Blood Group" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem v-for="bg in ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']" :key="bg" :value="bg">{{ bg }}</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-1">
                <Label for="only_child">Whether Only Child? *</Label>
                <Select id="only_child" v-model="form.only_child">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Yes">Yes</SelectItem>
                      <SelectItem value="No">No</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-1">
                <Label for="social_category">Social Category *</Label>
                <Select id="social_category" v-model="form.social_category">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Category" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem v-for="cat in ['GENERAL', 'SC', 'ST', 'OBC-A', 'OBC-B']" :key="cat" :value="cat">{{ cat }}</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-1">
                <Label for="nationality">Nationality *</Label>
                <Select id="nationality" v-model="form.nationality">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Nationality" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="INDIAN">INDIAN</SelectItem>
                      <SelectItem value="OTHER">OTHER</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

               <div class="space-y-1">
                <Label for="bpl">Whether BPL Beneficiary? *</Label>
                <Select id="bpl" v-model="form.bpl">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Yes">Yes</SelectItem>
                      <SelectItem value="No">No</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-1">
                <Label for="cwsn">Whether CWSN? *</Label>
                <Select id="cwsn" v-model="form.cwsn">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="Yes">Yes</SelectItem>
                      <SelectItem value="No">No</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>

              <div class="space-y-1">
                <Label for="aadhaar_no">Aadhaar Number *</Label>
                <Input id="aadhaar_no" v-model="form.aadhaar_no" required />
                <div class="text-sm text-red-500" v-if="form.errors.aadhaar_no">{{ form.errors.aadhaar_no }}</div>
              </div>

              <div class="space-y-1">
                <Label for="email">Email Address *</Label>
                <Input id="email" type="email" v-model="form.email" required />
                <div class="text-sm text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
              </div>

              <div class="space-y-1">
                <Label for="present_class">Present Class *</Label>
                <Input id="present_class" v-model="form.present_class" required />
              </div>

              <div class="space-y-1">
                <Label for="admission_sought_for_class">Admission sought for Class *</Label>
                <Select id="admission_sought_for_class" v-model="form.admission_sought_for_class">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Class" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem v-for="cls in ['Nursery', 'LKG', 'UKG', 'CLASS I', 'CLASS II', 'CLASS III', 'CLASS IV', 'CLASS V', 'CLASS VI', 'CLASS VII', 'CLASS VIII', 'CLASS IX', 'CLASS X', 'CLASS XI', 'CLASS XII']" :key="cls" :value="cls">{{ cls }}</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>
            </div>

            <!-- ACADEMIC INFORMATION -->
            <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded mt-8">ACADEMIC INFORMATION</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="space-y-1">
                <Label for="total_subjects">Total Subjects</Label>
                <Input type="number" id="total_subjects" v-model="form.total_subjects" />
              </div>
              <div class="space-y-1">
                <Label for="total_marks_obtained">Total Marks Obtained</Label>
                <Input type="number" id="total_marks_obtained" v-model="form.total_marks_obtained" />
              </div>
              <div class="space-y-1">
                <Label for="full_marks">Full Marks</Label>
                <Input type="number" id="full_marks" v-model="form.full_marks" />
              </div>
            </div>

            <!-- PARENT’S INFORMATION -->
            <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded mt-8">PARENT’S INFORMATION</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
               <div class="space-y-1">
                <Label for="parents_category_b">Category *</Label>
                <Select id="parents_category_b" v-model="form.parents_category_b">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Select Category" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="CIVILIAN">Civilian</SelectItem>
                      <SelectItem value="DEFENCE AR">Defence - AR</SelectItem>
                      <SelectItem value="DEFENCE CRPS">Defence - CRPS</SelectItem>
                      <SelectItem value="DEFENCE AFS">Defence - AFS</SelectItem>
                      <SelectItem value="DEFENCE ARMY">Defence - ARMY</SelectItem>
                      <SelectItem value="DEFENCE OTHERS">Defence - Others</SelectItem>
                      <SelectItem value="RETIRED DEFENCE">Retired Defence</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
              </div>
              <div class="space-y-1">
                <Label for="father_name">Father's Name *</Label>
                <Input id="father_name" v-model="form.father_name" required />
              </div>
              <div class="space-y-1">
                <Label for="father_phone">Father's Phone *</Label>
                <Input id="father_phone" v-model="form.father_phone" required />
              </div>
              <div class="space-y-1">
                <Label for="mother_name">Mother's Name *</Label>
                <Input id="mother_name" v-model="form.mother_name" required />
              </div>
              <div class="space-y-1">
                <Label for="mother_phone">Mother's Phone *</Label>
                <Input id="mother_phone" v-model="form.mother_phone" required />
              </div>
              <div class="space-y-1">
                <Label for="annual_income">Annual Income *</Label>
                <Input type="number" id="annual_income" v-model="form.annual_income" required />
              </div>
            </div>

            <!-- ADDRESS DETAILS -->
            <h3 class="text-lg font-semibold text-white bg-slate-500 p-2 rounded mt-8">CURRENT ADDRESS DETAILS</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="space-y-1">
                <Label for="c_street_area_locality">Street/Area/Locality *</Label>
                <Input id="c_street_area_locality" v-model="form.c_street_area_locality" required />
              </div>
              <div class="space-y-1">
                <Label for="c_village_town">Village/Town *</Label>
                <Input id="c_village_town" v-model="form.c_village_town" required />
              </div>
              <div class="space-y-1">
                <Label for="c_post_office">Post Office *</Label>
                <Input id="c_post_office" v-model="form.c_post_office" required />
              </div>
              <div class="space-y-1">
                <Label for="c_pin_code">Pin Code *</Label>
                <Input id="c_pin_code" v-model="form.c_pin_code" required />
              </div>
              <div class="space-y-1">
                <Label for="c_state">State *</Label>
                <Input id="c_state" v-model="form.c_state" required />
              </div>
              <div class="space-y-1">
                <Label for="c_district">District *</Label>
                <Input id="c_district" v-model="form.c_district" required />
              </div>
            </div>

            <div class="flex items-center space-x-2 mt-4">
              <input type="checkbox" id="same_address" :checked="sameAddressRef" @change="toggleSameAddress" class="rounded border-gray-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50" />
              <Label for="same_address">Permanent Address same as Current Address</Label>
            </div>

            <h3 class="text-lg font-semibold text-white bg-slate-500 p-2 rounded mt-4">PERMANENT ADDRESS DETAILS</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="space-y-1">
                <Label for="p_street_area_locality">Street/Area/Locality *</Label>
                <Input id="p_street_area_locality" v-model="form.p_street_area_locality" required />
              </div>
              <div class="space-y-1">
                <Label for="p_village_town">Village/Town *</Label>
                <Input id="p_village_town" v-model="form.p_village_town" required />
              </div>
              <div class="space-y-1">
                <Label for="p_post_office">Post Office *</Label>
                <Input id="p_post_office" v-model="form.p_post_office" required />
              </div>
              <div class="space-y-1">
                <Label for="p_pin_code">Pin Code *</Label>
                <Input id="p_pin_code" v-model="form.p_pin_code" required />
              </div>
              <div class="space-y-1">
                <Label for="p_state">State *</Label>
                <Input id="p_state" v-model="form.p_state" required />
              </div>
              <div class="space-y-1">
                <Label for="p_district">District *</Label>
                <Input id="p_district" v-model="form.p_district" required />
              </div>
            </div>

            <!-- PAYMENT -->
            <h3 class="text-lg font-semibold text-white bg-sky-500 p-2 rounded mt-8">PAYMENT INFORMATION</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-1">
                <Label for="reference_number">Payment Reference No./Transaction ID *</Label>
                <Input id="reference_number" v-model="form.reference_number" required />
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-4 pt-6 border-t font-semibold">
            <Link :href="`/school-admin/registrations/${registration.id}`">
              <Button type="button" variant="outline">Cancel</Button>
            </Link>
            <Button type="submit" :disabled="form.processing">
              {{ form.processing ? 'Updating...' : 'Update Registration' }}
            </Button>
          </div>
        </form>
      </div>
    </div>
  </SchoolAdminLayout>
</template>
