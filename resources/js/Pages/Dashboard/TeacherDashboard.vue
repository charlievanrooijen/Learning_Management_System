<script setup>
console.log('Teacher-specific dashboard');
</script>

<template>
    <div>
        <h2 class="text-xl font-semibold">Teacher Dashboard</h2>
        <p class="pb-3">Here you can create courses, quizzes, and view student progress.</p>
        <a href="{{ route('quizzes.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Create Quiz
        </a>
    </div>
</template>
