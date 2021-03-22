<template>
    <div>
        <button type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-copy-tertiary text-left hover:bg-background-secondary focus:outline-none focus:bg-background-secondary transition duration-150 ease-in-out" v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href" class="block px-4 py-2 text-sm leading-5 text-copy-tertiary hover:bg-background-secondary focus:outline-none focus:bg-background-secondary transition duration-150 ease-in-out" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['href', 'as']
    }
</script>
