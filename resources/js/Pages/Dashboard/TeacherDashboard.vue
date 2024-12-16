<script setup>
</script>

<template>
    <div>
        <h2 class="text-xl font-semibold">Teacher Dashboard</h2>
        <p class="pb-3">Here you can create courses, quizzes, and view student progress.</p>
        <button @click="$inertia.visit('quizzes/create')"
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Create Quiz
        </button>
    </div>
</template>
