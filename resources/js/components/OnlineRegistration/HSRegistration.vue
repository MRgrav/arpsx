<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import Input from '../ui/input/Input.vue'
import Label from '../ui/label/Label.vue';
import { ref } from 'vue';
import FormSuccess from './FormSuccess.vue';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '../ui/select';
import Loader from './Loader.vue';

// Online Registration Form Object
const form = useForm({
  //student information
  name: '',
  dob: '',
  gender: '',
  contact_number: '',
  email: '',

  // academic
  last_school_name: '',
  pre_board_percentage: '',
  stream: '',
  pen_number: '',
  apaar_id: '',


  // parents infromation
  father_name: '',
  mother_name: '',
  parents_contact_number: '',
  whatsapp: '',

  // Current address
  address: '',

  reason_of_interest: '',
})

// initial value of form submit
const success = ref(false);
const submitting = ref(false);
// ID of the submitted form, used to download PDF
const submittedId = ref<number | null>(null);
const errorModel = ref({});


// Submit the form using Inertia js Form helper
const submitForm = () => {

  submitting.value = true;
  form.post(route('hs-registration.store'), {
    forceFormData: true,
    onError: () => {
      errorModel.value = form.errors ? { ...form.errors } : {};
      submitting.value = false;
    },
    onSuccess: (data) => {
      success.value = true;
      form.reset();
      submitting.value = false;
      // Set the submitted ID from the flash data
      submittedId.value = (data.props.flash && (data.props.flash as any).data.id) ?? null;
    },
    onFinish: () => {
      submitting.value = false;
    },
  })
}

