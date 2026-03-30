<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import SchoolAdminLayout from '@/layouts/SchoolAdminLayout.vue';
import { BreadcrumbItem, HSRegistration } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
  hsRegistration: HSRegistration;
}
const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/school-admin/dashboard',
  },
  {
    title: 'HS Registration',
    href: '/school-admin/hs-registration',
  },
  {
    title: 'View',
    href: `/school-admin/hs-registration/${props.hsRegistration.id}`,
  }
];

</script>

<template>
    <Head title="HS Registration" />

    <SchoolAdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <Card>
                <CardHeader>
                    <CardTitle>Application Details</CardTitle>
                    <p>Registration for Admission in Class XI (2026-27)</p>
                </CardHeader>
                <CardContent>
                    <div class="flex justify-end mb-6 space-x-2">
                        <Link :href="`/school-admin/hs-registrations/${props.hsRegistration.id}/edit`">
                            <Button variant="outline">Edit Registration</Button>
                        </Link>
                        <a
                            :href="`/hs-registration/${props.hsRegistration.id}/pdf`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="h-min w-min"
                        >
                            <Button class="w-min ms-auto cursor-pointer">Download Application</Button>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <Label for="name">Name: </Label>
                            <p>{{ hsRegistration.name }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="dob">Date of Birth ( MM-DD-YYYY ): </Label>
                            <p>{{ hsRegistration.dob }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="gender">Gender: </Label>
                            <p>{{ hsRegistration.gender }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="email">Email Address: </Label>
                            <p>{{ hsRegistration.email }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="contact_number">Contact Number: </Label>
                            <p>{{ hsRegistration.contact_number }}</p>
                        </div>
                        <hr class="col-span-full" />
                        <div class="space-y-1">
                            <Label for="percentage">Pre-Board Percentage: </Label>
                            <p>{{ hsRegistration.pre_borad_percentage ?? 0 }}%</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="last_school_name">Last School Name: </Label>
                            <p>{{ hsRegistration.last_school }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="stream">Stream: </Label>
                            <p>{{ hsRegistration.stream }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="pen_number">PEN Number:</Label>
                            <p>{{ hsRegistration.pen_number }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="apaar_id">APAAR ID:</Label>
                            <p>{{ hsRegistration.apaar_id }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="father_name">Father's Name: </Label>
                            <p>{{ hsRegistration.father_name }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="mother_name">Mother's Name: </Label>
                            <p>{{ hsRegistration.mother_name }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="parents_contact_number">Parent's Contact Number:</Label>
                            <p>{{ hsRegistration.parents_contact_number }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="whatsapp">WhatsApp:</Label>
                            <p>{{ hsRegistration.whatsapp }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="address">Address: </Label>
                            <p>{{ hsRegistration.address }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="reference_number">Reference Number: </Label>
                            <p>{{ hsRegistration.reference_number }}</p>
                        </div>
                        <div class="space-y-1">
                            <Label for="payment_screenshot">Payment Screenshot: </Label>
                            <img :src="hsRegistration.payment_screenshot as string" alt="Payment Screenshot" />
                        </div>
                        <hr class="col-span-full" />
                        <div class="col-span-full space-y-1">
                            <Label for="reason_of_interest">Reason of Interest: </Label>
                            <p>{{ hsRegistration.reason_of_interest }}</p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <Link href="/school-admin/hs-registrations">
                <Button>Back</Button>
            </Link>
        </div>  
    </SchoolAdminLayout>
</template>