<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuizTeaser from '@/Components/QuizTeaser.vue';
import QuizAttemptTeaser from '@/Components/QuizAttemptTeaser.vue';

import AdminDashboard from './Dashboard/AdminDashboard.vue';
import TeacherDashboard from './Dashboard/TeacherDashboard.vue';
import StudentDashboard from './Dashboard/StudentDashboard.vue';

import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    quizzes: {
        type: Array,
        default: () => [],
    },
    recentAttempts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-2xl font-bold">Welcome, {{ user.name }}!</h1>
                        <div class="mt-6">
                            <AdminDashboard v-if="user.role === 'Admin'" />
                            <TeacherDashboard v-else-if="user.role === 'Teacher'" />
                            <StudentDashboard v-else-if="user.role === 'Student'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Quizzes</h2>
                        <div v-if="quizzes.length === 0">
                            <p>No quizzes available at the moment.</p>
                        </div>
                        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <QuizTeaser v-for="quiz in quizzes" 
                                :key="quiz.id" 
                                :quiz="quiz" 
                                :userId="user.id"
                                :userRole="user.role" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-bold mb-4">Recent Quiz Scores</h2>
                        <div v-if="recentAttempts.length === 0">
                            <p>You haven't taken any quizzes yet.</p>
                        </div>
                        <div v-else class="space-y-4">
                            <QuizAttemptTeaser v-for="attempt in recentAttempts" :key="attempt.id" :attempt="attempt" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
