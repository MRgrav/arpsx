<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import classroom1 from '@/pages/Classrooms/classroom1.jpeg';
import classroom2 from '@/pages/Classrooms/classroom2.jpeg';
import classroom3 from '@/pages/Classrooms/classroom3.jpeg';
import classroom4 from '@/pages/Classrooms/classroom4.jpeg';
import classroom5 from '@/pages/Classrooms/classroom5.jpeg';
import classroom6 from '@/pages/Classrooms/classroom6.jpeg';

const images = [classroom1, classroom2, classroom3, classroom4, classroom5, classroom6];

</script>

<template>
    <AppLayout>
        <div>
            <div class="max-w-7xl mx-auto p-8">
                <!-- Hero -->
                <section class="py-12">
                    <h1 class=" font-bold">Our Classrooms</h1>
                    <p class="mt-2 text-gray-500">
                        At our school, every classroom is more than just four walls.
                        <br>
                        It is a space carefully designed to inspire learning, encourage collaboration, and make students
                        feel comfortable and engaged.
                    </p>
                </section>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="image in images" class="aspect-4/3" :key="image">
                        <img :src="image" alt="" class="h-full w-full object-cover">
                    </div>
                </div>

                <!-- Message -->
                <section class="py-12">
                    <p class="mt-3 text-gray-500 leading-relaxed">


                        The classroom is thoughtfully designed to provide a comfortable and engaging learning
                        environment for students. It is equipped with modern teaching aids and infrastructure that
                        support both traditional and digital modes of education. Key facilities include a Smart Board,
                        Projector, and a Black Board, allowing teachers to conduct interactive and multimedia-based
                        sessions, as well as conventional chalk-and-talk lessons. This blend of tools helps cater to
                        different teaching styles and learning needs.
                        <br>
                        <br>
                        The Smart Board enhances classroom instruction by enabling real-time visual demonstrations,
                        digital note-taking, and interactive quizzes. The Projector supports video presentations,
                        animated content, and lesson slides, making learning more visual and effective. The Black Board
                        remains an essential tool for quick explanations and hands-on teaching during discussions.
                        <br>
                        <br>
                        In addition to teaching aids, the classroom features well-maintained furniture arranged to
                        ensure maximum visibility and comfort. Ergonomically designed desks and chairs create a
                        student-friendly atmosphere, promoting better focus and participation during lessons.
                        <br>
                        <br>
                        Cleanliness, proper ventilation, and a well-organized layout further enhance the overall
                        learning experience. This well-equipped classroom environment ensures that both teachers and
                        students can engage in productive and enjoyable academic activities.

                    </p>
                </section>
            </div>
        </div>
    </AppLayout>
</template>