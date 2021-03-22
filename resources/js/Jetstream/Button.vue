<template>
    <button :type="type" @click="clicked" :class="classes">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            classes: {
                type: String,
                default: 'bg-background-secondary hover:bg-background-primary active:bg-background-primary focus:bg-background-primary mb-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs text-copy-primary uppercase tracking-widest focus:outline-none focus:shadow-outline-gray transition ease-in-out duration-150',
            },
        },
        methods: {
            clicked() {
                this.$emit('clicked');
            }
        }
    }
</script>
