<template>
    <div data-theme="light" class="min-h-screen flex flex-col md:flex-row">
        <div class="flex items-center justify-between p-4 bg-base-200 md:hidden">
            <button class="btn btn-ghost">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="text-xl font-bold">Questions</h1>
        </div>
        <aside class="fixed top-0 left-0 h-full w-64 bg-base-200 p-4 overflow-y-auto hidden md:block">
            <ul class="menu w-full">
                <li class="w-full">
                    <a class="block w-full bg-gray-200">Questions</a>
                </li>
            </ul>
        </aside>
        <main class="flex-1 p-4 bg-base-100 md:ml-64">
            <MathQuiz />
        </main>
    </div>
</template>

<script>
    import MathQuiz from './components/MathQuiz.vue';

    export default {
        name: 'App',
        components: {
            MathQuiz,
        },
    };
</script>