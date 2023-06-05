<template>
    <div>
        <h1>{{ message }}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
           message: 'This is a new Vue script'
        };
    },
    mounted() {
        this.message = this.$root.message;
    }
};
</script>
