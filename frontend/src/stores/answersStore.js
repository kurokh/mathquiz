import { defineStore } from 'pinia';

export const useAnswersStore = defineStore('answers', {
    state: () => ({
        answers: {}
    }),
    actions: {
        setAnswer(questionId, answer) {
            this.answers[questionId] = answer;
        }
    }
});