const clearErrors = () => {
  errorModel.value = {};
}
</script>
<template>
  <Loader :open="submitting" />
  <!-- Show Success messsage after form submit with PDF download link -->
  <FormSuccess :show="success" @close="success = false" :id="submittedId ?? undefined" />

  <form @submit.prevent="submitForm" class="space-y-8 p-8">
    <h1 class="font-bold text-gray-800 uppercase">REGISTRATION FOR ADmission</h1>
    <p class="text-gray-600 text-lg font-semibold">Class - XI</p>
    <p class="text-red-600 font-semibold">Note: Document required at the time of admission, please bring the following:</p>
    <ul class="list-disc list-inside text-red-600">
      <li>Admission form</li>
      <li>Xerox copy of Class X Marksheet & Admit Card</li>
      <li>Passport-size photo (2 copies)</li>
      <li>Original TC certificate</li>
      <li>Original Migration Certificate (other than CBSE)</li>
    </ul>

    <div class="space-y-4">
      <!-- STUDENT’S INFORMATION -->
      <h3 class="text-lg font-semibold text-white bg-sky-400 p-2">STUDENT’S INFORMATION</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="space-y-1">
          <Label for="name">Applicant Name: </Label>
          <Input id="name" v-model="form.name" placeholder="APPLICANT NAME" required />
          <div class="text-sm text-red-500" v-if="form.errors.name">{{ form.errors.name }}</div>
        </div>
        <div class="space-y-1">
          <Label for="dob">Date of Birth ( MM-DD-YYYY ): </Label>
          <Input type="date" id="dob" v-model="form.dob" required />
          <div class="text-sm text-red-500" v-if="form.errors.dob">{{ form.errors.dob }}</div>
        </div>
        <div class="space-y-1">
          <Label for="gender">Gender: </Label>
          <Select id="gender" v-model="form.gender" required>
            <SelectTrigger class="form-select w-full">
              <SelectValue placeholder="-- Select --" />
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
          <Label for="email">Email Address: </Label>
          <Input id="email" v-model="form.email" placeholder="EMAIL ADDRESS" required />
          <div class="text-sm text-red-500" v-if="form.errors.email">{{ form.errors.email }}</div>
        </div>
        <div class="space-y-1">
          <Label for="contact_number">Contact Number: </Label>
          <Input type="number" id="contact_number" v-model="form.contact_number" placeholder="CONTACT NUMBER" required />
          <div class="text-sm text-red-500" v-if="form.errors.contact_number">{{ form.errors.contact_number }}</div>
        </div>
      </div>
    </div>

    
    <!-- ACADEMIC INFORMATION -->
    <div class="space-y-4">
      <h3 class="text-lg font-semibold text-white bg-sky-400 p-2">ACADEMIC INFORMATION</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="space-y-1">
          <Label for="last_school_name">Last School Name: </Label>
          <Input id="last_school_name" v-model="form.last_school_name" placeholder="LAST SCHOOL NAME" required />
          <div class="text-sm text-red-500" v-if="form.errors.last_school_name">{{ form.errors.last_school_name }}
          </div>
        </div>

        <div class="space-y-1">
          <Label for="pre_board_percentage">Pre-Board Percentage: </Label>
          <Input type="number" id="pre_board_percentage" v-model="form.pre_board_percentage" placeholder="PRE-BOARD PERCENTAGE" />
          <div class="text-sm text-red-500" v-if="form.errors.pre_board_percentage">{{ form.errors.pre_board_percentage
          }}</div>
        </div>
        <div class="space-y-1">
          <Label for="stream">Stream Applied: </Label>
          <Select id="stream" v-model="form.stream" required>
            <SelectTrigger class="form-select w-full">
              <SelectValue placeholder="-- Select --" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem value="Arts">Arts</SelectItem>
                <SelectItem value="Commerce">Commerce</SelectItem>
                <SelectItem value="Science">Science</SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
          <div class="text-sm text-red-500" v-if="form.errors.stream">{{ form.errors.stream }}</div>
        </div>
        <div class="space-y-1">
          <Label for="pen_number">PEN Number: </Label>
          <Input id="pen_number" v-model="form.pen_number" placeholder="PEN NUMBER" />
          <div class="text-sm text-red-500" v-if="form.errors.pen_number">{{ form.errors.pen_number }}</div>
        </div>
        <div class="space-y-1">
          <Label for="apaar_id">APAAR ID: </Label>
          <Input id="apaar_id" v-model="form.apaar_id" placeholder="APAAR ID" />
          <div class="text-sm text-red-500" v-if="form.errors.apaar_id">{{ form.errors.apaar_id }}</div>
        </div>
      </div>
    </div>


    <!-- PARENT’S INFORMATION -->
    <div class="space-y-4">
      <h3 class="text-lg font-semibold text-white bg-sky-400 p-2">PARENT’S INFORMATION</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="space-y-1">
          <Label for="father_name">Father's Name: </Label>
          <Input id="father_name" v-model="form.father_name" placeholder="FATHER'S NAME" required />
          <div class="text-sm text-red-500" v-if="form.errors.father_name">{{ form.errors.father_name }}</div>
        </div>
        <div class="space-y-1">
          <Label for="mother_name">Mother's Name: </Label>
          <Input id="mother_name" v-model="form.mother_name" placeholder="MOTHER'S NAME" required />
          <div class="text-sm text-red-500" v-if="form.errors.mother_name">{{ form.errors.mother_name }}</div>
        </div>
        <div class="space-y-1">
          <Label for="parents_contact_number">Parent's Contact Number: </Label>
          <Input type="number" id="parents_contact_number" v-model="form.parents_contact_number" placeholder="PARENT'S CONTACT NUMBER" required />
          <div class="text-sm text-red-500" v-if="form.errors.parents_contact_number">{{ form.errors.parents_contact_number }}</div>
        </div>
        <div class="space-y-1">
          <Label for="whatsapp">Whatsapp: </Label>
          <Input type="number" id="whatsapp" v-model="form.whatsapp" placeholder="WHATSAPP" />
          <div class="text-sm text-red-500" v-if="form.errors.whatsapp">{{ form.errors.whatsapp }}</div>
        </div>
      </div>
    </div>

    <!--CURRENT ADDRESS -->
    <div class="space-y-4">
      <h3 class="text-base font-medium text-white bg-sky-400 p-1">CURRENT ADDRESS DETAILS</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="space-y-1">
          <Label for="address">Address: </Label>
          <Input id="address" v-model="form.address" placeholder="ADDRESS" required />
          <div class="text-sm text-red-500" v-if="form.errors.address">{{ form.errors.address }}</div>
        </div>
      </div>
    </div>

    <div class="space-y-4">
      <h3 class="text-base font-medium text-white bg-slate-400 p-1">REASON FOR CHOOSING ARPS</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="space-y-1">
          <Label for="reason">Why ARPS, Jorhat?</Label>
          <Input id="reason" v-model="form.reason_of_interest" placeholder="REASON FOR CHOOSING ARPS, JORHAT" required />
          <div class="text-sm text-red-500" v-if="form.errors.reason_of_interest">{{ form.errors.reason_of_interest }}</div>
        </div>
      </div>
    </div>
    

    <!-- SUBMIT BUTTON -->
    <div class="flex justify-end mt-6">
      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        :disabled="form.processing">
        Submit
      </button>
    </div>
  </form>

  <!-- Show Success messsage after form submit with PDF download link -->
  <FormSuccess :show="success" @close="success = false" :id="submittedId ?? undefined" />

  <!-- Error Modal -->
  <div v-if="Object.keys(errorModel).length" class="fixed inset-0 flex items-center justify-center z-50">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 z-10">
      <h2 class="text-lg font-bold text-red-700 mb-4">Please fix the following errors:</h2>
      <ul class="list-disc list-inside text-red-600">
        <li v-for="(error, key) in errorModel" :key="key">{{ error }}</li>
      </ul>
      <div class="mt-4 flex justify-end">
        <button @click="clearErrors" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
          Close
        </button>
      </div>
    </div>
  </div>

</template>
