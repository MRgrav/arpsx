<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import coverImage from '@/pages/Laboratory/Computer/computer.avif';
</script>

<template>
    <AppLayout>
        <PageHeadIndi heading="Computer Lab" />
        <div class="container mx-auto p-8 lg:px-16" data-ast-blocks-layout="true" itemprop="text">
            <div class="flex flex-col gap-6 lg:flex-row">
                <main class="flex-1">
                    <img :src="coverImage" alt="" class="mx-auto aspect-21/9 h-auto w-full max-w-5xl rounded-xl object-cover" />
                    <p class="pt-8 font-serif text-gray-700">
                        <span class="me-10"></span>The Computer Lab serves as a vital center for digital learning and academic development within the
                        institution. It is designed to meet the evolving technological needs of students and faculty by providing a well-structured
                        and resource-rich environment. The lab is equipped with 2 dedicated servers and 21 client systems, all configured through an
                        N-Computing setup, which allows multiple users to share computing resources efficiently while reducing hardware and energy
                        costs. The N-Computing architecture significantly enhances the manageability and scalability of the lab. It centralizes
                        processing through the servers while providing individual access points for students, maintaining performance without the need
                        for fully independent desktop units. This setup also simplifies maintenance, upgrades, and software deployment across the lab.
                        <br />
                        <br />
                        <span class="me-10"></span>The lab features modern computing systems with updated hardware and licensed software to support
                        programming, design, simulation, and other curriculum-related applications. It is further strengthened by a high-speed
                        internet connection, enabling smooth access to cloud platforms, research databases, and online learning tools. The seamless
                        connectivity supports both academic instruction and independent student research.
                        <br />
                        <br />
                        <span class="me-10"></span>To ensure reliability, especially during power fluctuations, the lab is backed by a 2 KVA
                        Uninterruptible Power Supply (UPS). This UPS provides sufficient backup to allow safe shutdown of systems and continuity of
                        work for a limited period during outages, preventing data loss and hardware damage.
                        <br />
                        <br />
                        <span class="me-10"></span>Overall, the Computer Lab is a well-maintained, tech-enabled facility that promotes hands-on
                        learning, technical skill development, and digital literacy among students. It supports a wide range of academic programs and
                        serves as a backbone for technology-driven education in the institution. Through its efficient infrastructure and networked
                        systems, the lab stands as a model of smart resource utilization and educational innovation.
                    </p>
                </main>
                <aside class="min-w-fit border p-4">
                    <b class="border-b py-4">Other Links</b>
                    <ul class="mt-8 space-y-2">
                        <li v-for="name in ['biology', 'chemistry', 'computer', 'physics']" :key="name" class="rounded px-2 py-1 hover:bg-red-100">
                            <a :href="name">{{ name }} Lab</a>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </AppLayout>
</template>
