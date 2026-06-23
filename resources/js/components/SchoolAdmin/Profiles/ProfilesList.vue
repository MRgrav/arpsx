<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow
} from '@/components/ui/table';
import { Profile } from '@/types';// Type definition for a registration object in types folder.
import { Link } from '@inertiajs/vue3';

/**
 * Props definition
 * The component expects an array of registrations.
 */
interface Props {
  profiles: Profile[]
}
const props = defineProps<Props>() // Make props reactive and type-safe.

</script>

<template>
  <!-- Main Table -->
  <Table>
    <!-- Caption  -->
    <TableCaption>A list of your recent Profiles.</TableCaption>

    <!-- Table header row -->
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px]">Name</TableHead>
        <TableHead>Role</TableHead>
        <TableHead>Department</TableHead>
        <TableHead class="text-right">Quick Action</TableHead>
      </TableRow>
    </TableHeader>

    <!-- Table body with data rows -->
    <TableBody>
      <!-- Loop through each registration -->
      <TableRow v-for="profile in props.profiles" :key="profile.id">

        <!-- Name -->
        <TableCell class="w-[150px] font-medium">
          <div class="flex items-center gap-1.5">
            <span>{{ profile.name }}</span>
            <span v-if="profile.is_hod" class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-350">
              HOD
            </span>
          </div>
        </TableCell>

        <!-- Role -->
        <TableCell>{{ profile.role?.display_name }}</TableCell>

        <!-- Department for -->
        <TableCell>{{ profile.department?.display_name }}</TableCell>


        <!-- Actions -->
        <TableCell class="text-right space-x-2">
          <!-- Link to registration detail page -->
          <Link :href="`/school-admin/profiles/${profile.id}`">
            <Button>Details</Button>
          </Link>
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