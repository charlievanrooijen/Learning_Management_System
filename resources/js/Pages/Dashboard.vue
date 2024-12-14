<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminDashboard from './Dashboard/AdminDashboard.vue';
import TeacherDashboard from './Dashboard/TeacherDashboard.vue';
import StudentDashboard from './Dashboard/StudentDashboard.vue';

import { Head } from '@inertiajs/vue3';

defineProps({
    user: {
        type: Object,
        required: true,
    },
});
</script>


<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
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
                        <div>
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
        </div>
    </AuthenticatedLayout>
</template>