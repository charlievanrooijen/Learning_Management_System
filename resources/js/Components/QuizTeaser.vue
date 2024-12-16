<script setup>
const props = defineProps({
    quiz: {
        type: Object,
        required: true,
    },
    userId: {
        type: Number,
        required: true,
    },
    userRole: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">
        <h3 class="text-lg font-semibold">{{ quiz.title }}</h3>
        <p class="text-gray-600 mt-2">{{ quiz.description }}</p>
        <div class="flex justify-between mt-4">
            <button v-if="quiz.author_id === userId || userRole === 'Admin'"
                @click="$inertia.visit(route('quizzes.edit', quiz.id))"
                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Edit Quiz
            </button>
            <button @click="$inertia.visit(route('quizzes.take', quiz.id))"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Take Quiz
            </button>
        </div>
    </div>
</template>
