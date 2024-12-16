<script setup>
const props = defineProps({
    quiz: {
        type: Object,
        required: true,
    },
    feedback: {
        type: Array,
        required: true,
    },
    score: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Quiz Review: {{ quiz.title }}</h1>
        <p class="text-lg font-semibold mb-4">Your Score: {{ score }}/{{ feedback.length }}</p>
        <div class="mt-6 flex justify-end">
            <a
                href="/dashboard"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                Return to Dashboard
            </a>
        </div>
    </div>
</template>
