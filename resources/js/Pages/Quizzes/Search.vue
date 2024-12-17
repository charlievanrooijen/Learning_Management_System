<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    },
    query: {
        type: String,
        default: '',
    },
});

const form = useForm({
    query: props.query || '',
});

const submitSearch = () => {
    form.get(route('quizzes.search'));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

    <div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6  mt-5">
        <h1 class="text-2xl font-bold mb-6">Search Quizzes</h1>

        <form @submit.prevent="submitSearch" class="mb-6">
            <div class="flex gap-2">
                <input type="text" v-model="form.query" placeholder="Search by title or description"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Search
                </button>
            </div>
        </form>

        <div v-if="quizzes.length === 0" class="text-gray-600">
            <p>No results found.</p>
        </div>

        <ul v-else>
            <li v-for="quiz in quizzes" :key="quiz.id" class="mb-4 p-4 border rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold">{{ quiz.title }}</h2>
                <p class="text-gray-600">{{ quiz.description }}</p>
                <button @click="$inertia.visit(route('quizzes.take', quiz.id))"
                    class="mt-2 bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                    Take Quiz
                </button>
            </li>
        </ul>
    </div>
</AuthenticatedLayout>
</template>
