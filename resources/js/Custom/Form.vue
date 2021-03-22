<template>
    <form @submit.prevent="$emit('submitted')">
        <div class="shadow overflow-hidden sm:rounded-md bg-background-tertiary">
            <slot name="form"></slot>

            <div class="flex items-center justify-end py-3 text-right" v-if="hasActions">
                <slot name="actions"></slot>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
