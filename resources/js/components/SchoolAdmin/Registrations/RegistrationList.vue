<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow
} from '@/components/ui/table';
import { Registration } from '@/types';// Type definition for a registration object in types folder.
import { Link, router } from '@inertiajs/vue3';
import { FilePen, Info, Trash } from 'lucide-vue-next';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
  registrations: Registration[]
}
const props = defineProps<Props>() // Make props reactive and type-safe.
/**
 * Delete registration function
 */
const deleteRegistration = (id: number) => {
  if (confirm('Are you sure you want to delete this registration?')) {
    router.delete(`/school-admin/registrations/${id}`, {
      onSuccess: () => {
        // Optional: show toast message
        
      }
    })
  }
}

</script>

<template>
  <!-- Main Table -->
  <Table>
    <!-- Caption  -->
    <TableCaption>A list of your recent registrations.</TableCaption>

    <!-- Table header row -->
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px]">Registration ID</TableHead>
        <TableHead>Name</TableHead>
        <TableHead>Gender</TableHead>
        <TableHead>For Class</TableHead>
        <TableHead>Phone</TableHead>
        <TableHead>Date</TableHead>
        <TableHead class="text-right">Quick Action</TableHead>
      </TableRow>
    </TableHeader>

    <!-- Table body with data rows -->
    <TableBody>
      <!-- Loop through each registration -->
      <TableRow v-for="registration in props.registrations" :key="registration.id">
        <!-- ID -->
        <TableCell class="font-medium">{{ registration.id }}</TableCell>

        <!-- Name -->
        <TableCell>{{ registration.applicant_name }}</TableCell>

        <!-- Gender -->
        <TableCell>{{ registration.gender }}</TableCell>

        <!-- Class applied for -->
        <TableCell>{{ registration.admission_sought_for_class }}</TableCell>

        <!-- Father's phone number -->
        <TableCell>{{ registration.father_phone }}</TableCell>

        <!-- Created date formatted -->
        <TableCell>
          {{
            new Date(registration.created_at).toLocaleString('en-CA', {
              year: 'numeric',
              month: '2-digit',
              day: '2-digit',
              hour: '2-digit',
              minute: '2-digit',
            })
          }}
        </TableCell>

        <!-- Actions -->
        <TableCell class="text-right space-x-2">
          <!-- Link to registration detail page -->
          <Link :href="`/school-admin/registrations/${registration.id}`">
            <Button class="group">
              <Info class="group-hover:hidden w-3 h-3" />
              <span class="group-hover:block hidden">View</span>
            </Button>
          </Link>
          <Link :href="`/school-admin/registrations/${registration.id}/edit`">
            <Button class="group">
              <FilePen class="group-hover:hidden w-3 h-3" />
              <span class="group-hover:block hidden">Edit</span>
            </Button>
          </Link>
          <Button variant="destructive" class="group" @click="deleteRegistration(registration.id)">
            <Trash class="group-hover:hidden w-3 h-3" />
            <span class="group-hover:block hidden">Delete</span>
          </Button>
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>

<style scoped>
/* Add responsive behavior if needed (optional).
   Example: Make table scrollable on small screens.
*/
/* @media (max-width: 640px) {
  table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }
} */
</style>

<!-- TODO -->
<!-- Add pagination, filteration, searching, sorting -->