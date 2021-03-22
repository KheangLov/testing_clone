<template>
    <input :class="classes" :type="type" :value="value" @input="$emit('input', $event.target.value)" ref="input">
</template>

<script>
    export default {
        props: {
            value: {
                default: ''
            },
            type: {
                default: 'text'
            },
            classes: {
                default: 'form-input rounded-md shadow-sm'
            }
        },

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

