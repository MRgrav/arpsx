<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PageHeadIndi from '@/components/PageHeadIndi.vue';
import coverBiology from '@/pages/Laboratory/Biology/biology.avif';
import coverChemistry from '@/pages/Laboratory/Chemistry/chemistry.avif';
import coverComputer from '@/pages/Laboratory/Computer/computer.avif';
import coverPhysics from '@/pages/Laboratory/Physics/physics.avif';

const props = defineProps<{
  slug: string
}>()

const labs = [
    {
        slug: 'computer',
        title: 'Computer Lab',
        img: coverComputer,
        texts: `<span class="me-10"></span>The Computer Lab serves as a vital center for digital learning and academic development within the
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
  <br />`,
    },
    {
        slug: 'biology', title: 'Biology Lab', img: coverBiology, texts: `    <span class="me-5"></span>Our Biology Lab is a hub for exploration and discovery. Well-equipped with microscopes,models, and specimens, students investigate the intricacies of life sciences. From cellular biology to ecosystems, our lab enables hands-on learning, promoting a deeper understanding of biological concepts. Experienced faculty guide students in conducting experiments, collecting data, and analyzing results, fostering a passion for scientific inquiry.ln practicals we include experiments like observation and identification of various permanent  slides under microscope, Identification of various specimens ,quadrate method,slide preparation and observation, DNA experiment etc.We have a human skeleton and different models of anatomical parts of human in lab .`
    },
    {
        slug: 'chemistry', title: 'Chemistry Lab', img: coverChemistry, texts: `   <span class="me-5"></span>Our Chemistry Lab is designed for safe and effective experimentation. Equipped with modern equipment and chemicals, students investigate chemical reactions, properties, and processes. Our lab encourages curiosity and creativity, allowing students to explore the molecular world. Faculty supervision ensures students follow proper protocols, developing essential skills in laboratory procedures and scientific inquiry.In practicals we include various experiments like inorganic salt analysis,organic salt analysis and volumetric analysis etc.we have digital balance and equipments like conical flask, beaker,volumetric flask, funnel ,biurett, pipette, test tubes , holder, bunsen burner etc.`
    },
    {
        slug: 'physics', title: 'Physics Lab', img: coverPhysics, texts: `<span class="me-5"></span>Our Physics Lab is equipped with modern apparatus and instruments, enabling students to explore fundamental concepts through hands-on experimentation. From mechanics to electromagnetism, our lab facilitates experiential learning, fostering a deeper understanding of physical principles. Experienced faculty guide students in conducting experiments, analyzing data, and drawing meaningful conclusions.In experiments we have Meter bridge, Potentiometer, Travelling microscope, Vernier callipers, Screw gauge,Spherometer, Ohm’s law apparatus , prism, Glass slab and p-n junction etc.`
    },
];

const lab = labs.find(item => item.slug === props.slug)
</script>

<template>
    <AppLayout>
        <PageHeadIndi v-if="lab" :heading="lab.title" />
        
        <div class="container mx-auto p-8 lg:px-16" data-ast-blocks-layout="true" itemprop="text">
            <div v-if="lab" class="flex flex-col gap-8 lg:flex-row">
                <main class="flex-1">
                    <img :src="lab.img" alt="Lab image" class="mx-auto aspect-21/9 h-auto w-full max-w-5xl rounded-2xl object-cover shadow-md border border-blue-100 p-1 bg-white" />
                    <div class="pt-8 font-serif text-gray-700 leading-relaxed text-justify">
                        <div v-html="lab.texts"></div>
                    </div>
                </main>
                
                <aside class="flex flex-col min-w-52 h-fit border border-blue-100 rounded-2xl p-4 bg-white/50 backdrop-blur-md shadow-sm">
                    <b class="border-b border-blue-100 pb-2 mb-4 font-bold text-blue-900 tracking-wide text-sm">Other Labs</b>
                    <ul class="space-y-2">
                        <li v-for="name in ['biology', 'chemistry', 'computer', 'physics']" :key="name">
                            <a 
                                :href="name" 
                                class="capitalize rounded-xl px-3 py-2 text-sm text-blue-700 hover:bg-blue-600 hover:text-white transition duration-200 block font-semibold"
                                :class="{ 'bg-blue-600 text-white': name === props.slug }"
                            >
                                {{ name }} Lab
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </AppLayout>
</template>
