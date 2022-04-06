<template>
    <div class="container">
        <header class="jumbotron">
            <h3>{{ content }}</h3>
        </header>
    </div>
</template>

<script>
import { ref } from '@vue/reactivity';
export default {
    name: "Home",
    setup() {
        let message = ref("");

        return {
            message,
        };
    },
    mounted() {},
};
</script>
