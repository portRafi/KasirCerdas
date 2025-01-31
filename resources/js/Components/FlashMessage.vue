<!-- components/FlashMessage.vue -->
<template>
    <Transition>
        <div v-if="show" :class="[
            'fixed top-4 right-4 z-50 p-4 rounded shadow-lg max-w-md transition-all duration-300',
            typeClasses[type]
        ]">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Icon based on type -->
                    <span v-if="type === 'success'" class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span v-else-if="type === 'error'" class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span v-else-if="type === 'info'" class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>

                    <p class="text-sm">{{ message }}</p>
                </div>

                <!-- Close button -->
                <button @click="closeFlash" class="ml-4 text-sm hover:opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div v-else></div>
    </Transition>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    duration: {
        type: Number,
        default: 3000
    }
})

// State
const show = ref(false)
const message = ref('')
const type = ref('success')

// Style classes for different types
const typeClasses = {
    success: 'bg-green-500 text-white',
    error: 'bg-red-500 text-white',
    info: 'bg-blue-500 text-white'
}

// Timer reference
let timer = null

// Watch for flash messages from Inertia
const page = usePage()
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.type === 'reload') {
            window.location.reload()
        }
        if (flash?.message) {
            showFlash(flash.message, flash.type || 'success')
        }
    },
    { deep: true }
)

// Method to show flash message
const showFlash = (msg, messageType = 'success') => {
    message.value = msg
    type.value = messageType
    show.value = true

    // Clear any existing timer
    if (timer) clearTimeout(timer)

    // Set new timer
    timer = setTimeout(() => {
        closeFlash()
    }, props.duration)
}

// Method to close flash message
const closeFlash = () => {
    show.value = false
}

// Clean up on component unmount
onMounted(() => {
    // Check for initial flash message
    const flash = page.props.flash
    if (flash?.message) {
        showFlash(flash.message, flash.type || 'success')
    }

    return () => {
        if (timer) clearTimeout(timer)
    }
})
</script>

<style scoped>
/* Transition classes */
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

/* Close button hover */
button:hover {
    opacity: 0.75;
}
</style>