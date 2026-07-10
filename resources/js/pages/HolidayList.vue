<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Holiday List" />

        <div class="p-8 lg:p-16 w-full" data-ast-blocks-layout="true" itemprop="text">

            <div class="entry-content clear w-full" data-ast-blocks-layout="true" itemprop="text">



                <table id="tablepress-4" class="w-full">
 
                    <thead>
                        <tr class="row-1">
                            <th colspan="3" class="column-1">VACATION (2025-26)</th>
                        </tr>
                    </thead>
                    <tbody class="row-striping row-hover">
                        <tr class="row-2">
                            <td class="column-1">VACATION </td>
                            <td class="column-2">DURATION </td>
                            <td class="column-3">DAYS</td>
                        </tr>
                        <tr class="row-3">
                            <td class="column-1">SUMMER </td>
                            <td class="column-2">2 JUNE- 11 JULY 2025</td>
                            <td class="column-3">40</td>
                        </tr>
                        <tr class="row-4">
                            <td class="column-1">AUTUMN</td>
                            <td class="column-2">22 SEPTEMBER- 6 OCTOBER 2025</td>
                            <td class="column-3">15</td>
                        </tr>
                        <tr class="row-5">
                            <td class="column-1">WINTER</td>
                            <td class="column-2">22 DECEMBER- 5 JANUARY 2026</td>
                            <td class="column-3">15</td>
                        </tr>
                        <tr class="row-6">
                            <td colspan="2" class="column-1">TOTAL DAYS</td>
                            <td class="column-3">70</td>
                        </tr>
                    </tbody>
                </table>




                <table id="tablepress-3" class="tablepress tablepress-id-3 w-full">

                    <thead>
                        <tr class="row-1">
                            <th colspan="3" class="column-1">HOLIDAY LIST 2025-26</th>
                        </tr>
                    </thead>
                    <tbody class="row-striping row-hover">
                        <tr class="row-2">
                            <td class="column-1">10th APRIL 2025</td>
                            <td class="column-2">THURSDAY </td>
                            <td class="column-3">MAHAVIR JAYANTI </td>
                        </tr>
                        <tr class="row-3">
                            <td class="column-1">14th APRIL </td>
                            <td class="column-2">MONDAY </td>
                            <td class="column-3">BAiSAKHI </td>
                        </tr>
                        <tr class="row-4">
                            <td class="column-1">15th APRIL </td>
                            <td class="column-2">TUESDAY </td>
                            <td class="column-3">BOHAG BIHU </td>
                        </tr>
                        <tr class="row-5">
                            <td class="column-1">18th APRIL </td>
                            <td class="column-2">FRIDAY </td>
                            <td class="column-3">GOOD FRIDAY </td>
                        </tr>
                        <tr class="row-6">
                            <td class="column-1">12th MAY </td>
                            <td class="column-2">MONDAY </td>
                            <td class="column-3">BUDDHA PURNIMA </td>
                        </tr>
                        <tr class="row-7">
                            <td class="column-1">15th AUGUST </td>
                            <td class="column-2">FRIDAY </td>
                            <td class="column-3">INDEPENDENCE DAY </td>
                        </tr>
                        <tr class="row-8">
                            <td class="column-1">5th SEPTEMBER </td>
                            <td class="column-2">FRIDAY </td>
                            <td class="column-3">MILAD-UN-NABI </td>
                        </tr>
                        <tr class="row-9">
                            <td class="column-1">17th SEPTEMBER </td>
                            <td class="column-2">WEDNESDAY </td>
                            <td class="column-3">VISWAKARMA PUJA (RESTRICTED )</td>
                        </tr>
                        <tr class="row-10">
                            <td class="column-1">20th OCTOBER </td>
                            <td class="column-2">MONDAY </td>
                            <td class="column-3">DIWALI </td>
                        </tr>
                        <tr class="row-11">
                            <td class="column-1">5th NOVEMBER </td>
                            <td class="column-2">WEDNESDAY </td>
                            <td class="column-3">GURU NANAK’S BIRTHDAY </td>
                        </tr>
                        <tr class="row-12">
                            <td class="column-1">14th JANUARY </td>
                            <td class="column-2">THURSDAY </td>
                            <td class="column-3">MAGH BIHU </td>
                        </tr>
                        <tr class="row-13">
                            <td class="column-1">26th JANUARY </td>
                            <td class="column-2">MONDAY </td>
                            <td class="column-3">REPUBLIC DAY </td>
                        </tr>
                        <tr class="row-14">
                            <td class="column-1">4th MARCH </td>
                            <td class="column-2">WEDNESDAY </td>
                            <td class="column-3">HOLI </td>
                        </tr>
                        <tr class="row-15">
                            <td class="column-1">21st MARCH </td>
                            <td class="column-2">SATURDAY </td>
                            <td class="column-3">EID-UL-FITAR </td>
                        </tr>
                    </tbody>
                </table>



            </div><!-- .entry-content .clear -->
        </div>

    </AppLayout>
</template>

<style scoped>
table {
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    margin-bottom: 2rem;
}

td,
th {
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
}

tr:nth-child(even) {
    background-color: #f8fafc;
}

tr:hover {
    background-color: #f1f5f9;
    transition: background-color 0.2s ease;
}

.row-1 {
    background: linear-gradient(135deg, #1e3a8a 0%, #312e81 100%);
    color: white !important;
    font-weight: 750;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    font-size: 0.95rem;
}
</style>