<template>
    <div class="post">
        <div class="post-header">
            <h1 class="post-title" @click="toggleStatus" :class="{ completed: post.is_completed }">{{ post.name }}</h1>
        </div>
        <div class="post-body">
            <p class="post-description" @click="toggleStatus" :class="{ completed: post.is_completed }">{{ post.description }}</p>
            <p class="post-date">{{ formattedDate }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "PostComponent",
    props: {
        post: {
            type: Object,
            required: true,
            default: () => ({
                name: '',
                description: '',
                created_at: '',
                is_completed: false,
            })
        }
    },
    methods: {
        toggleStatus() {
            const newStatus = !this.post.is_completed;
            axios.put(`/tasks/${this.post.id}`, { is_completed: newStatus })
                .then(response => {
                    this.$emit('status-updated', { ...this.post, is_completed: newStatus });
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                });
        }
    },
    computed: {
        formattedDate() {
            if (this.post.created_at) {
                const date = new Date(this.post.created_at);
                return date.toLocaleDateString();
            }
            return 'No date provided';
        }
    }
}
</script>

<style scoped>
.post {
    background-color: #fff; /* Background color for the post */
    color: #333; /* Text color */
    border-radius: 10px; /* Rounded corners */
    padding: 20px; /* Padding inside the post */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23); /* Shadow for the post */
    display: flex; /* Flexbox for layout */
    flex-direction: column; /* Stack children vertically */
    margin-bottom: 20px; /* Bottom margin for space between posts */
    animation: fadeIn 0.5s ease; /* Fade-in animation */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px); /* Start 10px above */
    }
    to {
        opacity: 1;
        transform: translateY(0); /* End at original position */
    }
}

.post-header {
    display: flex; /* Flexbox for layout */
    justify-content: space-between; /* Space between items */
    align-items: center; /* Center items vertically */
}

.post-title {
    font-size: 24px; /* Font size for the title */
    cursor: pointer; /* Pointer cursor on hover */
    margin: 0; /* Remove default margin */
}

.post-body {
    margin-top: 10px; /* Top margin */
}

.post-description {
    margin: 10px 0; /* Margin around the description */
    cursor: pointer; /* Pointer cursor on hover */
}

.post-date {
    font-size: 14px; /* Font size for the date */
    color: #888; /* Text color for the date */
    text-align: right; /* Align text to the right */
}

.completed {
    text-decoration: line-through; /* Line through completed tasks */
    color: grey; /* Color for completed tasks */
}
</style>
