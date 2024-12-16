<script setup>
const props = defineProps({
    attempt: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="p-4 border rounded-md shadow-sm bg-gray-50">
        <h3 class="text-lg font-semibold">{{ attempt.quiz.title }}</h3>
        <p class="text-gray-600">
            <span class="font-semibold">Score:</span> {{ attempt.score }}
        </p>
        <p class="text-sm text-gray-500">
            <span class="font-semibold">Attempted on:</span>
            {{ new Date(attempt.created_at).toLocaleString() }}
        </p>
        <div class="mt-4">
            <button
                @click="$inertia.visit(route('quiz-attempt.review', attempt.id))"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
                View Details
            </button>
        </div>
    </div>
</template>
