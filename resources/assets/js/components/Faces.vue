<template>
    <div class="faces">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        }
    }
</script>
