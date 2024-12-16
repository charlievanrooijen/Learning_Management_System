<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    quiz: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    answers: reactive([]),
});

JSON.parse(props.quiz.content).forEach(() => form.answers.push([]));

const submitQuiz = () => {
    form.post(route('quiz-attempt.store', props.quiz.id));
};
</script>

<template>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">{{ quiz.title }}</h1>
        <p class="text-gray-600 mb-4">{{ quiz.description }}</p>

        <form @submit.prevent="submitQuiz">
            <div v-for="(question, questionIndex) in JSON.parse(quiz.content)" :key="questionIndex" class="mb-6">
                <h3 class="text-lg font-semibold mb-2">{{ question.question }}</h3>

                <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="mb-2">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            :value="choice.text"
                            :name="'answers[' + questionIndex + '][]'"
                            v-model="form.answers[questionIndex]"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        />
                        <span>{{ choice.text }}</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                    Submit Quiz
                </button>
            </div>
        </form>
    </div>
</template>
